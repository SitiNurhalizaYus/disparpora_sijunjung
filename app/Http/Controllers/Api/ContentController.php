<?php

namespace App\Http\Controllers\Api;

use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\ContentResource;

class ContentController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan pengguna terautentikasi, kecuali untuk metode index dan show
        $this->middleware('auth:api')->except("index", "show");
    }

    public function index(Request $request)
    {
        // Ambil parameter dari request
        $count = $request->get('count', false);
        $sort = $request->get('sort', 'id_content:asc');
        $search = $request->get('search', '');
        $per_page = intval($request->get('per_page', 10));
        $page = intval($request->get('page', 1));
        $type = $request->get('type', null);  // Mengambil type dari request
        $category_id = $request->get('category_id', null);  // Mengambil category_id dari request

        // Menentukan kolom dan arah sorting (default 'id_content:asc')
        $sort = explode(':', $sort);
        if (count($sort) !== 2 || !Schema::hasColumn('contents', $sort[0])) {
            $sort = ['id_content', 'asc'];
        }

        // Membuat query dasar untuk tabel Content dengan relasi arsip dan kategori
        $query = Content::with(['category', 'createdBy', 'updatedBy']);

        // Filter berdasarkan tipe konten
        if ($type) {
            $query->where('type', $type);
        }

        // Filter berdasarkan category_id
        if ($category_id) {
            $query->whereHas('category', function ($q) use ($category_id) {
                $q->where('id_category', $category_id);
            });
        }

        // Filter berdasarkan bulan dan tahun jika ada
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('created_at', $request->month)
                ->whereYear('created_at', $request->year);
        }

        // Filter berdasarkan pencarian judul
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        // Paginasi dan sorting
        $metadata['total_data'] = $query->count();
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        if ($per_page > 0) {
            $data = $query->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get();
        } else {
            $data = $query->orderBy($sort[0], $sort[1])->get();
        }

        return ContentResource::collection($data)->additional([
            'success' => true,
            'message' => 'Get data successful',
            'metadata' => $metadata
        ]);
    }


    public function show($id_content)
    {
        $query = Content::with(['arsip', 'category', 'createdBy', 'updatedBy']);

        // Jika tidak ada autentikasi, filter hanya konten yang aktif
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        $data = is_numeric($id_content)
            ? $query->find($id_content)
            : $query->where('slug', $id_content)->first();

        if ($data) {
            return (new ContentResource($data))->additional([
                'success' => true,
                'message' => 'Get data successful'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        // Validasi input, termasuk validasi tipe yang diperbolehkan
        $request->validate([
            'title' => 'required',
            'type' => 'required|in:berita,artikel,profil',  // Validasi untuk type
            'category_id' => 'required_if:type,!=profil',  // Wajib jika bukan tipe profil
        ]);

        // Generate slug unik berdasarkan title
        $slug = $this->generateUniqueSlug($request->input('title'));

        // Ambil semua input dari request
        $req = $request->all();

        // Tambahkan slug dan created_by ke data yang akan disimpan
        $req['slug'] = $slug;
        $req['created_by'] = auth()->id();

        // Periksa level user, jika kontributor (level_id = 3), atur is_active = 0
        $user = auth()->user();
        if ($user->level_id == 3) {
            $req['is_active'] = 0;
        }

        // Simpan data ke dalam tabel content
        $data = Content::create($req);

        // Return response dengan resource tambahan
        return (new ContentResource($data))->additional([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function update(Request $request, $id_content)
    {
        $data = Content::findOrFail($id_content);

        $request->validate([
            'title' => 'required',
            'type' => 'required|in:berita,artikel,profil',  // Validasi untuk type
            'category_id' => 'required_if:type,!=profil',  // Wajib jika bukan tipe profil
        ]);

        $slug = $this->generateUniqueSlug($request->input('title'));
        $req = $request->all();
        $data['slug'] = $slug;
        $data['updated_by'] = auth()->id();

        $user = auth()->user();
        if ($user->level_id == 3) {
            // Kontributor tidak dapat mengubah status jika konten aktif
            if ($data->is_active == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kontributor tidak dapat mengubah konten yang sudah aktif'
                ], 403);
            }
            unset($data['is_active']);
        }

        $data->update($req);

        return (new ContentResource($data))->additional([
            'success' => true,
            'message' => 'Data berhasil diperbarui'
        ]);
    }

    public function destroy($id_content)
    {
        $content = Content::findOrFail($id_content);

        $user = auth()->user();
        if ($user->level_id == 3 && $content->is_active == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Kontributor tidak dapat menghapus konten yang sudah aktif'
            ], 403);
        }

        $content->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ], 201);
    }

    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Content::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}

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

    // Metode index untuk menampilkan daftar konten dengan filter, pencarian, dan paginasi
    public function index(Request $request)
    {
        // Mengambil parameter dari request
        $count = $request->get('count', false);
        $sort = $request->get('sort', 'id_content:asc');
        $where = $request->get('where', '{}');
        $search = $request->get('search', '');
        $per_page = intval($request->get('per_page', 10));
        $page = intval($request->get('page', 1));
        $type = $request->get('type', null);
        $category_id = $request->get('category_id', null);

        // Menentukan kolom dan arah sorting (default 'id_content:asc')
        $sort = explode(':', $sort);
        if (count($sort) !== 2 || !Schema::hasColumn('contents', $sort[0])) {
            $sort = ['id_content', 'asc']; // Sorting default jika tidak valid
        }

        // Mengubah where string menjadi array JSON
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // Membuat query dasar untuk tabel Content dengan relasi arsip dan kategori
        $query = Content::with(['category', 'createdBy', 'updatedBy']);

        // Menambahkan filter berdasarkan tipe konten jika ada
        if ($type) {
            $query->where('type', $type);
        }

        // Menambahkan filter berdasarkan category_id jika ada
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // Filter dinamis berdasarkan semua kolom yang ada di tabel
        $filterable_columns = ['title', 'slug', 'content', 'is_active', 'created_by', 'updated_by'];
        foreach ($filterable_columns as $column) {
            if ($request->has($column)) {
                $query->where($column, $request->get($column));
            }
        }

        // Jika tidak ada otentikasi, filter hanya konten yang aktif
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        // Menambahkan filter where jika ada
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        // Menambahkan pencarian berdasarkan judul jika ada
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        // Membuat metadata untuk pagination
        $metadata = [];
        $metadata['total_data'] = $query->count(); // Total data sebelum paginasi
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        if ($per_page > 0) {
            // Pastikan menggunakan limit jika offset digunakan
            $data = $query->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get();
        } else {
            // Jika per_page adalah 0 atau 'all', ambil semua data tanpa limit dan offset
            $data = $query->orderBy($sort[0], $sort[1])->get();
        }

        // Mengembalikan hasil data dalam format ContentResource dengan metadata tambahan
        return ContentResource::collection($data)->additional([
            'success' => true,
            'message' => 'Get data successful',
            'metadata' => $metadata
        ]);
    }

    // Metode untuk menampilkan detail satu data berdasarkan id_content atau slug
    public function show($id_content)
    {
        // Membuat query dasar dengan relasi arsip dan kategori
        $query = Content::with(['arsip', 'category', 'createdBy', 'updatedBy']);

        // Jika tidak ada autentikasi, filter hanya konten yang aktif
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        // Mendapatkan data berdasarkan ID atau slug
        if (is_numeric($id_content)) {
            $data = $query->find($id_content);
        } else {
            $data = $query->where('slug', $id_content)->first();
        }

        // Mengembalikan hasil data dalam format ContentResource
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

    // Metode untuk menyimpan data baru
    public function store(Request $request)
    {
        // Ambil tipe konten dari request, default 'berita'
        $type = $request->input('type', 'berita');

        $request->validate([
            'title' => 'required',
        ]);

        // Membuat slug yang unik
        $slug = $this->generateUniqueSlug($request->input('title'));
        $data = $request->$slug;
        // Ambil semua input form dan set category_id jika bukan tipe 'profil'
        $data = $request->all();

        if ($type !== 'profil') {
            $data['category_id'] = $request->category_id; // Set category_id sesuai dengan input kategori
        }

        $data['type'] = $type; // Set tipe konten
        $data['created_by'] = auth()->id();
        // Memperbarui data berdasarkan input dari form dan menyimpan konten baru
        $content = Content::create($data); // Mengembalikan objek Content, bukan array

        // Mengembalikan hasil pembaruan dalam format ContentResource
        return (new ContentResource($content))->additional([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }


    // Metode untuk memperbarui data
    public function update(Request $request, $id_content)
    {
        $content = Content::findOrFail($id_content);

        // Ambil tipe konten dari request, default 'berita'
        $type = $request->input('type', 'berita');

        $request->validate([
            'title' => 'required',
        ]);

        // Membuat slug yang unik
        $slug = $this->generateUniqueSlug($request->input('title'));
        $data = $request->$slug;

        if ($type !== 'profil') {
            $data['category_id'] = $request->category_id; // Set category_id sesuai dengan input kategori
        }
        
        $data['updated_by'] = auth()->id();
        $data = $request->all();
        $content->update($data);

        // Mengembalikan hasil pembaruan dalam format ContentResource
        return (new ContentResource($content))->additional([
            'success' => true,
            'message' => 'Data berhasil diperbarui'
        ]);
    }


    // Metode untuk menghapus data
    public function destroy($id_content)
    {
        // Mengambil dan menghapus data berdasarkan id_content
        $content = Content::findOrFail($id_content);
        $content->delete();

        // Mengembalikan hasil penghapusan dalam format JSON
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use Illuminate\Http\Request;
use App\Models\Content;

class BeritaController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan pengguna terautentikasi, kecuali untuk index dan show
        $this->middleware('auth:api')->except("index", "show");
    }

    public function index(Request $request)
    {
        // Mengambil parameter dari request
        $sort = $request->get('sort', 'id_content:asc');
        $per_page = intval($request->get('per_page', 10));
        $page = intval($request->get('page', 1));
        $search = $request->get('search', '');
        $where = json_decode($request->get('where', '{}'), true);
        $category_id = $request->get('category_id');
        $arsip_id = $request->get('arsip_id');

        // Memastikan nilai per_page dan page tidak negatif atau nol
        if ($per_page <= 0) {
            $per_page = 10;
        }
        if ($page <= 0) {
            $page = 1;
        }

        // Mengatur sorting
        $sort = explode(':', $sort);
        if (count($sort) !== 2) {
            $sort = ['id_content', 'asc']; // Default sorting jika format tidak valid
        }

        // Membuat query untuk mengambil data tipe 'berita'
        $query = Content::where('type', 'berita');

        // Jika pengguna tidak terautentikasi, hanya menampilkan konten yang aktif
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        // Menambahkan filter berdasarkan kondisi `where`, `category_id`, dan `arsip_id` jika ada
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($arsip_id) {
            $query->where('arsip_id', $arsip_id);
        }

        // Menambahkan filter pencarian berdasarkan judul jika ada
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        // Metadata untuk pagination
        $metadata = [];
        $metadata['total_data'] = $query->count();
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $per_page);
        $metadata['page'] = $page;

        // Mengambil data dengan pagination
        if ($per_page == 0 || $per_page == 'all') {
            $data = $query->orderBy($sort[0], $sort[1])->get();
        } else {
            $data = $query->orderBy($sort[0], $sort[1])
                          ->limit($per_page)
                          ->offset(($page - 1) * $per_page)
                          ->get();
        }

        // Menggunakan ContentResource untuk response
        return ContentResource::collection($data)
            ->additional(['metadata' => $metadata]);
    }

    public function show($id_content)
    {
        // Membuat query untuk mengambil data tipe 'berita'
        $query = Content::where('type', 'berita');

        // Jika pengguna tidak terautentikasi, hanya menampilkan konten yang aktif
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        // Mengambil data berdasarkan ID atau slug
        $data = is_numeric($id_content) ? $query->find($id_content) : $query->where('slug', $id_content)->first();

        // Menggunakan ContentResource untuk response
        if ($data) {
            return new ContentResource($data);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data found',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug',
            'content' => 'required',
            'category_id' => 'required',
            'arsip_id' => 'required',
        ]);

        // Menambahkan tipe sebagai 'berita'
        $data = Content::create(array_merge($request->all(), ['type' => 'berita']));

        // Menggunakan ContentResource untuk response
        if ($data) {
            return (new ContentResource($data))
                ->response()
                ->setStatusCode(201)
                ->header('message', 'Data telah berhasil ditambahkan');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal ditambahkan',
            ], 400);
        }
    }

    public function update(Request $request, $id_content)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug,' . $id_content,
            'content' => 'required',
            'category_id' => 'required',
            'arsip_id' => 'required',
        ]);

        // Mengupdate data yang ada
        $query = Content::where('type', 'berita')->findOrFail($id_content);
        $query->update($request->all());

        $data = Content::where('type', 'berita')->findOrFail($id_content);

        // Menggunakan ContentResource untuk response
        if ($data) {
            return (new ContentResource($data))
                ->response()
                ->setStatusCode(200)
                ->header('message', 'Data berhasil diperbarui');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal diperbarui',
            ], 400);
        }
    }

    public function destroy($id_content)
    {
        // Menghapus data berdasarkan ID
        $query = Content::where('type', 'berita')->findOrFail($id_content);
        $query->delete();

        // Mengirimkan response
        if ($query) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus',
            ], 400);
        }
    }
}

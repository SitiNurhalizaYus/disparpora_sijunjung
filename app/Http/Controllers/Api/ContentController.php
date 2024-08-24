<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use Illuminate\Http\Request;
use App\Models\Content;

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
        $arsip_id = $request->get('arsip_id', null);
        $category_id = $request->get('category_id', null);

        // Menentukan kolom dan arah sorting (default 'id_content:asc')
        $sort = explode(':', $sort);
        if (count($sort) !== 2) {
            $sort = ['id_content', 'asc']; // Sorting default jika tidak valid
        }

        // Mengubah where string menjadi array JSON
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // Membuat query dasar untuk tabel Content dengan relasi arsip dan kategori
        $query = Content::with(['arsip', 'category', 'createdBy', 'updatedBy']);

        // Menambahkan filter berdasarkan tipe konten jika ada
        if ($type) {
            $query->where('type', $type);
        }

        // Menambahkan filter berdasarkan arsip_id jika ada
        if ($arsip_id) {
            $query->where('arsip_id', $arsip_id);
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

        // Menampilkan semua data jika per_page adalah 0 atau 'all'
        if ($per_page == 0 || $per_page == 'all') {
            $data = $query->orderBy($sort[0], $sort[1])->get();
        } else {
            // Mengambil data dengan paginasi
            $data = $query->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get();
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
        // Validasi input
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug',
            'content' => 'required',
        ]);

        // Menyimpan data baru dengan tipe 'profil'
        $req = $request->all();
        $req['type'] = 'profil'; // Mengatur tipe sebagai 'profil'
        $data = Content::create($req);

        // Mengembalikan hasil penyimpanan dalam format ContentResource
        if ($data) {
            return (new ContentResource($data))->additional([
                'success' => true,
                'message' => 'Data telah berhasil ditambahkan'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal ditambahkan'
            ], 400);
        }
    }

    // Metode untuk memperbarui data
    public function update(Request $request, $id_content)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug,' . $id_content,
            'content' => 'required',
        ]);

        // Mengambil data yang akan diperbarui
        $query = Content::findOrFail($id_content);
        $req = $request->all();
        $query->update($req);

        // Mengembalikan hasil pembaruan dalam format ContentResource
        $data = Content::findOrFail($id_content);

        if ($data) {
            return (new ContentResource($data))->additional([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal diperbarui'
            ], 400);
        }
    }

    // Metode untuk menghapus data
    public function destroy($id_content)
    {
        // Mengambil dan menghapus data berdasarkan id_content
        $query = Content::findOrFail($id_content);
        $query->delete();

        // Mengembalikan hasil penghapusan dalam format ApiResource
        if ($query) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus'
            ], 400);
        }
    }
}

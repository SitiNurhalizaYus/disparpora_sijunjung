<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    // Constructor yang menerapkan middleware untuk memastikan otentikasi API kecuali untuk metode index dan show
    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show");
    }

    // Metode index untuk menampilkan daftar konten dengan filter, pencarian, dan paginasi
    public function index(Request $request)
    {
        // Mengambil parameter dari request
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'id:asc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? intval($request->get('per_page')) : 10;
        $page = $request->has('page') ? intval($request->get('page')) : 1;
        $type = $request->has('type') ? $request->get('type') : null;
        $arsip_id = $request->has('arsip_id') ? $request->get('arsip_id') : null;
        $category_id = $request->has('category_id') ? $request->get('category_id') : null;

        // Validasi per_page dan page agar tidak bernilai negatif atau nol
        if ($per_page <= 0) {
            $per_page = 10;
        }
        if ($page <= 0) {
            $page = 1;
        }

        // Menentukan kolom dan arah sorting (default 'id:asc')
        $sort = explode(':', $sort);
        if (count($sort) !== 2) {
            $sort = ['id', 'asc']; // Sorting default jika tidak valid
        }

        // Mengubah where string menjadi array JSON
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // Membuat query dasar untuk tabel Content dengan relasi arsip dan kategori
        $query = Content::with(['arsip', 'category']);

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
            $data = $query->orderBy($sort[0], $sort[1])->get()->toArray();
            $metadata['total_data'] = count($data);
            $metadata['per_page'] = $metadata['total_data'];
            $metadata['total_page'] = 1;
            $metadata['page'] = 1;
        } else {
            // Mengambil data dengan paginasi
            $data = $query->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get()
                ->toArray();
        }

        // Mengembalikan hasil data dalam format ApiResource
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    // Metode untuk menampilkan detail satu data berdasarkan id atau slug
    public function show($id)
    {
        // Membuat query dasar dengan relasi arsip dan kategori
        $query = Content::with(['arsip', 'category']);

        // Jika tidak ada autentikasi, filter hanya konten yang aktif
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        // Mendapatkan data berdasarkan ID atau slug
        if (is_numeric($id)) {
            $data = $query->find($id);
        } else {
            $data = $query->where('slug', $id)->first();
        }

        // Mengembalikan hasil data dalam format ApiResource
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
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

        // Mengembalikan hasil penyimpanan dalam format ApiResource
        if ($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    // Metode untuk memperbarui data
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug,' . $id,
            'content' => 'required',
        ]);

        // Mengambil data yang akan diperbarui
        $query = Content::findOrFail($id);
        $req = $request->all();
        $query->update($req);

        // Mengembalikan hasil pembaruan dalam format ApiResource
        $data = Content::findOrFail($id);

        if ($data) {
            return new ApiResource(true, 201, 'Data berhasil diperbarui', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal diperbarui', [], []);
        }
    }

    // Metode untuk menghapus data
    public function destroy($id)
    {
        // Mengambil dan menghapus data berdasarkan id
        $query = Content::findOrFail($id);
        $query->delete();

        // Mengembalikan hasil penghapusan dalam format ApiResource
        if ($query) {
            return new ApiResource(true, 201, 'Data berhasil dihapus', [], []);
        } else {
            return new ApiResource(false, 400, 'Data gagal dihapus', [], []);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Content;

class ArtikelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show");
    }

    public function index(Request $request)
    {
        // parameter
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'id:asc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? intval($request->get('per_page')) : 10;
        $page = $request->has('page') ? intval($request->get('page')) : 1;
        $arsip_id = $request->has('arsip_id') ? $request->get('arsip_id') : null;
        $category_id = $request->has('category_id') ? $request->get('category_id') : null;

        // Validasi per_page dan page agar tidak bernilai negatif atau nol
        if ($per_page <= 0) {
            $per_page = 10;
        }
        if ($page <= 0) {
            $page = 1;
        }

        $sort = explode(':', $sort);
        if (count($sort) !== 2) {
            $sort = ['id', 'asc']; // Default sorting jika tidak valid
        }
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Content::with(['arsip', 'category'])->where('type', 'artikel');

        // Filter berdasarkan arsip_id jika ada
        if ($arsip_id) {
            $query->where('arsip_id', $arsip_id);
        }

        // Filter berdasarkan category_id jika ada
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // Cek token dan filter konten aktif jika tidak ada autentikasi
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        // metadata
        $metadata = [];
        $metadata['total_data'] = $query->count();
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        if ($per_page == 0 || $per_page == 'all') {
            $data = $query->orderBy($sort[0], $sort[1])->get()->toArray();
            $metadata['total_data'] = count($data);
            $metadata['per_page'] = $metadata['total_data'];
            $metadata['total_page'] = 1;
            $metadata['page'] = 1;
        } else {
            $data = $query->orderBy($sort[0], $sort[1])
                          ->limit($per_page)
                          ->offset(($page - 1) * $per_page)
                          ->get()
                          ->toArray();
        }

        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function show($id)
    {
        // query
        $query = Content::with(['arsip', 'category'])->where('type', 'artikel');

        // cek token
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        // data
        if (is_numeric($id)) {
            $data = $query->find($id);
        } else {
            $query = $query->where('slug', $id);
            $data = $query->first();
        }

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'arsip_id' => 'required|exists:arsips,id',
        ]);

        $req = $request->all();
        $req['type'] = 'artikel'; // Mengatur tipe sebagai 'artikel'
        $data = Content::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug,' . $id,
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'arsip_id' => 'required|exists:arsips,id',
        ]);

        $query = Content::where('type', 'artikel')->findOrFail($id);
        $req = $request->all();
        $query->update($req);

        $data = Content::where('type', 'artikel')->findOrFail($id);

        if ($data) {
            return new ApiResource(true, 201, 'Data berhasil diperbarui', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal diperbarui', [], []);
        }
    }

    public function destroy($id)
    {
        $query = Content::where('type', 'artikel')->findOrFail($id);
        $query->delete();

        if ($query) {
            return new ApiResource(true, 201, 'Data berhasil dihapus', [], []);
        } else {
            return new ApiResource(false, 400, 'Data gagal dihapus', [], []);
        }
    }
}

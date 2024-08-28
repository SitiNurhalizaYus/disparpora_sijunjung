<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use App\Models\Gallery;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan pengguna terautentikasi, kecuali untuk index dan show
        $this->middleware('auth:api')->except("index", "show");
    }

    public function index(Request $request)
    {
        // Mengambil parameter dari request
        $sort = $request->get('sort', 'id:asc');
        $per_page = intval($request->get('per_page', 10));
        $page = intval($request->get('page', 1));
        $search = $request->get('search', '');
        $where = json_decode($request->get('where', '{}'), true);

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
            $sort = ['id', 'asc']; // Default sorting jika format tidak valid
        }

        // Membuat query untuk mengambil data tipe 'profil'
        $query = Gallery::where('type', 'gambar', 'video');

        // Jika pengguna tidak terautentikasi, hanya menampilkan konten yang aktif
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        // Menambahkan filter berdasarkan kondisi `where` jika ada
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
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

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function show($id)
    {
        // Membuat query untuk mengambil data tipe 'profil'
        $query = Gallery::where('type', 'gambar', 'video');

        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // data
        $data = $query->find($id);

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
        ]);

        // Menambahkan tipe sebagai 'profil'
        $data = Gallery::create(array_merge($request->all(), ['type' => 'gambar', 'video']));

        if($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
        ]);

        // Mengupdate data yang ada
        $query = Gallery::where('type', 'gambar', 'video')->findOrFail($id);
        $query->update($request->all());

        $data = Gallery::where('type', 'gambar', 'video')->findOrFail($id);

        if($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    public function destroy($id)
    {
        // Menghapus data berdasarkan ID
        $query = Gallery::where('type', 'profil')->findOrFail($id);
        $query->delete();

        // Mengirimkan response
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Data gagal dihapus'], 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Mitra;

class MitraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show");
    }

    public function index(Request $request)
    {
        // parameter
        $count = $request->get('count', false); // Mengambil parameter count
        $sort = $request->get('sort', 'id:asc');
        $where = $request->get('where', '{}');
        $search = $request->get('search', '');
        $per_page = intval($request->get('per_page', 10));
        $page = intval($request->get('page', 1));

        // Validasi per_page dan page agar tidak bernilai negatif atau nol
        if ($per_page <= 0) {
            $per_page = 10;
        }
        if ($page <= 0) {
            $page = 1;
        }

        $sort = explode(':', $sort);
        if (count($sort) !== 2) {
            $sort = ['id', 'desc']; // Default sorting jika tidak valid
        }
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Mitra::where([['id', '>', '0']]);

        // cek token
        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // Filter berdasarkan parameter where
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        // Pencarian berdasarkan nama mitra
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Jika count=true, hanya mengembalikan jumlah data
        if ($count == true) {
            $total_count = $query->count('id');
            return new ApiResource(true, 200, 'Data count retrieved successfully', [], ['count' => $total_count]);
        }

        // metadata dan data
        $metadata = [];
        $metadata['total_data'] = $query->count(); // Hitung total data sebelum paginasi
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $per_page);
        $metadata['page'] = $page;

        // Ambil data dengan paginasi jika per_page bukan 0 atau 'all'
        if ($per_page == 0 || $per_page == 'all') {
            $data = $query->orderBy($sort[0], $sort[1])->get()->toArray();
            $metadata['total_data'] = count($data); // Update total data
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

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function show($id)
    {
        // Query dengan eager loading untuk mengambil 'createdBy' dan 'updatedBy'
        $query = Mitra::with(['createdBy', 'updatedBy'])->where('id', $id);

        // Jika tidak ada autentikasi, filter hanya konten yang aktif
        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1); // Hanya ambil data yang aktif
        }

        $data = $query->first(); // Ambil data pertama yang cocok dengan id

        if (!$data) {
            return new ApiResource(false, 404, 'Data not found', [], []);
        }

        // Menampilkan data agenda dan mengubah 'created_by' dan 'updated_by' menjadi nama user
        $result = $data->toArray();
        if ($data->createdBy) {
            $result['created_by'] = $data->createdBy->name; // Menampilkan nama user dari 'created_by'
        }
        if ($data->updatedBy) {
            $result['updated_by'] = $data->updatedBy->name; // Menampilkan nama user dari 'updated_by'
        }

        // result
        if ($result) {
            return new ApiResource(true, 200, 'Get data successful', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->all();
        $req['created_by'] = auth()->id();

        $user = auth()->user();
        if ($user->level_id == 3) {
            // Jika user adalah kontributor, status aktif otomatis 0
            $req['is_active'] = 0;
        }

        $data = Mitra::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $data = Mitra::find($id);
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->all();
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

        if ($data) {
            return new ApiResource(true, 201, 'Data berhasil diperbarui', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal diperbarui', [], []);
        }
    }

    public function destroy($id)
    {
        $query = Mitra::findOrFail($id);
        $query->delete();

        if ($query) {
            return new ApiResource(true, 201, 'Data berhasil dihapus', [], []);
        } else {
            return new ApiResource(false, 400, 'Data gagal dihapus', [], []);
        }
    }
}

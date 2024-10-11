<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Agenda;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(["index", "show"]);
    }

    public function index(Request $request)
    {
        // parameter
        $count = $request->get('count', false);
        $sort = $request->has('sort') ? $request->get('sort') : 'event_date:desc'; // Default sorting berdasarkan tanggal terbaru
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? intval($request->get('per_page')) : 10;
        $page = $request->has('page') ? intval($request->get('page')) : 1;
        $month = $request->get('month', null);  // Mengambil bulan dari request
        $year = $request->get('year', null);    // Mengambil tahun dari request

        // Validasi per_page dan page agar tidak bernilai negatif atau nol
        if ($per_page <= 0) {
            $per_page = 10;
        }
        if ($page <= 0) {
            $page = 1;
        }

        $sort = explode(':', $sort);
        if (count($sort) !== 2) {
            $sort = ['event_date', 'desc']; // Default sorting jika tidak valid
        }

        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Agenda::where([['id', '>', '0']]);

        // cek token
        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // Apply where clause jika ada
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn($key, $value);
                } else {
                    $query = $query->where($key, $value);
                }
            }
        }

        // Apply pencarian
        if ($search) {
            $query = $query->where('name', 'like', "%{$search}%");
        }

        // Filter berdasarkan bulan dan tahun
        if ($month && $year) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        } elseif ($year) {
            $query->whereYear('created_at', $year);
        }

        // metadata dan data
        $metadata = [];
        $metadata['total_data'] = $query->count(); // Hitung total data sebelum paginasi
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if ($count == true) {
            $total_count = $query->count();
            return new ApiResource(true, 200, 'Data count retrieved successfully', [], ['count' => $total_count]);
        }

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
        $query = Agenda::with(['createdBy', 'updatedBy'])->where('id', $id);

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
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'organizer' => 'required|string|max:255',
            'file_path' => 'nullable|string|max:255',
        ]);

        $req = $request->all();
        $req['created_by'] = auth()->id();

        $user = auth()->user();
        if ($user->level_id == 3) {
            // Jika user adalah kontributor, status aktif otomatis 0
            $req['is_active'] = 0;
        }

        $data = Agenda::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $data = Agenda::find($id);

        if (!$data) {
            return new ApiResource(false, 404, 'Data not found', [], []);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'organizer' => 'required|string|max:255',
            'file_path' => 'nullable|string|max:255',
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
        $query = Agenda::find($id);

        if (!$query) {
            return new ApiResource(false, 404, 'Data not found', [], []);
        }

        $query->delete();

        if ($query) {
            return new ApiResource(true, 201, 'Data berhasil dihapus', [], []);
        } else {
            return new ApiResource(false, 400, 'Data gagal dihapus', [], []);
        }
    }
}

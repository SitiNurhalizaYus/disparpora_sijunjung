<?php

namespace App\Http\Controllers\Api;

use App\Models\InfoTempat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class InfoTempatController extends Controller
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
        $author_id = $request->get('author_id', null);
        $month = $request->get('month', null);
        $year = $request->get('year', null);

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
        // Default sorting column
        $sort = $request->get('sort', 'id:asc');
        $sort = explode(':', $sort);
        if (count($sort) !== 2 || !in_array($sort[0], ['id', 'name', 'created_at'])) {  // Validasi kolom yang bisa diurutkan
            $sort = ['id', 'asc']; // Gunakan 'id' sebagai default sorting
        }
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // Membuat query dasar untuk tabel InfoTempat dengan relasi createdBy dan updatedBy
        $query = InfoTempat::with(['createdBy', 'updatedBy']);

        // Cek user yang login
        $user = auth()->user();

        // Filter data hanya untuk user yang memiliki level_id == 3 (kontributor)
        if ($user && $user->level_id == 3) {
            // Jika user adalah kontributor, tampilkan hanya data yang dibuat oleh user tersebut
            $query->where('created_by', $user->id);  // Hanya data yang dibuat oleh user login
        }

        // Jika user bukan kontributor (level_id != 3), bisa menampilkan semua data atau filter lain
        if ($request->has('author') && !empty($request->author)) {
            $query->where('created_by', $request->author);
        }

        // Jika tidak ada token API (pengguna belum login), tampilkan data yang aktif saja
        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // Filter berdasarkan where clause jika ada
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn($key, $value);
                } else {
                    $query = $query->where($key, $value);
                }
            }
        }

        // Filter berdasarkan bulan dan tahun (jika ada)
        if ($month && $year) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        } elseif ($year) {
            $query->whereYear('created_at', $year);
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $query = $query->where('name', 'like', "%{$search}%");
        }

        // Metadata dan data
        $metadata = [];
        $metadata['total_data'] = $query->count(); // Hitung total data sebelum paginasi
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
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
        // Cek apakah user tidak autentikasi, filter konten aktif
        $query = InfoTempat::with(['createdBy', 'updatedBy']);

        if (!auth()->guard('api')->user()) {
            // Hanya ambil data yang aktif jika tidak autentikasi
            $query->where('is_active', 1);
        }

        // Ambil data berdasarkan id atau slug
        if (is_numeric($id)) {
            $data = $query->where('id', $id)->first();  // Jika ID berupa angka
        } else {
            $data = $query->where('slug', $id)->first(); // Jika ID berupa slug
        }
        // Cek apakah data ditemukan
        if (!$data) {
            return new ApiResource(false, 404, 'Data not found', [], []);
        }

        // Jika data ditemukan, kembalikan respons
        return new ApiResource(true, 200, 'Get data successful', $data->toArray(), []);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);


        // Generate slug unik berdasarkan title
        $slug = $this->generateUniqueSlug($request->input('name'));
        $req = $request->all();
        $req['slug'] = $slug;
        $req['created_by'] = auth()->id();

        $user = auth()->user();
        if ($user->level_id == 3) {
            // Jika user adalah kontributor, status aktif otomatis 0
            $req['is_active'] = 0;
        }

        $data = InfoTempat::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $data = InfoTempat::find($id);

        if (!$data) {
            return new ApiResource(false, 404, 'Data not found', [], []);
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);


        $slug = $this->generateUniqueSlug($request->input('name'));
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

        if ($data) {
            return new ApiResource(true, 201, 'Data berhasil diperbarui', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal diperbarui', [], []);
        }
    }


    public function destroy($id)
    {
        $query = InfoTempat::find($id);

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

    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (InfoTempat::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}

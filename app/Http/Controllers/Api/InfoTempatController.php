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
        $query = InfoTempat::where([['id', '>', '0']]);

        // cek token
        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn($key, $value);
                } else {
                    $query = $query->where($key, $value);
                }
            }
        }

        if ($search) {
            $query = $query->where('name', 'like', "%{$search}%");
        }

        // metadata dan data
        $metadata = [];
        $metadata['total_data'] = $query->count(); // Hitung total data sebelum paginasi
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if ($count == true) {
            $query = $query->count('id');
            $data['count'] = $query;
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

        // query
        $query = InfoTempat::where([['id', '>', '0']]);

        if (!auth()->guard('api')->user()) {
            $query->where('is_active', 1);
        }

        if (is_numeric($id)) {
            $data = $query->find($id);
        } else {
            $data = $query->where('slug', $id)->first();
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
            'name' => 'required',
        ]);

        $slug = $this->generateUniqueSlug($request->input('title'));
        $req = $request->all();
        $data['slug'] = $slug;
        $data['created_by'] = auth()->id();

        $user = auth()->user();
        if ($user->level_id == 3) {
            // Jika user adalah kontributor, status aktif otomatis 0
            $data['is_active'] = 0;
        }

        $data = InfoTempat::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Data berhasil ditambahkan', $data, []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $data = InfoTempat::findOrFail($id);

        $request->validate([
            'name' => 'required',
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
            return new ApiResource(true, 201, 'Data berhasil diperbarui', $data, []);
        } else {
            return new ApiResource(false, 400, 'Data gagal diperbarui', [], []);
        }
    }


    public function destroy($id)
    {
        $query = InfoTempat::findOrFail($id);
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

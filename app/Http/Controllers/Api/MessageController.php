<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show", "store");
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
            $sort = ['id', 'asc']; // Default sorting jika tidak valid
        }
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Message::where([['id', '>', '0']]);

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

        // Jika count=true, hanya mengembalikan jumlah data
        if ($count == true) {
            $total_count = $query->count();
            return new ApiResource(true, 200, 'Data count retrieved successfully', [], ['count' => $total_count]);
        }

        // metadata dan data
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
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function show($id)
    {
        // query
        $query = Message::where([['id', '>', '0']]);

        // cek token
        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // data
        $data = $query->find($id);

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->post();
        $data = Message::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Insert data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to insert data', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->post();
        $query = Message::findOrFail($id);
        $query->update($req);

        $data = Message::findOrFail($id);

        if ($data) {
            return new ApiResource(true, 201, 'Update data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to update data', [], []);
        }
    }

    public function destroy($id)
    {
        $query = Message::findOrFail($id);
        $query->delete();

        if ($query) {
            return new ApiResource(true, 201, 'Delete data successfull', [], []);
        } else {
            return new ApiResource(false, 400, 'Failed to delete data', [], []);
        }
    }
}

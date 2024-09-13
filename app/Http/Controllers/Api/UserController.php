<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        // parameter
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'users.id_user:asc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;

        // Validasi per_page dan page agar tidak bernilai negatif atau nol
        if ($per_page <= 0) {
            $per_page = 10;
        }
        if ($page <= 0) {
            $page = 1;
        }

        $sort = explode(':', $sort);
        if (count($sort) !== 2) {
            $sort = ['users.id_user', 'asc']; // Default sorting jika tidak valid
        }
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query: joining users and user_levels tables
        $query = User::with(relations: ['levels']);


        // cek token
        $jwt_payload = auth()->guard('api')->user();
        if ($jwt_payload['level_id'] != 1) {
            $query = $query->where('users.id_user', $jwt_payload['id_user']);
        }

        // Filtering berdasarkan kondisi
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn('users.' . $key, $value);
                } else {
                    $query = $query->where('users.' . $key, $value);
                }
            }
        }

        // Filtering berdasarkan pencarian
        if ($search) {
            $query = $query->where(function ($query) use ($search) {
                $query->where('users.username', 'like', "%{$search}%")
                    ->orWhere('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        // data dan metadata
        $data = [];
        $metadata = [];

        // Hitung total data
        $metadata['total_data'] = $query->count('users.id_user');
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if ($count == true) {
            $query = $query->count('id_user');
            $data['count'] = $query;
        }

        // Dapatkan data
        if ($count == true) {
            $data['count'] = $query->count('users.id_user');
        } else {
            $query = $query
                ->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get()
                ->toArray();

            foreach ($query as $qry) {
                $temp = $qry;
                array_push($data, $temp);
            }
        }

        // Kembalikan hasil
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }


    public function show($id_user)
    {
        // query: joining users and user_levels tables
        $data = User::with('levels')->where('id_user', $id_user)->first();

        // cek token
        $jwt_payload = auth()->guard('api')->user();
        if ($jwt_payload['level_id'] != 1 && $jwt_payload['id_user'] != $id_user) {
            return new ApiResource(false, 401, 'Does Not Have Access', [], []);
        }

        // Siapkan data response
        $response = $data->toArray();
        $response['level_name'] = isset($data->levels) ? $data->levels->name : 'Unknown';

        // Return result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $response, []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }


    public function store(Request $request)
    {
        // cek token
        $jwt_payload = auth()->guard('api')->user();
        if ($jwt_payload['level_id'] != 1) {
            return new ApiResource(false, 401, 'Does Not Have Access', [], []);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        $req = $request->all();
        $req['password'] = bcrypt($req['password']);

        $data = User::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Insert data successful', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to insert data', [], []);
        }
    }

    public function update(Request $request, $id_user)
    {
        // Cek token
        $jwt_payload = auth()->guard('api')->user();
        if ($jwt_payload['level_id'] != 1 && $jwt_payload['id_user'] != $id_user) {
            return new ApiResource(false, 401, 'Does Not Have Access', [], []);
        }

        // Validasi data
        $request->validate([
            'name' => 'sometimes|required',
            'email' => 'sometimes|required|unique:users,email,' . $id_user . ',id_user',
            'username' => 'sometimes|required|unique:users,username,' . $id_user . ',id_user',
            'password' => 'sometimes|required',
            'level_id' => 'required' // Pastikan level_id divalidasi
        ]);

        // Ambil semua input
        $req = $request->all();

        // Jika ada password, encrypt
        if ($request->filled('password')) {
            $req['password'] = bcrypt($req['password']);
        } else {
            unset($req['password']);
        }

        // Temukan user
        $user = User::findOrFail($id_user);

        // Update data user
        $user->update($req);

        // Update data session setelah perubahan profil
        AppHelper::instance()->setSession($user->toArray(), session('token'));

        // Ambil data terbaru dengan relasi levels
        $data = User::with('levels')->where('id_user', $id_user)->first();

        // Siapkan data response
        $response = $data->toArray();
        // Tambahkan level_name ke dalam response, cek jika relasi levels ada
        $response['level_name'] = isset($data->levels) ? $data->levels->name : 'Unknown'; // Mengambil nama level
   
        // Return response setelah update
        if ($data) {
            return new ApiResource(true, 201, 'Update data successful', $response, []);
        } else {
            return new ApiResource(false, 400, 'Failed to update data', [], []);
        }
    }


    public function destroy($id_user)
    {
        // cek token
        $jwt_payload = auth()->guard('api')->user();
        if ($jwt_payload['level_id'] != 1) {
            return new ApiResource(false, 401, 'Does Not Have Access', [], []);
        }

        $query = User::findOrFail($id_user);
        $query->delete();

        if ($query) {
            return new ApiResource(true, 201, 'Delete data successful', [], []);
        } else {
            return new ApiResource(false, 400, 'Failed to delete data', [], []);
        }
    }
}

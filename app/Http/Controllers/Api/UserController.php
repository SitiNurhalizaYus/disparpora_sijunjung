<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\User;

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
            $sort = ['id_user', 'asc']; // Default sorting jika tidak valid
        }
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);


        // query
        $query = User::select('users.*', 'user_levels.name as level_name')->join('user_levels', 'users.level_id', '=', 'user_levels.id_user')->where([['users.id_user', '>', '0']]);

        // cek token
        $jwt_payload = auth()->guard('api')->user();
        if ($jwt_payload['level_id'] != 1) {
            $query = $query->where('users.id_user', $jwt_payload['id_user']);
        }

        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn('users.' . $key, $value);
                } else {
                    $query = $query->where('users.' . $key, $value);
                }
            }
        }

        if ($search) {
            $query = $query->whereAny(['users.username', 'users.name', 'users.email'], 'like', "%{$search}%");
        }

        // data
        $data = [];
        $metadata = [];

        // metadata
        $metadata['total_data'] = $query->count('users.id_user');
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if ($count == true) {
            $query = $query->count('users.id_user');
            $data['count'] = $query;
        }
        // get data
        else {
            $query = $query
                ->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get()
                ->toArray();

            foreach ($query as $qry) {
                $temp = $qry;
                array_push($data, $temp);
            };
        }

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function show($id_user)
    {
        // query
        $query = User::select('users.*', 'user_levels.name as level_name')->join('user_levels', 'users.level_id', '=', 'user_levels.id_level')->where([['users.id_user', '>', '0']]);

        // cek token
        $jwt_payload = auth()->guard('api')->user();
        if ($jwt_payload['level_id'] != 1) {
            $query = $query->where('users.id_user', $jwt_payload['id_user']);
        }

        // data
        $data = $query->find($id_user);

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data->toArray(), []);
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

        $req = $request->post();
        $req['password'] = bcrypt($req['password']);

        $data = User::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Insert data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to insert data', [], []);
        }
    }

    public function update(Request $request, $id_user)
    {
        // cek token
        $jwt_payload = auth()->guard('api')->user();
        if ($jwt_payload['level_id'] != 1) {
            if ($jwt_payload['id_user'] != $id_user) {
                return new ApiResource(false, 401, 'Does Not Have Access', [], []);
            }
        }

        $req = $request->post();
        if (isset($req['password'])) {
            $req['password'] = bcrypt($req['password']);
        }

        $query = User::findOrFail($id_user);
        $query->update($req);

        $data = User::findOrFail($id_user);

        if ($data) {
            return new ApiResource(true, 201, 'Update data successfull', $data->toArray(), []);
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
            return new ApiResource(true, 201, 'Delete data successfull', [], []);
        } else {
            return new ApiResource(false, 400, 'Failed to delete data', [], []);
        }
    }
}

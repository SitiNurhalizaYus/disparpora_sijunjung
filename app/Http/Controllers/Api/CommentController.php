<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    public function index(Request $request)
    {
        // Parameter
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'id:asc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $kontenId = $request->query('konten_id'); // Filter berdasarkan konten_id

        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // Query
        $query = Comment::with('user') // Include user relation
                         ->where([['id', '>', '0']]);

        // Filter berdasarkan konten_id
        if ($kontenId) {
            $query = $query->where('konten_id', $kontenId);
        }

        // Check token
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
            $query = $query->where('content', 'like', "%{$search}%");
        }

        // Metadata
        $metadata = [];
        $metadata['total_data'] = $query->count('id');
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // Get count
        if ($count) {
            $query = $query->count('id');
            $data['count'] = $query;
        } else {
            $query = $query
                ->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get()
                ->toArray();

            $data = $query;
        }

        return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
    }

    public function show($id)
    {
        // Query
        $query = Comment::with('user') // Include user relation
                         ->where([['id', '>', '0']]);

        // Check token
        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // Data
        $data = $query->find($id);

        return $data
            ? new ApiResource(true, 200, 'Get data successful', $data->toArray(), [])
            : new ApiResource(false, 200, 'No data found', [], []);
    }

    public function store(Request $request)
    {
        $request->validate([
            'konten_id' => 'required|exists:kontens,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required',
        ]);

        $req = $request->post();
        $data = Comment::create($req);

        return $data
            ? new ApiResource(true, 201, 'Insert data successful', $data->toArray(), [])
            : new ApiResource(false, 400, 'Failed to insert data', [], []);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $req = $request->post();
        $query = Comment::findOrFail($id);
        $query->update($req);

        $data = Comment::findOrFail($id);

        return $data
            ? new ApiResource(true, 200, 'Update data successful', $data->toArray(), [])
            : new ApiResource(false, 400, 'Failed to update data', [], []);
    }

    public function destroy($id)
    {
        $query = Comment::findOrFail($id);
        $query->delete();

        return $query
            ? new ApiResource(true, 200, 'Delete data successful', [], [])
            : new ApiResource(false, 400, 'Failed to delete data', [], []);
    }
}

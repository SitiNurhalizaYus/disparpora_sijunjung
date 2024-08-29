<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    public function index(Request $request)
    {
        // Parameters
        $count = $request->get('count', false);
        $sort = $request->get('sort', 'id:asc');
        $where = $request->get('where', '{}');
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $sort = explode(':', $sort);
        $where = json_decode(str_replace("'", "\"", $where), true);

        // Query Builder
        $query = Gallery::query();

        // If the user is not authenticated, only show active items
        if (!auth()->guard('api')->check()) {
            $query->where('active_status', 1);
        }

        // Apply Where Clauses
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        // Apply Search
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%");
        }

        // Metadata
        $totalData = $query->count();
        $metadata = [
            'total_data' => $totalData,
            'per_page' => $perPage,
            'total_page' => ceil($totalData / $perPage),
            'page' => $page,
        ];

        // Get Count
        if ($count) {
            return new ApiResource(true, 200, 'Count data successful', ['count' => $totalData], $metadata);
        }

        // Apply Sorting
        $query->orderBy($sort[0], $sort[1]);

        // Apply Pagination
        if ($perPage > 0) {
            $query->limit($perPage)->offset(($page - 1) * $perPage);
        }

        $data = $query->get();

        // Result
        if ($data->isNotEmpty()) {
            return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function show($id)
    {
        $query = Gallery::query();

        if (!auth()->guard('api')->check()) {
            $query->where('active_status', 1);
        }

        $data = $query->find($id);

        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data, []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);
        $data = Gallery::create($request->all());

        if ($data) {
            return new ApiResource(true, 201, 'Insert data successful', $data, []);
        } else {
            return new ApiResource(false, 400, 'Failed to insert data', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(['title' => 'required']);
        $query = Gallery::findOrFail($id);
        $query->update($request->all());

        $data = Gallery::find($id);

        if ($data) {
            return new ApiResource(true, 201, 'Update data successful', $data, []);
        } else {
            return new ApiResource(false, 400, 'Failed to update data', [], []);
        }
    }

    public function destroy($id)
    {
        $query = Gallery::findOrFail($id);
        $query->delete();

        return new ApiResource(true, 201, 'Delete data successful', [], []);
    }
}

<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show");
    }

    public function index(Request $request)
    {
        // Parameter dan query
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
        $query = Content::query();

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
            $query = $query->where('title', 'like', "%{$search}%");
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
        return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
    }

    public function show($id)
    {
        $content = Content::findOrFail($id);

        if ($content->type !== 'profil') {
            $content->load(['category', 'arsip']);
        }

        return new ApiResource(true, 200, 'Get data successful', $content->toArray(), []);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents',
            'content' => 'required',
            'type' => 'required|in:berita,artikel,profil',
            'is_active' => 'boolean',
        ]);

        $content = Content::create($request->all());

        return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $content->toArray(), []);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug,' . $id,
            'content' => 'required',
            'type' => 'required|in:berita,artikel,profil',
            'is_active' => 'boolean',
        ]);

        $content = Content::findOrFail($id);
        $content->update($request->all());

        return new ApiResource(true, 200, 'Data berhasil diperbarui', $content->toArray(), []);
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        return new ApiResource(true, 200, 'Data berhasil dihapus', [], []);
    }
}

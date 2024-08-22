<?php 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show");
    }

    public function index(Request $request)
    {
        try {
            // Logging parameter untuk debugging
            Log::info('Request parameters:', $request->all());

            // Parameter dan query
            $count = $request->has('count') ? $request->get('count') : false;
            $sort = $request->get('sort', 'id:asc');
            $where = $request->get('where', '{}');
            $search = $request->get('search', '');
            $type = $request->get('type', null);  // Menambahkan filter type
            $per_page = $request->get('per_page', 10);
            $page = $request->get('page', 1);

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

            // Query dasar
            $query = Content::query();

            // Filter berdasarkan tipe konten (profil, berita, artikel)
            if ($type) {
                $query->where('type', $type);
            }

            // Jika user tidak terautentikasi, hanya ambil konten yang aktif
            if (!auth()->guard('api')->user()) {
                $query->where('is_active', 1);
            }

            // Filter tambahan berdasarkan `where` dari request
            if ($where) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        $query->whereIn($key, $value);
                    } else {
                        $query->where($key, $value);
                    }
                }
            }

            // Pencarian berdasarkan title
            if ($search) {
                $query->where('title', 'like', "%{$search}%");
            }

            // Metadata untuk pagination
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

            // Hasil response dengan format ApiResource
            return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
        } catch (\Exception $e) {
            Log::error('Error in ContentController@index: ' . $e->getMessage());

            return new ApiResource(false, 500, 'Server Error', [], []);
        }
    }

    public function show($id)
    {
        try {
            $content = Content::findOrFail($id);

            // Hanya load relasi jika tipe bukan 'profil'
            if ($content->type !== 'profil') {
                $content->load(['category', 'arsip']);
            }

            return new ApiResource(true, 200, 'Get data successful', $content->toArray(), []);
        } catch (\Exception $e) {
            Log::error('Error in ContentController@show: ' . $e->getMessage());

            return new ApiResource(false, 500, 'Server Error', [], []);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'slug' => 'required|unique:contents',
                'content' => 'required',
                'type' => 'required|in:berita,artikel,profil',
                'is_active' => 'boolean',
            ]);

            $content = Content::create($request->all());

            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $content->toArray(), []);
        } catch (\Exception $e) {
            Log::error('Error in ContentController@store: ' . $e->getMessage());

            return new ApiResource(false, 500, 'Server Error', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error in ContentController@update: ' . $e->getMessage());

            return new ApiResource(false, 500, 'Server Error', [], []);
        }
    }

    public function destroy($id)
    {
        try {
            $content = Content::findOrFail($id);
            $content->delete();

            return new ApiResource(true, 200, 'Data berhasil dihapus', [], []);
        } catch (\Exception $e) {
            Log::error('Error in ContentController@destroy: ' . $e->getMessage());

            return new ApiResource(false, 500, 'Server Error', [], []);
        }
    }
}

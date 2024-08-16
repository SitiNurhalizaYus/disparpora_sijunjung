<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Agent;

class AgentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show","getAllData","getKategori");
    }

    public function getKategori()
    {
        $categories = Kategori::all();
        return response()->json($categories);
    }

    public function index(Request $request)
    {
        // parameter
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'agents.id:asc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $kategoriId = $request->query('kategori_id'); // Tambahkan kategori_id

        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Agent::where([['id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('agents.is_active', 1);
        }

        // Tambahkan filter kategori_id
        if ($kategoriId) {
            $query = $query->where('agents.kategori_id', $kategoriId);
        }

        if($where){
            foreach($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn('agents.'.$key, $value);
                } else {
                    $query = $query->where('agents.'.$key, $value);
                }
            }
        }

        if($search){
            $query = $query->whereAny(['agents.nama'], 'like', "%{$search}%");
        }

        // data
        $data = [];
        $metadata = [];

        // metadata
        $metadata['total_data'] = $query->count('agents.id');
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if($count == true) {
            $query = $query->count('agents.id');
            $data['count'] = $query;
        }
        // get data
        else {
            if ($per_page > 0) {
                $query = $query
                    ->orderBy($sort[0], $sort[1])
                    ->limit($per_page)
                    ->offset(($page-1) * $per_page)
                    ->get()
                    ->toArray();
            } else {
                $query = $query
                    ->orderBy($sort[0], $sort[1])
                    ->get()
                    ->toArray();
            }

            foreach ($query as $qry) {
                $temp = $qry;
                $temp['datetime_local'] = \App\Helpers\AppHelper::instance()->convertDateTimeIndo($temp['created_at']);
                array_push($data, $temp);
            };
        }

        // result
        if($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

   
    public function show($id)
    {
        // query
        $query = Agent::where([['id','>','0']]);
                        
        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('agents.is_active', 1);
        }

        // data
        if(is_numeric($id)) {
            $data = $query->find($id);
        } else {
            $query = $query->where('agents.slug', $id);
            $data = $query->first();
        }

        // result
        if($data) {
            if(is_numeric($id)) {
                $data = $data->toArray();
                $data['datetime_local'] =  \App\Helpers\AppHelper::instance()->convertDateTimeIndo($data['datetime']);
                return new ApiResource(true, 200, 'Get data successfull', $data, []);
            } else {
                $data['datetime_local'] =  \App\Helpers\AppHelper::instance()->convertDateTimeIndo($data['datetime']);
                return new ApiResource(true, 200, 'Get data successfull', $data, []);
            }
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    public function getAllData(Request $request)
    {
        // parameter
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'id:asc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;

        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Agent::select('agents.*', 'kategoris.name as kategori')
            ->join('kategoris', 'agents.kategori_id', '=', 'kategoris.id')
            ->where([['agents.id', '>', '0']]);

        // check token
        if (!auth()->guard('api')->user()) {
            $query = $query->where('agents.is_active', 1);
        }

        if ($where) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn('agents.' . $key, $value);
                } else {
                    $query = $query->where('agents.' . $key, $value);
                }
            }
        }

        if ($search) {
            $query = $query->whereAny(['agents.nama'], 'like', "%{$search}%");
        }

        // data
        $data = [];
        $metadata = [];

        // metadata
        $metadata['total_data'] = $query->count('agents.id');

        // get count
        if ($count == true) {
            $query = $query->count('id');
            $data['count'] = $query;
        }
        // get data
        else {
            if ($per_page > 0) {
                $query = $query
                    ->orderBy($sort[0], $sort[1])
                    ->limit($per_page)
                    ->offset(($page - 1) * $per_page)
                    ->get()
                    ->toArray();
            } else {
                $query = $query
                    ->orderBy($sort[0], $sort[1])
                    ->get()
                    ->toArray();
            }

            foreach ($query as $qry) {
                $temp = $qry;
                array_push($data, $temp);
            };
        }

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get all data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $req = $request->post();
        $data = Agent::create($req);

        if($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $req = $request->post();
        $query = Agent::findOrFail($id);
        $query->update($req);

        $data = Agent::findOrFail($id);

        if($data) {
            return new ApiResource(true, 201, 'Data berhasil diperbarui', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal diperbarui', [], []);
        }
    }

    
    public function destroy($id)
    {
        $query = Agent::findOrFail($id);
        $query->delete();

        if($query) {
            return new ApiResource(true, 201, 'Data berhasil dihapus', [], []);
        } else {
            return new ApiResource(false, 400, 'Data gagal dihapus', [], []);
        }
    }
}

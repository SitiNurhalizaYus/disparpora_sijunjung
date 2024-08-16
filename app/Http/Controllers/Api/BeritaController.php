<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show");
    }

    public function index(Request $request)
    {
        // parameter
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'beritas.id:asc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;

        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Berita::select('beritas.*', 'users.name as created_name')->join('users','beritas.created_by','=','users.id')->where([['beritas.id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('beritas.is_active', 1);
        }

        if($where){
            foreach($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn('beritas.'.$key, $value);
                } else {
                    $query = $query->where('beritas.'.$key, $value);
                }
            }
        }

        if($search){
            $query = $query->whereAny(['beritas.name'], 'like', "%{$search}%");
        }

        // data
        $data = [];
        $metadata = [];

        // metadata
        $metadata['total_data'] = $query->count('beritas.id');
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if($count == true) {
            $query = $query->count('beritas.id');
            $data['count'] = $query;
        }
        // get data
        else {
            $query = $query
                ->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page-1) * $per_page)
                ->get()
                ->makeHidden(['description_long'])
                ->toArray();

            foreach($query as $qry) {
                $temp = $qry;
                $temp['datetime_local'] = \App\Helpers\AppHelper::instance()->convertDateTimeIndo($temp['datetime']);
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
        $query = Berita::select('beritas.*', 'users.name as created_name')->join('users','beritas.created_by','=','users.id')->where([['beritas.id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('beritas.is_active', 1);
        }

        // data
        if(is_numeric($id)) {
            $data = $query->find($id);
        } else {
            $query = $query->where('beritas.slug', $id);
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->post();
        $data = Berita::create($req);

        if($data) {
            return new ApiResource(true, 201, 'Data telah berhasil ditambahkan', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal ditambahkan', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->post();
        $query = Berita::findOrFail($id);
        $query->update($req);

        $data = Berita::findOrFail($id);

        if($data) {
            return new ApiResource(true, 201, 'Data berhasil diperbarui', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Data gagal diperbarui', [], []);
        }
    }

    public function destroy($id)
    {
        $query = Berita::findOrFail($id);
        $query->delete();

        if($query) {
            return new ApiResource(true, 201, 'Data berhasil dihapus', [], []);
        } else {
            return new ApiResource(false, 400, 'Data gagal dihapus', [], []);
        }
    }
}

<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Upload;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;

class UploadController extends Controller
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
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;

        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Upload::where([['id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('active_status', 1);
        }

        if($where){
            foreach($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn($key, $value);
                } else {
                    $query = $query->where($key, $value);
                }
            }
        }

        if($search){
            $query = $query->whereAny(['name'], 'like', "%{$search}%");
        }

        // data
        $data = [];
        $metadata = [];

        // metadata
        $metadata['total_data'] = $query->count('id');
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if($count == true) {
            $query = $query->count('id');
            $data['count'] = $query;
        }
        // get data
        else {
            $query = $query
                ->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page-1) * $per_page)
                ->get()
                ->toArray();

            foreach($query as $qry) {
                $temp = $qry;
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
        $query = Upload::where([['id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('active_status', 1);
        }

        // data
        $data = $query->first();

        // result
        if($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }


    public function store(Request $request)
    {
        if($request->hasFile('image')) {

            $image = $request->file('image');
            $file = $image->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $size = $request->file('image')->getSize();

            setlocale(LC_TIME, 'IND');
            $date_format = Carbon::now()->format('Ymd_His');
            $filename_new = $date_format.'-'.str_replace(' ','_', $filename).'.'.$extension;

            $hd = $request->has('hd') ? $request->get('hd') == true : false;

            if ($hd == true) {
                $image_resize_100 = ImageManager::gd()->read($image->getRealPath())->resize(100, 100)->save(public_path('uploads/100/' .$filename_new));
                $image_resize_300 = ImageManager::gd()->read($image->getRealPath())->resize(300, 300)->save(public_path('uploads/300/' .$filename_new));
                $image_resize_500 = ImageManager::gd()->read($image->getRealPath())->resize(500, 500)->save(public_path('uploads/500/' .$filename_new));
                $image_resize_1000 = ImageManager::gd()->read($image->getRealPath())->resize(1000, 1000)->save(public_path('uploads/1000/' .$filename_new));
            }else {
                $image_resize_100 = ImageManager::gd()->read($image->getRealPath())->resize(100, 100)->save(public_path('uploads/100/' .$filename_new));
                $image_resize_300 = ImageManager::gd()->read($image->getRealPath())->resize(300, 300)->save(public_path('uploads/300/' .$filename_new));
                $image_resize_500 = ImageManager::gd()->read($image->getRealPath())->resize(500, 500)->save(public_path('uploads/500/' .$filename_new));
            }
            
            $req = [
                'name' => $filename,
                'type' => $extension,
                'ext' => '.' . $extension,
                'size' => $size,
                'hd' => $hd,
                'hash' => $filename_new,
                'url' => 'uploads/xxx/' . $filename_new,
            ];
            $data = Upload::create($req);

            if($data) {
                return new ApiResource(true, 201, 'Insert data successfull', $data->toArray(), ['url'=>'change xxx to 100/300/500/1000']);
            } else {
                return new ApiResource(false, 400, 'Failed to insert data', [], []);
            }

        } else {
            return new ApiResource(false, 400, 'Image not found', [], []);
        }

    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->post();
        $query = Upload::findOrFail($id);
        
        $req = $request->only(['name', 'type', 'ext', 'size', 'hd', 'hash', 'url']); // Sesuaikan dengan kolom yang ingin diperbarui
        $query->update($req);

        $data = Upload::findOrFail($id);

        if($data) {
            return new ApiResource(true, 201, 'Update data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to update data', [], []);
        }
    }

    public function destroy($id)
    {
        $query = Upload::findOrFail($id);
        $query->delete();

        if($query) {
            return new ApiResource(true, 201, 'Delete data successfull', [], []);
        } else {
            return new ApiResource(false, 400, 'Failed to delete data', [], []);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show");
    }

    /**
     * @OA\Get(
     *     path="/blog",
     *     tags={"Blog"},
     *     summary="",
     *     description="Get all data",
     *     operationId="blog_index",
     *     @OA\Parameter(
     *          name="per_page",
     *          description="per_page value is number. ex : ?per_page=10",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          description="page value is number. ex : ?page=1",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="sort",
     *          description="Sort value is string with rule column-name:order. ex : ?sort=id:asc",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="where",
     *          description="Where value is object. ex : ?where={'name':['john','doe'], 'dob':'1990-12-31'}",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="count",
     *          description="Count value is boolean. ex : ?count=true",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Get Data Successfull",
     *                  "data"={},
     *                  "metadata"={"total_data":"", "per_page":"", "total_page":"", "page":""}
     *              }
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        // parameter
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'blogs.id:asc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;

        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Blog::select('blogs.*', 'users.name as created_name')->join('users','blogs.created_by','=','users.id')->where([['blogs.id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('blogs.is_active', 1);
        }

        if($where){
            foreach($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn('blogs.'.$key, $value);
                } else {
                    $query = $query->where('blogs.'.$key, $value);
                }
            }
        }

        if($search){
            $query = $query->whereAny(['blogs.name'], 'like', "%{$search}%");
        }

        // data
        $data = [];
        $metadata = [];

        // metadata
        $metadata['total_data'] = $query->count('blogs.id');
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if($count == true) {
            $query = $query->count('blogs.id');
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

    /**
     * @OA\Get(
     *     path="/blog/{id}",
     *     tags={"Blog"},
     *     summary="",
     *     description="Get data by id",
     *     operationId="blog_show",
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Get Data Successfull",
     *                  "data"={},
     *                  "metadata"={}
     *              }
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        // query
        $query = Blog::select('blogs.*', 'users.name as created_name')->join('users','blogs.created_by','=','users.id')->where([['blogs.id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('blogs.is_active', 1);
        }

        // data
        if(is_numeric($id)) {
            $data = $query->find($id);
        } else {
            $query = $query->where('blogs.slug', $id);
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

    /**
     * @OA\Post(
     *     path="/blog",
     *     tags={"Blog"},
     *     summary="",
     *     description="Insert data",
     *     operationId="blog_store",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Insert Data Successfull",
     *                  "data"={},
     *                  "metadata"={}
     *              }
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->post();
        $data = Blog::create($req);

        if($data) {
            return new ApiResource(true, 201, 'Insert data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to insert data', [], []);
        }
    }

    /**
     * @OA\Put(
     *     path="/blog/{id}",
     *     tags={"Blog"},
     *     summary="",
     *     description="Update data",
     *     operationId="blog_update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Update Data Successfull",
     *                  "data"={},
     *                  "metadata"={}
     *              }
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->post();
        $query = Blog::findOrFail($id);
        $query->update($req);

        $data = Blog::findOrFail($id);

        if($data) {
            return new ApiResource(true, 201, 'Update data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to update data', [], []);
        }
    }

    /**
     * @OA\Delete(
     *     path="/blog/{id}",
     *     tags={"Blog"},
     *     summary="",
     *     description="Delete data",
     *     operationId="blog_destroy",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Delete Data Successfull",
     *                  "data"={},
     *                  "metadata"={}
     *              }
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $query = Blog::findOrFail($id);
        $query->delete();

        if($query) {
            return new ApiResource(true, 201, 'Delete data successfull', [], []);
        } else {
            return new ApiResource(false, 400, 'Failed to delete data', [], []);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Message;


class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show", "store");
    }

    public function show($id)
    {
        // query
        $query = Message::where([['id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // data
        $data = $query->find($id);

        // result
        if($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    /**
     * @OA\Post(
     *     path="/message",
     *     tags={"Message"},
     *     summary="",
     *     description="Insert data",
     *     operationId="message_store",
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
        $data = Message::create($req);

        if($data) {
            return new ApiResource(true, 201, 'Insert data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to insert data', [], []);
        }
    }

    /**
     * @OA\Put(
     *     path="/message/{id}",
     *     tags={"Message"},
     *     summary="",
     *     description="Update data",
     *     operationId="message_update",
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
        $query = Message::findOrFail($id);
        $query->update($req);

        $data = Message::findOrFail($id);

        if($data) {
            return new ApiResource(true, 201, 'Update data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to update data', [], []);
        }
    }

    /**
     * @OA\Delete(
     *     path="/message/{id}",
     *     tags={"Message"},
     *     summary="",
     *     description="Delete data",
     *     operationId="message_destroy",
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
        $query = Message::findOrFail($id);
        $query->delete();

        if($query) {
            return new ApiResource(true, 201, 'Delete data successfull', [], []);
        } else {
            return new ApiResource(false, 400, 'Failed to delete data', [], []);
        }
    }
}

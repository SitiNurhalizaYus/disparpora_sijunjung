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
        $query = Upload::where([['id', '>', '0']]);

        // cek token
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
            $query = $query->where('name', 'like', "%{$search}%");
        }

        // data dan metadata
        $metadata['total_data'] = $query->count('id');
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        // get count
        if ($count == true) {
            $data['count'] = $query->count('id');
        } else {
            $data = $query
                ->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get()
                ->toArray();
        }

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function show($id)
    {
        // query
        $query = Upload::where([['id', '>', '0']]);

        // cek token
        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // data
        $data = $query->first();

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $file = $image->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();

            setlocale(LC_TIME, 'IND');
            $date_format = Carbon::now()->format('Ymd_His');
            $filename_new = $date_format . '-' . str_replace(' ', '_', $filename) . '.' . $extension;

            $hd = $request->has('hd') ? $request->get('hd') == true : false;

            // Resize dan simpan gambar
            $this->resizeAndSaveImage($image, $filename_new, $hd);

            $req = [
                'name' => $filename,
                'type' => $extension,
                'ext' => '.' . $extension,
                'size' => $size,
                'hd' => $hd,
                'hash' => $filename_new,
                'url' => 'uploads/xxx/' . $filename_new
            ];
            $data = Upload::create($req);

            if ($data) {
                return new ApiResource(true, 201, 'Insert data successful', $data->toArray(), ['url' => 'change xxx to 100/300/500/1000']);
            } else {
                return new ApiResource(false, 400, 'Failed to insert data', [], []);
            }
        } else {
            return new ApiResource(false, 400, 'Image not found', [], []);
        }
    }

    public function update(Request $request, $id)
    {
        $upload = Upload::findOrFail($id);

        // Cek apakah ada file gambar baru yang diunggah
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file = $image->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();

            // Format nama file baru
            $date_format = Carbon::now()->format('Ymd_His');
            $filename_new = $date_format . '-' . str_replace(' ', '_', $filename) . '.' . $extension;

            // Resize dan simpan gambar
            $hd = $request->has('hd') ? $request->get('hd') == true : false;
            $this->resizeAndSaveImage($image, $filename_new, $hd);

            // Hapus gambar lama dari storage
            $this->deleteOldImage($upload);

            // Update informasi gambar di database
            $upload->update([
                'name' => $filename,
                'type' => $extension,
                'ext' => '.' . $extension,
                'size' => $size,
                'hd' => $hd,
                'hash' => $filename_new,
                'url' => 'uploads/xxx/' . $filename_new,
            ]);

            return new ApiResource(true, 200, 'Update data successful', $upload->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Image not found', [], []);
        }
    }

    public function destroy($id)
    {
        $upload = Upload::findOrFail($id);

        // Hapus gambar dari storage
        $this->deleteOldImage($upload);

        // Hapus data dari tabel uploads
        $upload->delete();

        return new ApiResource(true, 201, 'Delete data successful', [], []);
    }

    private function resizeAndSaveImage($image, $filename_new, $hd)
    {
        if ($hd == true) {
            $image_resize_100 = ImageManager::gd()->read($image->getRealPath())->resize(100, 100)->save(public_path('uploads/100/' . $filename_new));
            $image_resize_300 = ImageManager::gd()->read($image->getRealPath())->resize(300, 300)->save(public_path('uploads/300/' . $filename_new));
            $image_resize_500 = ImageManager::gd()->read($image->getRealPath())->resize(500, 500)->save(public_path('uploads/500/' . $filename_new));
            $image_resize_1000 = ImageManager::gd()->read($image->getRealPath())->resize(1000, 1000)->save(public_path('uploads/1000/' . $filename_new));
        } else {
            $image_resize_100 = ImageManager::gd()->read($image->getRealPath())->resize(100, 100)->save(public_path('uploads/100/' . $filename_new));
            $image_resize_300 = ImageManager::gd()->read($image->getRealPath())->resize(300, 300)->save(public_path('uploads/300/' . $filename_new));
            $image_resize_500 = ImageManager::gd()->read($image->getRealPath())->resize(500, 500)->save(public_path('uploads/500/' . $filename_new));
        }
    }

    private function deleteOldImage($upload)
    {
        if ($upload) {
            $paths = [
                public_path('uploads/100/' . $upload->hash),
                public_path('uploads/300/' . $upload->hash),
                public_path('uploads/500/' . $upload->hash),
                public_path('uploads/1000/' . $upload->hash),
            ];

            foreach ($paths as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }
    }
}

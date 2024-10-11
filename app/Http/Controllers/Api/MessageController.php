<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Mail\ReplyMessageMail;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationEmail;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show", "store");
    }

    public function index(Request $request)
    {
        $count = $request->get('count', false);
        $sort = $request->get('sort', 'id:asc');
        $where = $request->get('where', '{}');
        $search = $request->get('search', '');
        $per_page = intval($request->get('per_page', 10));
        $page = intval($request->get('page', 1));

        if ($per_page <= 0) $per_page = 10;
        if ($page <= 0) $page = 1;

        $sort = explode(':', $sort);
        if (count($sort) !== 2) {
            $sort = ['id', 'asc'];
        }

        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        $query = Message::where([['id', '>', '0']]);

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

        if ($count == true) {
            $total_count = $query->count();
            return new ApiResource(true, 200, 'Data count retrieved successfully', [], ['count' => $total_count]);
        }

        $metadata = [];
        $metadata['total_data'] = $query->count();
        $metadata['per_page'] = $per_page;
        $metadata['total_page'] = ceil($metadata['total_data'] / $metadata['per_page']);
        $metadata['page'] = $page;

        if ($per_page == 0 || $per_page == 'all') {
            $data = $query->orderBy($sort[0], $sort[1])->get()->toArray();
            $metadata['total_data'] = count($data);
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

        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function show($id)
    {
        $query = Message::where([['id', '>', '0']]);

        if (!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        $data = $query->find($id);

        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 200, 'No data found', [], []);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $req = $request->post();
        $data = Message::create($req);

        if ($data) {
            return new ApiResource(true, 201, 'Insert data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to insert data', [], []);
        }
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $req = $request->post();
        $query = Message::findOrFail($id);
        $query->update($req);

        $data = Message::findOrFail($id);

        if ($data) {
            return new ApiResource(true, 201, 'Update data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 400, 'Failed to update data', [], []);
        }
    }

    public function destroy($id)
    {
        $query = Message::findOrFail($id);
        $query->delete();

        if ($query) {
            return new ApiResource(true, 201, 'Delete data successfull', [], []);
        } else {
            return new ApiResource(false, 400, 'Failed to delete data', [], []);
        }
    }

    public function sendReply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $message = Message::findOrFail($id);

        $message->reply = $request->input('reply');
        $message->updated_by = auth()->user()->id;
        $message->is_active = 1; // Pesan dianggap sudah dibalas
        $message->save();

        try {
            Mail::to($message->email)->send(new ReplyMessageMail($message->name, $message->reply, $message->subject));

            return new ApiResource(true, 200, 'Balasan berhasil dikirim dan email terkirim ke pengirim pesan.', [], []);
        } catch (\Exception $e) {
            return new ApiResource(false, 500, 'Gagal mengirim balasan. Silakan coba lagi.', [], []);
        }
    }

    public function sendConfirmationEmail($id)
    {
        $message = Message::findOrFail($id);

        try {
            // Mengirim email menggunakan Mail Facade dan mailable yang sudah dibuat
            Mail::to($message->email)->send(new ConfirmationEmail($message));

            // Update kolom 'verified' menjadi 1 di tabel message
            $message->verified = 1;
            $message->save();

            return response()->json(['success' => true, 'message' => 'Email konfirmasi berhasil dikirim.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email.']);
        }
    }
}

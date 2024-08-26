<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Menyimpan komentar baru
    public function store(Request $request)
    {
        $request->validate([
            'konten_id' => 'required|exists:kontens,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string',
        ]);

        $comment = Comment::create($request->all());

        // Mengalihkan pengguna kembali ke halaman konten yang di-comment
        return redirect()->back()->with('success', 'Comment added successfully');
    }
}

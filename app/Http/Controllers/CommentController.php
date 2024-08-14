<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function show()
    {
        return response()->json(Comment::query()->where('status', 0)->get());
    }

    public function show_user($id)
    {
        $block = Block::query()->find($id);
        $comments = Comment::query()->where('block_id', $block->id)->where('status', 1)->get();
        return response()->json($comments);
    }

    public function change_status(Request $request, $id)
    {
        $comment = Comment::query()->find($id);
        if (!$comment) {
            return response()->json('Упс, комментарий не найден. Перезагрузите страницу и повторите попытку снова!', 404);
        }
        $comment->status = $request->status;
        $comment->save();
        if ($request->status === 1) {
            return response()->json('Комментарий успешно подтвержден!', 200);
        }
        else if ($request->status === 0) {
            return response()->json('Комментарий успешно отклонен!', 200);
        }
    }

    public function create(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2', 'max:15'],
            'email' => ['required', 'email:dns,rfc'],
            'text' => ['required', 'max:255']
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 500);
        }
        Comment::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'text' => $request->text,
            'block_id' => $request->block_id
        ]);
        return response()->json('Комментарий успешно создан!', 200);
    }
}


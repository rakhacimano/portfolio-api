<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['count'] = Comment::count();

        if ($data['count'] > 0) {
            $data['comments'] = Comment::all();

            return ResponseFormatter::success(
                $data,
                'Data comment berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data comment tidak ada',
                404
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => ['required', 'integer'],
            'content' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $comment = Comment::create($request->all());

        if ($comment) {
            return ResponseFormatter::success(
                $comment,
                'Data comment berhasil ditambahkan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data comment gagal ditambahkan',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $comment = Comment::find($id);

        if ($comment) {
            return ResponseFormatter::success(
                $comment,
                'Data comment berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data comment tidak ada',
                404
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => ['required', 'integer'],
            'content' => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $comment->update($request->all());

        if ($comment) {
            return ResponseFormatter::success(
                $comment,
                'Data comment berhasil diperbarui'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data comment gagal diperbarui',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        if ($comment) {
            return ResponseFormatter::success(
                null,
                'Data comment berhasil dihapus'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data comment gagal dihapus',
                500
            );
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['count'] = Article::count();

        if ($data['count'] > 0) {
            $data['articles'] = Article::all();

            return ResponseFormatter::success(
                $data,
                'Data artikel berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data artikel tidak ada',
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
    public function store(StoreArticleRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:50'],
            'content' => ['required', 'string'],
            'slug' => ['required', 'string', 'max:50', 'unique:articles'],
            'category_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $article = Article::create($request->all());

        if ($article) {
            return ResponseFormatter::success(
                $article,
                'Data artikel berhasil ditambahkan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data artikel gagal ditambahkan',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::find($id);

        if ($article) {
            return ResponseFormatter::success(
                $article,
                'Data artikel berhasil ditemukan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data artikel tidak ada',
                404
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['string', 'max:50'],
            'content' => ['text'],
            'slug' => ['string', 'max:50', 'unique:articles'],
            'media_id' => ['integer'],
            'category_id' => ['integer'],
            'user_id' => ['integer'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $article->update($request->all());

        if ($article) {
            return ResponseFormatter::success(
                $article,
                'Data artikel berhasil diperbarui'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data artikel gagal diperbarui',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        if ($article) {
            return ResponseFormatter::success(
                null,
                'Data artikel berhasil dihapus'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data artikel gagal dihapus',
                500
            );
        }
    }
}

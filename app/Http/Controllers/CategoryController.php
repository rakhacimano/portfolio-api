<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['count'] = Category::count();

        if ($data['count'] > 0) {
            $data['categories'] = Category::all();

            return ResponseFormatter::success(
                $data,
                'Data kategori berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data kategori tidak ada',
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
    public function store(StoreCategoryRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails())
        {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $category = Category::create($request->all());

        if ($category) {
            return ResponseFormatter::success(
                $category,
                'Data kategori berhasil ditambahkan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data kategori gagal ditambahkan',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);

        if ($category) {
            return ResponseFormatter::success(
                $category,
                'Data kategori berhasil ditemukan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data kategori tidak ada',
                404
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails())
        {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $category->update($request->all());

        if ($category) {
            return ResponseFormatter::success(
                $category,
                'Data kategori berhasil diperbarui'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data kategori gagal diperbarui',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        if ($category) {
            return ResponseFormatter::success(
                null,
                'Data kategori berhasil dihapus'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data kategori gagal dihapus',
                500
            );
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['count'] = Portfolio::count();

        if ($data['count'] > 0) {
            $data['portfolios'] = Portfolio::all();

            return ResponseFormatter::success(
                $data,
                'Data portfolio berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data portfolio tidak ada',
                404
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePortfolioRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:50'],
            'content' => ['required', 'string'],
            'slug' => ['required', 'string', 'max:50', 'unique:articles'],
            'media_id' => ['integer'],
            'user_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $portfolio = Portfolio::create($request->all());

        if ($portfolio) {
            return ResponseFormatter::success(
                $portfolio,
                'Data portfolio berhasil ditambahkan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data portfolio gagal ditambahkan',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $portfolio = Portfolio::find($id);

        if ($portfolio) {
            return ResponseFormatter::success(
                $portfolio,
                'Data portfolio berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data portfolio tidak ada',
                404
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['string', 'max:50'],
            'content' => ['text'],
            'slug' => ['string', 'max:50', 'unique:articles'],
            'media_id' => ['integer'],
            'user_id' => ['integer'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $portfolio->update($request->all());

        if ($portfolio) {
            return ResponseFormatter::success(
                $portfolio,
                'Data portfolio berhasil diperbarui'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data portfolio gagal diperbarui',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        if ($portfolio) {
            return ResponseFormatter::success(
                null,
                'Data portfolio berhasil dihapus'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data portfolio tidak ada',
                404
            );
        }
    }
}

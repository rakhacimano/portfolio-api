<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Media;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['count'] = Media::count();

        if ($data['count'] > 0) {
            $data['media'] = Media::all();

            return ResponseFormatter::success(
                $data,
                'Data media berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data media tidak ada',
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
    public function store(StoreMediaRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => ['required', 'string', 'max:255', 'mimes:jpg,png,jpeg'],
        ]);

        if ($validator->fails())
        {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $path = $request->file('path')->store('public');

        $media = Media::create([
            'path' => $path,
        ]);

        if ($media) {
            return ResponseFormatter::success(
                $media,
                'Data media berhasil ditambahkan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data media gagal ditambahkan',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $media = Media::find($id);

        if ($media) {
            return ResponseFormatter::success(
                $media,
                'Data media berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data media tidak ada',
                404
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaRequest $request, Media $media)
    {
        $validator = Validator::make($request->all(), [
            'path' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails())
        {
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors()
                ],
            );
        }

        $media->update($request->all());

        if ($media) {
            return ResponseFormatter::success(
                $media,
                'Data media berhasil diperbarui'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data media gagal diperbarui',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        $media->delete();

        if ($media) {
            return ResponseFormatter::success(
                null,
                'Data media berhasil dihapus'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data media gagal dihapus',
                500
            );
        }
    }
}

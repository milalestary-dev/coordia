<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengumumanController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Data pengumuman berhasil diambil.',
            'data' => Pengumuman::latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'author' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pengumuman = Pengumuman::create($validator->validated());

        return response()->json([
            'message' => 'Data pengumuman berhasil dibuat.',
            'data' => $pengumuman,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $pengumuman = Pengumuman::find($id);

        if (! $pengumuman) {
            return response()->json([
                'message' => 'Data pengumuman tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data pengumuman berhasil diambil.',
            'data' => $pengumuman,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $pengumuman = Pengumuman::find($id);

        if (! $pengumuman) {
            return response()->json([
                'message' => 'Data pengumuman tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'content' => ['sometimes', 'required', 'string'],
            'author' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pengumuman->update($validator->validated());

        return response()->json([
            'message' => 'Data pengumuman berhasil diperbarui.',
            'data' => $pengumuman,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $pengumuman = Pengumuman::find($id);

        if (! $pengumuman) {
            return response()->json([
                'message' => 'Data pengumuman tidak ditemukan.',
            ], 404);
        }

        $pengumuman->delete();

        return response()->json([
            'message' => 'Data pengumuman berhasil dihapus.',
        ]);
    }
}

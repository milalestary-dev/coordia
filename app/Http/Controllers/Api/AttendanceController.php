<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Data attendance berhasil diambil.',
            'data' => Attendance::latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $attendance = Attendance::create($validator->validated());

        return response()->json([
            'message' => 'Data attendance berhasil dibuat.',
            'data' => $attendance,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $attendance = Attendance::find($id);

        if (! $attendance) {
            return response()->json([
                'message' => 'Data attendance tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data attendance berhasil diambil.',
            'data' => $attendance,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $attendance = Attendance::find($id);

        if (! $attendance) {
            return response()->json([
                'message' => 'Data attendance tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'status' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $attendance->update($validator->validated());

        return response()->json([
            'message' => 'Data attendance berhasil diperbarui.',
            'data' => $attendance,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $attendance = Attendance::find($id);

        if (! $attendance) {
            return response()->json([
                'message' => 'Data attendance tidak ditemukan.',
            ], 404);
        }

        $attendance->delete();

        return response()->json([
            'message' => 'Data attendance berhasil dihapus.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MeetingNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeetingNoteController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Data meeting notes berhasil diambil.',
            'data' => MeetingNote::latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'meeting_title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $meetingNote = MeetingNote::create($validator->validated());

        return response()->json([
            'message' => 'Data meeting notes berhasil dibuat.',
            'data' => $meetingNote,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $meetingNote = MeetingNote::find($id);

        if (! $meetingNote) {
            return response()->json([
                'message' => 'Data meeting notes tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data meeting notes berhasil diambil.',
            'data' => $meetingNote,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $meetingNote = MeetingNote::find($id);

        if (! $meetingNote) {
            return response()->json([
                'message' => 'Data meeting notes tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'meeting_title' => ['sometimes', 'required', 'string', 'max:255'],
            'content' => ['sometimes', 'required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $meetingNote->update($validator->validated());

        return response()->json([
            'message' => 'Data meeting notes berhasil diperbarui.',
            'data' => $meetingNote,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $meetingNote = MeetingNote::find($id);

        if (! $meetingNote) {
            return response()->json([
                'message' => 'Data meeting notes tidak ditemukan.',
            ], 404);
        }

        $meetingNote->delete();

        return response()->json([
            'message' => 'Data meeting notes berhasil dihapus.',
        ]);
    }
}

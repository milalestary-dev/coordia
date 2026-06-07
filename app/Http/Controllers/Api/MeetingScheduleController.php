<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MeetingSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeetingScheduleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Data meeting schedule berhasil diambil.',
            'data' => MeetingSchedule::latest('meeting_date')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'agenda' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'meeting_date' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $meetingSchedule = MeetingSchedule::create($validator->validated());

        return response()->json([
            'message' => 'Data meeting schedule berhasil dibuat.',
            'data' => $meetingSchedule,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $meetingSchedule = MeetingSchedule::find($id);

        if (! $meetingSchedule) {
            return response()->json([
                'message' => 'Data meeting schedule tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data meeting schedule berhasil diambil.',
            'data' => $meetingSchedule,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $meetingSchedule = MeetingSchedule::find($id);

        if (! $meetingSchedule) {
            return response()->json([
                'message' => 'Data meeting schedule tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'agenda' => ['sometimes', 'required', 'string'],
            'location' => ['sometimes', 'required', 'string', 'max:255'],
            'meeting_date' => ['sometimes', 'required', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $meetingSchedule->update($validator->validated());

        return response()->json([
            'message' => 'Data meeting schedule berhasil diperbarui.',
            'data' => $meetingSchedule,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $meetingSchedule = MeetingSchedule::find($id);

        if (! $meetingSchedule) {
            return response()->json([
                'message' => 'Data meeting schedule tidak ditemukan.',
            ], 404);
        }

        $meetingSchedule->delete();

        return response()->json([
            'message' => 'Data meeting schedule berhasil dihapus.',
        ]);
    }
}

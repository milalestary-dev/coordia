<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        return $this->store($request);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $auth = Auth::where('username', $validated['username'])->first();

        if (! $auth || ! Hash::check($validated['password'], $auth->password)) {
            return response()->json([
                'message' => 'Username atau password salah.',
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil.',
            'data' => $auth,
        ]);
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Data auth berhasil diambil.',
            'data' => Auth::latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:auths,username'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $auth = Auth::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Data auth berhasil dibuat.',
            'data' => $auth,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $auth = Auth::find($id);

        if (! $auth) {
            return response()->json([
                'message' => 'Data auth tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data auth berhasil diambil.',
            'data' => $auth,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $auth = Auth::find($id);

        if (! $auth) {
            return response()->json([
                'message' => 'Data auth tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => ['sometimes', 'required', 'string', 'max:255', 'unique:auths,username,'.$id],
            'password' => ['sometimes', 'required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $auth->update($validated);

        return response()->json([
            'message' => 'Data auth berhasil diperbarui.',
            'data' => $auth,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $auth = Auth::find($id);

        if (! $auth) {
            return response()->json([
                'message' => 'Data auth tidak ditemukan.',
            ], 404);
        }

        $auth->delete();

        return response()->json([
            'message' => 'Data auth berhasil dihapus.',
        ]);
    }
}

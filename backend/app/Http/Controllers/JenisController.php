<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();

        return response()->json([
            'success' => true,
            'data' => $jenis
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_name' => 'required|string',
            'poin_per_rakaat' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $is_exist = Jenis::where('jenis_name', $request->jenis_name)->first();
        if ($is_exist) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis already exist'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $jenis = Jenis::create([
                'jenis_name' => $request->jenis_name,
                'poin_per_rakaat' => $request->poin_per_rakaat,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $jenis
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $jenis = Jenis::find($id);
        if (!$jenis) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jenis
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_name' => 'nullable|string',
            'poin_per_rakaat' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $jenis = Jenis::find($id);
        if (!$jenis) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis not found'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $jenis->jenis_name = $request->jenis_name ?? $jenis->jenis_name;
            $jenis->poin_per_rakaat = $request->poin_per_rakaat ?? $jenis->poin_per_rakaat;
            $jenis->save();

            return response()->json([
                'success' => true,
                'data' => $jenis
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $jenis = Jenis::find($id);
        if (!$jenis) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis not found'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $jenis->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Jenis deleted'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Monitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MonitorController extends Controller
{
    public function generateRatio($a, $b)
    {
        if ($a == 0 && $b == 0) {
            return [0, 0];
        }

        if ($b == 0) {
            return [1, 0];
        }

        if ($a == 0) {
            return [0, 1];
        }

        $gcd = $this->findGCD($a, $b);
        return [
            (int) round($a / $gcd),
            (int) round($b / $gcd)
        ];
    }

    private function findGCD($a, $b)
    {
        if ($b == 0) {
            return $a;
        }

        return $this->findGCD($b, $a % $b);
    }

    public function index()
    {
        $monitor = Monitor::all();
        return response()->json([
            'sucsess' => true,
            'message' => 'Data berhasil ditampilkan',
            'data' => $monitor
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_monitor' => 'required',
            'tanggal_monitor' => 'required',
            'jenis_id' => 'required',
            'total_rakaat' => 'required',
            'total_gagal' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        DB::beginTransaction();
        try {
            $monitor = [];
            $total_poin_rakaat = 0;
            $jenis_data = [];

            foreach ($request->jenis_id as $jenis_id) {
                $jenis = Jenis::find($jenis_id);
                $poin_per_rakaat = $jenis->poin_per_rakaat * $request->total_rakaat;
                $total_poin_rakaat += $poin_per_rakaat;
                $jenis_data[$jenis_id] = [
                    'jenis' => $jenis,
                    'poin_per_rakaat' => $poin_per_rakaat
                ];
            }

            $total_poin_setelah_gagal = $total_poin_rakaat - $request->total_gagal;

            foreach ($jenis_data as $jenis_id => $data) {
                $ratio = $this->generateRatio($data['poin_per_rakaat'], $total_poin_rakaat);
                $poin_gerakan = ($total_poin_setelah_gagal * $ratio[0]) / $ratio[1];
                $persentase = ($poin_gerakan / $data['poin_per_rakaat']) * 100;

                $monitor[] = Monitor::create([
                    'nama_monitor' => $request->nama_monitor,
                    'tanggal_monitor' => $request->tanggal_monitor,
                    'jenis_id' => $jenis_id,
                    'total_rakaat' => $request->total_rakaat,
                    'total_sukses' => $poin_gerakan,
                    'total_gagal' => $data['poin_per_rakaat'] - $poin_gerakan,
                    'persentase' => $persentase,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $monitor
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_monitor' => 'required',
            'tanggal_monitor' => 'required',
            'jenis_id' => 'required',
            'total_rakaat' => 'required',
            'total_gagal' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $monitor = Monitor::with('jenis')->find($id);
        if (!$monitor) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $total_poin_rakaat = $request->total_rakaat * $monitor->jenis->poin_per_rakaat;
            $persentase = ($total_poin_rakaat - $request->total_gagal) / $total_poin_rakaat * 100;
            $monitor->update([
                'nama_monitor' => $request->nama_monitor,
                'tanggal_monitor' => $request->tanggal_monitor,
                'jenis_id' => $request->jenis_id,
                'total_rakaat' => $request->total_rakaat,
                'total_sukses' => $total_poin_rakaat - $request->total_gagal,
                'total_gagal' => $request->total_gagal,
                'persentase' => $request->persentase ?? $persentase,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah',
                'data' => $monitor
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $monitor = Monitor::find($id);
        if (!$monitor) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditampilkan',
            'data' => $monitor
        ], 200);
    }

    public function destroy($id)
    {
        $monitor = Monitor::find($id);
        if (!$monitor) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $monitor->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

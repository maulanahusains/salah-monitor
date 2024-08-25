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
            $total_poin_per_rakaat = [];
            for ($i = 0; $i < count($request->jenis_id); $i++) {
                $jenis_id = $request->jenis_id[$i];
                $jenis = Jenis::find($jenis_id);
                $total_poin_per_rakaat[$jenis_id] = $jenis->poin_per_rakaat * $request->total_rakaat;
            }

            $total_poin_rakaat = array_sum($total_poin_per_rakaat);

            $monitor[] = Monitor::create([
                'nama_monitor' => $request->nama_monitor,
                'tanggal_monitor' => $request->tanggal_monitor,
                'jenis_id' => $request->jenis_id[$i],
                'total_rakaat' => $request->total_rakaat,
                'total_gagal' => $request->total_gagal,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $monitor
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}

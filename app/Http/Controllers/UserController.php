<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class UserController extends Controller
{
    public function DonutChart()
    {
        $currentMonth = Carbon::now()->month;
        $locations = DB::table('pengiriman')
            ->join('lokasi', 'pengiriman.lokasi_id', '=', 'lokasi.id')
            ->select('lokasi.nama_lokasi', DB::raw('COUNT(*) as total'))
            ->whereMonth('pengiriman.tanggal', $currentMonth)
            ->groupBy('lokasi.nama_lokasi')
            // ->havingRaw('total > 100')
            ->get();

        return response()->json($locations);
    }
    public function DonutChartV2()
    {
        $currentYear = Carbon::now()->year;

        $items = DB::table('pengiriman')
            ->join('barang', 'pengiriman.barang_id', '=', 'barang.id')
            ->select('barang.nama_barang', DB::raw('COUNT(*) as total'))
            ->whereYear('pengiriman.tanggal', $currentYear)
            ->where('barang.harga_barang', '>', 1000)
            ->groupBy('barang.nama_barang')
            ->get();

        return response()->json($items);
    }
    public function InputDataController(Request $request)
    {
        if ($request->barang == null || $request->lokasi == null || $request->no_transaksi == null || $request->jumlah_barang == null) {
            return redirect()
                ->back()
                ->with('error', 'Silahkan isi semua data.');
        } else {
            if ($request->jumlah_barang < 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Minimal jumlah barang adalah 0.');
            } else {
                $stock = DB::TABLE('barang')
                    ->where('id', $request->barang)
                    ->value('stok_barang');
                if ($stock < $request->jumlah_barang) {
                    return redirect()
                        ->back()
                        ->with('error', 'Stok tidak mencukupi.');
                } else {
                    $price = DB::TABLE('barang')
                        ->where('id', $request->barang)
                        ->value('harga_barang');
                    $total = $price * $request->jumlah_barang;
                    $kurir_id = DB::TABLE('kurir')
                        ->where('name', session()->get('username'))
                        ->value('id');

                    $todaySend = DB::TABLE('pengiriman')
                        ->where('lokasi_id', $request->lokasi)
                        ->where('tanggal', date('Y-m-d'))
                        ->count();

                    $transaksi_count = DB::TABLE('pengiriman')
                        ->where('no_pengiriman', $request->no_transaksi)
                        ->count();

                    if ($transaksi_count > 0) {
                        return redirect()
                            ->back()
                            ->with('error', 'No Transaksi telah terdaftar didalam database.');
                    } else {
                        if ($todaySend > 4) {
                            return redirect()
                                ->back()
                                ->with('error', 'Kota ini sudah mencapai batas.');
                        } else {
                            $insert = DB::TABLE('pengiriman')->insert([
                                'no_pengiriman' => $request->no_transaksi,
                                'tanggal' => date('Y-m-d H:i:s'),
                                'lokasi_id' => $request->lokasi,
                                'barang_id' => $request->barang,
                                'jumlah_barang' => $request->jumlah_barang,
                                'harga_barang' => $total,
                                'kurir_id' => $kurir_id,
                            ]);
                            if ($insert) {
                                DB::TABLE('barang')
                                    ->where('id', $request->barang)
                                    ->update([
                                        'stok_barang' => $stock - $request->jumlah_barang,
                                    ]);
                                return redirect()
                                    ->back()
                                    ->with('success', 'Data berhasil diinput.');
                            } else {
                                return redirect()
                                    ->back()
                                    ->with('error', 'Terjadi kesalahan.');
                            }
                        }
                    }
                }
            }
        }
    }
}

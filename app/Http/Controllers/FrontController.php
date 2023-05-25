<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function cek(){
        return view('cek');
    }
    public function ceknis(Request $request){
        $detail = Student::where('nis', $request->nis)->first();
        $data = Payment::where('nis', $request->nis)
        ->where('acc','y')
        ->orderBy('id_bayar', 'desc')
        ->limit(3)
        ->get();
        if(!$detail){
            return redirect()->route('cek')->with('gagal', 'Data tidak ditemukan, periksa kembali NIS anda!');
        } else {
            return view('spp', compact('data', 'detail'));
        }
        
    }
    public function bayar(Request $request){
        Payment::create([
            'nis' => $request->nis,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'makan' => 0,
            'spp' => 0,
            'subsidi' => 0,
            'total' => 0,
            'acc' => 'n'
        ]);
        
        return redirect()->route('cek')->with("sukses","Pembayaran bulan ".$request->bulan." dan tahun ".$request->tahun." berhasil diajukan, silakan lakukan pembayaran di Sekolah atau hubungi operator");
    }
}

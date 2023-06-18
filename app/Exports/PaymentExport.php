<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
    public $bln, $thn;
    public function __construct($bln)
    {
        $this->bln = $bln;
    }
    public function view(): View
    {
        $data = DB::table('payments')
        ->leftJoin('students','students.nis','payments.nis')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->where('payments.created_at', 'like','%'.$this->bln.'%')
        ->where('acc','y')
        ->select('payments.nis','nama','bulan','tahun','makan','spp','total','acc','payments.created_at','subsidi','id_bayar', 'payments.updated_at', 'nama_kelas')
        ->orderBy('payments.nis', 'asc')
        ->get();
        return view('excel.alldata',[
            'data' => $data
        ]);
    }
}

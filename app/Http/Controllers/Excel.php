<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel as Sheet;

class Excel extends Controller
{
    public function allData($bln){
        return Sheet::download(new PaymentExport($bln), $bln.'-spp.xlsx');
    }
}

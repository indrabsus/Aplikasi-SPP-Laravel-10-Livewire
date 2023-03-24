<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Pembayaran extends Component
{
    public $nama, $status, $id_kelas, $wa_ortu, $nis, $bulan, 
    $tahun, $makan, $spp, $subsidi, $total, $switch, $acc, $id_bayar;
    public $data2;
    use WithPagination;
    public $cari = '';
    public $acc2 = 'y';
    public $carinis = '';
    public $result = 10;
    public $caribulan = '';
    public $caritgl = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = DB::table('payments')
        ->leftJoin('students','students.nis','payments.nis')
        ->where('nama', 'like','%'.$this->cari.'%')
        ->where('payments.nis', 'like','%'.$this->carinis.'%')
        ->where('payments.acc', 'like','%'.$this->acc2.'%')
        ->where('payments.bulan', 'like','%'.$this->caribulan.'%')
        ->where('payments.created_at', 'like','%'.$this->caritgl.'%')
        ->orderBy('id_bayar', 'desc')
        ->paginate($this->result);
        return view('livewire.petugas.pembayaran', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->bulan = '';
        $this->tahun = '';
        $this->spp = '';
        $this->subsidi = '';
    }
    public function k_bayar($id){
        
        $data = Payment::where('id_bayar', $id)->first();
        $this->id_bayar = $data->id_bayar;
        $this->nis = $data->nis;
        $this->bulan = $data->bulan;
        $this->tahun = $data->tahun;
        $this->spp = $data->spp;
        $this->subsidi = $data->subsidi;
        $this->total = $data->total;
        $this->makan = $data->makan;
        $this->acc = $data->acc;
    }
    public function bayar(){
        $this->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'spp' => 'required',
            'subsidi' => 'required',
            'acc' => 'required'
        ]);

        $hitung = Payment::where('nis', $this->nis)
        ->where('bulan', $this->bulan)
        ->where('tahun', $this->tahun)
        ->where('acc', 'y')
        ->count();

        if($hitung < 1){
            Payment::where('id_bayar', $this->id_bayar)->update([
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
                'subsidi' => $this->subsidi,
                'spp' => $this->spp,
                'total' => $this->makan + $this->spp - $this->subsidi,
                'acc' => $this->acc
            ]);
            $this->clearForm();
            session()->flash('sukses', 'Data berhasil diedit');
            $this->dispatchBrowserEvent('closeModal');
        } else {
            $this->clearForm();
            session()->flash('gagal', 'Terdeteksi data ganda');
            $this->dispatchBrowserEvent('closeModal');
        }

        
    }
    public function k_hapus($id){
        $data = Payment::where('id_bayar',$id)->first();
        $this->id_bayar = $data->id_bayar;
    }
    public function delete(){
        Payment::where('id_bayar', $this->id_bayar)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    
}

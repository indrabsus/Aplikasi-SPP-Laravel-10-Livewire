<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Payment;
use App\Models\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Pengajuan extends Component
{
    public $bulan, $tahun, $subsidi, $nis, $id_bayar;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = DB::table('requests')
        ->leftJoin('payments','payments.id_bayar','requests.id_bayar')
        ->leftJoin('students','students.nis','payments.nis')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->where('nama', 'like','%'.$this->cari.'%')
        ->orderBy('id_pengajuan', 'desc')
        ->paginate($this->result);
        return view('livewire.petugas.pengajuan',compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function k_acc($id){
        $data = Payment::where('id_bayar', $id)->first();
        $this->bulan = $data->bulan;
        $this->tahun = $data->tahun;
        $this->makan = $data->makan;
        $this->spp = $data->spp;
        $this->subsidi = $data->subsidi;
        $this->nis = $data->nis;
        $this->id_bayar = $data->id_bayar;
    }
    public function prosesacc(){
        $this->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'subsidi' => 'required'
        ]);

        $hitung = Payment::where('nis', $this->nis)
        ->where('bulan', $this->bulan)
        ->where('tahun', $this->tahun)
        ->where('acc', 'y')
        ->count();

        if($hitung<1){
            $data = [
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
                'subsidi' => $this->subsidi,
                'total' => $this->makan + $this->spp - $this->subsidi,
                'acc' => 'y'
            ];
            Payment::where('id_bayar', $this->id_bayar)->update($data);
            session()->flash('sukses', 'Data berhasil ditambahkan');
            $this->dispatchBrowserEvent('closeModal');
        } else {
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
        $this->dispatchBrowserEvent('closeModal');
    }
}

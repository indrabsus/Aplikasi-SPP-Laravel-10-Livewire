<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Group;
use App\Models\Payment;
use App\Models\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Controllers\Controller;

class StudentMgmt extends Component
{
    public $nama, $status, $id_kelas, $wa_ortu, $nis, $bulan, $no_va, $tgl_lahir,
    $tahun, $makan, $spp, $subsidi, $total, $switch, $kelompok, $ortu;
    public $data2;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = DB::table('students')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->where('nama', 'like','%'.$this->cari.'%')
        ->orderBy('students.created_at', 'desc')
        ->paginate($this->result);
        $kelas = Group::all();
        return view('livewire.petugas.student-mgmt', compact('data','kelas'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nis = '';
        $this->nama = '';
        $this->status = '';
        $this->id_kelas = '';
        $this->bulan = '';
        $this->tahun = '';
        $this->spp = '';
        $this->subsidi = '';
        $this->no_va = '';
        $this->tgl_lahir = '';
    }
    public function insert(){
        $this->validate([
            'nis' => 'required|unique:students',
            'nama' => 'required',
            'status' => 'required',
            'id_kelas' => 'required',
            'wa_ortu' => 'required',
            'no_va' => 'required',
            'tgl_lahir' => 'required',
        ],[
            'nama.required' => 'Nama tidak boleh kosong!',
            'nis.required' => 'NIS tidak boleh kosong!',
            'nis.unique' => 'NIS sudah digunakan!',
            'status.required' => 'Status tidak boleh kosong!',
            'id_kelas.required' => 'Kelas tidak boleh kosong!',
            'wa_ortu.required' => 'Wa Orang Tua tidak boleh kosong!',
            'no_va.required' => 'No Va tidak boleh kosong!',
            'tgl_lahir.required' => 'Tgl Lahir tidak boleh kosong!',
        ]);
        Student::create([
            'nis' => $this->nis,
            'nama' => ucwords($this->nama),
            'status' => $this->status,
            'id_kelas' => $this->id_kelas,
            'wa_ortu' => $this->wa_ortu,
            'no_va' => $this->no_va,
            'tgl_lahir' => $this->tgl_lahir,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $this->data2 = null;
        $data = Student::where('nis',$id)->first();

        $this->nis = $data->nis;
        $this->nama = $data->nama;
        $this->status = $data->status;
        $this->wa_ortu = $data->wa_ortu;
        $this->id_kelas = $data->id_kelas;
        $this->no_va = $data->no_va;
        $this->tgl_lahir = $data->tgl_lahir;
    }
    public function update(){
        $this->validate([
            'nis' => 'required',
            'nama' => 'required',
            'status' => 'required',
            'wa_ortu' => 'required',
            'id_kelas' => 'required',
            'no_va' => 'required',
            'tgl_lahir' => 'required',
        ]);
        Student::where('nis', $this->nis)->update([
            'nis' => $this->nis,
            'nama' => ucwords($this->nama),
            'status' => $this->status,
            'id_kelas' => $this->id_kelas,
            'wa_ortu' => $this->wa_ortu,
            'no_va' => $this->no_va,
            'tgl_lahir' => $this->tgl_lahir,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $this->data2 = null;
        $data = Student::where('nis',$id)->first();
        $this->nis = $data->nis;
    }
    public function delete(){
        Student::where('nis', $this->nis)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_bayar($id){
        $this->data2 = null;
        $data = DB::table('students')->where('nis', $id)->first();
        $this->nis = $data->nis;
        $this->status = $data->status;
        $this->nama = $data->nama;
    }
    public function bayar(){
        $con = new Controller;
        $konfig = $con->cons();
        $this->validate([
                'bulan' => 'required',
                'tahun' => 'required',
        ]);
        $hitung = Payment::where('nis', $this->nis)
        ->where('bulan', $this->bulan)
        ->where('tahun', $this->tahun)
        ->count();

        if($hitung<1){
            $data = [
                'nis' => $this->nis,
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
                'spp' => $this->spp,
                'makan' => $this->makan,
                'subsidi' => $this->subsidi == null ? 0 : $this->subsidi,
                'total' => $this->spp + $this->makan - $this->subsidi
             ];
             $text = "Siswa atas nama ".$this->nama.", dengan NIS: ".$this->nis.", sudah membayar SPP Bulan ".$this->bulan." ".$this->tahun." Subsidi Rp.".number_format($this->subsidi).", Total pembayaran Rp.".number_format($this->spp + $this->makan - $this->subsidi);
             Http::get('https://api.telegram.org/bot'.$konfig['token'].'/sendMessage?chat_id='.$konfig['chatid'].'&text='.$text);
            Payment::create($data);
            $this->clearForm();
            session()->flash('sukses', 'Data berhasil ditambahkan');
            $this->dispatchBrowserEvent('closeModal');
        } else {
            session()->flash('gagal', 'Data sudah ada');
            $this->dispatchBrowserEvent('closeModal');
        }

        // if($hitung<1){
        //     if($this->switch == 'm'){
        //         $this->validate([
        //             'spp' => 'required'
        //         ]);
        //         if($this->status == 'fd'){
        //             $data = [
        //                 'nis' => $this->nis,
        //                 'bulan' => $this->bulan,
        //                 'tahun' => $this->tahun,
        //                 'spp' => $this->spp,
        //                 'makan' => 200000,
        //                 'subsidi' => $this->subsidi == null ? 0 : $this->subsidi,
        //                 'total' => $this->spp + 200000 - $this->subsidi
        //              ];
        //         } elseif($this->status == 'bs'){
        //             $data = [
        //                 'nis' => $this->nis,
        //                 'bulan' => $this->bulan,
        //                 'tahun' => $this->tahun,
        //                 'spp' => $this->spp,
        //                 'makan' => 375000,
        //                 'subsidi' => $this->subsidi == null ? 0 : $this->subsidi,
        //                 'total' => $this->spp + 375000 - $this->subsidi
        //              ];
        //         }
        //     } elseif($this->switch == 'o'){
        //         if($this->status == 'fd'){
        //             $data = [
        //                 'nis' => $this->nis,
        //                 'bulan' => $this->bulan,
        //                 'tahun' => $this->tahun,
        //                 'spp' => 500000,
        //                 'makan' => 200000,
        //                 'subsidi' => $this->subsidi == null ? 0 : $this->subsidi,
        //                 'total' => 700000 - $this->subsidi
        //              ];
        //         } elseif($this->status == 'bs'){
        //             $data = [
        //                 'nis' => $this->nis,
        //                 'bulan' => $this->bulan,
        //                 'tahun' => $this->tahun,
        //                 'spp' => 500000,
        //                 'makan' => 375000,
        //                 'subsidi' => $this->subsidi == null ? 0 : $this->subsidi,
        //                 'total' => 875000 - $this->subsidi
        //              ];
        //         }
        //     }
             
        //     Payment::create($data);
        //     $this->clearForm();
        //     session()->flash('sukses', 'Data berhasil ditambahkan');
        //     $this->dispatchBrowserEvent('closeModal');
        // } else {
        //     session()->flash('gagal', 'Data berhasil sudah ada');
        //     $this->dispatchBrowserEvent('closeModal');
        // }

        
    }
    public function history($id){
        $data = DB::table('payments')
        ->where('nis', $id)
        ->where('acc','y')
        ->orderBy('id_bayar', 'desc')
        ->limit(3)
        ->get();
        $this->data2 = $data;
    }
    public function req($id){
        $this->data2 = null;
        
        $data = Student::where('nis', $id)->first();
        $this->nama = $data->nama;
        $this->nis = $data->nis;
        $this->id_kelas = $data->id_kelas;
        $this->status = $data->status;
    }
    public function prosesreq(){
        $this->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'subsidi' => 'required',
            'kelompok' => 'required',
            'ortu' => 'required'
        ]);

        $data1 = [
            'nis' => $this->nis,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'makan' => 0,
            'spp' => 0,
            'subsidi' => $this->subsidi,
            'total' => 0 - $this->subsidi,
            'acc' => 'n'
        ];
        $bayar = Payment::create($data1);
        $data2 = [
            'kelompok' => $this->kelompok,
            'org_tua' => $this->ortu,
            'id_bayar' => $bayar->id_bayar,
            'tgl_pengajuan' => now()
        ];
        Request::create($data2);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
}

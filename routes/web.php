<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\Admin\Index;
use App\Http\Livewire\Admin\UserMgmt;
use App\Http\Livewire\Petugas\GroupMgmt;
use App\Http\Livewire\Petugas\Pembayaran;
use App\Http\Livewire\Petugas\Pengajuan;
use App\Http\Livewire\Petugas\StudentMgmt;
use Illuminate\Support\Facades\Route;


Route::get('/',[AuthController::class,'index'])->name('index');
Route::post('proseslogin', [AuthController::class,'login'])->name('login');
Route::get('logout',[AuthController::class,'logout'])->name('logout');
Route::group(['middleware' => ['auth']], function(){
    Route::group(['middleware' => ['cekrole:admin']], function(){
        Route::get('admin', Index::class)->name('indexadmin');
        Route::get('admin/usermgmt', UserMgmt::class)->name('usermgmt');
        Route::get('admin/studentmgmt', StudentMgmt::class)->name('studentmgmt');
        Route::get('admin/groupmgmt', GroupMgmt::class)->name('groupmgmt');
        Route::get('admin/pembayaran', Pembayaran::class)->name('pembayaran');
        Route::get('admin/pengajuan', Pengajuan::class)->name('pengajuan');
    });
    Route::group(['middleware' => ['cekrole:petugas']], function(){
        Route::get('petugas', Index::class)->name('indexpetugas');
        Route::get('petugas/studentmgmt', StudentMgmt::class)->name('petugas-studentmgmt');
        Route::get('petugas/groupmgmt', GroupMgmt::class)->name('petugas-groupmgmt');
        Route::get('petugas/pembayaran', Pembayaran::class)->name('petugas-pembayaran');
        Route::get('petugas/pengajuan', Pengajuan::class)->name('petugas-pengajuan');
    });
});
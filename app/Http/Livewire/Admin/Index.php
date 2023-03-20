<?php

namespace App\Http\Livewire\Admin;

use App\Models\Payment;
use App\Models\Student;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $bs = Student::where('status','bs')->count();
        $fd = Student::where('status', 'fd')->count();
        $subsidi = Payment::where('acc', 'y')->sum('subsidi');
        $total = Payment::where('acc', 'y')->sum('total');
        return view('livewire.admin.index', compact('bs','fd','subsidi','total'))
        ->extends('layouts.app')
        ->section('content');
    }
}

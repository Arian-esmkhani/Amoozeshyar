<?php

namespace App\Livewire;

use Livewire\Component;

class Amoozeshyar extends Component
{
    public $userRole;
    public $isStudent = false;
    public $isTeacher = false;

    public function mount($userRole)
    {
        $this->userRole = $userRole;
        $this->isStudent = auth()->user()->isStudent();
        $this->isTeacher = auth()->user()->isTeacher();
    }

    public function render()
    {
        return view('livewire.amoozeshyar');
    }
}

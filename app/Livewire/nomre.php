<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LessonStatus;

class Nomre extends Component
{
    public $status;

    public $userName;

    public function mount()
    {
        $this->status = $data -> lessonStatus;
        $this->userName = $data['userData']->name;
    }

    public function saveNomre($nomre , $studentName , $lessonName)
    {
        $lessonStatus = LessonStatus::where('master_name', $this->userName )
                                    ->where('student_name', $studentName)
                                    ->where('lesson_name', $lessonName)
                                    ->first();

        $lessonStatus->update([
            'lesson_score' => $nomre
        ]);

        session()->flash('message', "نمره دانش‌آموز {$studentName} برای درس {$lessonName} ذخیره شد.");
    }

    public function render()
    {
        return view('livewire.nomreView');
    }
}
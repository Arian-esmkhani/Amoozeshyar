<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MasterBase;

class Score extends Component
{
    public $lessonMaster;

    public function mount($data)
    {
        $this->lessonMaster = $data;
    }

    public function saveScore($score)
    {
        $masterBase = MasterBase::where('master_name', $this->date->lesssonData)->first();

        $newUsersSave = $masterBase->users_save + 1;
        $newMasterScore = ($masterBase->master_score + $score) / $newUsersSave;

        $masterBase->update([
            'users_save' => $newUsersSave,
            'master_score' => $newMasterScore
        ]);
    }

    public function render()
    {
        return view('livewire.ScoreView');
    }
}

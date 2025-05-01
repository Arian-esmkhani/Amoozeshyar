<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MasterBase;

class Score extends Component
{
    public $userData;
    public $lessonMaster;

    public function mount($data)
    {
        $this->userData = $data['userData'];
        $this->lessonMaster = $data['lessonMaster'];
    }

    public function saveScore($score)
    {

        $masterBase = MasterBase::where('master_name', $this->lessonMaster)->first();
        $studentIds = $this->userData->user_id;

        $studentId = json_decode($masterBase->student_id, true);
        $studentsIds = [];
        $studentsIds = is_array($studentId) ? array_values($studentId) : [];

        if(in_array($studentIds, $studentsIds)) {
            session()->flash('message', 'قبلا نمره ثبت شده است برای این استاد');
            session()->flash('type', 'error');
        }else{
            $currentScore = (float) $masterBase->master_score;
            $currentUsersSave = (int) $masterBase->users_savee ?? 0;

            $newTotalScore = ($currentScore * $currentUsersSave) + $score;
            $newUsersSave = $currentUsersSave + 1;
            $newMasterScore = ($newUsersSave > 0) ? ($newTotalScore / $newUsersSave) : $score;

            try {
                $masterBase->update([
                    'users_savee' => $newUsersSave,
                    'master_score' => $newMasterScore,
                    'student-id' => json_encode($studentIds)
                ]);

                session()->flash('message', 'نمره شما با موفقیت ثبت شد.');
                session()->flash('type', 'success');
            } catch (\Exception $e) {
                session()->flash('message', 'خطایی در هنگام ثبت نمره رخ داد: ' . $e->getMessage());
                session()->flash('type', 'error');
            }
        }

    }

    public function render()
    {
        return view('livewire.ScoreView');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MasterBase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class Score extends Component
{
    public $data;
    public $scores = [];

    public function mount($data)
    {
        $this->data = $data;
        if (isset($this->data['evaluationData']) && is_iterable($this->data['evaluationData'])) {
            foreach ($this->data['evaluationData'] as $item) {
                if (isset($item['lesson_id'])) {
                    $this->scores[$item['lesson_id']] = null;
                }
            }
        }
    }

    public function saveScore($lessonId)
    {
        if (empty($this->data) || empty($this->data['evaluationData']) || !is_iterable($this->data['evaluationData'])) {
            session()->flash('message', 'اطلاعات لازم برای ارزیابی در دسترس نیست.');
            session()->flash('type', 'error');
            return;
        }

        $userId = Auth::id();
        if (!$userId) {
            session()->flash('message', 'برای ثبت نمره، ابتدا باید وارد شوید.');
            session()->flash('type', 'error');
            return;
        }

        $evaluationItem = null;
        if (isset($this->data['evaluationData']) && is_iterable($this->data['evaluationData'])) {
            $evaluationItem = Arr::first($this->data['evaluationData'], function ($item) use ($lessonId) {
                return isset($item['lesson_id']) && $item['lesson_id'] == $lessonId;
            });
        }

        if (!$evaluationItem || !isset($evaluationItem['master_name'])) {
            session()->flash('message', 'اطلاعات مورد نیاز برای ارزیابی یافت نشد.');
            session()->flash('type', 'error');
            return;
        }

        $masterBase = MasterBase::where('master_name', $evaluationItem['master_name'])->first();

        if (!$masterBase) {
            session()->flash('message', 'اطلاعات استاد مورد نظر یافت نشد.');
            session()->flash('type', 'error');
            return;
        }

        $studentIds = json_decode($masterBase->{'student-id'} ?? '[]', true) ?? [];
        if (!is_array($studentIds)) {
            $studentIds = [];
        }

        if (in_array($userId, $studentIds)) {
            session()->flash('message', 'شما قبلاً برای این درس/استاد نمره ثبت کرده‌اید.');
            session()->flash('type', 'warning');
            return;
        }

        if (!array_key_exists($lessonId, $this->scores)) {
            session()->flash('message', 'خطا: نمره برای درس مشخص نشده است.');
            session()->flash('type', 'error');
            return;
        }
        $score = $this->scores[$lessonId];

        if (!is_numeric($score) || $score < 1 || $score > 10) {
            session()->flash('message', 'نمره وارد شده معتبر نیست (باید عددی بین 1 تا 10 باشد).');
            session()->flash('type', 'error');
            return;
        }
        $score = (int) $score;

        $currentScore = (float) $masterBase->master_score;
        $currentUsersSave = (int) $masterBase->{'users-save'} ?? 0;

        $newTotalScore = ($currentScore * $currentUsersSave) + $score;
        $newUsersSave = $currentUsersSave + 1;
        $newMasterScore = ($newUsersSave > 0) ? ($newTotalScore / $newUsersSave) : $score;

        $studentIds[] = $userId;

        try {
            $masterBase->update([
                'users-save' => $newUsersSave,
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

    public function render()
    {
        return view('livewire.ScoreView');
    }
}

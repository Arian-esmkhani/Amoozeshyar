<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;//محاسبه مقادیر

class Slider extends Component
{
    // نوع اسلاید
    public string $type;
    // عنوان اسلاید
    public string $title;
    // لینک مشاهده همه
    public string $viewAllLink;
    // آیتم‌های اسلاید
    public array $items;
    // اسلاید فعلی
    public int $currentSlide = 0;
    // حالت پخش خودکار
    public $autoplay = true;

    // متد برای مقداردهی اولیه
    public function mount($type, $title, $viewAllLink, $items)
    {
        $this->type = $type;
        $this->title = $title;
        $this->viewAllLink = $viewAllLink;
        $this->items = $items;
    }

    // متد برای رفتن به اسلاید بعدی
    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->items);
    }

    // متد برای رفتن به اسلاید قبلی
    public function previousSlide()
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->items)) % count($this->items);
    }

    // متد برای رفتن به اسلاید مشخص
    public function goToSlide($index)
    {
        $this->currentSlide = $index;
    }

    // متد برای تغییر حالت پخش خودکار
    public function toggleAutoplay()
    {
        $this->autoplay = !$this->autoplay;
    }

    #[Computed]
    // متد برای دریافت اسلاید فعلی
    public function currentSlide()
    {
        return $this->items[$this->currentSlide] ?? null;
    }

    // متد برای رندر کردن ویو
    public function render()
    {
        return view('livewire.slider');
    }
}
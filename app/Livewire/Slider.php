<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class Slider extends Component
{
    public string $type;
    public string $title;
    public string $viewAllLink;
    public array $items;
    public int $currentSlide = 0;
    public $autoplay = true;

    public function mount($type, $title, $viewAllLink, $items)
    {
        $this->type = $type;
        $this->title = $title;
        $this->viewAllLink = $viewAllLink;
        $this->items = $items;
    }

    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->items);
    }

    public function previousSlide()
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->items)) % count($this->items);
    }

    public function goToSlide($index)
    {
        $this->currentSlide = $index;
    }

    public function toggleAutoplay()
    {
        $this->autoplay = !$this->autoplay;
    }

    #[Computed]
    public function currentSlide()
    {
        return $this->items[$this->currentSlide] ?? null;
    }

    public function render()
    {
        return view('livewire.slider');
    }
}

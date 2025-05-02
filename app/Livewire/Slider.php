<?php

namespace App\Livewire;

use App\Models\Slider as SliderModel; // استفاده از نام مستعار برای جلوگیری از تداخل نام
use App\Services\CacheService; // اضافه کردن سرویس کش
use Illuminate\Support\Facades\Storage; // برای کار با فایل‌ها و لینک‌ها
use Illuminate\Support\Facades\Log; // اضافه کردن Log facade
use Livewire\Component;
use Livewire\Attributes\Computed; // برای تعریف پراپرتی‌های محاسباتی

/**
 * کامپوننت لایووایر برای نمایش اسلایدر
 */
class Slider extends Component
{
    /**
     * نوع اسلایدر (مثلاً 'khabar' یا 'etelaiie')
     * @var string
     */
    public string $type;

    /**
     * عنوان کلی اسلایدر که در بالای آن نمایش داده می‌شود
     * @var string
     */
    public string $title;

    /**
     * لینک دکمه "مشاهده همه"
     * @var string
     */
    public string $viewAllLink;

    /**
     * اندیس اسلاید فعلی که نمایش داده می‌شود
     * @var int
     */
    public int $currentSlide = 0;

    // پراپرتی برای کنترل وضعیت Autoplay
    public bool $isAutoplaying = true;

    // زمان انقضای کش برای اسلایدرها (10 دقیقه)
    private const SLIDER_CACHE_TTL = 600;

    /**
     * مقداردهی اولیه کامپوننت هنگام ایجاد
     *
     * @param string $type نوع اسلایدر
     * @param string $title عنوان اسلایدر
     * @param string $viewAllLink لینک "مشاهده همه"
     */
    public function mount($type, $title, $viewAllLink)
    {
        $this->type = $type;
        $this->title = $title;
        $this->viewAllLink = $viewAllLink;
    }

    /**
     * پراپرتی محاسباتی برای دریافت آیتم‌های اسلایدر از کش یا دیتابیس
     *
     * @return array
     */
    #[Computed]
    public function items(): array
    {
        $cacheKey = "sliders.{$this->type}";
        $cacheService = app(CacheService::class);

        // فعال کردن مجدد کش
        return $cacheService->remember($cacheKey, self::SLIDER_CACHE_TTL, function () {
            $sliders = SliderModel::where('type', $this->type)
                             ->where('is_active', true)
                             ->latest()
                             ->limit(10)
                             // اضافه کردن id به فیلدهای دریافتی
                             ->get(['id', 'title', 'description', 'image', 'link']);

            return $sliders->map(function ($slider) {
                $slider->image_url = $slider->image ? Storage::url($slider->image) : null;
                return $slider;
            })->toArray();
        });
    }

    /**
     * متد برای تیک Autoplay (فراخوانی توسط wire:poll)
     */
    public function autoplayTick()
    {
        // فقط اگر Autoplay فعال باشد، اسلاید را عوض کن
        if ($this->isAutoplaying && count($this->items()) > 1) {
            Log::info("[Slider {$this->type}] Autoplay tick triggered nextSlide");
            $this->nextSlide();
        }
    }

    /**
     * متد برای متوقف کردن Autoplay (فراخوانی توسط @mouseenter)
     */
    public function pauseAutoplay()
    {
        Log::info("[Slider {$this->type}] Pausing autoplay");
        $this->isAutoplaying = false;
    }

    /**
     * متد برای ادامه دادن Autoplay (فراخوانی توسط @mouseleave)
     */
    public function resumeAutoplay()
    {
        Log::info("[Slider {$this->type}] Resuming autoplay");
        $this->isAutoplaying = true;
    }

    /**
     * رفتن به اسلاید بعدی
     * با استفاده از (%) به ابتدای لیست برمی‌گردد اگر در انتهای لیست باشد.
     */
    public function nextSlide()
    {
        $itemCount = count($this->items());
        if ($itemCount > 0) {
            $oldSlide = $this->currentSlide;
            $this->currentSlide = ($this->currentSlide + 1) % $itemCount;
            Log::info("[Slider {$this->type}] nextSlide: {$oldSlide} -> {$this->currentSlide}"); // لاگ کردن تغییر
        }
    }

    /**
     * رفتن به اسلاید قبلی
     * با استفاده از (%) به انتهای لیست برمی‌گردد اگر در ابتدای لیست باشد.
     */
    public function previousSlide()
    {
        $itemCount = count($this->items());
        if ($itemCount > 0) {
            $oldSlide = $this->currentSlide;
            $this->currentSlide = ($this->currentSlide - 1 + $itemCount) % $itemCount;
            Log::info("[Slider {$this->type}] previousSlide: {$oldSlide} -> {$this->currentSlide}"); // لاگ کردن تغییر
        }
    }

    /**
     * رفتن به یک اسلاید مشخص با اندیس آن
     *
     * @param int $index اندیس اسلاید مورد نظر
     */
    public function goToSlide(int $index)
    {
        $itemCount = count($this->items());
        if ($index >= 0 && $index < $itemCount) {
            $oldSlide = $this->currentSlide;
            if ($oldSlide !== $index) { // فقط اگر اندیس واقعا تغییر کند لاگ کن
                $this->currentSlide = $index;
                Log::info("[Slider {$this->type}] goToSlide: {$oldSlide} -> {$this->currentSlide}"); // لاگ کردن تغییر
            }
        } else {
            Log::warning("[Slider {$this->type}] goToSlide called with invalid index: {$index}");
        }
    }

    /**
     * پراپرتی محاسباتی برای دریافت اطلاعات اسلاید فعلی
     *
     * @return array|null اطلاعات اسلاید فعلی یا null اگر اسلایدری وجود نداشته باشد
     */
    #[Computed]
    public function currentSlideItem(): ?array
    {
        $items = $this->items();
        // اطمینان از اینکه اندیس در محدوده معتبر است
        if (isset($items[$this->currentSlide])) {
            return $items[$this->currentSlide];
        }
        // اگر اندیس نامعتبر بود (مثلا بعد از حذف آیتم)، به صفر برگردان
        elseif (count($items) > 0) {
             Log::warning("[Slider {$this->type}] currentSlide index {$this->currentSlide} out of bounds, resetting to 0.");
             $this->currentSlide = 0;
             return $items[0];
        }
        return null; // اگر هیچ آیتمی وجود ندارد
    }

    /**
     * رندر کردن ویوی مربوط به این کامپوننت
     */
    public function render()
    {
        $items = $this->items();
        // لاگ کردن مقدار currentSlide قبل از رندر ویو
        Log::info("[Slider {$this->type}] Rendering view with currentSlide: {$this->currentSlide}");
        return view('livewire.slider', [
            'items' => $items,
            'itemCount' => count($items)
            // currentSlide به صورت خودکار در ویو در دسترس است
        ]);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;

/**
 * کلاس منبع (Resource) مدیریت اسلایدرهای سایت
 * این کلاس امکانات مدیریت اسلایدرهای صفحه اصلی را فراهم می‌کند
 */
class SliderResource extends Resource
{
    /**
     * مدل مرتبط با این منبع
     */
    protected static ?string $model = Slider::class;

    /**
     * آیکون نمایشی در منوی ناوبری - نماد تصویر
     */
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    /**
     * عنوان نمایشی در منوی ناوبری
     */
    protected static ?string $navigationLabel = 'sliders';

    /**
     * برچسب مدل در رابط کاربری
     */
    protected static ?string $modelLabel = 'slider';

    /**
     * تعریف ساختار فرم برای ایجاد و ویرایش اسلایدر
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // عنوان اسلایدر - متن اجباری
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('عنوان')
                    ->maxLength(255),
                // توضیحات اسلایدر - متن بلند
                Forms\Components\Textarea::make('description')
                    ->label('توضیحات')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                // تصویر اسلایدر - آپلود فایل تصویری
                Forms\Components\FileUpload::make('image')
                    ->label('تصویر')
                    ->image()
                    ->required()
                    ->directory('sliders'),
                // لینک اسلایدر - آدرس مقصد کلیک
                Forms\Components\TextInput::make('link')
                    ->label('لینک')
                    ->maxLength(255),
                // ترتیب نمایش - عدد برای اولویت‌بندی
                Forms\Components\TextInput::make('order')
                    ->label('ترتیب')
                    ->required()
                    ->numeric()
                    ->default(0),
                // وضعیت فعال بودن - کلید تغییر وضعیت
                Forms\Components\Toggle::make('is_active')
                    ->label('فعال')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'news' => 'news',
                        'event' => 'event',
                    ])
                    ->native(false)
                    ->required(),
            ]);
    }

    /**
     * تعریف ساختار جدول نمایش اطلاعات اسلایدرها
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // نمایش تصویر اسلایدر
                Tables\Columns\ImageColumn::make('image')
                    ->label('تصویر'),
                // عنوان با قابلیت جستجو
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable(),
                // ترتیب نمایش با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('order')
                    ->label('ترتیب')
                    ->numeric()
                    ->sortable(),
                // وضعیت فعال بودن با نمایش آیکون
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->sortable(),
                // تاریخ ایجاد - قابل مخفی کردن
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // تاریخ بروزرسانی - قابل مخفی کردن
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخرین بروزرسانی')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // محل تعریف فیلترهای جدول
            ])
            ->actions([
                // دکمه‌های عملیات در هر ردیف
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // عملیات‌های گروهی
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * تعریف روابط با سایر مدل‌ها
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // محل تعریف روابط
        ];
    }

    /**
     * تعریف صفحات مربوط به این منبع
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),          // صفحه لیست اسلایدرها
            'create' => Pages\CreateSlider::route('/create'),   // صفحه ایجاد اسلایدر جدید
            'edit' => Pages\EditSlider::route('/{record}/edit'),// صفحه ویرایش اسلایدر
        ];
    }
}

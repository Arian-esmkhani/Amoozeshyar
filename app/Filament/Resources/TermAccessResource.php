<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermAccessResource\Pages;
use App\Models\TermAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * کلاس منبع (Resource) مدیریت دسترسی ترم‌های تحصیلی
 * این کلاس امکان تنظیم و کنترل دسترسی به ترم‌های مختلف را فراهم می‌کند
 */
class TermAccessResource extends Resource
{
    /**
     * مدل مرتبط با این منبع
     */
    protected static ?string $model = TermAccess::class;

    /**
     * آیکون نمایشی در منوی ناوبری - نماد قفل بسته
     */
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    /**
     * عنوان نمایشی در منوی ناوبری
     */
    protected static ?string $navigationLabel = 'مدیریت دسترسی ترم‌ها';

    /**
     * برچسب مدل در رابط کاربری
     */
    protected static ?string $modelLabel = 'دسترسی ترم';

    /**
     * تعریف ساختار فرم برای ایجاد و ویرایش دسترسی ترم
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // شماره ترم - فیلد عددی اجباری
                Forms\Components\TextInput::make('term_number')
                    ->required()
                    ->label('شماره ترم')
                    ->numeric(),
                // وضعیت فعال بودن - کلید تغییر وضعیت
                Forms\Components\Toggle::make('is_active')
                    ->label('فعال')
                    ->required(),
                // تاریخ شروع دسترسی - انتخابگر تاریخ و زمان
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('تاریخ شروع دسترسی')
                    ->nullable(),
                // تاریخ پایان دسترسی - انتخابگر تاریخ و زمان
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('تاریخ پایان دسترسی')
                    ->nullable(),
                // پیام نمایشی - متن توضیحات برای کاربران
                Forms\Components\Textarea::make('message')
                    ->label('پیام نمایشی')
                    ->helperText('این پیام به کاربرانی که دسترسی ندارند نمایش داده می‌شود')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    /**
     * تعریف ساختار جدول نمایش اطلاعات دسترسی‌ها
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ستون شماره ترم با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('term_number')
                    ->label('شماره ترم')
                    ->numeric()
                    ->sortable(),
                // ستون وضعیت فعال بودن با نمایش آیکون
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                // ستون تاریخ شروع با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('start_date')
                    ->label('تاریخ شروع')
                    ->dateTime()
                    ->sortable(),
                // ستون تاریخ پایان با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('end_date')
                    ->label('تاریخ پایان')
                    ->dateTime()
                    ->sortable(),
                // ستون تاریخ ایجاد - قابل مخفی کردن
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // ستون تاریخ بروزرسانی - قابل مخفی کردن
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
            'index' => Pages\ListTermAccesses::route('/'),          // صفحه لیست دسترسی‌ها
            'create' => Pages\CreateTermAccess::route('/create'),   // صفحه ایجاد دسترسی جدید
            'edit' => Pages\EditTermAccess::route('/{record}/edit'),// صفحه ویرایش دسترسی
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserStatusResource\Pages; // دسترسی به صفحات مرتبط با منبع UserStatusResource در سیستم Filament
use App\Models\UserStatus; // مدل UserStatus برای تعامل با جدول دیتابیس مربوط به وضعیت کاربران
use Filament\Forms; // فضای نام کلی برای کار با فرم‌ها در Filament
use Filament\Forms\Form; // کلاس Form برای مدیریت و طراحی فرم‌های پیشرفته
use Filament\Resources\Resource; // کلاس Resource برای مدیریت منابع داده‌ها در سیستم Filament
use Filament\Tables; // فضای نام کلی برای نمایش داده‌ها در قالب جداول
use Filament\Tables\Table; // کلاس Table برای طراحی و مدیریت جداول پیشرفته

/**
 * کلاس منبع (Resource) مدیریت وضعیت تحصیلی دانشجویان
 * این کلاس امکانات CRUD برای مدیریت وضعیت تحصیلی دانشجویان را فراهم می‌کند
 */
class UserStatusResource extends Resource
{
    /**
     * مدل مرتبط با این منبع
     */
    protected static ?string $model = UserStatus::class;

    /**
     * آیکون نمایشی در منوی ناوبری
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * تعریف ساختار فرم برای ایجاد و ویرایش وضعیت تحصیلی
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // شناسه کاربر (دانشجو)
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                // حداقل تعداد واحد قابل اخذ
                Forms\Components\TextInput::make('min_unit')
                    ->required()
                    ->numeric()
                    ->default(12),
                // حداکثر تعداد واحد قابل اخذ
                Forms\Components\TextInput::make('max_unit')
                    ->required()
                    ->numeric()
                    ->default(20),
                // تعداد واحدهای پاس شده
                Forms\Components\TextInput::make('passed_units')
                    ->numeric()
                    ->default(0),
                // تعداد واحدهای افتاده
                Forms\Components\TextInput::make('loss_units')
                    ->numeric()
                    ->default(0),
                // واحدهای کارآموزی
                Forms\Components\TextInput::make('unit_interm')
                    ->numeric()
                    ->default(0),
                // واحدهای کارورزی
                Forms\Components\TextInput::make('unit_intership')
                    ->numeric()
                    ->default(0),
                // واحدهای معاف شده
                Forms\Components\TextInput::make('free_unit')
                    ->numeric()
                    ->default(0),
                // تعداد ترم‌های گذرانده
                Forms\Components\TextInput::make('pass_term')
                    ->numeric()
                    ->default(0),
                // تعداد ترم‌های مشروطی
                Forms\Components\TextInput::make('lost_term')
                    ->numeric(),
                // ترم جاری
                Forms\Components\TextInput::make('term')
                    ->required()
                    ->numeric(),
                // وضعیت گوش دادن به دروس
                Forms\Components\TextInput::make('take_listen'),
                // تعداد ترم‌های مجاز
                Forms\Components\TextInput::make('allowed_term')
                    ->required()
                    ->numeric()
                    ->default(8),
                // وضعیت دانشجو (فعال/غیرفعال)
                Forms\Components\TextInput::make('student_status')
                    ->required()
                    ->maxLength(20)
                    ->default('active'),
                // امکان اخذ واحد
                Forms\Components\TextInput::make('can_take_courses')
                    ->required()
                    ->numeric()
                    ->default(1),
                // یادداشت‌های تحصیلی
                Forms\Components\Textarea::make('academic_notes')
                    ->columnSpanFull(),
            ]);
    }

    /**
     * تعریف ساختار جدول نمایش اطلاعات
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // تعریف ستون‌های جدول با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_unit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_unit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('passed_units')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loss_units')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_interm')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_intership')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('free_unit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pass_term')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lost_term')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('term')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('allowed_term')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('can_take_courses')
                    ->numeric()
                    ->sortable(),
                // ستون‌های تاریخ با قابلیت مخفی شدن
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // محل تعریف فیلترهای جدول
            ])
            ->actions([
                // دکمه ویرایش در هر ردیف
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // اکشن‌های گروهی
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
            'index' => Pages\ListUserStatuses::route('/'),          // صفحه لیست
            'create' => Pages\CreateUserStatus::route('/create'),    // صفحه ایجاد
            'edit' => Pages\EditUserStatus::route('/{record}/edit'), // صفحه ویرایش
        ];
    }
}

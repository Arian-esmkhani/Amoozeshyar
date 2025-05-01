<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoginHistoryResource\Pages;
use App\Models\LoginHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * کلاس منبع (Resource) مدیریت سوابق ورود کاربران
 *
 * این کلاس امکانات مدیریت و نمایش تاریخچه ورود و خروج کاربران را فراهم می‌کند
 * و برای نظارت بر فعالیت‌های کاربران و تشخیص موارد امنیتی استفاده می‌شود
 */
class LoginHistoryResource extends Resource
{
    /**
     * مدل مرتبط با این منبع
     */
    protected static ?string $model = LoginHistory::class;

    /**
     * آیکون نمایشی در منوی ناوبری
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * تعریف ساختار فرم برای ایجاد و ویرایش سوابق ورود
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // شناسه کاربر
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                // زمان ورود
                Forms\Components\DateTimePicker::make('login_time')
                    ->required(),
                // زمان خروج
                Forms\Components\DateTimePicker::make('logout_at'),
                // آدرس IP کاربر
                Forms\Components\TextInput::make('ip_address')
                    ->maxLength(45),
                // اطلاعات مرورگر و دستگاه
                Forms\Components\TextInput::make('user_agent')
                    ->maxLength(255),
                // وضعیت ورود (موفق/ناموفق)
                Forms\Components\TextInput::make('status')
                    ->required(),
                // دلیل شکست در صورت ناموفق بودن
                Forms\Components\TextInput::make('failure_reason')
                    ->maxLength(255),
                // وضعیت فعال بودن
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                // آخرین زمان ورود
                Forms\Components\DateTimePicker::make('last_login_at'),
            ]);
    }

    /**
     * تعریف ساختار جدول نمایش سوابق ورود
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ستون شناسه کاربر
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                // ستون زمان ورود
                Tables\Columns\TextColumn::make('login_time')
                    ->dateTime()
                    ->sortable(),
                // ستون زمان خروج
                Tables\Columns\TextColumn::make('logout_at')
                    ->dateTime()
                    ->sortable(),
                // ستون آدرس IP
                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable(),
                // ستون اطلاعات مرورگر
                Tables\Columns\TextColumn::make('user_agent')
                    ->searchable(),
                // ستون وضعیت
                Tables\Columns\TextColumn::make('status'),
                // ستون دلیل شکست
                Tables\Columns\TextColumn::make('failure_reason')
                    ->searchable(),
                // ستون وضعیت فعال بودن
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                // ستون آخرین ورود
                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
                    ->sortable(),
                // ستون‌های زمانی سیستم
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
            'index' => Pages\ListLoginHistories::route('/'),          // صفحه لیست سوابق
            'create' => Pages\CreateLoginHistory::route('/create'),    // صفحه ایجاد سابقه جدید
            'edit' => Pages\EditLoginHistory::route('/{record}/edit'), // صفحه ویرایش سابقه
        ];
    }
}

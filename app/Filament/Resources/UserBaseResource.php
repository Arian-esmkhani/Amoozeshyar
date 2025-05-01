<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserBaseResource\Pages;
use App\Models\UserBase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * کلاس منبع (Resource) مدیریت کاربران پایه سیستم
 * این کلاس امکانات CRUD برای مدیریت کاربران را فراهم می‌کند
 * فقط کاربران ادمین به این بخش دسترسی دارند
 */
class UserBaseResource extends Resource
{
    /**
     * مدل مرتبط با این منبع
     */
    protected static ?string $model = UserBase::class;

    /**
     * آیکون نمایشی در منوی ناوبری
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * بررسی دسترسی به این بخش
     * فقط ادمین‌ها می‌توانند به این بخش دسترسی داشته باشند
     */
    public static function canAccess(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * بررسی امکان ایجاد کاربر جدید
     * فقط ادمین‌ها می‌توانند کاربر جدید ایجاد کنند
     */
    public static function canCreate(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * بررسی امکان ویرایش کاربر
     * فقط ادمین‌ها می‌توانند کاربران را ویرایش کنند
     */
    public static function canEdit(Model $record): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * بررسی امکان حذف کاربر
     * فقط ادمین‌ها می‌توانند کاربران را حذف کنند
     */
    public static function canDelete(Model $record): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * تعریف ساختار فرم برای ایجاد و ویرایش کاربران
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // نام کاربری - اجباری، حداکثر 45 کاراکتر
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(45),
                // رمز عبور - اجباری، حداکثر 255 کاراکتر
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                // ایمیل - اجباری، حداکثر 45 کاراکتر
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(45),
                // نقش کاربر - اجباری، حداکثر 30 کاراکتر
                Forms\Components\TextInput::make('role')
                    ->required()
                    ->maxLength(30),
            ]);
    }

    /**
     * تعریف ساختار جدول نمایش اطلاعات کاربران
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ستون نام کاربری با قابلیت جستجو
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                // ستون ایمیل با قابلیت جستجو
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                // ستون نقش با قابلیت جستجو
                Tables\Columns\TextColumn::make('role')
                    ->searchable(),
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
            'index' => Pages\ListUserBases::route('/'),          // صفحه لیست کاربران
            'create' => Pages\CreateUserBase::route('/create'),   // صفحه ایجاد کاربر جدید
            'edit' => Pages\EditUserBase::route('/{record}/edit'),// صفحه ویرایش کاربر
        ];
    }
}

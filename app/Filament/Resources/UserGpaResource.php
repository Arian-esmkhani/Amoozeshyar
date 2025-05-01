<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserGpaResource\Pages;
use App\Filament\Resources\UserGpaResource\RelationManagers;
use App\Models\UserGpa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * کلاس منبع (Resource) مدیریت معدل‌های دانشجویان
 * این کلاس امکانات CRUD برای مدیریت معدل و وضعیت تحصیلی دانشجویان را فراهم می‌کند
 */
class UserGpaResource extends Resource
{
    /**
     * مدل مرتبط با این منبع
     */
    protected static ?string $model = UserGpa::class;

    /**
     * آیکون نمایشی در منوی ناوبری
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * تعریف ساختار فرم برای ایجاد و ویرایش معدل‌ها
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
                // معدل ترم جاری
                Forms\Components\TextInput::make('semester_gpa')
                    ->numeric(),
                // معدل ترم قبل
                Forms\Components\TextInput::make('last_gpa')
                    ->numeric(),
                // معدل کل
                Forms\Components\TextInput::make('cumulative_gpa')
                    ->numeric(),
                // معدل دروس تخصصی
                Forms\Components\TextInput::make('major_gpa')
                    ->numeric(),
                // معدل دروس عمومی
                Forms\Components\TextInput::make('general_gpa')
                    ->numeric(),
                // تعداد کل واحدها
                Forms\Components\TextInput::make('total_units')
                    ->numeric()
                    ->default(0),
                // لیست دروس گذرانده شده
                Forms\Components\Textarea::make('passed_listen')
                    ->columnSpanFull(),
                // وضعیت تحصیلی
                Forms\Components\TextInput::make('academic_status')
                    ->required()
                    ->maxLength(20)
                    ->default('active'),
            ]);
    }

    /**
     * تعریف ساختار جدول نمایش اطلاعات معدل‌ها
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
                // ستون معدل ترم
                Tables\Columns\TextColumn::make('semester_gpa')
                    ->numeric()
                    ->sortable(),
                // ستون معدل ترم قبل
                Tables\Columns\TextColumn::make('last_gpa')
                    ->numeric()
                    ->sortable(),
                // ستون معدل کل
                Tables\Columns\TextColumn::make('cumulative_gpa')
                    ->numeric()
                    ->sortable(),
                // ستون معدل دروس تخصصی
                Tables\Columns\TextColumn::make('major_gpa')
                    ->numeric()
                    ->sortable(),
                // ستون معدل دروس عمومی
                Tables\Columns\TextColumn::make('general_gpa')
                    ->numeric()
                    ->sortable(),
                // ستون تعداد کل واحدها
                Tables\Columns\TextColumn::make('total_units')
                    ->numeric()
                    ->sortable(),
                // ستون وضعیت تحصیلی
                Tables\Columns\TextColumn::make('academic_status')
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
            'index' => Pages\ListUserGpas::route('/'),          // صفحه لیست معدل‌ها
            'create' => Pages\CreateUserGpa::route('/create'),   // صفحه ایجاد معدل جدید
            'edit' => Pages\EditUserGpa::route('/{record}/edit'),// صفحه ویرایش معدل
        ];
    }
}

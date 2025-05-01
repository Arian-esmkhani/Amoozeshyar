<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonOfferedResource\Pages;
use App\Models\LessonOffered;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * کلاس منبع (Resource) مدیریت دروس ارائه شده در ترم
 * این کلاس امکانات مدیریت و ثبت دروس ارائه شده در هر ترم تحصیلی را فراهم می‌کند
 * شامل مدیریت اطلاعات کلاس، استاد، ظرفیت و زمان‌بندی می‌باشد
 */
class LessonOfferedResource extends Resource
{
    /**
     * مدل مرتبط با این منبع
     */
    protected static ?string $model = LessonOffered::class;

    /**
     * آیکون نمایشی در منوی ناوبری
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * تعریف ساختار فرم برای ایجاد و ویرایش درس ارائه شده
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // شناسه یکتای درس در سیستم
                Forms\Components\TextInput::make('lesten_id')
                    ->required()
                    ->numeric(),
                // عنوان کامل درس
                Forms\Components\TextInput::make('lesten_name')
                    ->required()
                    ->maxLength(145),
                // رشته تحصیلی مرتبط با درس
                Forms\Components\TextInput::make('major')
                    ->required()
                    ->maxLength(100),
                // نام استاد ارائه دهنده درس
                Forms\Components\TextInput::make('lesten_master')
                    ->required()
                    ->maxLength(45),
                // تاریخ و زمان برگزاری کلاس
                Forms\Components\DateTimePicker::make('lesten_date')
                    ->required(),
                // محدودیت جنسیتی برای ثبت‌نام
                Forms\Components\TextInput::make('lesson_sex')
                    ->maxLength(45),
                // تاریخ و زمان امتحان پایانی
                Forms\Components\DateTimePicker::make('lesten_final'),
                // تعداد واحد درسی
                Forms\Components\TextInput::make('unit_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                // ظرفیت کل کلاس
                Forms\Components\TextInput::make('capacity')
                    ->numeric(),
                // تعداد دانشجویان ثبت‌نام شده
                Forms\Components\TextInput::make('registered_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                // هزینه درس
                Forms\Components\TextInput::make('lesten_price')
                    ->required()
                    ->numeric(),
                // نوع کلاس (تئوری/عملی)
                Forms\Components\TextInput::make('class_type')
                    ->required()
                    ->maxLength(20)
                    ->default('theoretical'),
                // شماره یا نام کلاس
                Forms\Components\TextInput::make('classroom')
                    ->maxLength(45),
                // برنامه زمانی جلسات کلاس
                Forms\Components\TextInput::make('class_schedule'),
                // وضعیت ارائه درس (فعال/غیرفعال)
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(20)
                    ->default('active'),
                // پیش‌نیازهای درس
                Forms\Components\Textarea::make('prerequisites')
                    ->columnSpanFull(),
                // نوع درس (اصلی/اختیاری/عمومی)
                Forms\Components\TextInput::make('lesten_type')
                    ->required()
                    ->maxLength(45),
            ]);
    }

    /**
     * تعریف ساختار جدول نمایش اطلاعات دروس ارائه شده
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // نمایش شناسه درس با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('lesten_id')
                    ->numeric()
                    ->sortable(),
                // نمایش نام درس با قابلیت جستجو
                Tables\Columns\TextColumn::make('lesten_name')
                    ->searchable(),
                // نمایش رشته تحصیلی با قابلیت جستجو
                Tables\Columns\TextColumn::make('major')
                    ->searchable(),
                // نمایش نام استاد با قابلیت جستجو
                Tables\Columns\TextColumn::make('lesten_master')
                    ->searchable(),
                // نمایش تاریخ برگزاری با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('lesten_date')
                    ->dateTime()
                    ->sortable(),
                // نمایش محدودیت جنسیتی با قابلیت جستجو
                Tables\Columns\TextColumn::make('lesson_sex')
                    ->searchable(),
                // نمایش تاریخ امتحان با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('lesten_final')
                    ->dateTime()
                    ->sortable(),
                // نمایش تعداد واحد با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('unit_count')
                    ->numeric()
                    ->sortable(),
                // نمایش ظرفیت کلاس با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
                // نمایش تعداد ثبت‌نام شده با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('registered_count')
                    ->numeric()
                    ->sortable(),
                // نمایش هزینه درس با قابلیت مرتب‌سازی
                Tables\Columns\TextColumn::make('lesten_price')
                    ->numeric()
                    ->sortable(),
                // نمایش نوع کلاس با قابلیت جستجو
                Tables\Columns\TextColumn::make('class_type')
                    ->searchable(),
                // نمایش شماره کلاس با قابلیت جستجو
                Tables\Columns\TextColumn::make('classroom')
                    ->searchable(),
                // نمایش وضعیت درس با قابلیت جستجو
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                // نمایش تاریخ‌های سیستمی با قابلیت مخفی شدن
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
                // نمایش نوع درس با قابلیت جستجو
                Tables\Columns\TextColumn::make('lesten_type')
                    ->searchable(),
            ])
            ->filters([
                // محل تعریف فیلترهای جدول
            ])
            ->actions([
                // دکمه ویرایش برای هر رکورد
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
            // محل تعریف روابط با سایر مدل‌ها
        ];
    }

    /**
     * تعریف صفحات مربوط به این منبع
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessonOffereds::route('/'),          // صفحه لیست دروس ارائه شده
            'create' => Pages\CreateLessonOffered::route('/create'),   // صفحه ایجاد درس جدید
            'edit' => Pages\EditLessonOffered::route('/{record}/edit'),// صفحه ویرایش درس
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'اسلایدرها';

    protected static ?string $modelLabel = 'اسلایدر';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('عنوان')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('توضیحات')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('تصویر')
                    ->image()
                    ->required()
                    ->directory('sliders'),
                Forms\Components\TextInput::make('link')
                    ->label('لینک')
                    ->maxLength(255),
                Forms\Components\TextInput::make('order')
                    ->label('ترتیب')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('فعال')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('تصویر'),
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('ترتیب')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخرین بروزرسانی')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}

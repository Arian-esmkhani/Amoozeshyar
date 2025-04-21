<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermAccessResource\Pages;
use App\Filament\Resources\TermAccessResource\RelationManagers;
use App\Models\TermAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TermAccessResource extends Resource
{
    protected static ?string $model = TermAccess::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static ?string $navigationLabel = 'مدیریت دسترسی ترم‌ها';

    protected static ?string $modelLabel = 'دسترسی ترم';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('term_number')
                    ->required()
                    ->label('شماره ترم')
                    ->numeric(),
                Forms\Components\Toggle::make('is_active')
                    ->label('فعال')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('تاریخ شروع دسترسی')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('تاریخ پایان دسترسی')
                    ->nullable(),
                Forms\Components\Textarea::make('message')
                    ->label('پیام نمایشی')
                    ->helperText('این پیام به کاربرانی که دسترسی ندارند نمایش داده می‌شود')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('term_number')
                    ->label('شماره ترم')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('تاریخ شروع')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('تاریخ پایان')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListTermAccesses::route('/'),
            'create' => Pages\CreateTermAccess::route('/create'),
            'edit' => Pages\EditTermAccess::route('/{record}/edit'),
        ];
    }
}

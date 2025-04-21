<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonOfferedResource\Pages;
use App\Filament\Resources\LessonOfferedResource\RelationManagers;
use App\Models\LessonOffered;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonOfferedResource extends Resource
{
    protected static ?string $model = LessonOffered::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lesten_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('lesten_name')
                    ->required()
                    ->maxLength(145),
                Forms\Components\TextInput::make('major')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('lesten_master')
                    ->required()
                    ->maxLength(45),
                Forms\Components\DateTimePicker::make('lesten_date')
                    ->required(),
                Forms\Components\TextInput::make('lesson_sex')
                    ->maxLength(45),
                Forms\Components\DateTimePicker::make('lesten_final'),
                Forms\Components\TextInput::make('unit_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('capacity')
                    ->numeric(),
                Forms\Components\TextInput::make('registered_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('lesten_price')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('class_type')
                    ->required()
                    ->maxLength(20)
                    ->default('theoretical'),
                Forms\Components\TextInput::make('classroom')
                    ->maxLength(45),
                Forms\Components\TextInput::make('class_schedule'),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(20)
                    ->default('active'),
                Forms\Components\Textarea::make('prerequisites')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('lesten_type')
                    ->required()
                    ->maxLength(45),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lesten_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lesten_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('major')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lesten_master')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lesten_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lesson_sex')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lesten_final')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('registered_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lesten_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('class_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('classroom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('lesten_type')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLessonOffereds::route('/'),
            'create' => Pages\CreateLessonOffered::route('/create'),
            'edit' => Pages\EditLessonOffered::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentDataResource\Pages;
use App\Filament\Resources\StudentDataResource\RelationManagers;
use App\Models\StudentData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentDataResource extends Resource
{
    protected static ?string $model = StudentData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('enrollment_date')
                    ->required(),
                Forms\Components\DatePicker::make('expected_graduation'),
                Forms\Components\TextInput::make('konkoor_number')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('helf_date')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('student_number')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('study_type')
                    ->required()
                    ->maxLength(20)
                    ->default('full_time'),
                Forms\Components\TextInput::make('degree_level')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('major')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('faculty')
                    ->required()
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('enrollment_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expected_graduation')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('konkoor_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('helf_date')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('study_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('degree_level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('major')
                    ->searchable(),
                Tables\Columns\TextColumn::make('faculty')
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
            'index' => Pages\ListStudentData::route('/'),
            'create' => Pages\CreateStudentData::route('/create'),
            'edit' => Pages\EditStudentData::route('/{record}/edit'),
        ];
    }
}

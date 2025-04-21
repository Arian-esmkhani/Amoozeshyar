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

class UserGpaResource extends Resource
{
    protected static ?string $model = UserGpa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('semester_gpa')
                    ->numeric(),
                Forms\Components\TextInput::make('last_gpa')
                    ->numeric(),
                Forms\Components\TextInput::make('cumulative_gpa')
                    ->numeric(),
                Forms\Components\TextInput::make('major_gpa')
                    ->numeric(),
                Forms\Components\TextInput::make('general_gpa')
                    ->numeric(),
                Forms\Components\TextInput::make('total_units')
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('passed_listen')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('academic_status')
                    ->required()
                    ->maxLength(20)
                    ->default('active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester_gpa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_gpa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cumulative_gpa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('major_gpa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('general_gpa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_units')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('academic_status')
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
            'index' => Pages\ListUserGpas::route('/'),
            'create' => Pages\CreateUserGpa::route('/create'),
            'edit' => Pages\EditUserGpa::route('/{record}/edit'),
        ];
    }
}

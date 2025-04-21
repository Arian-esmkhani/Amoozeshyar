<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserStatusResource\Pages;
use App\Filament\Resources\UserStatusResource\RelationManagers;
use App\Models\UserStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserStatusResource extends Resource
{
    protected static ?string $model = UserStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('min_unit')
                    ->required()
                    ->numeric()
                    ->default(12),
                Forms\Components\TextInput::make('max_unit')
                    ->required()
                    ->numeric()
                    ->default(20),
                Forms\Components\TextInput::make('passed_units')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('loss_units')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('unit_interm')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('unit_intership')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('free_unit')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('pass_term')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('lost_term')
                    ->numeric(),
                Forms\Components\TextInput::make('term')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('take_listen'),
                Forms\Components\TextInput::make('allowed_term')
                    ->required()
                    ->numeric()
                    ->default(8),
                Forms\Components\TextInput::make('student_status')
                    ->required()
                    ->maxLength(20)
                    ->default('active'),
                Forms\Components\TextInput::make('can_take_courses')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Textarea::make('academic_notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListUserStatuses::route('/'),
            'create' => Pages\CreateUserStatus::route('/create'),
            'edit' => Pages\EditUserStatus::route('/{record}/edit'),
        ];
    }
}

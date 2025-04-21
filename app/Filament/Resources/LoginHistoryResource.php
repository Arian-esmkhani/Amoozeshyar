<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoginHistoryResource\Pages;
use App\Filament\Resources\LoginHistoryResource\RelationManagers;
use App\Models\LoginHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoginHistoryResource extends Resource
{
    protected static ?string $model = LoginHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('login_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('logout_at'),
                Forms\Components\TextInput::make('ip_address')
                    ->maxLength(45),
                Forms\Components\TextInput::make('user_agent')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('failure_reason')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\DateTimePicker::make('last_login_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('login_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('logout_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_agent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('failure_reason')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
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
            'index' => Pages\ListLoginHistories::route('/'),
            'create' => Pages\CreateLoginHistory::route('/create'),
            'edit' => Pages\EditLoginHistory::route('/{record}/edit'),
        ];
    }
}

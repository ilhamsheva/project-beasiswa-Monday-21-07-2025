<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DataPesertaResource\Pages;
use App\Filament\Admin\Resources\DataPesertaResource\RelationManagers;
use App\Models\DataPeserta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataPesertaResource extends Resource
{
    protected static ?string $model = DataPeserta::class;

    protected static ?string $navigationGroup = 'Manajemen Peserta';

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->label('User')
                    ->required()
                    ->relationship('user', 'name'),
                Forms\Components\TextInput::make('nim')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('jurusan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('angkatan')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jurusan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('angkatan')
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
            'index' => Pages\ListDataPesertas::route('/'),
            'create' => Pages\CreateDataPeserta::route('/create'),
            'edit' => Pages\EditDataPeserta::route('/{record}/edit'),
        ];
    }
}

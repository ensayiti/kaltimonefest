<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftarResource\Pages;
use App\Filament\Resources\PendaftarResource\RelationManagers;
use App\Models\Pendaftar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendaftarResource extends Resource
{
    protected static ?string $model = Pendaftar::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Data Pendaftar';

    protected static ?string $navigationGroup = 'Database';

    protected static ?string $modelLabel = "Data Pendaftar";

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                Forms\Components\TextInput::make('no_handphone')
                    ->label('No. Whatsapp')
                    ->required()
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
                Forms\Components\TextInput::make('daerah')
                    ->label('Asal Daerah')
                    ->required(),
                Forms\Components\Textarea::make('pesan')
                    ->label('Pesan untuk Kai Isran - Hadi')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('no_handphone')
                    ->label('No. Whatsapp'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('daerah')
                    ->label('Asal Daerah'),
                Tables\Columns\TextColumn::make('pesan')
                    ->label('Pesan untuk Kai Isran - Hadi')
            ])
            ->defaultPaginationPageOption(25)
            ->paginated([25, 50, 100, 200, 500])

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
            'index' => Pages\ListPendaftars::route('/'),
            'create' => Pages\CreatePendaftar::route('/create'),
            'edit' => Pages\EditPendaftar::route('/{record}/edit'),
        ];
    }
}

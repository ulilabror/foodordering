<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourierResource\Pages;
use App\Filament\Resources\CourierResource\RelationManagers;
use App\Models\Courier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class CourierResource extends Resource
{
    protected static ?string $model = Courier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(
                        fn () => User::where('role', 'courier')
                            ->limit(50)
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => User::where('role', 'courier')->where('name', 'like', "%{$search}%")->limit(50)->get()->mapWithKeys(fn($user) => [$user->id => $user->name])->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => User::find($value)?->name)
                    ->required(),
                Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('gps_latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('gps_longitude')
                    ->numeric(),
                Forms\Components\TextInput::make('vehicle_type')
                    ->required(),
                Forms\Components\TextInput::make('vehicle_plate')
                    ->required(),
                Forms\Components\Toggle::make('is_partner')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gps_latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gps_longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicle_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_plate')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_partner')
                    ->boolean(),
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
            'index' => Pages\ListCouriers::route('/'),
            'create' => Pages\CreateCourier::route('/create'),
            'edit' => Pages\EditCourier::route('/{record}/edit'),
        ];
    }

    public static function getNavigation(): array
    {
        return [
            'label' => 'Couriers',
            'icon' => 'heroicon-o-user',
            'group' => 'Pengiriman',
            'sort' => 5,
        ];
    }
}

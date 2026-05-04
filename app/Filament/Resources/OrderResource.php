<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Đơn hàng';

    protected static ?string $modelLabel = 'Đơn hàng';

    protected static ?string $pluralModelLabel = 'Đơn hàng';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin đơn hàng')
                    ->schema([
                        TextInput::make('code')
                            ->label('Mã đơn hàng')
                            ->disabled(),

                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'pending'    => '⏳ Chờ xử lý',
                                'processing' => '📦 Đang xử lý',
                                'shipping'   => '🚚 Đang giao',
                                'completed'  => '✅ Hoàn thành',
                                'cancelled'  => '❌ Đã hủy',
                            ])
                            ->required(),

                        TextInput::make('total_price')
                            ->label('Tổng tiền (₫)')
                            ->disabled()
                            ->prefix('₫'),
                    ])->columns(3),

                Section::make('Thông tin khách hàng')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('Họ')
                            ->disabled(),

                        TextInput::make('last_name')
                            ->label('Tên')
                            ->disabled(),

                        TextInput::make('email')
                            ->label('Email')
                            ->disabled(),

                        TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->disabled(),

                        Textarea::make('address')
                            ->label('Địa chỉ')
                            ->disabled()
                            ->columnSpanFull(),

                        TextInput::make('city')
                            ->label('Thành phố')
                            ->disabled(),

                        Textarea::make('note')
                            ->label('Ghi chú')
                            ->disabled()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Mã đơn')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Khách hàng')
                    ->searchable(['first_name', 'last_name']),

                Tables\Columns\TextColumn::make('phone')
                    ->label('SĐT')
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Tổng tiền')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' ₫')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'    => 'warning',
                        'processing' => 'info',
                        'shipping'   => 'primary',
                        'completed'  => 'success',
                        'cancelled'  => 'danger',
                        default      => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'    => 'Chờ xử lý',
                        'processing' => 'Đang xử lý',
                        'shipping'   => 'Đang giao',
                        'completed'  => 'Hoàn thành',
                        'cancelled'  => 'Đã hủy',
                        default      => $state,
                    }),

                Tables\Columns\TextColumn::make('orderItems_count')
                    ->label('Số SP')
                    ->counts('orderItems')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày đặt')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending'    => 'Chờ xử lý',
                        'processing' => 'Đang xử lý',
                        'shipping'   => 'Đang giao',
                        'completed'  => 'Hoàn thành',
                        'cancelled'  => 'Đã hủy',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

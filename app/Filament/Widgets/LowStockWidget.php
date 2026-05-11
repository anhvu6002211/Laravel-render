<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class LowStockWidget extends BaseWidget
{
    protected static ?string $heading  = '⚠️ Sản phẩm sắp hết hàng';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $data    = Cache::get('analytics_data', []);
        $records = collect($data['low_stock'] ?? []);

        return $table
            ->query(fn () => \App\Models\Product::query()->where('stock', '<', 10)->where('is_active', 1)->orderBy('stock'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên sản phẩm')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Tồn kho')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state == 0  => 'danger',
                        $state <= 3  => 'danger',
                        $state <= 6  => 'warning',
                        default      => 'success',
                    }),
                Tables\Columns\TextColumn::make('price')
                    ->label('Giá')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . '₫'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->badge(),
            ])
            ->paginated(false);
    }
}

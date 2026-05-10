<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Sản phẩm';

    protected static ?string $modelLabel = 'Sản phẩm';

    protected static ?string $pluralModelLabel = 'Sản phẩm';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin cơ bản')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên sản phẩm')
                            ->required()
                            ->maxLength(256)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (\Filament\Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(256)
                            ->unique(ignoreRecord: true),

                        Select::make('category_id')
                            ->label('Danh mục')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        RichEditor::make('description')
                            ->label('Mô tả sản phẩm')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Giá & Tồn kho')
                    ->schema([
                        TextInput::make('price')
                            ->label('Giá bán (₫)')
                            ->required()
                            ->numeric()
                            ->prefix('₫')
                            ->minValue(0),

                        TextInput::make('stock')
                            ->label('Số lượng tồn kho')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Hiển thị trên cửa hàng')
                            ->default(true),
                    ])->columns(3),

                Section::make('Hình ảnh')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('Ảnh sản phẩm')
                            ->collection('image')
                            ->image()
                            ->multiple()
                            ->reorderable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->label('Ảnh')
                    ->collection('image')
                    ->circular()
                    ->size(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('Tên sản phẩm')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Giá')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' ₫')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Tồn kho')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->color(fn (int $state): string => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger')),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->formatStateUsing(fn ($state) => $state?->format('d/m/Y'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Danh mục')
                    ->relationship('category', 'name'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Hiển thị'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

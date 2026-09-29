<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private Builder $query)
    {
    }

    public function query(): QueryBuilder|Builder|Relation
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'ID', 'Name', 'SKU', 'Category', 'Brand',
            'Price', 'Sale Price', 'Cost Price', 'Stock',
            'Status', 'Featured', 'On Sale', 'Created At',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->sku,
            $product->category,
            $product->brand,
            $product->price,
            $product->sale_price,
            $product->cost_price,
            (string) $product->stock,
            $product->status,
            $product->is_featured ? 'Yes' : 'No',
            $product->is_on_sale ? 'Yes' : 'No',
            optional($product->created_at)->format('Y-m-d H:i'),
        ];
    }
}

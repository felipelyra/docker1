<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use FullTextSearch;

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    /**
     * Column full text index
     */
    protected $searchable = [
        'title'
    ];

    protected $filterable = [
        'brand',
        'pricemin',
        'pricemax',
        'stock'
    ];

    protected $sortable = [
        'title',
        'brand',
        'price',
        'stock'
    ];

    public function getFilterable()
    {
        return $this->filterable;
    }

    public function getSortable()
    {
        return $this->sortable;
    }

}

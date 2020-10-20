<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAdditional extends Model
{
    protected $table = 'product_additional';

    protected $fillable = [
        // 'id',
        'name',
        'price',
        'price_include_vat',
        'payment_scheme_id',
        'bandwidth',
        'bandwidth_unit_id',
        'description',
        'required',
        'product_id',
        'created_at',
        'updated_at',

        'price_can_be_adjusted',
        'quantity_can_be_adjusted',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'price' => 'double',
        'price_include_vat' => 'boolean',
        'payment_scheme_id' => 'integer',
        'bandwidth' => 'integer',
        'bandwidth_unit_id' => 'integer',
        'description' => 'string',
        'required' => 'boolean',
        'product_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        
        'price_can_be_adjusted' => 'boolean',
        'quantity_can_be_adjusted' => 'boolean',
    ];

    public function payment_scheme()
    {
        return $this->belongsTo(PaymentScheme::class);
    }

    public function bandwidth_unit()
    {
        return $this->belongsTo(BandwidthUnit::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bandwidth_type()
    {
        return $this->belongsTo(BandwidthType::class);
    }

    public function discounts()
    {
        return $this->hasMany(ProductAdditionalDiscount::class);
    }

    public function tags()
    {
        return $this->belongsToMany(ProductAdditionalTag::class, ProductAdditionalHasTag::class, 'product_additional_id', 'tag_id');
    }

    public function customer_products()
    {
        return $this->belongsToMany(CustomerProduct::class, CustomerProductAdditional::class);
    }
}

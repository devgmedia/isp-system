<?php

namespace GMedia\IspSystem\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use EagerLoadPivotTrait;

    protected $table = 'product';

    protected $fillable = [
        // 'id',
        'name',
        'price',
        'price_include_vat',
        'payment_scheme_id',
        'bandwidth',
        'bandwidth_unit_id',
        'description',
        'branch_id',
        'created_at',
        'updated_at',
        'bandwidth_type_id',

        'brand_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'price' => 'integer',
        'price_include_vat' => 'boolean',
        'payment_scheme_id' => 'integer',
        'bandwidth' => 'integer',
        'bandwidth_unit_id' => 'integer',
        'description' => 'string',
        'branch_id' => 'integer',
        'bandwidth_type_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        
        'brand_id' => 'integer',
    ];

    public function payment_scheme()
    {
        return $this->belongsTo(PaymentScheme::class);
    }

    public function bandwidth_unit()
    {
        return $this->belongsTo(BandwidthUnit::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function bandwidth_type()
    {
        return $this->belongsTo(BandwidthType::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function additionals()
    {
        return $this->hasMany(ProductAdditional::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, ProductDiscount::class)->withPivot('id');
    }

    public function tags()
    {
        return $this->belongsToMany(ProductTag::class, ProductHasTag::class, 'product_id', 'tag_id');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, CustomerProduct::class);
    }
}

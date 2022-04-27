<?php

namespace Gmedia\IspSystem\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use EagerLoadPivotTrait;

    protected $connection = 'isp_system';
    protected $table = 'product';

    protected $fillable = [
        // 'id',
        'name',
        'price',
        'price_include_tax',
        'payment_scheme_id',
        'bandwidth',
        'bandwidth_unit_id',
        'description',
        'branch_id',

        'created_at',
        'updated_at',

        'bandwidth_type_id',

        'brand_id',
        
        'available_via_midtrans',
        'price_can_be_adjusted',
        'bandwidth_can_be_adjusted',

        'uuid',        
        'ar_invoice_item_category_id',

        'hide',

        'radius_username_suffix',
        'radius_password_prefix',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'price' => 'integer',
        'price_include_tax' => 'boolean',
        'payment_scheme_id' => 'integer',
        'bandwidth' => 'integer',
        'bandwidth_unit_id' => 'integer',
        'description' => 'string',
        'branch_id' => 'integer',
        'bandwidth_type_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        
        'brand_id' => 'integer',
        
        'available_via_midtrans' => 'boolean',
        'price_can_be_adjusted' => 'boolean',
        'bandwidth_can_be_adjusted' => 'boolean',

        'uuid' => 'string',        
        'ar_invoice_item_category_id' => 'integer',

        'hide' => 'boolean',
        
        'radius_username_suffix' => 'string',
        'radius_password_prefix' => 'string',
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

    public function ar_invoice_item_category()
    {
        return $this->belongsTo(ArInvoiceItemCategory::class);
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

    public function billings()
    {
        return $this->hasMany(ProductBilling::class);
    }

    public function routers()
    {
        return $this->hasMany(ProductRouter::class);
    }
}

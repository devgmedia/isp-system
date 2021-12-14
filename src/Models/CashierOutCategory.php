<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CashierOutCategory extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'cashier_out_category';

    protected $fillable = [
        // 'id',

        'name',

        'created_at',
        'updated_at',

        'chart_of_account_title_id',
        'chart_of_account_id',
        'chart_of_account_card_id',
        'branch_id',

        'accounting_menu_id',
        'accounting_division_category_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'chart_of_account_title_id' => 'integer',
        'chart_of_account_id' => 'integer',
        'chart_of_account_card_id' => 'integer',
        'branch_id' => 'integer',

        'accounting_division_category_id' => 'integer',
        'accounting_menu_id' => 'integer',
    ];

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function chart_of_account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function chart_of_account_card()
    {
        return $this->belongsTo(ChartOfAccountCard::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function accounting_division_category()
    {
        return $this->belongsTo(AccountingDivisionCategory::class);
    }

    public function accounting_menu()
    {
        return $this->belongsTo(AccountingMenu::class);
    }
}

<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\ChartOfAccountTitle;
use Gmedia\IspSystem\Models\ProductBrand;
use Gmedia\IspSystem\Models\SpmBranchManagerApproval;
use Gmedia\IspSystem\Models\SpmDirectorApproval;
use Gmedia\IspSystem\Models\SpmFinanceApproval;
use Gmedia\IspSystem\Models\SpmGeneralManagerApproval;
use Gmedia\IspSystem\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Page
{
    public static function config($additional = [])
    {
        $user = User::with([
            'employee',
            'employee.branch',
            'employee.branch.regional',
        ])
        ->find(Auth::guard('api')->id());

        $branch = $user->employee->branch;

        $company = $user->employee->branch->regional->company;
        $company_id = $company->id;

        $regional = $user->employee->branch->regional;

        $brand = null;
        $session_brand_id = session()->get('brand_id');
        if ($session_brand_id) {
            $brand = ProductBrand::find($session_brand_id);
        }

        $config = [
            'branch_id' => $branch->id,
            'branch_name' => $branch->name,
            'company' => $company,
            'brand_id' => $brand ? $brand->id : null,
            'brand_name' => $brand ? $brand->name : null,
        ];

        return collect($config)->merge($additional)->all();
    }

    public static function get_options(Request $request, $additional_options = [])
    {
        $user = User::with([
            'employee',
            'employee.branch',
            'employee.branch.regional',
        ])
            ->find(Auth::guard('web')->id());

        $company = $user->employee->branch->regional->company;
        $company_id = $company->id;

        $regional = $user->employee->branch->regional;
        $regional_id = $regional->id;

        $branch = $user->employee->branch;
        $branch_id = $branch->id;

        $session_branch_id = $request->session()->get('branch_id');
        if ($session_branch_id) {
            $branch = Branch::find($session_branch_id);
            $branch_id = $branch->id;

            $regional = $branch->regional;
            $regional_id = $regional->id;

            $company = $branch->regional->company;
            $company_id = $company->id;
        }

        $brand = null;
        $session_brand_id = $request->session()->get('brand_id');
        if ($session_brand_id) {
            $brand = ProductBrand::find($session_brand_id);
        } elseif ($user->employee->preferred_brand) {
            $brand = ProductBrand::find($user->employee->preferred_brand);
        } else {
            $brand = ProductBrand::oldest()->first();
        }

        $brand_type = $brand ? $brand->type : null;

        $default_options = [
            'employee_name' => $user->employee->name,

            'company_id' => $company_id,
            'company_name' => $company->name,
            'company_code' => $company->code, // deprecated

            'regional_id' => $regional_id,
            'regional_name' => $regional->name,

            'branch_id' => $branch_id,
            'branch_name' => $branch->name,

            'brand_id' => $brand ? $brand->id : null,
            'brand_name' => $brand ? $brand->name : null,
            'brand_uuid' => $brand ? $brand->uuid : null,
            'brand_type_name' => $brand_type ? $brand_type->name : null,
        ];

        $default_options = collect($default_options)->merge(static::get_accounting_options($request))->all();
        $default_options = collect($default_options)->merge(static::get_spm_options($request))->all();
        $default_options = collect($default_options)->merge(static::get_ar_options($request))->all();

        return collect($default_options)->merge($additional_options)->all();
    }

    public static function get_accounting_options(Request $request, $additional_options = [])
    {
        $user = User::with([
            'employee',
            'employee.branch',
        ])
            ->find(Auth::guard('web')->id());

        $branch = $user->employee->branch;
        $branch_id = $branch->id;

        $session_branch_id = $request->session()->get('branch_id');
        if ($session_branch_id) {
            $branch_id = $session_branch_id;
        }

        $chart_of_account_title_id = $request->session()->get('chart_of_account_title_id');
        if (! $chart_of_account_title_id) {
            $chart_of_account_title_query = ChartOfAccountTitle::where('branch_id', $branch_id)
                ->orderByDesc('effective_date');

            if ($chart_of_account_title_query->exists()) {
                $chart_of_account_title_id = $chart_of_account_title_query->value('id');
            }
        }

        $default_options = [
            'chart_of_account_title_id' => $chart_of_account_title_id,
            'chart_of_account_title_uuid' => ChartOfAccountTitle::find($chart_of_account_title_id)->uuid,
        ];

        return collect($default_options)->merge($additional_options)->all();
    }

    public static function get_spm_options(Request $request, $additional_options = [])
    {
        $user = User::with([
            'employee',
            'employee.branch',
        ])
            ->find(Auth::guard('web')->id());

        $regional = $user->employee->branch->regional;

        $branch = $user->employee->branch;
        $branch_id = $branch->id;

        $session_branch_id = $request->session()->get('branch_id');
        if ($session_branch_id) {
            $branch_id = $session_branch_id;
        }

        $chart_of_account_title_id = $request->session()->get('chart_of_account_title_id');
        if (! $chart_of_account_title_id) {
            $chart_of_account_title_query = ChartOfAccountTitle::where('branch_id', $branch_id)
                ->orderByDesc('effective_date');

            if ($chart_of_account_title_query->exists()) {
                $chart_of_account_title_id = $chart_of_account_title_query->value('id');
            }
        }

        $branch_manager_unread = SpmBranchManagerApproval::select(
            DB::raw('count(spm_branch_manager_approval.id) as unread'),
        )
            ->where('branch_id', $branch_id)
            ->where('chart_of_account_title_id', $chart_of_account_title_id)
            ->where(function ($query) {
                $query->where('invalid', false);
                $query->orWhereNull('invalid');
            })
            ->where(function ($query) {
                $query->where('read', false);
                $query->orWhereNull('read');
            })
            ->value('unread');

        $finance_unread = SpmFinanceApproval::select(
            DB::raw('count(spm_finance_approval.id) as unread'),
        )
            ->where('branch_id', $branch_id)
            ->where('chart_of_account_title_id', $chart_of_account_title_id)
            ->where(function ($query) {
                $query->where('invalid', false);
                $query->orWhereNull('invalid');
            })
            ->where(function ($query) {
                $query->where('read', false);
                $query->orWhereNull('read');
            })
            ->value('unread');

        $general_manager_unread = SpmGeneralManagerApproval::select(
            DB::raw('count(spm_general_manager_approval.id) as unread'),
        )
            ->where('branch_id', $branch_id)
            ->where('chart_of_account_title_id', $chart_of_account_title_id)
            ->where(function ($query) {
                $query->where('invalid', false);
                $query->orWhereNull('invalid');
            })
            ->where(function ($query) {
                $query->where('read', false);
                $query->orWhereNull('read');
            })
            ->value('unread');

        $director_unread = SpmDirectorApproval::select(
            DB::raw('count(spm_director_approval.id) as unread'),
        )
            ->where('branch_id', $branch_id)
            ->where('chart_of_account_title_id', $chart_of_account_title_id)
            ->where(function ($query) {
                $query->where('invalid', false);
                $query->orWhereNull('invalid');
            })
            ->where(function ($query) {
                $query->where('read', false);
                $query->orWhereNull('read');
            })
            ->value('unread');

        $default_options = [
            'spm' => [
                'branch_manager_is_active' => $branch->spm_is_active,
                'branch_manager_unread' => $branch_manager_unread,

                'finance_is_active' => $regional->spm_finance_is_active,
                'finance_unread' => $finance_unread,

                'general_manager_is_active' => $regional->spm_general_manager_is_active,
                'general_manager_unread' => $general_manager_unread,

                'director_is_active' => $regional->spm_director_is_active,
                'director_unread' => $director_unread,
            ],
        ];

        return collect($default_options)->merge($additional_options)->all();
    }

    public static function get_ar_options(Request $request, $additional_options = [])
    {
        $user = User::with([
            'employee',
            'employee.branch',
        ])
            ->find(Auth::guard('web')->id());

        $branch = $user->employee->branch;
        $branch_id = $branch->id;

        $session_branch_id = $request->session()->get('branch_id');
        if ($session_branch_id) {
            $branch_id = $session_branch_id;
        }

        $chart_of_account_title_id = $request->session()->get('chart_of_account_title_id');
        if (! $chart_of_account_title_id) {
            $chart_of_account_title_query = ChartOfAccountTitle::where('branch_id', $branch_id)
                ->orderByDesc('effective_date');

            if ($chart_of_account_title_query->exists()) {
                $chart_of_account_title_id = $chart_of_account_title_query->value('id');
            }
        }

        $ar_invoices_query = DB::table('ar_invoice')
            ->select(
                'ar_invoice.id',
                DB::raw('(
                    case when
                        datediff(curdate(), ar_invoice.date) > datediff(ar_invoice.due_date, ar_invoice.date)
                    then
                        true
                    else
                        false
                    end
                ) as over_due'),
                DB::raw('(
                    case when
                        datediff(curdate(), ar_invoice.date) > (datediff(ar_invoice.due_date, ar_invoice.date) / 2) and
                        datediff(curdate(), ar_invoice.date) <= datediff(ar_invoice.due_date, ar_invoice.date)
                    then
                        true
                    else
                        false
                    end
                ) as warning_due'),
                DB::raw('(
                    case when
                        datediff(curdate(), ar_invoice.date) > 0 and
                        datediff(curdate(), ar_invoice.date) <= (datediff(ar_invoice.due_date, ar_invoice.date) / 2)
                    then
                        true
                    else
                        false
                    end
                ) as active'),
                DB::raw('(
                    case when
                        ar_invoice.billing_end_date < curdate()
                    then
                        true
                    else
                        false
                    end
                ) as non_active'),
            )
            ->where('ar_invoice.paid', false)
            ->where('ar_invoice.branch_id', $branch_id)
            ->where('ar_invoice.chart_of_account_title_id', $chart_of_account_title_id);

        $aging_retail_over_due_query = clone $ar_invoices_query;
        $aging_retail_over_due = DB::table(DB::raw('('.$aging_retail_over_due_query
            ->having('non_active', false)
            ->having('over_due', true)
            ->toSql()
        .') as ar_invoice'))
            ->select(DB::raw('count(ar_invoice.id) as total_over_due'))
            ->setBindings($aging_retail_over_due_query->getBindings())
            ->value('total_over_due');

        $aging_retail_warning_due_query = clone $ar_invoices_query;
        $aging_retail_warning_due = DB::table(DB::raw('('.$aging_retail_warning_due_query
            ->having('non_active', false)
            ->having('warning_due', true)
            ->toSql()
        .') as ar_invoice'))
            ->select(DB::raw('count(ar_invoice.id) as total_warning_due'))
            ->setBindings($aging_retail_warning_due_query->getBindings())
            ->value('total_warning_due');

        $aging_retail_active_query = clone $ar_invoices_query;
        $aging_retail_active = DB::table(DB::raw('('.$aging_retail_active_query
            ->having('non_active', false)
            ->having('active', true)
            ->toSql()
        .') as ar_invoice'))
            ->select(DB::raw('count(ar_invoice.id) as total_active'))
            ->setBindings($aging_retail_active_query->getBindings())
            ->value('total_active');

        $aging_retail_non_active_query = clone $ar_invoices_query;
        $aging_retail_non_active = DB::table(DB::raw('('.$aging_retail_non_active_query
            ->having('non_active', true)
            ->toSql()
        .') as ar_invoice'))
            ->select(DB::raw('count(ar_invoice.id) as total_non_active'))
            ->setBindings($aging_retail_non_active_query->getBindings())
            ->value('total_non_active');

        $default_options = [
            'ar' => [
                'aging_retail_non_active' => $aging_retail_non_active,
                'aging_retail_active' => $aging_retail_active,
                'aging_retail_warning_due' => $aging_retail_warning_due,
                'aging_retail_over_due' => $aging_retail_over_due,
            ],
        ];

        return collect($default_options)->merge($additional_options)->all();
    }
}

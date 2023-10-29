<?php

namespace App\Admin\Controllers;

use App\Models\Earning;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EarningController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Earning';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Earning());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('user.name', __('User Name'));
        $grid->column('order_code', __('Order code'))->sortable();
        $grid->column('sales_amount', __('Sales amount'))->totalRow();
        $grid->column('total_quantity', __('Total quantity'))->sortable();
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->in('user_id', 'ユーザー名')->multipleSelect(User::all()->pluck('name', 'id'));
            $filter->like('order_code', '注文コード');
            $filter->between('created_at', '注文期間')->datetime();
        });

        $grid->disableCreateButton();
        $grid->actions(function($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }

}

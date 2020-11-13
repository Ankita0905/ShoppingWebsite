<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes, Utility;

    protected $table = 'order_detail';

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'total_price',

        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    public $sortOrder = 'desc';
    public $sortEntity = 'order_detail.id';

    public function pagination(Request $request) {
        $perPage = defaultPerPage();

        $fields = "order_detail.*, category.category_name";

        $filter = 1;
        $sortOrder = $this->sortOrder;
        $sortEntity = $this->sortEntity;

        if($request->has('perPage') && $request->get('perPage') != '') {
            $perPage = $request->get('perPage');
        }

        if($request->has('keyword') && $request->get('keyword') != '') {
            $filter .= " and (order_detail.order_detail_name like '%" . addslashes($request->get('keyword')) ."%'
                or order_detail.description like '%" . addslashes($request->get('keyword')) . "%')";
        }

        if($request->has('status') && $request->get('status') != '') {
            $filter .= " and order_detail.status = '" . addslashes($request->get('status')) . "'";
        }

        if($request->has('sortEntity') && $request->get('sortEntity') != '') {
            $sortEntity = $request->get('sortEntity');
        }

        if($request->has('sortOrder') && $request->get('sortOrder') != '') {
            $sortOrder = $request->get('sortOrder');
        }

        return $this
            ->select(\DB::raw($fields))
            ->leftJoin('category', 'category.id', '=', 'order_detail.category_id')
            ->whereRaw($filter)
            ->order_detailBy($sortEntity, $sortOrder)
            ->paginate($perPage);
    }

    public function fetch($id) {
        $fields = [
            'order_detail.*'
        ];
        return $this
            ->where('order_detail.id', $id)
            ->first($fields);
    }

    public function toggleStatus($status, $ids = [])
    {
        if(isset($ids) && count($ids) > 0) {
            return $this->whereIn('order_detail.id', $ids)->update(['status' => $status]);
        }
    }

    public function scopeActive($query) {
        return $query->where('order_detail.status', 1);
    }

    public function service($heading = true) {
        $result = $this
            ->active()
            ->order_detailBy('order_detail_name', 'asc')
            ->get(['id', 'order_detail_name']);

        $service = [];
        if($heading) {
            $service = ['' => '-Select Product-'];
        }

        if(isset($result) && count($result) > 0) {
            foreach($result as $key => $row) {
                $service[$row->id] = $row->order_detail_name;
            }
        }
        return $service;
    }

    public function customerOrder($orderId) 
    {
        $fields = [
            'order_detail.*',
            'product.product_name',
            'product.description',
            'category.category_name',
        ];

        return $this
            ->join('product', 'product.id', '=', 'order_detail.product_id')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->where('order_detail.order_id', $orderId)
            ->get($fields);
    }
}

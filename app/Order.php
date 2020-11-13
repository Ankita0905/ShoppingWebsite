<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, Utility;

    protected $table = 'orders';

    protected $fillable = [
        'payment_mode',
        'order_number',
        'address',
        'order_date',
        'order_status', // 1 => pending, 2 => confirmed
        'user_id',
        'total_price',
        'total_item',

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
    public $sortEntity = 'orders.id';

    public function validation($inputs = [], $id = null)
    {
        $rules = [
            'order_status' => 'required|numeric|in:1,2'
        ];
        return validator($inputs, $rules);
    }

    public function pagination(Request $request) {
        $perPage = defaultPerPage();

        $fields = "orders.*, users.name, users.email, users.mobile_number";

        $filter = 1;
        $sortOrder = $this->sortOrder;
        $sortEntity = $this->sortEntity;

        if($request->has('perPage') && $request->get('perPage') != '') {
            $perPage = $request->get('perPage');
        }

        if($request->has('keyword') && $request->get('keyword') != '') {
            $filter .= " and (orders.order_number like '%" . addslashes($request->get('keyword')) ."%'" .
                " or users.name like '%" . addslashes($request->get('keyword')) . "%'" .
                " or users.email like '%" . addslashes($request->get('keyword')) . "%'" .
                ")";
        }

        if($request->has('status') && $request->get('status') != '') {
            $filter .= " and orders.order_status = '" . addslashes($request->get('status')) . "'";
        }

        if($request->has('sortEntity') && $request->get('sortEntity') != '') {
            $sortEntity = $request->get('sortEntity');
        }

        if($request->has('sortOrder') && $request->get('sortOrder') != '') {
            $sortOrder = $request->get('sortOrder');
        }

        return $this
            ->select(\DB::raw($fields))
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->whereRaw($filter)
            ->orderBy($sortEntity, $sortOrder)
            ->paginate($perPage);
    }

    public function fetch($id) {
        $fields = [
            'orders.*',
            'users.name',
            'users.email'
        ];
        
        return $this
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.id', $id)
            ->first($fields);
    }

    public function toggleStatus($status, $ids = [])
    {
        if(isset($ids) && count($ids) > 0) {
            return $this->whereIn('orders.id', $ids)->update(['status' => $status]);
        }
    }

    public function scopeActive($query) {
        return $query->where('orders.status', 1);
    }

    public function service($heading = true) {
        $result = $this
            ->active()
            ->orderBy('order_name', 'asc')
            ->get(['id', 'order_name']);

        $service = [];
        if($heading) {
            $service = ['' => '-Select Product-'];
        }

        if(isset($result) && count($result) > 0) {
            foreach($result as $key => $row) {
                $service[$row->id] = $row->order_name;
            }
        }
        return $service;
    }

    public function orderNumber() {
        $result = $this
                    ->orderBy('id', 'desc')
                    ->first();

        $number = ($result) ? $result->id : 0;
        return srNo($number);
    }

    public function customerOrder($userId)
    {
        return $this
            ->where('orders.user_id', $userId)
            ->orderBy('orders.id', 'desc')
            ->paginate(5);
    }
}

<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomOrderDetail extends Model
{
    use SoftDeletes, Utility;

    protected $table = 'order_detail';

    protected $fillable = [
        'order_id',
        'name',
        'contact_number',
        'email',
        'address',
        'is_verified',
        'otp_code',

        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    public $sortOrder = 'desc';
    public $sortEntity = 'order_detail.id';

    public function validation($inputs = [], $id = null)
    {
        $rules = [
            'name' => 'required',
            'contact_number' => 'required|digits:10',
            'email' => 'required|email',
            'address' => 'required|max:255',
            'order_detail_date' => 'required',
            'order_detail_time' => 'required'
        ];
        return validator($inputs, $rules);
    }

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
}

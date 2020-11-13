<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomOrder extends Model
{
    use SoftDeletes, Utility;

    protected $table = 'order';

    protected $fillable = [
        'category_id',
        'name',
        'contact_number',
        'email',
        'address',
        'order_date',
        'order_time',
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
    public $sortEntity = 'order.id';

    public function validation($inputs = [], $id = null)
    {
        $rules = [
            'name' => 'required',
            'contact_number' => 'required|digits:10',
            'email' => 'required|email',
            'address' => 'required|max:255',
            'order_date' => 'required',
            'order_time' => 'required'
        ];
        return validator($inputs, $rules);
    }

    public function pagination(Request $request) {
        $perPage = defaultPerPage();

        $fields = "order.*, category.category_name";

        $filter = 1;
        $sortOrder = $this->sortOrder;
        $sortEntity = $this->sortEntity;

        if($request->has('perPage') && $request->get('perPage') != '') {
            $perPage = $request->get('perPage');
        }

        if($request->has('keyword') && $request->get('keyword') != '') {
            $filter .= " and (order.order_name like '%" . addslashes($request->get('keyword')) ."%'
                or order.description like '%" . addslashes($request->get('keyword')) . "%')";
        }

        if($request->has('status') && $request->get('status') != '') {
            $filter .= " and order.status = '" . addslashes($request->get('status')) . "'";
        }

        if($request->has('sortEntity') && $request->get('sortEntity') != '') {
            $sortEntity = $request->get('sortEntity');
        }

        if($request->has('sortOrder') && $request->get('sortOrder') != '') {
            $sortOrder = $request->get('sortOrder');
        }

        return $this
            ->select(\DB::raw($fields))
            ->leftJoin('category', 'category.id', '=', 'order.category_id')
            ->whereRaw($filter)
            ->orderBy($sortEntity, $sortOrder)
            ->paginate($perPage);
    }

    public function fetch($id) {
        $fields = [
            'order.*'
        ];
        return $this
            ->where('order.id', $id)
            ->first($fields);
    }

    public function toggleStatus($status, $ids = [])
    {
        if(isset($ids) && count($ids) > 0) {
            return $this->whereIn('order.id', $ids)->update(['status' => $status]);
        }
    }

    public function scopeActive($query) {
        return $query->where('order.status', 1);
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
}

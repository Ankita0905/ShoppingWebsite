<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, Utility;

    protected $table = 'category';

    protected $fillable = [
        'category_name',
        'status',

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
    public $sortEntity = 'id';

    public function validation($inputs = [], $id = null)
    {
        $rules = [
            'category_name' => 'required|unique:category',
            'status' => 'required|numeric|in:0,1',
        ];

        if($id) {
            $rules['category_name'] = 'required|unique:category,category_name,'.$id;
        }
        return validator($inputs, $rules);
    }

    public function pagination(Request $request) {
        $perPage = defaultPerPage();
        $filter = 1;
        $sortOrder = $this->sortOrder;
        $sortEntity = $this->sortEntity;

        if($request->has('perPage') && $request->get('perPage') != '') {
            $perPage = $request->get('perPage');
        }

        if($request->has('keyword') && $request->get('keyword') != '') {
            $filter .= " and category.category_name like '%" . addslashes($request->get('keyword')) ."%'";
        }

        if($request->has('status') && $request->get('status') != '') {
            $filter .= " and category.status = '" . addslashes($request->get('status')) . "'";
        }

        if($request->has('sortEntity') && $request->get('sortEntity') != '') {
            $sortEntity = $request->get('sortEntity');
        }

        if($request->has('sortOrder') && $request->get('sortOrder') != '') {
            $sortOrder = $request->get('sortOrder');
        }

        return $this
            ->whereRaw($filter)
            ->orderBy($sortEntity, $sortOrder)
            ->paginate($perPage);
    }

    public function fetch($id) {
        $fields = [
            'category.*'
        ];
        return $this
            ->where('category.id', $id)
            ->first($fields);
    }

    public function toggleStatus($status, $ids = [])
    {
        if(isset($ids) && count($ids) > 0) {
            return $this->whereIn('category.id', $ids)->update(['status' => $status]);
        }
    }

    public function scopeActive($query) {
        return $query->where('category.status', 1);
    }

    public function service($heading = true) {
        $result = $this
            ->active()
            ->orderBy('category_name', 'asc')
            ->get(['id', 'category_name']);

        $service = [];
        if($heading) {
            $service = ['' => '-Select Category-'];
        }

        if(isset($result) && count($result) > 0) {
            foreach($result as $row) {
                $service[$row->id] = $row->category_name;
            }
        }
        return $service;
    }

    public function frontService($heading = true) {
        $result = $this
            ->active()
            ->orderBy('category_name', 'asc')
            ->get(['id', 'category_name']);

        $service = [];
        if($heading) {
            $service = ['' => 'All'];
        }

        if(isset($result) && count($result) > 0) {
            foreach($result as $row) {
                $service[$row->id] = $row->category_name;
            }
        }
        return $service;
    }

    public function categories() {
        return $this
            ->active()
            ->get();
    }
}

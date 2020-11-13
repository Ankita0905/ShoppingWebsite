<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, Utility;

    protected $table = 'product';

    protected $fillable = [
        'category_id',
        'product_name',
        'price',
        'description',
        'status',
        'image',

        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $hidden = [
          
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    public $sortOrder = 'desc';
    public $sortEntity = 'product.id';

    public function validation($inputs = [], $id = null)
    {
        $rules = [
            'category_id' => 'required|numeric|min:1',
            // 'product_name' => 'required|unique:product',
            'product_name' => 'required|min:3',
            'status' => 'required|numeric|in:0,1',
            'price' => 'required|numeric|min:1',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif'
        ];

        if($id) {
            // $rules['product_name'] = 'required|unique:product,product_name,'.$id;
            $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,gif';
        }
        return validator($inputs, $rules);
    }
    
    public function pagination(Request $request)
    {
        $perPage = defaultPerPage();
        $fields = "product.*, category.category_name";

        $filter = 1;
        $sortOrder = $this->sortOrder;
        $sortEntity = $this->sortEntity;

        if($request->has('perPage') && $request->get('perPage') != '') {
            $perPage = $request->get('perPage');
        }

        if($request->has('keyword') && $request->get('keyword') != '') {
            $filter .= " and (product.product_name like '%" . addslashes($request->get('keyword')) ."%'
                or product.description like '%" . addslashes($request->get('keyword')) . "%')";
        }

        if($request->has('category_id') && $request->get('category_id') != '') {
            $filter .= " and product.category_id like '%" . addslashes($request->get('category_id')) . "%'";
        }

        if($request->has('status') && $request->get('status') != '') {
            $filter .= " and product.status = '" . addslashes($request->get('status')) . "'";
        }

        if($request->has('sortEntity') && $request->get('sortEntity') != '') {
            $sortEntity = $request->get('sortEntity');
        }

        if($request->has('sortOrder') && $request->get('sortOrder') != '') {
            $sortOrder = $request->get('sortOrder');
        }

        return $this
            ->select(\DB::raw($fields))
            ->join('category', 'category.id', '=', 'product.category_id')
            ->whereRaw($filter)
            ->orderBy($sortEntity, $sortOrder)
            ->paginate($perPage);
    }

    public function fetch($id) 
    {
        $fields = [
            'product.*',
            'category.category_name',
        ];
        return $this
            ->join('category', 'category.id', '=', 'product.category_id')
            ->where('product.id', $id)
            ->first($fields);
    }

    public function toggleStatus($status, $ids = [])
    {
        if(isset($ids) && count($ids) > 0) {
            return $this->whereIn('product.id', $ids)->update(['status' => $status]);
        }
    }

    public function scopeActive($query) {
        return $query->where('product.status', 1);
    }

    public function service($heading = true) {
        $result = $this
            ->active()
            ->orderBy('product_name', 'asc')
            ->get(['id', 'product_name']);

        $service = [];
        if($heading) {
            $service = ['' => '-Select Product-'];
        }

        if(isset($result) && count($result) > 0) {
            foreach($result as $key => $row) {
                $service[$row->id] = $row->product_name;
            }
        }
        return $service;
    }

    public function latestProduct($search = [])
    {
        $filter = 1;
        $take = 9;
        $fields = 'product.*, category.category_name';

        $result =  $this
            ->select(\DB::raw($fields))
            ->join('category', 'category.id', '=', 'product.category_id')
            ->active();

        if(isset($search['category']) && $search['category'] != '')  {
            $filter .= " and product.category_id = '" . addslashes($search['category']) . "'";
            $take = 12;
        }

        if(isset($search['search']) && $search['search'] != '')  {
            $filter .= " and product.product_name like '%" . addslashes($search['search']) . "%'";
            $take = 12;
        }
        
        return $result->whereRaw($filter)->paginate($take);
    }

    public function relatedProduct($search = [])
    {
        $filter = 1;
        if(isset($search) && count($search) > 0) {
            $f1 = (isset($search['category_id']) && $search['category_id'] != '') ?
                " and product.category_id = '" . addslashes($search['category_id']) . "'" : '';

            $f2 = (isset($search['skip_product_id']) && $search['skip_product_id'] != '') ?
                " and product.id != '" . addslashes($search['skip_product_id']) . "'" : '';

            $filter .= $f1 . $f2;
        }

        $fields = ['product.*', 'category.category_name'];
        return $this
            ->join('category', 'category.id', '=', 'product.category_id')
            ->whereRaw($filter)
            ->active()
            ->take(12)
            ->get($fields);
    }

    public function cartValidation($inputs = [])
    {
        $rules = [
            'id' => 'required|numeric|min:1',
            'quantity' => 'required|numeric|min:1|max:100',
        ];


        if(isset($inputs['id']) && $inputs['id'] != '') {
            $result = $this->fetch($inputs['id']);
            if($result) {
                if ($result->has_variation) {

                    $rules['color'] = 'required';
                    $rules['size'] = 'required';

                    $measure = explode(',', $result->measurements);
                    foreach ($measure as $m => $mValue) {
                        $rules[$mValue] = 'required|numeric|min:1|max:100';
                    }
                }
            }
        }
        return validator($inputs, $rules);
    }
}

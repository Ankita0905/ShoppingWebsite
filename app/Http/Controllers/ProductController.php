<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortOrder = (new Product)->sortOrder;
        $sortEntity = (new Product)->sortEntity;

        $result = null;
        if($request->ajax()) {
            $sortEntity = $request->sortEntity;
            $sortOrder = $request->sortOrder;

            $result = (new Product)->pagination($request);
            return view('product.pagination', compact('result', 'sortOrder', 'sortEntity'));
        }

        $category = (new Category)->service();
        return view('product.index', compact('result', 'sortOrder', 'sortEntity', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = (new Category)->service();
        return view('product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validation = (new Product)->validation($inputs);
        if($validation->fails()) {
            return jsonResponse(false, 206, $validation->getMessageBag());
        }

        try {
            \DB::beginTransaction();
            $authId = authId();
            
            // image upload code start
            if($request->hasFile('image')) {
                $inputs['image'] = uploadImg($request, 'image', env('PRODUCT_PATH'));
            }
            // image upload code end

            $inputs['created_by'] = $authId;
            (new Product)->store($inputs);
            \DB::commit();

            $extra = ['redirect' => route('product.index')];
            $message = __('message.created', ['attr' => __('product.product')]);
            return jsonResponse(true, 201, $message, $extra);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            return jsonResponse(true, 207, __('message.server_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = (new Product)->fetch($id);
        if(!$result) {
            abort(404);
        }

        $category = (new Category)->service();
        return view('product.edit', compact('result', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = (new Product)->fetch($id);
        if(!$result) {
            $message = __('common.invalid_id', ['attr' => __('product.product')]);
            return jsonResponse(false, 207, $message);
        }

        $inputs = $request->all();
        $validation = (new Product)->validation($inputs, $id);
        if($validation->fails()) {
            return jsonResponse(false, 206, $validation->getMessageBag());
        }

        try {
            \DB::beginTransaction();
            $authId = authId();
            $inputs['updated_by'] = $authId;

            // image upload code start
            if($request->hasFile('image')) {
                $path = env('PRODUCT_PATH');
                $image = uploadImg($request, 'image', $path);
                if($image) {
                    $inputs['image'] = $image;
                    removeImg($result->image, $path);
                }
            }
            // image upload code end

            (new Product)->store($inputs, $id);
            \DB::commit();

            $extra = ['redirect' => route('product.index')];
            $message = __('message.updated', ['attr' => __('product.product')]);
            return jsonResponse(true, 201, $message, $extra);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            return jsonResponse(true, 207, __('message.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        (new Product)->find($id)->delete();
        $message = __('message.deleted', ['attr' => __('product.product')]);
        return jsonResponse(true, 201, $message);
    }

    public function toggleStatus($id, $status) {
        $result = (new Product)->fetch($id);
        if(!$result) {
            $message = __('common.invalid_id', ['attr' => __('product.product')]);
            return jsonResponse(false, 207, $message);
        }

        try {
            \DB::beginTransaction();
            $result->update(['status' => $status]);
            \DB::commit();

            $message = __('message.status', ['attr' => __('product.product')]);
            return jsonResponse(true, 201, $message);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function toggleAllStatus($status, Request $request) {
        try {
            \DB::beginTransaction();
            $inputs = $request->only('ids');

            (new Product)->toggleStatus($status, $inputs['ids']);
            \DB::commit();

            $message = __('message.status', ['attr' => __('product.product')]);
            return jsonResponse(true, 201, $message);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function status($id) {
        $result = (new Product)->fetch($id);
        if(!$result) {
            $message = __('message.invalid_id');
            return jsonResponse(false, 207, $message);
        }

        try {
            \DB::beginTransaction();
            $result->update(['status' => !$result->status]);
            \DB::commit();

            $message = __('message.status');
            return jsonResponse(true, 201, $message);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }
}

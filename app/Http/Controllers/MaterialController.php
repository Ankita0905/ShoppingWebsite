<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortOrder = (new Material)->sortOrder;
        $sortEntity = (new Material)->sortEntity;

        $result = null;
        if($request->ajax()) {
            $sortEntity = $request->sortEntity;
            $sortOrder = $request->sortOrder;

            $result = (new Material)->pagination($request);
            return view('material.pagination', compact('result', 'sortOrder', 'sortEntity'));
        }

        return view('material.index', compact('result', 'sortOrder', 'sortEntity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('material.create');
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
        $validation = (new Material)->validation($inputs);
        if($validation->fails()) {
            return jsonResponse(false, 206, $validation->getMessageBag());
        }

        try {
            \DB::beginTransaction();
            // image upload code start
            if($request->hasFile('image')) {
                $inputs['image'] = uploadImg($request, 'image', env('MATERIAL_PATH'));
            }
            // image upload code end

            $inputs['created_by'] = authId();
            (new Material)->store($inputs);
            \DB::commit();

            $extra = ['redirect' => route('material.index')];
            $message = __('message.created', ['attr' => __('material.material')]);
            return jsonResponse(true, 201, $message, $extra);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            return jsonResponse(true, 207, __('message.server_error') . $e->getMessage());
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
        $result = (new Material)->fetch($id);
        if(!$result) {
            abort(404);
        }
        return view('material.edit', compact('result'));
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
        $result = (new Material)->fetch($id);
        if(!$result) {
            $message = __('common.invalid_id', ['attr' => __('material.material')]);
            return jsonResponse(false, 207, $message);
        }

        $inputs = $request->all();
        $validation = (new Material)->validation($inputs, $id);
        if($validation->fails()) {
            return jsonResponse(false, 206, $validation->getMessageBag());
        }

        try {
            \DB::beginTransaction();
            // image upload code start
            if($request->hasFile('image')) {
                $path = env('MATERIAL_PATH');
                $image = uploadImg($request, 'image', $path);
                if($image) {
                    $inputs['image'] = $image;
                    removeImg($result->image, $path);
                }
            }
            // image upload code end

            $inputs['updated_by'] = authId();
            (new Material)->store($inputs, $id);
            \DB::commit();

            $extra = ['redirect' => route('material.index')];
            $message = __('message.updated', ['attr' => __('material.material')]);
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
        (new Material)->find($id)->delete();
        $message = __('message.deleted', ['attr' => __('material.material')]);
        return jsonResponse(true, 201, $message);
    }

    public function toggleStatus($id, $status) {
        $result = (new Material)->fetch($id);
        if(!$result) {
            $message = __('common.invalid_id', ['attr' => __('material.material')]);
            return jsonResponse(false, 207, $message);
        }

        try {
            \DB::beginTransaction();
            $result->update(['status' => $status]);
            \DB::commit();

            $message = __('message.status', ['attr' => __('material.material')]);
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

            (new Material)->toggleStatus($status, $inputs['ids']);
            \DB::commit();

            $message = __('message.status', ['attr' => __('material.material')]);
            return jsonResponse(true, 201, $message);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function status($id) {
        $result = (new Material)->fetch($id);
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

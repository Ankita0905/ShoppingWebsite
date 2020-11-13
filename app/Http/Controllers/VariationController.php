<?php

namespace App\Http\Controllers;

use App\Variation;
use App\Category;
use App\VariationDetail;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortOrder = (new Variation)->sortOrder;
        $sortEntity = (new Variation)->sortEntity;

        $result = null; 
        if($request->ajax()) {
            $sortEntity = $request->sortEntity;
            $sortOrder = $request->sortOrder;

            $result = (new Variation)->pagination($request);
            return view('variation.pagination', compact('result', 'sortOrder', 'sortEntity'));
        }

        $category = (new Category)->service();
        return view('variation.index', compact('result', 'sortOrder', 'sortEntity', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = (new Category)->service();
        return view('variation.create', compact('category'));
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
        $validation = (new Variation)->validation($inputs);
        if($validation->fails()) {
            return jsonResponse(false, 206, $validation->getMessageBag());
        }

        try {
            \DB::beginTransaction();
            // variation code start
            $variation = [
                'category_id' => $inputs['category_id'],
                'variation_name' => $inputs['variation_name'],
                'status' => $inputs['status'],
                'description' => $inputs['description'],
                'created_by' => authId()
            ];
            $variationId = (new Variation)->store($variation);
            // variation code end

            // variation detail code start
            if($variationId) {
                $details = [];
                if(isset($inputs['variation_title']) && count($inputs['variation_title']) > 0) {
                    foreach($inputs['variation_title'] as $i => $row) {

                        // image code start
                        $image = null;
                        $file = $request->file('variation_image')[$i];
                        if ($file) {
                            $filename = $file->getClientOriginalName();
                            $filename = str_replace(' ', '', $filename);

                            $filename = str_random(8) . '_' . $filename;
                            $uploadPath = env('VARIATION_PATH');
                            if ($file->move($uploadPath, $filename)) {
                                $image = $filename;
                            }
                        }
                        // image code end

                        $details[] = [
                            'variation_id' => $variationId,
                            'title' => $inputs['variation_title'][$i],
                            'price' => $inputs['variation_price'][$i],
                            'status' => $inputs['variation_status'][$i],
                            'image' => $image,
                            'created_by' => authId(),
                        ];
                    }

                    if(isset($details) && count($details) > 0) {
                        (new VariationDetail)->store($details, null, true);
                    }
                }
            }
            // variation detail code end
            \DB::commit();

            $extra = ['redirect' => route('variation.index')];
            $message = __('message.created', ['attr' => __('variation.variation')]);
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
        $result = (new Variation)->fetch($id);
        if(!$result) {
            abort(404);
        }

        $items = (new VariationDetail)->items($result->id);
        $category = (new Category)->service();
        return view('variation.edit', compact('result', 'items', 'category'));
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
        $result = (new Variation)->fetch($id);
        if(!$result) {
            $message = __('common.invalid_id', ['attr' => __('variation.variation')]);
            return jsonResponse(false, 207, $message);
        }

        $inputs = $request->all();
        $validation = (new Variation)->validation($inputs, $id);
        if($validation->fails()) {
            return jsonResponse(false, 206, $validation->getMessageBag());
        }

        try {
            \DB::beginTransaction();
            // variation code start
            $authId = authId();
            $inputs['updated_by'] = $authId;
            (new Variation)->store($inputs, $id);
            // variation code end 

            // detail code start
            $details = [];
            if(isset($inputs['variation_title']) && count($inputs['variation_title']) > 0) {
                $uploadPath = env('VARIATION_PATH');

                foreach($inputs['variation_title'] as $i => $row) 
                {
                    $title = $inputs['variation_title'][$i];
                    $price = $inputs['variation_price'][$i];
                    $status = $inputs['variation_status'][$i];
                    $detailId = $inputs['variation_id'][$i];
                    
                    // image code start
                    $image = $inputs['variation_prev_img'][$i];
                    $file = $request->file('variation_image')[$i] ?? null;
                    if ($file) {
                        $filename = $file->getClientOriginalName();
                        $filename = str_replace(' ', '', $filename);
                        $filename = str_random(8) . '_' . $filename;
                        if ($file->move($uploadPath, $filename)) {
                            $prevImg = public_path($uploadPath . $image);
                            if($image != '' && file_exists($prevImg)) {
                                unlink($prevImg);
                            }
                            $image = $filename;
                        }
                    }
                    // image code end

                    // update code start
                    if(isset($detailId) && $detailId != '') {
                        $update = [
                            'title' => $title,
                            'price' => $price,
                            'status' => $status,
                            'image' => $image,
                            'updated_by' => $authId,
                        ];
                        (new VariationDetail)->store($update, $detailId);
                    }
                    // create code start
                    else {
                        $details[] = [
                            'variation_id' => $id,
                            'title' => $title,
                            'price' => $price,
                            'status' => $status,
                            'image' => $image,
                            'created_by' => $authId,
                        ];
                    }
                }

                if(isset($details) && count($details) > 0) {    
                    (new VariationDetail)->store($details, null, true);
                }
            }
            // detail code end
            \DB::commit();

            $extra = ['redirect' => route('variation.index')];
            $message = __('message.updated', ['attr' => __('variation.variation')]);
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
        (new Variation)->find($id)->delete();
        $message = __('message.deleted', ['attr' => __('variation.variation')]);
        return jsonResponse(true, 201, $message);
    }

    public function toggleStatus($id, $status) {
        $result = (new Variation)->fetch($id);
        if(!$result) {
            $message = __('common.invalid_id', ['attr' => __('variation.variation')]);
            return jsonResponse(false, 207, $message);
        }

        try {
            \DB::beginTransaction();
            $result->update(['status' => $status]);
            \DB::commit();

            $message = __('message.status', ['attr' => __('variation.variation')]);
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

            (new Variation)->toggleStatus($status, $inputs['ids']);
            \DB::commit();

            $message = __('message.status', ['attr' => __('variation.variation')]);
            return jsonResponse(true, 201, $message);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function status($id) {
        $result = (new Variation)->fetch($id);
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

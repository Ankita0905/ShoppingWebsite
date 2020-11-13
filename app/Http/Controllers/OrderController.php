<?php

namespace App\Http\Controllers;

use App\Order;
use App\Category;
use App\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource. 
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortOrder = (new Order)->sortOrder;
        $sortEntity = (new Order)->sortEntity;

        $result = null;
        if($request->ajax()) {
            $sortEntity = $request->sortEntity;
            $sortOrder = $request->sortOrder;

            $result = (new Order)->pagination($request);
            return view('order.pagination', compact('result', 'sortOrder', 'sortEntity'));
        }

        return view('order.index', compact('result', 'sortOrder', 'sortEntity'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = (new Order)->fetch($id);
        if(!$result) {
            dd('problem');
        }
        $detail = (new OrderDetail)->customerOrder($result->id);
        return view('front2.order-mail', compact('result', 'detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = (new Order)->fetch($id);
        if(!$result) {
            abort(404);
        }
        return view('order.edit', compact('result'));
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
        $result = (new Order)->fetch($id);
        if(!$result) {
            $message = __('common.invalid_id', ['attr' => __('order.order')]);
            return jsonResponse(false, 207, $message);
        }

        $inputs = $request->all();
        $validation = (new Order)->validation($inputs, $id);
        if($validation->fails()) {
            return jsonResponse(false, 206, $validation->getMessageBag());
        }

        try {
            \DB::beginTransaction();
            if($inputs['order_status'] == 2) { // confirm order
                // order code start
                $inputs['updated_by'] = authId();
                (new Order)->store($inputs, $id);
                // order code end
                
                // detail code start
                $detail = (new OrderDetail)->customerOrder($result->id);
                // detail code end
                
                
                // send mail code start
                $email = $result->email;
                $subject = 'Fashion waves: Order Confirmed #' . $result->order_number;
                \Mail::send('front2.order-mail', compact('result', 'detail'), function($message) use ($subject, $email){
                    $message->from(env('MAIL_FROM_EMAIL'), env('MAIL_FROM_NAME'));
                    $message->to($email, $email);
                    $message->subject($subject);
                });            
                // send mail code end
            }
            \DB::commit();

            $extra = ['redirect' => route('order.index')];
            $message = 'Order has been confirmed successfully!';
            return jsonResponse(true, 201, $message, $extra);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            return jsonResponse(true, 207, __('message.server_error') . $e->getMessage() . $e->getFile() . $e->getLine());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Category;
use App\Contact;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function welcome(Request $request) 
    {
        $inputs = $request->all();
        $products = (new Product)->latestProduct($inputs);

        $categoryId = isset($inputs['category']) ? $inputs['category'] : null;
        $search = isset($inputs['search']) ? $inputs['search'] : null;
        $products->appends('category', $categoryId);
        $products->appends('search', $search);
        
        return view('front2.welcome', compact('products', 'categoryId'));
    }

    public function contactUs() {
        return view('front2.contact-us');
    }

    public function contactSubmit(Request $request)
    {
        try {
            $inputs = $request->all();
            $validation = validator($inputs, [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'message' => 'required|max:255',
            ]);
            if($validation->fails()) {
                return jsonResponse(false, 206, $validation->getMessageBag());
            }

            (new Contact)->store($inputs);
            \DB::commit();

            $extra['redirect'] = route('front.contact-us');
            return jsonResponse(true, 201, 'Thanks for your feedback', $extra);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function faq() {
        return view('front2.faq');
    }

    public function tac() {
        return view('front2.tac');
    }

    public function detail($productId = null)
    {
        try {
            if(!$productId) { 
                return redirect()->route('front');
            }

            $result = (new Product)->fetch($productId);
            if(!$result) {
                return redirect()->route('front');
            }
            return view('front2.detail', compact('result'));
        }
        catch(\Exception $e) {
            return jsonResponse(false, 207, $e->getMessage());
        }
    }

    public function updateDetail($productId = null)
    {
        try {
            if(!$productId) {
                return redirect()->route('front');
            }

            $result = (new Product)->fetch($productId);
            if(!$result) {
                return redirect()->route('front');
            }

            $c = cart();
            $cart = null;

            if(isset($c[$productId])) {
                $cart = $c[$productId];
            }
            else {
                return redirect()->route('cart');
            }

            return view('front2.update-detail', compact('result', 'cart'));
        }
        catch(\Exception $e) {
            return jsonResponse(false, 207, $e->getMessage());
        }
    }

    public function orderList()
    {
        if(!\Auth::check()) {
            return redirect()->route('front.login');
        }

        $userId = authId();
        $result = (new Order)->customerOrder($userId);
        return view('front2.order-list', compact('result'));
    }

    public function orderDetail($orderId) {
        $userId = authId();
        $result = (new OrderDetail)->customerOrder($orderId);
        return view('front2.order-detail', compact('result'));
    }

    public function orderCancel(Request $request, $id)
    {
        $result = (new Order)->fetch($id);
        if(!$result) {
            $message = __('common.invalid_id', ['attr' => 'Order']);
            return jsonResponse(false, 207, $message);
        }

        if($result->status == 3) {
            return jsonResponse(false, 207, 'Order is already cancelled');
        }

        try {
            \DB::beginTransaction();
            $inputs['order_status'] = 3; // cancel Order
            (new Order)->store($inputs, $id);
            \DB::commit();

            $extra = ['redirect' => route('front.order-list')];
            $message = 'Order cancelled!';
            return jsonResponse(true, 201, $message, $extra);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            return jsonResponse(true, 207, __('message.server_error'));
        }
    }

    public function cart() {
        $cart = cart();
        return view('front2.cart', compact('cart'));
    }

    public function cartAdd(Request $request) 
    {
        try {
            $inputs = $request->all();
            $validation = (new Product)->cartValidation($inputs);
            if($validation->fails()) {
                return jsonResponse(false, 206, $validation->getMessageBag());
            }

            $id = $inputs['id'];
            $result = (new Product)->fetch($id);
            if(!$result) {
                return jsonResponse(false, 207, __('message.invalid_detail'));
            }

            $session = $request->session();
            $cartData = $session->get('cart') ?? [];

            $price = $result->price;
            $total = ($inputs['quantity'] * $price);

            $cartData[$id] = [
                'product_name' => $result->product_name,
                'product_desc' => $result->description,
                'category_name' => $result->category_name,
                
                'price' => $price,
                'total' => $total,
                'quantity' => $inputs['quantity'],
            ];

            $cartData[$id]['price'] = $price;
            $cartData[$id]['total'] = ($inputs['quantity'] * $price);

            $request->session()->put('cart', $cartData);

            $extra['redirect'] = route('front.cart');
            $message = 'Product updated in your cart successfully!';
            return jsonResponse(true, 201, $message, $extra);
        }
        catch(\Exception $e) {
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function cartRemove(Request $request)
    {
        try {
            $inputs = $request->all();
            $validation = validator($inputs, ['id' => 'required|numeric|min:1']);
            if($validation->fails()) {
                return jsonResponse(false, 206, $validation->getMessageBag());
            }

            $id = $inputs['id'];
            $result = (new Product)->fetch($id);
            if(!$result) {
                return jsonResponse(false, 207, __('message.invalid_detail'));
            }

            $session = $request->session();
            $cartData = $session->get('cart') ?? [];
            if(!isset($cartData[$id])) {
                return jsonResponse(false, 207, 'Item not exist');
            }

            unset($cartData[$id]);
            $request->session()->put('cart', $cartData);

            $extra['reload'] = true;
            $message = 'Product remove from cart successfully!';
            return jsonResponse(true, 201, $message, $extra);
        }
        catch(\Exception $e) {
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function register() {
        return view('front2.register');
    }

    public function registerSubmit(Request $request)
    {
        try {
            $inputs = $request->all();
            $validation = validator($inputs, [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:3',
                'confirm_password' => 'required|min:3|same:password',
                'mobile_number' => 'required|digits:10',
                'address' => 'required|max:255'
            ]);
            if($validation->fails()) {
                return jsonResponse(false, 206, $validation->getMessageBag());
            }

            $inputs['password'] = \Hash::make($inputs['password']);
            $inputs['user_type'] = customer();

            \DB::beginTransaction();
            (new User)->store($inputs);
            \DB::commit();
            
            $extra['redirect'] = route('front.login');
            return jsonResponse(true, 201, 'Register successfully', $extra);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            return jsonResponse(false, 207, __('message.server_error') . $e->getMessage());
        }
    }

    public function login() {
        return view('front2.login');
    }

    public function loginSubmit(Request $request)
    {
        try {
            $inputs = $request->all();
            $validation = validator($inputs, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if($validation->fails()) {
                return jsonResponse(false, 206, $validation->getMessageBag());
            }

            $cred = [
                'email' => $inputs['email'],
                'password' => $inputs['password'],
                'user_type' => customer(),
            ];
            if(\Auth::attempt($cred)) {
                $extra['redirect'] = route('front.order');
                return jsonResponse(true, 201, 'Login successfully!', $extra);
            }
            else {
                return jsonResponse(true, 207, 'Invalid details!');
            }
        }
        catch(\Exception $e) {
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function logout()
    {
        try {
            if(\Auth::check()) {
                \Auth::logout ();
            }
            return redirect()->route('front');
        }
        catch(\Exception $e) {
            return jsonResponse(false, 207, __('message.server_error'));
        }
    }

    public function order()
    {
        if(!\Auth::check()) {
            return redirect()->route('front.login');
        }

        $cart = cart();
        if(!$cart) {
            return redirect()->route('front');
        }

        $orderNumber = (new Order)->orderNumber();
        return view('front2.order', compact('cart', 'orderNumber'));
    }

    public function orderSubmit(Request $request)
    {
        try {
            if(!\Auth::check()) {
                return redirect()->route('front.login');
            }
            
            $inputs = $request->all();
            $validation = validator($inputs, [
                'payment_mode' => 'required|numeric|in:1,2',
                'address' => 'required|max:255'
            ]);
            if($validation->fails()) {
                return redirect()->route('front.order')->withErrors($validation);
            }

            $cart = cart();
            if(!$cart) {
                return redirect()->route('front');
            }
            
            \DB::beginTransaction();
            $order = [
                'order_number' => (new Order)->orderNumber(),
                'address' => $inputs['address'],
                'payment_mode' => $inputs['payment_mode'],
                'order_date' => date('Y-m-d'),
                'order_status' => 2,
                'user_id' => authId(),
                'total_item' => cartTotalQty(),
                'total_price' => cartTotal(),
            ];

            $orderId = (new Order)->store($order);
            if($orderId) {
                $orderDetail = [];
                $cart = cart();
                if(isset($cart) && count($cart) > 0) {
                    foreach($cart as $productId => $c) {
                        $orderDetail[] = [
                            'order_id' => $orderId,
                            'product_id' => $productId,
                            'quantity' => $c['quantity'],
                            'price' => $c['price'],
                            'total_price' => $c['total'],                            
                        ];
                    }
                    
                    if(isset($orderDetail) && count($orderDetail) > 0) {
                        (new OrderDetail)->store($orderDetail, null, true);
                    }
                }
            }
            \DB::commit();

            $request->session()->put('cart', []);
            return redirect()->route('front.order-list');
        }
        catch(\Exception $e) {
            \DB::rollBack();
            return jsonResponse(false, 207, __('message.server_error') . $e->getMessage());
        }
    }
}

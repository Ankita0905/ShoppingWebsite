<?php

use App\Category;
use App\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

function isAuth() { return Auth::check(); }
function authId() { return Auth::user()->id; }
function authName() { return ucfirst(Auth::user()->name); }
function authAddress() { return ucfirst(Auth::user()->address); }
function authStatus() { return Auth::user()->status; }
function isAuthActive() { return (Auth::user()->status == 1); }
function isAuthInActive() { return (Auth::user()->status == 2); }
function authType() { return Auth::user()->user_type; }
function authEmail() { return Auth::user()->email; }
function admin() { return 1; }
function customer() { return 2; }

function authDetail() {
    $user = Auth::user();
    return ucfirst($user->name);
}

function dumper(...$args)
{
    echo '<pre>';
    foreach ($args as $x) {
        print_r($x);
        echo "\n\n";
    }
    die(1);
}

function dateFormat($date, $format = 'd-m-Y') { return date($format, strtotime($date)); }
function addDays($date, $days, $format = 'Y-m-d') { 
    return date($format, strtotime($date . ' + ' . $days . ' days'));
}
function addYear($year) {
    return date('Y-m-d', strtotime('+' . $year . ' years'));
}

function pageDetail($pagination)
{
    $from = ((($pagination->currentPage() - 1) * $pagination->perPage()) + 1);
    $to = (($pagination->currentPage()) * $pagination->perPage());
    $total = $pagination->total();
    if ($to > $total) {
        $to = $pagination->total();
    }
    $detail = 'Showing ' . $from . ' to ' . $to . ' of ' . $total . ' entries';
    return $detail;
}

function pageIndex($pagination) { 
    return $from = ((($pagination->currentPage() - 1) * $pagination->perPage()) + 1);
}

function perPage() {
    return [
        10 => 10,
        20 => 20,
        50 => 50,
        100 => 100,
        200 => 200,
        500 => 500,
        1000 => 1000
    ];
}

function defaultPerPage() { return 20; }

function jsonResponse($status, $statusCode, $message, $extra = [])
{
    $response = ['success' => $status, 'status' => $statusCode];
    if ($statusCode == 206) {
        $response['message'] = errorMessages($message);
    } elseif ($statusCode == 207 || $statusCode == 201 || $statusCode == 204) {
        $response['message'] = $message;
    }

    $response['extra'] = $extra;
    return response()->json($response, $statusCode);
}

function errorMessages($errors = [])
{
    $error = [];
    foreach ($errors->toArray() as $key => $value) {
        $error[$key] = $value[0];
    }
    return $error;
}

function status($type = '', $html = true)
{
    $types = [
        '' => '-Select Status-',
        0 => 'Inactive',
        1 => 'Active'
    ];

    if ($type != '') {
        if ($html) {
            if ($type == 1) {
                return '<strong class="text-success">Active</strong>';
            } else {
                return '<strong class="text-danger">In Active</strong>';
            }
        } else {
            return $types[$type];
        }
    }

    return $types;
}

function yesNo($type = null)
{
    $types = [
        0 => 'No',
        1 => 'Yes'
    ];

    if($type != '') {
        return $types[$type];
    }
    return $types;
}

function statusSlider($route, $id, $check) {
    $checked = ($check) ? 'checked="checked"' : '';
    return '<label class="switch">'.
    '<input type="checkbox" class="__status" '.$checked.' data-route="'.route($route, $id).'">'.
    '<span class="slider round"></span>'.
    '</label>';
}

function discountType($type = '')
{
    $types = [
        1 => 'Fix',
        2 => 'Percentage'
    ];

    if ($type != '') {
        return $types[$type];
    }
    return $types;
}

function gender($type = '')
{
    $types = [
        '' => '-Select Gender-',
        1 => 'Male',
        2 => 'Female'
    ];

    if ($type != '') {
        return $types[$type];
    }
    return $types;
}

function srNo($number = 1, $length = 4, $padding = '0') {
    return str_pad($number + 1, $length, $padding, STR_PAD_LEFT);
}

function exportCSV($heading = [], $data = [], $filename = 'export', $delimiter = ',')
{
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv";');

    $f = fopen('php://output', 'w');
    fputcsv($f, $heading, $delimiter);
    foreach ($data as $line) {
        fputcsv($f, $line, $delimiter);
    }
    fclose($f);
    die;
}



function backup()
{
    $dbhost = env('DB_HOST');
    $dbuser = env('DB_USERNAME');
    $dbpass = env('DB_PASSWORD');
    $dbname = env('DB_DATABASE');

    // db connect
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    // file header stuff
    $output = "-- PHP MySQL Dump\n--\n";
    $output .= "-- Host: $dbhost\n";
    $output .= "-- Generated: " . date("r", time()) . "\n";
    $output .= "-- PHP Version: " . phpversion() . "\n\n";
    $output .= "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n\n";
    $output .= "--\n-- Database: `$dbname`\n--\n";
    // get all table names in db and stuff them into an array
    $tables = array();
    $stmt = $pdo->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }
    // process each table in the db
    foreach ($tables as $table) {
        $fields = "";
        $sep2 = "";
        $output .= "\n-- " . str_repeat("-", 60) . "\n\n";
        $output .= "--\n-- Table structure for table `$table`\n--\n\n";
        // get table create info
        $stmt = $pdo->query("SHOW CREATE TABLE $table");
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $output .= $row[1] . ";\n\n";
        // get table data
        $output .= "--\n-- Dumping data for table `$table`\n--\n\n";
        $stmt = $pdo->query("SELECT * FROM $table");
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            // runs once per table - create the INSERT INTO clause
            if ($fields == "") {
                $fields = "INSERT INTO `$table` (";
                $sep = "";
                // grab each field name
                foreach ($row as $col => $val) {
                    $fields .= $sep . "`$col`";
                    $sep = ", ";
                }
                $fields .= ") VALUES";
                $output .= $fields . "\n";
            }
            // grab table data
            $sep = "";
            $output .= $sep2 . "(";
            foreach ($row as $col => $val) {
                if (is_null($val)) {
                    $val = null;
                    $output .= $sep . "null";
                    $sep = ", ";
                } else {
                    // add slashes to field content
                    $val = addslashes($val);
                    // replace stuff that needs replacing
                    $search = array("\'", "\n", "\r");
                    $replace = array("''", "\\n", "\\r");
                    $val = str_replace($search, $replace, $val);
                    $output .= $sep . "'$val'";
                    $sep = ", ";
                }
            }
            // terminate row data
            $output .= ")";
            $sep2 = ",\n";
        }
        // terminate insert data
        $output .= ";\n";
    }
    // output file to browser

    $filename = 'Backup ' . date('d M Y');
    header('Content-Description: File Transfer');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $filename . '.sql');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . strlen($output));
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    header('Pragma: public');
    echo $output;
}

function numberFormat($number) { 
    return number_format((float)$number, 2);
}

function numberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '', trim($num));
    if (!$num) {
        return false;
    }
    $num = (int)$num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int)(($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int)($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int)($num_levels[$i] % 100);
        $singles = '';
        if ($tens < 20) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int)($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . (($levels && ( int )($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words) . ' Only';
}

function sorting($sortEntity, $name, $sortOrder)
{
    return '<a href="javascript:void(0);" data-sortEntity="' . $sortEntity . '" data-sortOrder="' . ($sortOrder == 'desc' ? 'asc' : 'desc') . '">
        ' . $name . ' <i class="fa fa-sort pull-right"></i> </a>';
}

function remarks($text) {
    $string = $text . ', DATE: ' . date('d-M-Y') . ', TIME: ' . date('H:i:s');
    return strtoupper($string);
}

function img($path, $img, $width = '100%', $classes = '', $default = 'default.png')
{
    $image = asset('uploads/' . $default);
    $file = public_path($path . $img);
    if ($img != '' && file_exists($file)) {
        $image = asset($path . $img);
    }
    return '<img src="'.$image.'" alt="'.$image.'" class="img-thumbnail img-fluid img-responsive '. $classes .'" width="'.$width.'" />';
}

function apiImg($path, $image, $default = 'default.png')
{
    $img = $path . $image;
    $file = public_path($img);
    if ($image != '' && file_exists($file)) {
        return asset($img);
    }
    else {
        $path = env('UPLOAD_PATH');
        $img = $path . $default;
        return asset($img);
    }
}

function ipAddress() {
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function uploadImg(Request $request, $column, $path) {
    $uploadFile = null;
    $file = $request->file($column);
    $fileExt = $file->getClientOriginalExtension();
    $filename = str_random(8) . '.' . $fileExt;

    if($file->move($path, $filename)) {
        $uploadFile = $filename;
    }
    return $uploadFile;
}

function removeImg($img, $path) {
    $file = public_path($path . $img);
    if ($img != '' && file_exists($file)) {
        unlink($file);
    }
}

function categories() {
    return (new Category)->categories();
}

function cart() {
    return session()->get('cart') ?? [];
}

function cartCount() {
    $cart = session()->get('cart') ?? [];
    return count($cart);
}

function cartTotalQty() {
    $total = 0;
    $cart = session()->get('cart') ?? [];
    if($cart) {
        $total = array_sum(array_column($cart, 'quantity'));
    }
    return $total;
}

function cartTotal() {
    $total = 0;
    $cart = session()->get('cart') ?? [];
    if($cart) {
        $total = array_sum(array_column($cart, 'total'));
    }
    return $total;
}

function paymentMode($type = '', $heading = false) {
    $types = [
        1 => 'Cash',
        2 => 'Online'
    ];

    if($heading) {
        $types = ['' => '-Select Payment Mode-'] + $types;
    }

    if($type != '') {
        return $types[$type];
    }
    return $types;
}

function orderStatus($type = '', $heading = false) {
    $types = [
        1 => 'Pending',
        2 => 'Confirm',
        3 => 'Cancel'
    ];

    if($heading) {
        $types = ['' => '-Select Status-'] + $types;
    }

    if($type != '') {
        return $types[$type];
    }
    return $types;
}

function frontType($type = '', $heading = false) {
    $types = [
        1 => 'Yes',
        0 => 'No'
    ];

    if($heading) {
        $types = ['' => '-Select Type-'] + $types;
    }

    if($type != '') {
        return $types[$type];
    }
    return $types;
}
<?php

use App\Models\Membership\Consts;

function cleanStr($str)
{
    return trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $str)));
}

function getSU()
{
    return config('constants.su_str');
}

function paymentMethods()
{
    return config('constants.payment_methods');
}

function paymentMethodsKeys()
{
    return config('constants.payment_methods_keys');
}

function allowedDiscountTypes()
{
    return config('constants.allwowed_discount_types');
}

function getRelationsForViews()
{
    return Consts::RELATIONS;
}

function baseURL()
{
    return env("BASE_URL", 'http://127.0.0.1:8000/'); // local url 
}

function calculateST($amount, $st_rate)
{
    $amount = (double) $amount;
    $st_rate = (int) $st_rate;
    // tax = (row_total / 100) * tax_rate;
    return ($amount / 100) * $st_rate;
}

function getTZ()
{
    return 'Asia/Karachi';
}

function sales_tax_rate()
{
    return 16;
}

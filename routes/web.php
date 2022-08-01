<?php

use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/apis.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/membership.php';

Route::get('/', function () {
    return redirect('login');
});

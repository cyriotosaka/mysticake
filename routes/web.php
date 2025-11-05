<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/banktransfer', function () {
    return view('banktransfer');
});

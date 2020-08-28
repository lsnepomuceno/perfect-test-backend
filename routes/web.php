<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::match([Request::METHOD_GET, Request::METHOD_POST], '/', 'Dashboard')->name('dashboard');

Route::resources([
    'product' => 'Product',
    'sale' => 'Sales',
    'customer' => 'Customers'
], ['except' => ['index', 'show']]);

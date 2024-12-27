<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\Admin\AdminOrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/admin/order/remove',[AdminOrderController::class,'OrderRemove'])->name('admin.order.remove');


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

require  __DIR__.'/Users/Users.php';
require  __DIR__.'/Projects/Projects.php';
require __DIR__.'/State/State.php';
require __DIR__.'/Task/Task.php';

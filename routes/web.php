<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('web.pages.home');
});
Route::get('/about', function () {
    return view('web.pages.about');
});
Route::get('/service', function () {
    return view('web.pages.service');
});
Route::get('/project', function () {
    return view('web.pages.project');
});
Route::get('/contact', function () {
    return view('web.pages.contact');
});

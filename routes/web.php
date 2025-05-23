<?php

use Illuminate\Support\Facades\Route;


Route::get('/', App\Livewire\Page\Landing::class)->name('home');
Route::get('/about', App\Livewire\Page\About::class)->name('about');
Route::get('/service', App\Livewire\Page\Service::class)->name('service');
Route::get('/project', App\Livewire\Page\Project::class)->name('project');
Route::get('/contact', App\Livewire\Page\Contact::class)->name('contact');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomFieldController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('contacts.index');
});


// CONTACT ROUTES
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
Route::post('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.delete');

// AJAX FILTER
Route::get('/contacts/filter', [ContactController::class, 'filter'])->name('contacts.filter');


// CUSTOM FIELD ROUTES
Route::get('/custom-fields', [CustomFieldController::class, 'index'])->name('customfields.index');
Route::post('/custom-fields', [CustomFieldController::class, 'store'])->name('customfields.store');
Route::delete('/custom-fields/{id}', [CustomFieldController::class, 'destroy'])->name('customfields.delete');

<?php

use Illuminate\Support\Facades\Route;

Route::view('/tasarim/formlar', 'formcraft.forms')->name('formcraft.preview.forms');
Route::view('/tasarim/kurucu', 'formcraft.builder')->name('formcraft.preview.builder');
Route::view('/tasarim/yeni-form', 'formcraft.form-create')->name('formcraft.preview.form-create');
Route::view('/tasarim/form-ayarlari', 'formcraft.form-edit')->name('formcraft.preview.form-edit');
Route::view('/tasarim/alanlar', 'formcraft.fields')->name('formcraft.preview.fields');
Route::view('/tasarim/yeni-alan', 'formcraft.field-create')->name('formcraft.preview.field-create');
Route::view('/tasarim/yanitlar', 'formcraft.submissions')->name('formcraft.preview.submissions');
Route::view('/tasarim/uyeler', 'formcraft.members')->name('formcraft.preview.members');
Route::view('/tasarim/davet', 'formcraft.invitation')->name('formcraft.preview.invitation');
Route::view('/f/aralik-bulusmasi', 'formcraft.public-form')->name('formcraft.preview.public-form');
Route::view('/f/aralik-bulusmasi/tesekkur', 'formcraft.thanks')->name('formcraft.preview.thanks');

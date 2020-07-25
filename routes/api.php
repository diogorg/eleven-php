<?php
use Illuminate\Support\Facades\Route;

Route::get('booglans/question-1', 'BooglanController@first');
Route::get('booglans/question-2', 'BooglanController@second');
Route::get('booglans/question-3', 'BooglanController@third');
Route::get('booglans/question-4', 'BooglanController@fourth');
Route::get('booglans/question-5', 'BooglanController@fifth');

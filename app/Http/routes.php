<?php

Route::group(array('prefix' => 'api'), function()
{

  Route::get('/', 'ApplicationController@index');

  Route::resource('jobs', 'JobsController');
  Route::resource('companies', 'CompaniesController');

  Route::post('auth/login', 'AuthController@authenticate');
});

Route::get('/', 'ApplicationController@index');

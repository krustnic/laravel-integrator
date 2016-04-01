<?php

Route::get('/integrator/gates'       , "IntegratorController@gates");

Route::group(['middleware' => ['integrator.auth']], function () {
    Route::get('/integrator/api/getToken', "IntegratorController@getToken");
});
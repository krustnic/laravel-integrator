<?php

Route::get('/integrator/test', function() {
    return "Integrator is working!";
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/integrator/gates/{token}', 'Krustnic\Integrator\IntegratorController@gates');
});

Route::group(['middleware' => ['Krustnic\Integrator\IntegratorAuth']], function () {
    Route::post('/integrator/api/getToken', 'Krustnic\Integrator\IntegratorController@getToken');
});
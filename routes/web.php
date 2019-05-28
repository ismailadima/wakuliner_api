<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});


// Banner endpoint
$app->get('/banner','BannerController@index');
$app->get('/banner/{id}','BannerController@show');
$app->post('/banner','BannerController@store');
$app->post('/banner/{id}','BannerController@update');
$app->delete('/banner/{id}','BannerController@destroy');

// Categories endpoint
$app->get('/category','CategoriesController@index');
$app->get('/category/{id}','CategoriesController@show');
$app->post('/category','CategoriesController@store');
$app->put('/category/{id}','CategoriesController@update');
$app->delete('/category/{id}','CategoriesController@destroy');

//Product endpoint
$app->get('/product','ProductController@index');
$app->get('/product/{id}','ProductController@show');
$app->post('/product','ProductController@store');
$app->post('/product/{id}','ProductController@update');
$app->delete('/product/{id}','ProductController@destroy');
$app->get('product/category/{id}','ProductController@categoryFilter'); //filter category
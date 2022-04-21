<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


Route::namespace('Admin')->prefix('dashboard')->group(function (){


    Route::get('/login', 'AuthController@login')->name('admin.login');

    Route::post('/do_login', 'AuthController@do_login')->name('admin.do_login');

    /********************************** Middleware For Admins   ***************************************/
    Route::middleware('admin_auth:admin')->group(function (){

        Route::get('/logout', 'AuthController@logout')->name('admin.logout');
        Route::get('/', 'DashboardController@index')->name('admin.home');



        Route::prefix('users_groups')->group(function (){

            Route::get('/', 'UserGroupController@index')->name('admin.user_group.index');

            Route::get('/edit/{id?}', array( 'uses' => 'UserGroupController@create_or_edit', function($id = null){}))->name('admin.user_group.edit');
            Route::post('/edit/{id?}', array( 'uses' => 'UserGroupController@create_or_edit', function($id = null){}))->name('admin.user_group.edit');

            Route::get('/delete/{id?}', array( 'uses' => 'UserGroupController@delete', function($id = null){}))->name('admin.user_group.delete');

        });

        Route::prefix('users')->group(function (){

            Route::get('/', 'UserController@index')->name('admin.user.index');

            Route::get('/edit/{id?}', array( 'uses' => 'UserController@create_or_edit', function($id = null){}))->name('admin.user.edit');
            Route::post('/edit/{id?}', array( 'uses' => 'UserController@create_or_edit', function($id = null){}))->name('admin.user.edit');

            Route::get('/delete/{id?}', array( 'uses' => 'UserController@delete', function($id = null){}))->name('admin.user.delete');

        });


        Route::prefix('places_types')->group(function (){

            Route::get('/', 'PlaceTypeController@index')->name('admin.place_type.index');

            Route::get('/edit/{id?}', array( 'uses' => 'PlaceTypeController@create_or_edit', function($id = null){}))->name('admin.place_type.edit');
            Route::post('/edit/{id?}', array( 'uses' => 'PlaceTypeController@create_or_edit', function($id = null){}))->name('admin.place_type.edit');

            Route::get('/delete/{id?}', array( 'uses' => 'PlaceTypeController@delete', function($id = null){}))->name('admin.place_type.delete');

        });


        Route::prefix('places')->group(function (){

            Route::get('/', 'PlaceController@index')->name('admin.place.index');

            Route::get('/edit/{id?}', array( 'uses' => 'PlaceController@create_or_edit', function($id = null){}))->name('admin.place.edit');
            Route::post('/edit/{id?}', array( 'uses' => 'PlaceController@create_or_edit', function($id = null){}))->name('admin.place.edit');

            Route::get('/delete/{id?}', array( 'uses' => 'PlaceController@delete', function($id = null){}))->name('admin.place.delete');

        });


        Route::prefix('crafts_types')->group(function (){

            Route::get('/', 'CraftsmanController@index')->name('admin.craft_type.index');

            Route::get('/edit/{id?}', array( 'uses' => 'CraftsmanController@create_or_edit', function($id = null){}))->name('admin.craft_type.edit');
            Route::post('/edit/{id?}', array( 'uses' => 'CraftsmanController@create_or_edit', function($id = null){}))->name('admin.craft_type.edit');

            Route::get('/delete/{id?}', array( 'uses' => 'CraftsmanController@delete', function($id = null){}))->name('admin.craft_type.delete');

        });


        Route::prefix('crafts')->group(function (){

            Route::get('/', 'CraftsmanController@index')->name('admin.craft.index');

            Route::get('/edit/{id?}', array( 'uses' => 'CraftsmanController@create_or_edit', function($id = null){}))->name('admin.craft.edit');
            Route::post('/edit/{id?}', array( 'uses' => 'CraftsmanController@create_or_edit', function($id = null){}))->name('admin.craft.edit');

            Route::get('/delete/{id?}', array( 'uses' => 'CraftsmanController@delete', function($id = null){}))->name('admin.craft.delete');

        });


        Route::prefix('cities')->group(function (){

            Route::get('/', 'CityController@index')->name('admin.city.index');

            Route::get('/edit/{id?}', array( 'uses' => 'CityController@create_or_edit', function($id = null){}))->name('admin.city.edit');
            Route::post('/edit/{id?}', array( 'uses' => 'CityController@create_or_edit', function($id = null){}))->name('admin.city.edit');

            Route::get('/delete/{id?}', array( 'uses' => 'CityController@delete', function($id = null){}))->name('admin.city.delete');

        });



        Route::get('/cats', 'CatController@index')->name('admin.cat.index');

        Route::get('/cats/edit/{id?}', array( 'uses' => 'CatController@create_or_edit', function($id = null){}))->name('admin.cat.edit');

        Route::post('/cats/edit/{id?}', array( 'uses' => 'CatController@create_or_edit', function($id = null){}))->name('admin.cat.edit');

        Route::get('/cats/delete/{id?}', array( 'uses' => 'CatController@delete', function($id = null){}))->name('admin.cat.delete');

    });

});


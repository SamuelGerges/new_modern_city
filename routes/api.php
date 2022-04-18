<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('Api\User')->group(function(){
    // out of middleware
    // TODO:: URL OF USER

    Route::post('store_user','UserController@RegisterUser')->name('StoreUser');
    Route::post('login_user','UserController@LoginUser')->name('LoginUser');


    // i n middleware
    Route::middleware('userToken:api_user')->prefix('auth/')->group(function(){

        Route::prefix('favourite_places_list/')->group(function (){
            Route::post('show_favorite','FavoriteController@ShowFavorite');
            Route::post('add_to_favorite','FavoriteController@AddToFavorite');
            Route::post('delete_from_favorite','FavoriteController@DeleteFromFavorite');
        });


        Route::prefix('places_types/')->group(function (){
            Route::post('show_all_places_types','PlaceTypeController@ShowAllPlacesTypes');
            Route::post('show_places_by_place_type','PlaceTypeController@ShowPlacesByType');
        });

    });
});


Route::group(['namespace' => 'Api\Craftsman'], function(){

    // TODO:: URL OF Craftsman
    Route::post('store_crafts','CraftsmanController@RegisterCraftsman')->name('StoreCraftsman');
    Route::post('login','CraftsmanController@LoginCraftsman')
        ->name('LoginCraftsman');
});

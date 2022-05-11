<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('Api\User')->group(function(){
    // out of middleware
    // TODO:: URL OF USER

    Route::post('store_user','UserController@RegisterUser')->name('StoreUser');


    Route::middleware('userToken:api_user')->group(function (){
        Route::post('edit_user','UserController@EditUser')->name('EditUser');
        Route::post('show_details_of_user','UserController@ShowDetailsOfUser');
        Route::post('upload_image','UserController@UploadImage');

    });
    // i n middleware
    Route::middleware('userToken:api_user')->prefix('auth/')->group(function(){

        Route::prefix('favourite_places_list/')->group(function (){
            Route::post('show_favorite','FavoriteController@ShowFavorite');
            Route::post('add_to_favorite','FavoriteController@AddToFavorite');
            Route::post('delete_from_favorite','FavoriteController@DeleteFromFavorite');
        });

        Route::prefix('places_types/')->group(function (){
            Route::post('show_all_places_types','PlaceTypeController@ShowAllPlacesTypes');
        });

        Route::prefix('places/')->group(function (){
            Route::post('show_places_by_place_type','PlaceController@ShowPlacesByType');
            Route::post('show_details_of_place','PlaceController@ShowDetailsOfPlace');
            Route::post('show_famous_places','PlaceController@ShowFamousPlaces');
            Route::post('show_advertisement','PlaceController@ShowPlacesAds');


        });

        Route::prefix('craftsman_type/')->group(function (){
            Route::post('show_all_crafts_types','CraftsmanTypeController@ShowAllCraftsTypes');
        });

        Route::prefix('craftsman/')->group(function (){
            Route::post('show_crafts_by_craftsman_type','CraftsmanController@ShowCraftsByType');
            Route::post('show_details_of_craftsman','CraftsmanController@ShowDetailsOfCraftsman');

        });

        Route::prefix('rate')->group(function (){
            Route::post('add_rate_place','PlaceController@AddRatePlace');
            Route::post('add_rate_craftsman','CraftsmanController@AddRateCraftsman');
        });

    });
});


Route::namespace('Api\Craftsman')->group(function(){

    // TODO:: URL OF Craftsman
    Route::post('store_crafts','CraftsmanController@RegisterCraftsman')->name('StoreCraftsman');





    Route::middleware('craftsmanToken:api_crafts')->prefix('authenticate/')->group(function (){
        Route::post('edit_craftsman','CraftsmanController@EditCraftsman');
        Route::post('edit_craftsman_status','CraftsmanController@EditStatus');

        Route::post('upload_image','CraftsmanController@UploadImage');


        Route::prefix('places_types/')->group(function (){
            Route::post('show_all_places_types','PlaceTypeController@ShowAllPlacesTypes');
        });

        Route::prefix('places/')->group(function (){
            Route::post('show_places_by_place_type','PlaceController@ShowPlacesByType');
            Route::post('show_details_of_place','PlaceController@ShowDetailsOfPlace');
        });

    });
});


Route::namespace('Api\Auth')->group(function () {
    // TODO :: URL OF LOGIN
    Route::post('login','AuthController@Login');

    // TODO :: URL OF Logout
    Route::post('logout_user','AuthController@LogoutUser')->middleware('guard:api_user');

    // TODO :: URL OF Logout
    Route::post('logout_crafts','AuthController@LogoutCraftsman')->middleware('guard:api_crafts');


});


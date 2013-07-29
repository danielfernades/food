<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    var_dump(ValidationRuleGenerator::getRules());
    $v = ValidationRuleGenerator::getRules();
    var_dump($v);
	// return View::make('hello');
});

Route::resource('data-derivation-codes', 'DataDerivationCodesController');
Route::resource('data-sources', 'DataSourcesController');
Route::resource('data-sources-links', 'DataSourcesLinksController');
Route::resource('food-descriptions', 'FoodDescriptionsController');
Route::resource('food-group-descriptions', 'FoodGroupDescriptionsController');
Route::resource('footnotes', 'FootnotesController');
Route::resource('langual-factor-descriptions', 'LangualFactorDescriptionsController');
Route::resource('langual-factors', 'LangualFactorsController');
Route::resource('nutrient-data', 'NutrientDataController');
Route::resource('nutrient-definitions', 'NutrientDefinitionsController');
Route::resource('source-codes', 'SourceCodesController');
Route::resource('weights', 'WeightsController');


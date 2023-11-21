<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'equipments'], function () use ($router) {
    $router->get('', ['as'=> 'getEquipments','uses'=> 'EquipmentController@index']);
    $router->post('', ['as' => 'createEquipment', 'uses' => 'EquipmentController@store']);
});

$router->group(['prefix' => 'equipments/{equipmentId}'], function () use ($router) {
    $router->get('', ['as' => 'getOneEquipment', 'uses' => 'EquipmentController@show']);
    $router->put('', ['as' => 'updateEquipment', 'uses' => 'EquipmentController@update']);
    $router->delete('', ['as' => 'deleteEquipment', 'uses' => 'EquipmentController@destroy']);
});

$router->group(['prefix' => 'equipments/{equipmentId}/maintenances'], function () use ($router) {
    $router->get('', ['as' => 'getMaintenances', 'uses' => 'MaintenanceController@index']);
    $router->post('', ['as' => 'createMaintenance', 'uses' => 'MaintenanceController@store']);
});

$router->group(['prefix' => 'equipments/{equipmentId}/maintenances/{maintenanceId}'], function () use ($router) {
    $router->get('', ['as' => 'getOneMaintenance', 'uses' => 'MaintenanceController@show']);
    $router->put('', ['as' => 'updateMaintenance', 'uses' => 'MaintenanceController@update']);
    $router->delete('', ['as' => 'deleteMaintenance', 'uses' => 'MaintenanceController@destroy']);
});

$router->group(['prefix' => 'equipments/{equipmentId}/sensors'], function () use ($router) {
    $router->get('', ['as' => 'getSensors', 'uses' => 'SensorController@index']);
    $router->post('', ['as' => 'createSensor', 'uses' => 'SensorController@store']);
});

$router->group(['prefix' => 'equipments/{equipmentId}/sensors/{sensorId}'], function () use ($router) {
    $router->get('', ['as' => 'getOneSensor', 'uses' => 'SensorController@show']);
    $router->post('', ['as'=> 'createSensorData', 'uses'=> 'SensorController@storeData']);
    $router->put('', ['as' => 'updateSensor', 'uses' => 'SensorController@update']);
    $router->delete('', ['as' => 'deleteSensor', 'uses' => 'SensorController@destroy']);
});
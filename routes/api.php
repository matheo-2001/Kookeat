<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::name('api.')
    ->group(function () {
        $panels = Filament::getPanels();

        foreach ($panels as $key => $panel) {
            try {

                Route::prefix($panel->getId())
                    ->name($panel->getId() . '.')
                    ->group(function () use ($panel) {
                        $resources = $panel->getResources();

                        foreach ($resources as $key => $resource) {
                            try {
                                $resourceName = str($resource)->beforeLast('Resource')->explode('\\')->last();

                                $apiServiceClass = $resource . '\\Api\\' . $resourceName . 'ApiService';

                                app($apiServiceClass)->registerRoutes();
                            } catch (Exception $e) {
                            }
                        }
                    });

            } catch (Exception $e) {
                dd($e);
            }
        }
    });

<?php

use Illuminate\Support\Facades\Route;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleServiceAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleServiceActionServiceCaller;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\AutorunServiceAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\NoAutorunServiceAction;

Route::get('/simple-action', SimpleAction::class);
Route::post('/simple-service-action', SimpleServiceAction::class);
Route::post('/simple-service-action-service-caller', SimpleServiceActionServiceCaller::class);
Route::post('/autorun-service-action', AutorunServiceAction::class);
Route::post('/no-autorun-service-action', NoAutorunServiceAction::class);

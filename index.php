<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once "autoload.php";

use App\Controllers\PageController;
use App\Controllers\UserController;
use chrisvanlier2005\Router as Route;
Route::get('/', [PageController::class, "index"]);
Route::prefix('/users', function () {
    Route::get('/', [UserController::class, "index"]);
});
Route::get('/{id}', [PageController::class, "show"]);


Route::notFound(function(){
    echo "404";
});
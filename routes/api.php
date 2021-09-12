<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategorieDepController;
use App\Http\Controllers\API\CategorieRevController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DepenseController;
use App\Http\Controllers\API\RevenuController;
use App\Http\Controllers\API\SousCategorieDepController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('categorie_deps', CategorieDepController::class);
    Route::resource('sous_categorie_deps', SousCategorieDepController::class);
    Route::resource('categorie_revs', CategorieRevController::class);
    Route::resource('depenses', DepenseController::class);
    Route::resource('revenus', RevenuController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('dashboard', [DashboardController::class, 'user']);
    Route::get('get_sous_cat_by_cat/{id}', [SousCategorieDepController::class, 'getSousCatByCat']);
    Route::get('montant_total', [DepenseController::class, 'montantTotal']);
    Route::get('chart_day', [DepenseController::class, 'chart']);
    Route::get('chart_month', [DepenseController::class, 'chartMois']);
    Route::get('chart_pie', [DepenseController::class, 'chartPie']);
    Route::get('solde_restant', [DepenseController::class, 'montantReste']);
    Route::get('montant_total_rev', [RevenuController::class, 'montantTotal']);
    Route::get('chart_month_rev', [RevenuController::class, 'chartMois']);
    Route::get('chart_pie_rev', [RevenuController::class, 'chartPie']);
    Route::get('chart_pie_dash', [DashboardController::class, 'chartPie']);
});

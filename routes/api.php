<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CashCountController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OutflowController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Public
Route::post('/auth/login', [AuthController::class, 'login']);

// Signed public links
Route::get('/reports/pdf-public', [ReportController::class, 'pdfPublic']);
Route::get('/reports/xlsx-public', [ReportController::class, 'xlsxPublic']);
Route::get('/reports/cash-public', [ReportController::class, 'cashPdfPublic']);

// Authenticated
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Plans - all authenticated users can see active plans
    Route::get('/plans/active', [PlanController::class, 'active']);

    // Admin only - Plan CRUD, User CRUD, Sale editing
    Route::middleware('admin')->group(function () {
        Route::get('/plans', [PlanController::class, 'index']);
        Route::post('/plans', [PlanController::class, 'store']);
        Route::put('/plans/{plan}', [PlanController::class, 'update']);

        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{user}', [UserController::class, 'update']);

        Route::put('/sales/{sale}', [SaleController::class, 'update']);
    });

    // Sales
    Route::get('/sales', [SaleController::class, 'index']);
    Route::post('/sales', [SaleController::class, 'store']);

    // Customers
    Route::get('/customers', [CustomerController::class, 'index']);

    // Cash count
    Route::get('/cash-count', [CashCountController::class, 'show']);
    Route::post('/cash-count', [CashCountController::class, 'store']);

    // Outflows
    Route::post('/cash-count/outflows', [OutflowController::class, 'store']);
    Route::delete('/cash-count/outflows/{outflow}', [OutflowController::class, 'destroy']);

    // Reports (authenticated)
    Route::get('/reports/pdf', [ReportController::class, 'pdf']);
    Route::get('/reports/xlsx', [ReportController::class, 'xlsx']);
    Route::get('/reports/pdf-link', [ReportController::class, 'pdfLink']);
    Route::get('/reports/xlsx-link', [ReportController::class, 'xlsxLink']);
    Route::get('/cash-count/pdf', [ReportController::class, 'cashPdf']);
    Route::get('/cash-count/pdf-link', [ReportController::class, 'cashPdfLink']);
});

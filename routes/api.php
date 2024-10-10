<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {

Route::get('/total-balance', [TransactionController::class, 'getTotalBalance']);
Route::get('/total-income', [TransactionController::class, 'getTotalIncome']);
Route::get('/total-expenses', [TransactionController::class, 'getTotalExpenses']);
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy'); 
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');
Route::get('/transactions', [TransactionController::class, 'index']); 
Route::get('/transactions/{id}', [TransactionController::class, 'show']); 
Route::post('/transactions', [TransactionController::class, 'store']); 
Route::put('/transactions/{id}', [TransactionController::class, 'update']);
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']); 

});

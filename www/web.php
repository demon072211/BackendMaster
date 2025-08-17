<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MailMarketingController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/hook', [LoginController::class, 'hook'])->name('hook');
Route::post('/hook-dev', [LoginController::class, 'hookDev'])->name('hookDev');
Route::post('/hook-pro', [LoginController::class, 'hookPro'])->name('hookPro');
Route::get('/deposit', [LoginController::class, 'getDeposit'])->name('getDeposit');
Route::middleware(['auth', 'locale'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/users', [UserController::class, 'getList'])->name('users');
    Route::get('/daily-report', [DailyReportController::class, 'index'])->name('daily-report');
    Route::get('/income', [IncomeController::class, 'index'])->name('income');
    Route::get('/game/{type}', [GameController::class, 'index'])->name('game'); // Mini game
    Route::get('/agent', [AgentController::class, 'index'])->name('agent');
    Route::get('/agent/create', [AgentController::class, 'create'])->name('agent-create');
    Route::post('/agent/store', [AgentController::class, 'store'])->name('agent-store');
    Route::get('/bank', [BankController::class, 'index'])->name('banks');
    Route::get('/bank/create', [BankController::class, 'create'])->name('bank-create');
    Route::get('/bank/edit/{id}', [BankController::class, 'edit'])->name('bank-edit');
    Route::post('/bank/store', [BankController::class, 'store'])->name('bank-store');
    Route::post('/bank/update/{id}', [BankController::class, 'update'])->name('bank-update');
    Route::post('/bank/delete', [BankController::class, 'delete'])->name('bank-delete');

    Route::get('/transaction', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction-create');
    Route::post('/transaction/reject', [TransactionController::class, 'reject'])->name('transaction-reject');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction-store');

    Route::post('/set/locale', [HomeController::class, 'locale'])->name('set-locale');

    Route::get('/topup/deposit', [DepositController::class, 'index'])->name('deposit');
    Route::post('/topup/deposit-reject', [DepositController::class, 'depositReject'])->name('deposit-reject');
    Route::post('/topup/deposit-approve', [DepositController::class, 'depositApprove'])->name('deposit-approve');
    Route::get('/topup/withdraw', [DepositController::class, 'withdrawList'])->name('withdraw');
    Route::post('/topup/withdraw-reject', [DepositController::class, 'withdrawReject'])->name('withdraw-reject');
    Route::post('/topup/withdraw-approve', [DepositController::class, 'withdrawApprove'])->name('withdraw-approve');

    Route::get('/changePass', [LoginController::class, 'changePass'])->name('change-pass');
    Route::post('/changePassword', [LoginController::class, 'changePassWord'])->name('change-password');

    Route::get('/info', [UserController::class, 'index'])->name('info');
    Route::post('/userInfo', [UserController::class, 'userInfo'])->name('user-info');

    Route::get('/topup/user', [DepositController::class, 'topUpUser'])->name('topup-user');
    Route::post('/topup/user', [DepositController::class, 'storeTopUpUser'])->name('store-topUp-user');
});


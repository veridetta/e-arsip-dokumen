<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GeneralDocumentController;
use App\Http\Controllers\Admin\PrivateDocumentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PrivateDocumentController as UserPrivateDocumentController;
use App\Http\Controllers\User\RequestController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//generate password
Route::get('/generate-password', function () {
    return Hash::make('password');
});

Route::get('/dashboard', function () {
    //alihkan sesuai role
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'user') {
        return redirect()->route('user.dashboard');
    }else{
        return redirect()->route('login');
    }
})->middleware(['auth'])->name('dashboard');

Route::get('/profile', [Controller::class, 'profile'])->middleware(['auth'])->name('profile');

Route::post('/profile/{id}', [Controller::class, 'updateProfile'])->middleware(['auth'])->name('updateProfile');

Route::get('/checkRole', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'user') {
        return redirect()->route('user.dashboard');
    }else{
        return redirect()->route('login');
    }
})->name('checkRole');

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('guest.home');
    })->name('home');
    Route::get('explorer', [Controller::class, 'explore'])->name('guest.explore');
    Route::get('explorer/filter', [Controller::class, 'explore_filter'])->name('guest.explore.filter');
    Route::get('/explorer/document/{id}', [Controller::class, 'document'])->name('guest.explore.document');

});

Route::middleware('checkRole:admin')->group(function () {
    //dashboard dari dashboard controller
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('admin')->name('admin.')->group(function () {
        //users
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        //general categories
        Route::resource('general-categories', \App\Http\Controllers\Admin\GeneralCategoryController::class);
        //general documents
        Route::resource('general-documents', \App\Http\Controllers\Admin\GeneralDocumentController::class);
        //preview document
        Route::get('general-documents/preview/{id}', [GeneralDocumentController::class, 'preview'])->name('general-documents.preview');
        //private documents
        Route::resource('private-documents', \App\Http\Controllers\Admin\PrivateDocumentController::class);
        //share
        Route::post('private-documents/shares/{document_id}', [PrivateDocumentController::class, 'share'])->name('private-documents.share');
        //preview document
        Route::get('private-documents/preview/{id}', [PrivateDocumentController::class, 'preview'])->name('private-documents.preview');
        //requests
        Route::resource('requests', \App\Http\Controllers\Admin\RequestController::class);
        //reply
        Route::post('requests/reply/{id}', [App\Http\Controllers\Admin\RequestController::class, 'reply'])->name('requests.reply');
        //reject
        Route::post('requests/reject/{id}', [App\Http\Controllers\Admin\RequestController::class, 'reject'])->name('requests.reject');
        //clients
        Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class);
        //preview client
        Route::get('clients/preview/{id}', [App\Http\Controllers\Admin\ClientController::class, 'preview'])->name('clients.preview');
        //get requests
        Route::resource('get-requests', \App\Http\Controllers\Admin\GetRequestController::class);
        //preview document
        Route::get('get-requests/preview/{id}', [App\Http\Controllers\Admin\GetRequestController::class, 'preview'])->name('get-requests.preview');
    });

});
Route::middleware('checkRole:user')->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    //filter
    Route::get('/user/dashboard/filter', [UserDashboardController::class, 'filter'])->name('user.dashboard.filter');
    //document
    Route::get('/user/general/document/{id}', [UserDashboardController::class, 'document'])->name('user.general.document');
    //masukkan ke dalam group route prefix admin
    Route::prefix('user')->name('user.')->group(function () {
        Route::resource('private-documents', UserPrivateDocumentController::class);
        //preview document
        Route::get('private-documents/preview/{id}', [UserPrivateDocumentController::class, 'preview'])->name('private-documents.preview');
        Route::get('general', [UserDashboardController::class, 'general'])->name('general');
        //get requests
        Route::resource('get-requests', \App\Http\Controllers\User\GetRequestController::class);
        //preview document
        Route::get('get-requests/preview/{id}', [App\Http\Controllers\User\GetRequestController::class, 'preview'])->name('get-requests.preview');
        //requests
        Route::resource('requests', RequestController::class);
        //reply
        Route::post('requests/reply/{id}', [RequestController::class, 'reply'])->name('requests.reply');
        //reject
        Route::post('requests/reject/{id}', [RequestController::class, 'reject'])->name('requests.reject');
    });

});


//read-notif
Route::get('/read-notif/{id}/{to}/{role}', function ($id, $to, $role) {
    $notif = \App\Models\Notification::find($id);
    $notif->is_read = 1;
    $notif->save();
    if($to == auth()->user()->id){
        //jika autho roel adalah user
        if($role == 'user'){
            $url = route('user.get-requests.index');
        }else{
            $url = route('admin.requests.index');
        }
    }else{
        if($role == 'user'){
            $url = route('user.requests.index');
        }else{
            $url = route('admin.request.index');
        }
    }
    return redirect($url);
})->name('read-notif');

//buat akun kasir, manager dan owner
Route::get('/buat', function () {
    //fungsi insert bulk kasir, manager, dan owner
    $data = [
        [
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user1234'),
            'role' => 'user',
        ],
        [
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('user1234'),
            'role' => 'user',
        ],
        [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]
    ];
    //insert bulk menggunakan eloquent
    \App\Models\User::insert($data);
    return 'berhasil';

})->name('buat');

//route php artisan storage:link
Route::get('/link', function () {
    //delete folder public/storage
    \Illuminate\Support\Facades\File::deleteDirectory(public_path('storage'));
    Artisan::call('storage:link');
    return 'berhasil';
})->name('link');

require __DIR__ . '/auth.php';

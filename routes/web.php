<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeavetypeController;
use App\Http\Controllers\Admin\ApplyleaveController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\KategoriDokumenController;

Route::get('/api/hitung-hari-kerja', function (\Illuminate\Http\Request $request) {
    $from = $request->query('from');
    $to = $request->query('to');

    if ($from && $to) {
        $jumlah = \App\Helpers\DateHelper::getWorkdays($from, $to);
        return response()->json(['jumlah' => $jumlah]);
    }

    return response()->json(['jumlah' => 0]);
});


// Apply Leave on Frontend
Route::get('add/applyleave', [ApplyleaveController::class, 'create']);
Route::post('add/applyleave', [ApplyleaveController::class, 'store']);
Route::get('show/applyleave', [ApplyleaveController::class, 'show']);
Route::get('edit/applyleave/{id}', [ApplyleaveController::class, '_edit']);
Route::put('update/applyleave/{id}', [ApplyleaveController::class, '_update']);
Route::get('edit/applyleave/{id}', [ApplyleaveController::class, '_edit']);
Route::put('update/applyleave/{id}', [ApplyleaveController::class, '_update']);

Route::get('showho/applyleave', [ApplyleaveController::class, 'showho']);
Route::post('applyleave/accept/{id}', [ApplyleaveController::class, 'accept']);
Route::post('applyleave/reject/{id}', [ApplyleaveController::class, 'reject']);


Route::get('show/dokumen', [DokumenController::class, 'show']);
Route::get('/dashboard', [DashboardController::class, 'dashemployee']);

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/home', [HomeController::class, 'home'])->name('home');


// Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
//  Route::get('/register', [RegisterController::class, 'create'])->name('auth.register');
//  Route::post('/register', [RegisterController::class, 'store'])->name('register');

// routes/web.php
Route::get('/profile', [UserController::class, 'show'])->name('profile');
Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

Route::prefix('adminiso')->middleware(['auth', 'role:5'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'dashiso'])->name('adminiso/dashboard');
  Route::get('dokumen', [DokumenController::class, 'index']);
  Route::get('add/dokumen', [DokumenController::class, 'create']);
  Route::post('store/dokumen', [DokumenController::class, 'store']);
  Route::get('edit/dokumen/{id}', [DokumenController::class, 'edit']);
  Route::put('update/dokumen/{id}', [DokumenController::class, 'update']);
  Route::delete('delete/dokumen/{id}', [DokumenController::class, 'delete']);

  Route::get('kategori', [KategoriDokumenController::class, 'index']);
  Route::get('add/kategori', [KategoriDokumenController::class, 'create']);
  Route::post('store/kategori', [KategoriDokumenController::class, 'store']);
  Route::get('edit/kategori/{id}', [KategoriDokumenController::class, 'edit']);
  Route::put('update/kategori/{id}', [KategoriDokumenController::class, 'update']);
  Route::delete('delete/kategori/{id}', [KategoriDokumenController::class, 'delete']);
});

//Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () { 
Route::prefix('admin')->middleware(['auth', 'role:1'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin/dashboard');
  Route::get('category', [CategoryController::class, 'index']);
  Route::get('add/category', [CategoryController::class, 'create']);
  Route::post('add_category', [CategoryController::class, 'store']);
  Route::get('edit_category/{category_id}', [CategoryController::class, 'edit']);
  Route::put('update_category/{category_id}', [CategoryController::class, 'update']);
  Route::delete('delete_category/{category_id}', [CategoryController::class, 'delete']);

  // Leavetype inside admin panel
  Route::get('leavetype', [LeavetypeController::class, 'index']);
  Route::get('add/leavetype', [LeavetypeController::class, 'create']);
  Route::post('add/leavetype', [LeavetypeController::class, 'store']);
  Route::get('edit/leavetype/{id}', [LeavetypeController::class, 'edit']);
  Route::put('update/leavetype/{id}', [LeavetypeController::class, 'update']);
  Route::delete('delete/leavetype/{id}', [LeavetypeController::class, 'delete']);

  //users inside admin panel
  Route::get('users', [UserController::class, 'index']);
  Route::get('add/user', [UserController::class, 'create']);
  Route::post('add/user', [UserController::class, 'store']);
  Route::get('user/{user_id}/edit', [UserController::class, 'edit']);
  Route::put('update_user/{user_id}', [UserController::class, 'update']);
  Route::delete('delete/user/{user_id}',[UserController::class,'destroy']);

  // Leave Types Routes
  Route::get('applyleave', [ApplyleaveController::class, 'index']);
  Route::get('add/applyleave', [ApplyleaveController::class, '_create']);// contructed create for admin
  Route::post('add/applyleave', [ApplyleaveController::class, 'register']);// store in admin contsructed
  Route::get('edit/applyleave/{id}', [ApplyleaveController::class, 'edit']);
  Route::put('update/applyleave/{id}', [ApplyleaveController::class, 'update']);
  Route::delete('delete/applyleave/{id}', [ApplyleaveController::class, 'delete']);

  // Department Routes inside admin
  Route::get('departments', [DepartmentController::class, 'index']);
  Route::get('add/department', [DepartmentController::class, 'create']);
  Route::post('store/department', [DepartmentController::class, 'store']);
  Route::get('edit/department/{id}', [DepartmentController::class, 'edit']);
  Route::put('update/department/{id}', [DepartmentController::class, 'update']);
  Route::delete('delete/department/{id}', [DepartmentController::class, 'delete']);

  Route::get('dokumen', [DokumenController::class, 'indexadmin']);
  Route::get('add/dokumen', [DokumenController::class, 'createadmin']);
  Route::post('store/dokumen', [DokumenController::class, 'storeadmin']);
  Route::get('edit/dokumen/{id}', [DokumenController::class, 'editadmin']);
  Route::put('update/dokumen/{id}', [DokumenController::class, 'updateadmin']);
  Route::delete('delete/dokumen/{id}', [DokumenController::class, 'deleteadmin']);

  Route::get('kategori', [KategoriDokumenController::class, 'indexadmin']);
  Route::get('add/kategori', [KategoriDokumenController::class, 'createadmin']);
  Route::post('store/kategori', [KategoriDokumenController::class, 'storeadmin']);
  Route::get('edit/kategori/{id}', [KategoriDokumenController::class, 'editadmin']);
  Route::put('update/kategori/{id}', [KategoriDokumenController::class, 'updateadmin']);
  Route::delete('delete/kategori/{id}', [KategoriDokumenController::class, 'deleteadmin']);
});

Route::prefix('manager')->middleware(['auth', 'role:2'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'dashmanager'])->name('manager/dashboard');

  // Leavetype inside admin panel
  Route::get('leavetype', [LeavetypeController::class, 'indexmanager']);
  Route::get('add/leavetype', [LeavetypeController::class, 'createmanager']);
  Route::post('add/leavetype', [LeavetypeController::class, 'storemanager']);
  Route::get('edit/leavetype/{id}', [LeavetypeController::class, 'editmanager']);
  Route::put('update/leavetype/{id}', [LeavetypeController::class, 'updatemanager']);
  Route::delete('delete/leavetype/{id}', [LeavetypeController::class, 'deletemanager']);

  //users inside admin panel
  Route::get('users', [UserController::class, 'indexmanager']);
  Route::get('add/user', [UserController::class, 'createmanager']);
  Route::post('add/user', [UserController::class, 'storemanager']);
  Route::get('user/{user_id}/edit', [UserController::class, 'editmanager']);
  Route::put('update_user/{user_id}', [UserController::class, 'updatemanager']);
  Route::delete('delete/user/{user_id}',[UserController::class,'destroymanager']);

  // Leave Types Routes
  Route::get('applyleave', [ApplyleaveController::class, 'indexmanager']);
  Route::get('applyleaveself', [ApplyleaveController::class, 'indexmanagerself']);
  Route::get('add/applyleave', [ApplyleaveController::class, '_createmanager']);// contructed create for manager
  Route::post('add/applyleave', [ApplyleaveController::class, 'registermanager']);// store in manager contsructed
  Route::get('edit/applyleave/{id}', [ApplyleaveController::class, 'editmanager']);
  Route::put('update/applyleave/{id}', [ApplyleaveController::class, 'updatemanager']);
  Route::delete('delete/applyleave/{id}', [ApplyleaveController::class, 'deletemanager']);

});






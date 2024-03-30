<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;

// function แก้ไข

Route::get('/edit-user/{id}', [Usercontroller::class, 'editUser'])->name('edit.user');
Route::put('/update-user/{id}', [Usercontroller::class, 'updateUser'])->name('update.user');

Route::get('/edit-user', function () {
return view('editpage');
});
// function ลบ

Route::delete('/delete-user/{id}', [App\Http\Controllers\Usercontroller::class, 'deleteUser'])->name('delete.user');

// function เพิ่ม

Route::get('/add-user', [App\Http\Controllers\Usercontroller::class, 'showAddPage']);

Route::post('/add-user', [App\Http\Controllers\Usercontroller::class, 'addUser'])->name('add.user');

Route::get('/add-user', function () {
    $titles = App\Models\Title::all();
    return view('addpage', compact('titles'));
});
// หน้าหลัก
Route::get('/', [Usercontroller::class, 'index'])->name('home');

// Route::get('/f', function () {
//     return view('homepage');
// });





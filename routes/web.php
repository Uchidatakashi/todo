<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TaskController;

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
URL::forceScheme('https');

Route::get('/folders/{id}/tasks', [TaskController::class, 'index'])
    -> name('tasks.index');

Route::get('/folders/create',  [FolderController::class, 'showCreateForm'])
    ->name('folders.create');
Route::post('/folders/create', [FolderController::class, 'create']);

Route::get('/folders/{id}/tasks/create',  [TaskController::class, 'showCreateForm'])
    ->name('tasks.create');
Route::post('/folders/{id}/tasks/create', [TaskController::class, 'create']);


// ---- 2023.02.26 r-nakayama delete 昨日を追加 -----
// 参照：https://codelikes.com/laravel-tutorial-todo-delete/
//       途中の解説もしっかり読もう。
// 個別削除
Route::get('/folders/{id}/tasks/{delete_task_id}/delete', [TaskController::class, 'delete']);
//    ->name('task.delete');
//---- ここまで追加----

// 一括削除
Route::POST('/folders/{id}/tasks/delete', [TaskController::class, 'someDelete']) // 要修正
    ->name('task.destroy');
    
// 編集機能の作成 todoアプリ09フォルダー
Route::get('/folders/{id}/tasks/{task_id}/edit', [TaskController::class, 'showEditForm'])
    ->name('tasks.edit');
Route::post('/folders/{id}/tasks/{task_id}/edit', [TaskController::class, 'edit']);

// 項目昇順・降順をきめるtasks.editもの
// Route::get('/folders/{id}/tasks/{task_id}/edit',  [TaskController::class, 'taskSortForm'])
//     ->name('tasks.index');
// Route::post('/folders/{id}/tasks/{task_id}/edit', [TaskController::class, 'index']);    
Route::get('/folders/{id}/tasks/sort',  [TaskController::class, 'sort']) 
    ->name('task.sort');
    // タイトルでソートの場合sort2とする
Route::get('/folders/{id}/tasks/sort2',  [TaskController::class, 'sort2']) 
    ->name('task.sort2');    
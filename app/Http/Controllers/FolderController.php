<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFolder; // ★追加
use App\Models\Folder;  
// use Illuminate\Http\Request; // ★削除

class CollectionController extends Controller
   Collection::macro('toUpper', function () {
    return $this->map(function ($value) {
        return Str::upper($value);
    });
});

$collection = collect(['first', 'second']);

$upper = $collection->toUpper();

// {
//     public function showCreateForm()
//     {
//         return view('folders/create');
//     }
    
//     public function create(CreateFolder $request) // ★引数の型を Request → CreateFolderへ変更
//     {
//         // フォルダモデルのインスタンスを作成する
//         $folder = new Folder();
//         // タイトルに入力値を代入する
//         $folder->title = $request->title;
//         // インスタンスの状態をデータベースに書き込む
//         $folder->save();

//         return redirect()->route('tasks.index', [
//             'id' => $folder->id,
//         ]);
//     }
// }

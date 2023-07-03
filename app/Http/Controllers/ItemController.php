<?php

namespace App\Http\Controllers;

// use App\Http\Requests\CreateTask; //★追加
// use App\Http\Requests\EditTask; //編集用のついか
use App\Models\Folder;
use App\Models\Task;
use Illuminate\Http\Request;
use Log;

class ItemController extends Controller
{     
    public function index(Request $request) { $sort = $request->query('sort', 'asc'); 
    // / ソートパラメータを取得し、デフォルト値を指定 
    $items = Item::orderBy('name', $sort)->get(); return view('items.index', compact('items', 'sort')); } 
}
   
<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTask; //★追加
use App\Http\Requests\EditTask; //編集用のついか
use App\Models\Folder;
use App\Models\Task;
use Illuminate\Http\Request;
use Log;

class TaskController extends Controller
{
    
    public function index(int $id)
    {
        //return "Hello world";
        $folders = Folder::all();
        
        //return view('tasks/index', ['folders' => $folders,]);
        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);
        
        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = Task::where('folder_id', $current_folder->id)->get();

        return view(
            'tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
            'sort'=> 'asc',
            ]
        );
    }
    
    public function sort(int $id, Request $request)
    {
        //return "Hello world";
        $folders = Folder::all();
        
        //return view('tasks/index', ['folders' => $folders,]);
        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);
        
        $sort = $request->query('sort', 'asc'); 
         
        $tasks = Task::where('folder_id', $current_folder->id)->orderBy('due_date', $sort)->get(); 
        
        // タイトルでソートの場合sort2とする
        $tasks = Task::where('folder_id', $current_folder->id)->orderBy('title', $sort2)->get(); 
        
        
        // 選ばれたフォルダに紐づくタスクを取得する
        // $tasks = Task::where('folder_id', $current_folder->id)->get();

        return view(
            'tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
            'sort'=> $sort,
            // タイトルでソートの場合sort2とする
            'sort2'=> $sort2,
            
            ]
        );
    }
    
    /**
     * GET /folders/{id}/tasks/create
     */
    public function showCreateForm(int $id)
    {
        return view(
            'tasks/create', [
            'folder_id' => $id
            ]
        );
    }
    
    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route(
            'tasks.index', [
            'id' => $current_folder->id,
            ]
        );
    }
    
    //編集フォームの作成
    public function showEditForm(int $id, int $task_id)
    {
    $task = Task::find($task_id);

    return view('tasks/edit', [
        'task' => $task,
    ]);
    }


    public function edit(int $id, int $task_id, EditTask $request)
    {
        // 1
     $task = Task::find($task_id);

        // 2
     $task->title = $request->title;
     $task->status = $request->status;
     $task->due_date = $request->due_date;
     $task->save();

        // 3
     return redirect()->route(
        'tasks.index', [
        'id' => $task->folder_id,
            ]
        );
    }

    // ---- 2023.02.26 r-nakayama delete 昨日を追加 -----
    // 参照：https://qiita.com/kamome_susume/items/8fd0c775fc87b86d9068
    //       途中の解説もしっかり読もう。
    public function delete(Request $request) {
        Log::debug("[info]start delete");
        
        //delete_task_id を取得する
        $delete_task_id = $request->delete_task_id;
        //Log::debug("debug1--delete task id: " . $delete_task_id);
        
        //$task = Task::find($delete_task_id);
        //LogController::console_log("[info]$task");
        //LogController::console_log("[debug]delete_task_id: $delete_task_id");
        
        // -- debug

        
        //Taskクラスのfindメソッドをつかって、 delete_task_idをdelete()させる
        //Task::find($delete_task_id)->delete();

        /* 同様に処理 */
        // Booksテーブルから指定のIDのレコード1件を取得
        $task = Task::find($delete_task_id);
        // // レコードを削除
        $task->delete();
        
        //LogController::console_log("[info]end delete");

        //削除したら、表示していたフォルダにリダイレクトする
        return redirect()->route(
            'tasks.index', [
            'id' => $task->folder_id,
            ]
        );
    }
    // ---- ここまで追加 ----

    public function someDelete(int $id, Request $request)
    {
         //チェックボックスでチェックしたidを取得 修正前
    //   $delete = array($request->input('delete_task'));
      
         //チェックボックスでチェックしたidを取得 
      $delete = $request->input('delete_task');
    
      // debug ---
      
      Log::info("delete: ".var_dump($delete));
      //var_dump($delete);
      return redirect()->route(
        'tasks.index', ['id' => $id,]
        );
        // --- debug
      
    //   //チェックしたidで1件ずつ削除する
    //   for($i=0; $i<count($delete); $i++){

    //      // Booksテーブルから指定のIDのレコード1件を取得
    //     $task = Task::find($delete[$i]);
    //     // レコードを削除
    //     $task->delete();
          
    //   }
        if ($request->has('delete_task')) {
            //チェックしたidで1件ずつ削除する
            foreach ($request->delete_task as $taskid) {
                LogController::console_log("[debug] delete taskId: " .$taskid);
                Log::info("delete/taskId: " .$taskid);
                // // Booksテーブルから指定のIDのレコード1件を取得
                $task = Task::find($taskid);
                // // レコードを削除
                $task->delete();
            }
            unset($taskid); // 最後の要素への参照を解除します
        }
      
      //echo "In someDelete function. Request= $request->input('task')" ;
        
        
        
     return redirect()->route(
        'tasks.index', [
        'id' => $task->folder_id,
            ]
        );
    }
    
    //  個別削除
    public function destroy($id)
    {
        // Booksテーブルから指定のIDのレコード1件を取得
        $task = Task::find($id);
        // レコードを削除
        $task->delete();
        // 削除したら一覧画面にリダイレクト
        return redirect()->route('tasks.index');
        
    }

    // タスク項目の昇順降順のへんこうについて(chatGDP)
    // public function index(Request $id)
    // {
    // $sort = $request->query('sort', 'asc'); // ソートパラメータを取得し、デフォルト値を指定
    
    // $task = Task::orderBy('name', $sort)->get();
    
    // return view('tasks.index', compact('index', 'sort'));
}
   
    
// }


// <!-- items/index.blade.php --> 
// <table> 
//  <thead> 
//   <tr> 
//     <th><a href="{{ route('items.index', ['sort' => $sort === 'asc' ? 'desc' : 'asc']) }}">項目名</a>
//     </th> 
// <!-- 他のヘッダー項目 --> 
//   </tr> 
//      </thead> 
//       <tbody> @foreach ($items as $item) 
//     <tr>
// <td>{{ $item->name }}</td> 
//  <!-- 他の項目 --> 
//     </tr> @endforeach 
//     </tbody> 
//   </table> 
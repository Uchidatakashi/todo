<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDo App</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
  <header>
    <nav class="my-navbar">
      <a class="my-navbar-brand" href="/">ToDo App</a>
    </nav>
  </header>
  <main>
    <div class="container">
      <div class="row">
        <div class="col col-md-4">
          <nav class="panel panel-default">
            <div class="panel-heading">フォルダ</div>
            <div class="panel-body">
              <a href="{{ route('folders.create') }}" class="btn btn-default btn-block">
                フォルダを追加する
              </a>
            </div>
            <div class="list-group">
              @foreach($folders as $folder)
              <a href="{{ route('tasks.index', ['id' => $folder->id]) }}"
                class="list-group-item {{ $current_folder_id === $folder->id ? 'active' : '' }}">
                {{ $folder->title }}
              </a>
              @endforeach
            </div>
          </nav>
        </div>
        <div class="column col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading">タスク</div>
            <div class="panel-body">
              <div class="text-right">
                <a href="{{ route('tasks.create', ['id' => $current_folder_id]) }}" class="btn btn-default btn-block">
                  タスクを追加する
                </a>
              </div>
            </div>
            <form action="{{ route('task.destroy', ['id' => $current_folder_id]) }}" method=POST>
                      @csrf
              <table class="table">
                <thead>
                  <tr>
                    <!--valueはidと連携する-->
                    <!--<th><input type="checkbox" name="task" value="{route('tasks.create',[id])}"> </th>-->
                    <th>チェックボックス</th>
                    <th><a herf="{{ route('task.sort',['id' => $current_folder_id, 'sort' => $sort === 'asc' ? 'desc' : 'asc'])  }}">タイトル▲▼</a></th>
                    <th>状態</th>
                    <!-- タイトルでソートの場合sort2とする-->
                    <th><a href="{{ route('task.sort2', ['id' => $current_folder_id,'sort' => $sort === 'asc' ? 'desc' : 'asc']) }}">期日▲▼</a></th>
                    <th>編集</th>
                    <th>削除</th>
                  </tr>
                </thead>
                <tbody>
                    @if (isset($tasks))
                    <!--<form action="{route('tasks.someDelete')}" method="post">-->
  
                      <div class="tasks-table__btn">
                        <span>操作：</span>
                        <!--<input type="submit" class="tasks-delete" value="タスク一括削除">-->
                        <!--<input type="submit" class="tasks-delete" name="delete[]" value="タスク一括削除">-->
                        
                      </div>
                      
                      <!--動作確認済みの内容-->
                      @foreach($tasks as $task)
                      <tr>
                        <td width="10%"><input type="checkbox" name="delete_task[]" value= "{{$task->id}}"></td>
                        <!--<td width="10%"><input　class="target" type="checkbox" name="delete[]" value="hoge"></td>-->
                        <td width="40%">{{ $task->title }}</td>
                        <td width="15%">
                          <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                        </td>
                        <td width="15%">{{ $task->formatted_due_date }}</td>
                        <!--編集に関して、ボタンを押してもホーム画面に戻る状態[#にホームのリンクが設定されている]削除と同じプロセスで考えると言い-->
                        <!--<td width="10%"><a href="#">編集</a></td> -->
                        <td width="10%"><a href="{{ route('tasks.edit', ['id' => $current_folder_id, 'task_id' => $task->id]) }}">編集</a></td> 
                        
                        <td width="10%">
                          <a href="/folders/{{$current_folder_id}}/tasks/{{$task->id}}/delete">削除</a>
                          <!--formタグの中にformタグは入れ込めない-->
                        </td>
                      </tr>
                      @endforeach
                      
                    <!--修正前-->
                     <!-- <form action=.. 'delete_task' => $delete_task] .. -->
                    <!--修正後    -->
                      <button type="submit"  class="btn btn-default btn-block">一括削除</button>
                    @endif
                </tbody>
              </table>
            </form>  
          </div>
        </div>
      </div>
    </div>

  </main>
</body>

</html>
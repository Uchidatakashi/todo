<?php
namespace App\Models;

use Carbon\Carbon; // ★追加
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
 use HasFactory;
  
 /**
  * 状態定義.
  */
 const STATUS = [
   1 => ['label' => '未着手', 'class' => 'label-warning'],
   2 => ['label' => '進捗遅れ', 'class' => 'label-danger'],
   3 => ['label' => '進捗順調', 'class' => 'label-info'],
   4 => ['label' => '進捗前倒し', 'class' => 'label-success'],
   5 => ['label' => '完了', 'class' => 'label-default'],
 ];

/**
  * タイトルについて.
  *
  * @return string
  */
 // public function getFormattedDueDateAttribute() {
 //   return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])
 //     ->format('Y/m/d')
   
 }

 /**
  * 整形した期限日.
  *
  * @return string
  */
 public function getFormattedDueDateAttribute() {
   return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])
     ->format('Y/m/d');
 }

 /**
  * 状態を表すHTMLクラス.
  *
  * @return string
  */ 
 public function getStatusClassAttribute() {
   // 状態値
   $status = $this->attributes['status'];
  
   // 定義されていなければ空文字を返す
   if (! isset(self::STATUS[$status])) {
     return '';
   }
  
   return self::STATUS[$status]['class'];
 }

 /**
  * 状態のラベル.
  *
  * @return string
  */
 public function getStatusLabelAttribute() {
 $status = $this->attributes['status'];
  
   // 定義されていなければ空文字を返す
   if (! isset(self::STATUS[$status])) {
     return '';
   }
  
   return self::STATUS[$status]['label'];
 }
 
}

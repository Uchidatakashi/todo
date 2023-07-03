<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
  public static function console_log($var) {
    echo '<script>console.log(', json_encode($var, JSON_UNESCAPED_UNICODE), ');</script>';
  }
}

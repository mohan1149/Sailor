<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
  public function __construct(){

  }
  public function getDashboardData(){
    $schol_owenr_id = $_SESSION['user_id'];
    $school_count   = DB::table('school')->where('school_owner_id',$schol_owenr_id)->count();
    return $school_count;
  }
}

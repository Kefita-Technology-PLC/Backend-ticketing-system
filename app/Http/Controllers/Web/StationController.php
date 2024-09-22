<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Association;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request){

      $query = Association::query();

      if($request->user()->hasRole("super admin")){

      }
    }
}

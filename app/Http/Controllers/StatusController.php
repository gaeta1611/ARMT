<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;

class StatusController extends Controller
{
    public function getAll ($statusType = null) {
        if ($statusType){
            $data = Status::where(['status'=>$statusType])->get()->toArray();
        } else {
            $data = Status::all()->toArray();
        }

        return response()->json($data);
    }
}

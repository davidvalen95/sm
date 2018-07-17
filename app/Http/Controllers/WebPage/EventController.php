<?php

namespace App\Http\Controllers\WebPage;

use App\Model\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    //




    public function getEvent(Request $request, $branch = ""){


        if(!$branch){
            $branch = Branch::where('name','=','pusat')->first();
        }else{
            $branch = Branch::find($branch);

        }


        if(!$branch){
            setDanger("Branch not found");
            return redirect()->route('get.home');
        }

        $data = [];
        $data["branch"] = $branch;

        return view('page.event',$data) ;
    }
}

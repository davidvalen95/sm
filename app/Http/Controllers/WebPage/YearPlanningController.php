<?php

namespace App\Http\Controllers\WebPage;

use App\Model\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YearPlanningController extends Controller
{
    //




    public function getYearPlanning(Request $request, $branch = ""){



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
        return view('page.yearPlanning',$data) ;
    }
}

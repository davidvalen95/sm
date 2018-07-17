<?php

namespace App\Http\Controllers;

use App\Model\Branch;
use App\Model\BranchEvent;
use App\Model\Photo;
use App\Model\Planning;
use App\Model\SelectEvent;
use Illuminate\Http\Request;

class BranchWebConfigurationController extends Controller
{
    //


    public function anyTop(Request $request)
    {


        $post = (object)$request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : '';
        $post->id = $post->id ?? "";


        $response = new \ApiResponse();
        $loggedInUser = \Auth::user();


        if ($request->is('api/*')) {
            if ($post->cmd == 'detail') {


                $branch = Branch::find($post->id);
                if(!$branch){
                    if($loggedInUser->isMaster()){
                        $branch = Branch::where('name','pusat')->first();
                    }
                }
                if (!$branch) {
                    $response->isSuccess = false;
                    $response->message = "Branch not found";
                    return response()->json($response);

                }
                if (!$loggedInUser->isThisMyBranch($branch) && $loggedInUser->isMeHeadBranch() && !$loggedInUser->isMaster()) {


                    $response->isSuccess = false;
                    $response->message = "Only head branch can configure web";
                    return response()->json($response);


                }


                $branchEvents = $branch->getBranchEvents;

                foreach ($branchEvents as $branchEvent) {
                    $branchEvent->getPhotos;
                }
                $branch->getPlannings;

                $response->isSuccess = true;
                $response->message = "Branch fetched";
                $response->data->branch = $branch;
                $response->data->postMaxSize = ini_get('post_max_size');


                return response()->json($response);
            }


        }


    }


    public function anyOp(Request $request)
    {


        $post = (object)$request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : '';
        $post->id = $post->id ?? "";
        $post->branchId = $post->branchId ?? "";
        $post->branchEventId = $post->branchEventId ?? "";
        $post->photoId = $post->photoId ?? "";
        $post->planningId = $post->planningId ?? "";

        $response = new \ApiResponse();
        $loggedInUser = \Auth::user();


        if ($request->is('api/*')) {
            if ($post->cmd == 'addEvent' || $post->cmd =='editEvent') {



                $this->validate($request,[
                   "title"=>"required",
                   "description"=>"required",

                ]);

                $branch = Branch::find($post->branchId);
                if(!$branch){
                    if($loggedInUser->isMaster()){
                        $branch = Branch::where('name','pusat')->first();
                    }
                }
                if(!$branch){
                    $response->isSuccess = false;
                    $response->message = "Branch not found";
                    return response()->json($response);
                }


                $branchEvent = null;
                if($post->cmd == "editEvent"){
                    $branchEvent = BranchEvent::find($post->branchEventId);
                    if(!$branchEvent){
                        $response->isSuccess = false;
                        $response->message = "Branch Event not found";
                        return response()->json($response);
                    }
                    $branchEvent->update($request->all());
                }else{
                    $branchEvent = new BranchEvent($request->all());
                    $branchEvent->getBranch()->associate($branch);

                }

                $branchEvent->save();

                if ($request->hasFile('photo')) {
                    foreach ($request->file('photo') as $currentPhoto) {

                        $photo = savePhoto($currentPhoto, $branchEvent->getPath());
                        $photo->getBranchEvent()->associate($branchEvent);
                        $photo->save();
                        $branchEvent->save();
                    }
                }

                addHistory($loggedInUser, SelectEvent::getUpdateWebsite(), "Konfigurasi website. Insert event, cabang  $branch->name");

                $response->isSuccess = true;
                $response->message = $post->cmd == 'addEvent' ? "Event saved" : "Event Updated";
                return response()->json($response);
            }


            if ($post->cmd == 'addPlanning' || $post->cmd == 'editPlanning') {


                $this->validate($request, [
                    "title" => "required",
                    "description" => "required",
                    "dueDate" => "required",

                ]);

                $branch = Branch::find($post->branchId);
                if(!$branch){
                    if($loggedInUser->isMaster()){
                        $branch = Branch::where('name','pusat')->first();
                    }
                }
                if (!$branch) {
                    $response->isSuccess = false;
                    $response->message = "Branch not found";
                    return response()->json($response);
                }


                $planning = null;
                if ($post->cmd == "editPlanning") {
                    $planning = Planning::find($post->planningId);
                    if (!$planning) {
                        $response->isSuccess = false;
                        $response->message = "Planning not found";
                        return response()->json($response);
                    }
                    $planning->update($request->all());
                } else {
                    $planning = new Planning($request->all());
                    $planning->getBranch()->associate($branch);

                }

                $planning->save();


                addHistory($loggedInUser, SelectEvent::getUpdateWebsite(), "Konfigurasi website. Insert planning, cabang  $branch->name");

                $response->isSuccess = true;
                $response->message = $post->cmd == 'addPlanning' ? "Planning saved" : "Planning Updated";
                return response()->json($response);
            }



            if($post->cmd =='deleteEvent'){

                $branchEvent = BranchEvent::find($post->branchEventId);


                if(!$branchEvent){
                    $response->isSuccess = false;
                    $response->message = "Branch Event not found";
                    return response()->json($response);
                }

                $branch = $branchEvent->getBranch;

                addHistory($loggedInUser, SelectEvent::getUpdateWebsite(), "Konfigurasi website. Delete event, cabang  $branch->name");

                $branchEvent->delete();



                $response->isSuccess = true;
                $response->message = "Event deleted";
                return response()->json($response);

            }


            if($post->cmd =='deletePlanning'){

                $planning = Planning::find($post->planningId);


                if(!$planning){
                    $response->isSuccess = false;
                    $response->message = "Branch Event not found";
                    return response()->json($response);
                }

                $branch = $planning->getBranch;

                addHistory($loggedInUser, SelectEvent::getUpdateWebsite(), "Konfigurasi website. Delete planning, cabang  $branch->name");

                $planning->delete();



                $response->isSuccess = true;
                $response->message = "Planning deleted";
                return response()->json($response);

            }

            if($post->cmd == 'deletePhoto'){

                $photo = Photo::where('id', $post->photoId)->where('branch_event_id',$post->branchEventId)->first();

                if(!$photo){
                    $response->isSuccess = false;
                    $response->message = "Photo not found";
                    return response()->json($response);
                }

                $photo->delete();

                $response->isSuccess = true;
                $response->message = "Photo deleted";
                return response()->json($response);
            }


        }
    }


}

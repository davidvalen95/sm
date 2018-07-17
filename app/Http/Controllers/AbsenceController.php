<?php

namespace App\Http\Controllers;

use App\Model\AbsenceBranch;
use App\Model\AbsenceDate;
use App\Model\Branch;
use App\Model\BranchUser;
use App\Model\SelectClass;
use App\Model\SelectRole;
use App\Model\User;
use App\Model\UserAbsenceRecord;
use Auth;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    //


    public function anyOp(Request $request)
    {

        $post = (object)$request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : "";
        $post->id = isset($post->id) ? $post->id : "";
        $post->available  = isset($post->available) ? $post->available : [];
        $post->branchUserId  = isset($post->branchUserId) ? $post->branchUserId : [];
        $post->reason  = isset($post->reason) ? $post->reason : [];
        $post->name  = isset($post->name) ? $post->name : [];
        $response = new \ApiResponse();
        $loggedInUser = Auth::user();





        if($request->is('api/*')){
            if($post->cmd == 'addAbsenceBranch'){


                $this->validate($request,[
                    "id" => "required"
                ]);

                $absenceBranch = AbsenceBranch::find($post->id);

                if(!$absenceBranch){
                    $response->isSuccess = false;
                    $response->message = "AbsenceBranch not found";

                    return response()->json($response);
                }


                //# cek post yang absen
                $totalAbsence = 0;
                foreach($post->available as $key => $available){
                    if(!(bool)$available){
                        $branchUser =  BranchUser::find($post->branchUserId[$key]);


                        $userAbsenceRecord = new UserAbsenceRecord();
                        $userAbsenceRecord->reason = $post->reason[$key];
                        $userAbsenceRecord->getBranchUser()->associate($branchUser);
                        $userAbsenceRecord->getAbsenceBranch()->associate($absenceBranch);
                        $userAbsenceRecord->save();

                        $totalAbsence++;
                    }
                }


                $absenceBranch->isDone = true;
                $absenceBranch->totalAbsence = $totalAbsence;
                $absenceBranch->totalPupil = sizeof($post->branchUserId);
                $absenceBranch->getUserCommiter()->associate($loggedInUser);
                $absenceBranch->save();
                $response->isSuccess = true;
                $response->message = "Absence record for {$absenceBranch->getBranch->name} has been saved";

                return response()->json($response);

            }

            if($post->cmd == 'followUp'){
                $userAbsenceRecord = UserAbsenceRecord::find($post->id);

                if(!$userAbsenceRecord){
                    $response->isSuccess = false;
                    $response->message = "User absence record not found";

                    return response()->json($response);
                }

                $this->validate($request,[
                    "reason" => "required"
                ]);


                $userAbsenceRecord->isFollowedUp = true;
                $userAbsenceRecord->reason = $post->reason;
                $userAbsenceRecord->save();

                $response->isSuccess = true;
                $response->message = "Follow up updated";
                return response()->json($response);

            }
        }

    }


    public function anyTop(Request $request){

        $post = (object) $request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : "";
        $post->id = isset($post->id) ? $post->id : "";
        $response = new \ApiResponse();
        $loggedInUser = Auth::user();
        if($request->is('api/*')){

            if($post->cmd='list'){

                $branch = Branch::find($post->id);
                if(!$branch){

                    $response->isSuccess = false;
                    $response->message = "Branch not found";
                    return response()->json($response);
                }

                $isThisLoggedInUserBranch = $loggedInUser->getBranchUser()->whereHas('getBranch',function($getBranch) use($post){
                        $getBranch->where('id',$post->id);
                })->count() > 0;


                $isCanAbsence = false;
                $canAbsenceReason = "";

                //#diri senidri
                if($isThisLoggedInUserBranch){
                    $isCanAbsence = true;
                    $canAbsenceReason .= "ownBranch, ";
                }

                //# master
                if($loggedInUser->isMaster()){
                    $isCanAbsence = true;
                    $canAbsenceReason .= "master, ";
                }


                //# di return karena tidak boleh lihat
                if(!$isCanAbsence){

                    $response->isSuccess = false;
                    $response->message = "Hanya boleh melihat sm milik sendiri";
                    return response()->json($response);
                }

                //region notDone
                $absenceDatesNotDone = AbsenceDate::whereHas('getAbsenceBranches', function($getAbsenceBranch) use ($branch){
                    $getAbsenceBranch->where('isDone', false)->where('branch_id', $branch->id);
                })->get();
                foreach($absenceDatesNotDone as $absenceDateNotDone){
                    $absenceBranches = $absenceDateNotDone->getAbsenceBranches()->where('branch_id',$branch->id)->where('isDone',false)->get();
                    foreach($absenceBranches as $absenceBranch){
                        $absenceBranch->getSelectClass;
                        $branch = $absenceBranch->getBranch;

                        //# dapetin informasi user untuk setiap class yg !isDone
                        $theUsers = $branch->getBranchUsers()->whereHas('getRole',function($getRole){
                            $getRole->where('id', SelectRole::getPupil()->first()->id);
                        })->where('select_class_id',$absenceBranch->select_class_id)->get();
                        foreach($theUsers as $theUser){
                            $theUser->getUser;
                        }


//                        debug($theUsers);
                        $branch->get_branch_users = $theUsers;
                    }

                    $absenceDateNotDone->get_absence_branches = $absenceBranches;
                }
                //endregion

                //region dapetin semua absenceDate 5 minggu terakir
                $absenceDateRecords = AbsenceDate::where('targetDate', '>=', getDefaultDatetime('today - 5 week'))->whereHas('getAbsenceBranches', function($getAbsenceBranch) use ($branch){
                    $getAbsenceBranch->where('branch_id', $branch->id);
                })->get();
                foreach($absenceDateRecords as $absenceDateRecord){
                    $absenceBranches = $absenceDateRecord->getAbsenceBranches()->where('branch_id',$branch->id)->get();
                    $totalPupil = 0;
                    $totalAbsence = 0;
                    $notYetDone = 0;
                    $notYetFollowedUp = 0 ;
                    foreach($absenceBranches as $absenceBranch){
                        if(!$absenceBranch->isDone){
                            $notYetDone++;
                        }else{
                            $totalPupil = $totalPupil + $absenceBranch->totalPupil;
                            $totalAbsence = $totalAbsence + $absenceBranch->totalAbsence;
                        }

                        $userAbsenceRecords = $absenceBranch->getUserAbsenceRecord;

                        foreach($userAbsenceRecords as $userAbsenceRecord){
                            $userAbsenceRecord->getBranchUser->getUser;
                            $notYetFollowedUp = $notYetFollowedUp + ( $userAbsenceRecord->isFollowedUp ? 0 : 1);

                        }
                        $absenceBranch->getUserCommiter;
                        $absenceBranch->getBranch;
                        $absenceBranch->getUserAbsenceRecord;
                        $absenceBranch->getSelectClass;
                    }

                    //# masukin nunut
                    $absenceDateRecord->totalPupil = $totalPupil;
                    $absenceDateRecord->totalAbsence = $totalAbsence;
                    $absenceDateRecord->notYetDone = $notYetDone;
                    $absenceDateRecord->notYetFollowedUp = $notYetFollowedUp;

                    //# dapetin detail absence Branch nya
                    $absenceDateRecord->get_absence_branches = $absenceBranches;



                    //# detail ketika di click

                }
                //endregion


                $response->isSuccess = true;
                $response->message = "";
                $response->data->isCanAbsence = $isCanAbsence;
                $response->data->canAbsenceReason = $canAbsenceReason;
                $response->data->branch = $branch;
                $response->data->absenceDatesNotDone = $absenceDatesNotDone;
                $response->data->absenceDateRecords = $absenceDateRecords;

                return response()->json($response);






            }


        }


    }

    //TODO di home pasang history user sudah ngapain aja, di home tambain data absensi semua sekolah minggu

    public function generateAbsence(){


        $lastAbsenceDate = AbsenceDate::orderby('created_at', 'desc')->first();

        //#insert advance 7 hari
        $advanceAbsenceDate = new AbsenceDate();
        $advanceAbsenceDate->targetDate = getDefaultDatetime("$lastAbsenceDate->targetDate + 7 day");
        $advanceAbsenceDate->save();

        $selectClasses = SelectClass::all();
        $branches = Branch::all();


        //# bikin absensi untuk setiap branch dan setiap class
        foreach($branches as $branch){
            foreach ($selectClasses as $selectClass){
                $absenceBranch = new AbsenceBranch();
                $absenceBranch->isDone = false;
                $absenceBranch->getSelectClass()->associate($selectClass);
                $absenceBranch->getBranch()->associate($branch);
                $absenceBranch->getAbsenceDate()->associate($advanceAbsenceDate);
                $absenceBranch->save();
            }
        }




    }



}

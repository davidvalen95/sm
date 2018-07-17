<?php

namespace App\Http\Controllers;

use App\Model\AbsenceDate;
use App\Model\Branch;
use App\Model\BranchUser;
use App\Model\SelectClass;
use App\Model\SelectEvent;
use App\Model\SelectRole;
use App\Model\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    //






    public function anyOp(Request $request){
        $post = (object) $request->all();
        $post->head = isset($post->head) ? $post->head : '';
        $post->owner = isset($post->owner) ? $post->owner : '';
        $post->id = isset($post->id) ? $post->id : '';
        $post->branchId = isset($post->branchId) ? $post->branchId : '';
        $post->role = isset($post->role) ? $post->role : '';
        $post->isActive = isset($post->isActive) ? $post->isActive : '';
        $post->selectClass = isset($post->selectClass) ? $post->selectClass : '';

        $response = new \ApiResponse();

        $loggedInUser = \Auth::user();




        if($request->is('api/*')){


            if($post->cmd == 'changeClass'){
                $branchUser = BranchUser::find($post->id);
                $branchUser->getClass()->associate(SelectClass::whereValue($post->class)->first());
                $branchUser->save();

                $response->isSuccess = true;
                $response->message = "Kelas {$branchUser->getUser->name} berhasil dirubah";
                return response()->json($response);
            }

            if($post->cmd == 'changeActiveStatus'){
                $branchUser = BranchUser::find($post->id);
                $user = $branchUser->getUser;
                $branch = $branchUser->getBranch;
                $branchHead = $branch->getHead;
                $branchOwner = $branch->getOwner;
                $branchUser->isActive = $post->isActive;


                //# kalau menjadi tidak aktif maka dicek apakah head / owner? jika iya otomatis hilang
                if(!$post->isActive){
                    $event = $branchUser->getRole->value == 'teacher' ? SelectEvent::getOffTeacher() : SelectEvent::getOffPupil();
                    addHistory($user, $event, "Keluar dari $branch->name, posisi {$branchUser->getRole->key}. Di input oleh $loggedInUser->name - $loggedInUser->nbg");

                    $branchUser->dateOut = getDefaultDatetime();

                    if($branchHead && $branchHead->id == $user->id){
                        $branch->getHead()->associate(NULL);
                        $branch->save();
                    }
                    if($branchOwner && $branchOwner->id == $user->id){
                        $branch->getOwner()->associate(NULL);
                        $branch->save();
                    }

                }
                if($post->isActive){
                    $event = $branchUser->getRole->value == 'teacher' ? SelectEvent::getActiveTeacher() : SelectEvent::getActivePupil();

                    addHistory($user, $event, "Kembali aktif dalam $branch->name sebagai {$branchUser->getRole->key}. Di input oleh $loggedInUser->name - $loggedInUser->nbg");
                    $branchUser->dateIn = getDefaultDatetime();
                }
                $branchUser->save();

                $response->isSuccess = true;
                $response->message = "Keaktifan dari {$branchUser->getUser->name} berhasil dirubah";
                return response()->json($response);
            }

            if($post->cmd == 'addBranch'){


                $branch = new Branch($request->all());
//                debug($branch);
                $head = null;
                $owner = null;

                $branch->save();


                $response->isSuccess = true;
                $response->message = "Branch added";


                return response()->json($response);
            }

            if($post->cmd == 'edit'){
                $branch = Branch::find($post->id);
                $branch->update($request->all());
                if(!$branch){

                    $response->isSuccess = false;
                    $response->message = "Branch not found";

                    return response()->json($response);

                }
                $head = null;
                $owner = null;
                if($post->head != ''){
                    $head = User::find($post->head);
                    if(!$head){
                        $response->isSuccess = false;
                        $response->message = "Head branch user not found";
                        return response()->json($response);
                    }

                    //# cari apakah si head/owner sudah punya status guru di tempat itu

                    BranchUser::addUniqueBranchUserAsTeacher($loggedInUser, $head, $branch, SelectRole::getTeacher()->first());
                    $branch->getHead()->associate($head);
                }

                if($post->owner != ''){
                    $owner = User::find($post->owner);
                    if(!$owner){
                        $response->isSuccess = false;
                        $response->message = "Owner branch user not found";
                        return response()->json($response);

                    }
                    BranchUser::addUniqueBranchUserAsTeacher($loggedInUser, $owner, $branch, SelectRole::getTeacher()->first());
                    $branch->getOwner()->associate($owner);
                }

                $branch->save();


                $response->isSuccess = true;
                $response->message = "Branch successfully edit";


                return response()->json($response);
            }

            if($post->cmd == 'addUserToBranch'){

                $user = User::find($post->id);
                $role = SelectRole::whereValue($post->role)->first();
                $branch = Branch::find($post->branchId);
                $class = SelectClass::whereValue($post->selectClass)->first();

                $event = $post->role == 'teacher' ? SelectEvent::getActiveTeacher() : SelectEvent::getActivePupil();
                if(!$user || !$role || !$branch || !$class){

                    $response->isSuccess = false;
                    $response->message = "User or role or branch or class not found";
                    return response()->json($response);
                }

                //# check if user exist, if so then change status to active
                $userSameRoleBranch = $user->getBranchUser()
                    ->whereHas('getBranch',function($getBranch) use ($branch){
                        $getBranch->where('id',$branch->id);
                    })
                    ->whereHas('getRole',function($getRole) use ($role){
                        $getRole->where('id', $role->id);
                    })->first();
                if($userSameRoleBranch){
                    if(!$userSameRoleBranch->isActive){
                        $userSameRoleBranch->isActive = true;
                        $userSameRoleBranch->dateIn = getDefaultDatetime();
                        $userSameRoleBranch->save();

                        addHistory($user, $event, "Kembali bergabung dalam $branch->name. Di input oleh $loggedInUser->name - $loggedInUser->nbg");
                        $response->isSuccess = true;
                        $response->message = "User Telah terdaftar di sekolah minggu ini ($branch->name), namun lama tidak aktif, status kembali aktif";
                        return response()->json($response);
                    }

                    $response->isSuccess = false;
                    $response->message = "User masih aktif dalam sekolah minggu ini ($branch->name)";
                    return response()->json($response);
                }else{
                    //# jika tidak ada maka buat BranchUser baru

                    $branchUser = new BranchUser();

                    $branchUser->getBranch()->associate($branch);
                    $branchUser->getClass()->associate($class);
                    $branchUser->getRole()->associate($role);
                    $branchUser->getUser()->associate($user);
                    $branchUser->isActive = true;
                    $branchUser->dateIn = getDefaultDatetime();

                    $branchUser->save();


                    addHistory($user, $event, "Bergabung dalam $branch->name sebagai $role->key. Di input oleh $loggedInUser->name - $loggedInUser->nbg");
                    $response->isSuccess = true;
                    $response->message = "User baru telah berhasil diasosiasikan";
                    return response()->json($response);

                }








            }


            if($post->cmd == 'advanceClass'){

                $branch = Branch::find($post->id);

                if(!$branch){
                    $response->isSuccess = false;
                    $response->isSuccess = "Branch not found";

                    return response()->json($response);
                }


                /** @var BranchUser[] $pupils */
                $pupils = $branch->getUsersAsPupil->where('isActive',true)->all();

                foreach ($pupils as $pupil){
                    $advanceClass = $pupil->getClass->getAdvance();

                    $pupil->getClass()->associate($advanceClass);
                    $pupil->save();

                }

                $response->isSuccess = true;
                $response->message = sizeof($pupils)." murid berhasil naik kelas";
                return response()->json($response);




            }
        }
    }

    public function anyTop(Request $request){

        $post = (object) $request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : '';

        $response = new \ApiResponse();
        $loggedInUser = \Auth::user();




        if($request->is('api/*')){
            if($post->cmd == 'list'){


                $branches = Branch::paginate(PER_PAGE);
                $branches->getCollection()->transform(function($branch){
                    /** @var \App\Model\Branch $branch */
                    $branch->getOwner;
                    $branch->getHead;
                    $branch->totalTeacher = $branch->getUsersAsTeacher()->count();
                    $branch->totalPupil = $branch->getUsersAsPupil()->count();

                    return $branch;
                });

                //# dapetin cabang ku dimana saja
                $myBranchUsers = $loggedInUser->getBranchUserAsTeacher()->where('isActive',true)->get();
                foreach($myBranchUsers as $currentUserBranch){
                    $currentUserBranch->getBranch;
                }

                $response->data->branches = $branches;
                $response->data->myBranchUsers = $myBranchUsers;

                return response()->json($response);

            }



            if($post->cmd =='detail'){

                $branch = Branch::find($post->id);



                if(!$branch){
                    $response->message = "Branch not found";
                    $response->isSuccess = false;

                    return response()->json($response);
                }


                $selectClass = SelectClass::all();

                $branch->getOwner;
                $branch->getHead;
                $pupils = $branch->getUsersAsPupil()->orderBy('isActive','desc')->get();
                $teachers = $branch->getUsersAsTeacher()->orderBy('isActive',   'desc')->get();

                $isCanAddPupil = false;
                $canAddPupilReason = "";
                $isCanEditPupil = false;
                $canEditPupiLReason = "";
                $isCanAbsence = false;
                $canAbsenceReason = "";
                $isCanConfigureWebBranch = false;
                $canConfigureWebBranchReason = "";
                foreach($teachers as $teacher){
                    $teacher->getUser;
                    $teacher->getClass;
                    $teacher->getRole;
                }
                foreach($pupils as $pupil){
                    $pupil->getUser;
                    $pupil->getClass;
                    $pupil->getRole;
                }


                if($loggedInUser->isMeHeadBranch() && $loggedInUser->isThisMyBranch($branch)){
                    $isCanAddPupil = true;
                    $canAddPupilReason .= "headBranchOfThis, ";

                    $canEditPupiLReason .= "headBranchOfThis, ";
                    $isCanEditPupil = true;


                    $isCanConfigureWebBranch = true;
                    $canConfigureWebBranchReason .= "headBranchOfThis, ";

                }



                if($loggedInUser->getPreviledge->isCanConfigureBranch){
                    $isCanAddPupil = true;
                    $canAddPupilReason .= "canConfigureBranch, ";

                    $canEditPupiLReason .= "canConfigureBranch, ";
                    $isCanEditPupil = true;
                }

                if($loggedInUser->isMaster()){
                    $isCanAbsence = true;
                    $canAbsenceReason .= "Master, ";


                    $isCanConfigureWebBranch = true;
                    $canConfigureWebBranchReason .= "Master, ";

                }

                if($loggedInUser->isThisMyBranch($branch)){
                    $isCanAbsence = true;
                    $canAbsenceReason .= "myBranch, ";

                    $canEditPupiLReason .= "theTeacherofThisBranch, ";
                    $isCanEditPupil = true;
                }



                $response->data->selectClass = $selectClass;
                $response->data->branch = $branch;
                $response->data->branch->get_users_as_pupil = $pupils;
                $response->data->branch->get_users_as_teacher = $teachers;
                $response->data->isCanAddPupil = $isCanAddPupil;
                $response->data->canAddPupilReason = $canAddPupilReason;
                $response->data->isCanEditPupil = $isCanEditPupil;
                $response->data->canEditPupilReason = $canEditPupiLReason;
                $response->data->isCanAbsence = $isCanAbsence;
                $response->data->canAbsenceReason = $canAbsenceReason;
                $response->data->isCanConfigureWebBranch = $isCanConfigureWebBranch;
                $response->data->canConfigureWebBranchReason = $canConfigureWebBranchReason;

                $response->data->isCanEditProfile = $loggedInUser->getPreviledge->isCanConfigureBranch;
                $response->data->isCanAddTeacher = $loggedInUser->getPreviledge->addTeacher;
//                $response->data->isCanEditProfile = $loggedInUser->getPreviledge->isCanConfigureBranch;

                return response()->json($response);
            }


        }



    }






}

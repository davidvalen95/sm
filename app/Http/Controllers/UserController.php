<?php

namespace App\Http\Controllers;

use App\Model\Branch;
use App\Model\BranchUser;
use App\Model\History;
use App\Model\Score;
use App\Model\SelectClass;
use App\Model\SelectEvent;
use App\Model\SelectRole;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //




    public function __construct(){



    }


    public function anyOp(Request $request){
        $post = (object) $request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : "";
        $post->registerKey = isset($post->registerKey) ? $post->registerKey : "";
        $loggedInUser = \Auth::user();

//        debug();
        if($request->is('api/*')){
            $response = new \ApiResponse();

            if($post->cmd == 'addUser'){

                $this->validate($request,$this->getRegisterRules(false, false));
                $this->validate($request,[
                    'branch' => 'required',
                    'selectRole' => 'required',
                    'selectClass' => 'required',
                ]);

                $branchUser = new BranchUser();
                $branchUser->dateIn = getDefaultDatetime();
                $selectRole = SelectRole::where('value',$post->selectRole)->first();

                //#role in branch user
                if(!$selectRole){
                    $response->message = "Role not found";
                    $response->isSuccess = false;
                    return response()->json($response);
                }


                //# set the branch
                $branch = Branch::find($post->branch);
                if(!$branch){
                    $response->message = "Branch not found";
                    $response->isSuccess = false;
                    return response()->json($response);
                }

                //# set class
                $selectClass = SelectClass::where('value', $post->selectClass)->first();
                if(!$selectClass){
                    $response->message = "Select Class not found";
                    $response->isSuccess = false;
                    return response()->json($response);
                }


                //# set previledge
                $user = new User($request->all());
                $user->password = \Hash::make( substr(str_replace(' ','',trim($post->name)),0,2). str_replace('-','', $post->birthDate));
                if($selectRole->value == 'teacher'){
                    $user->getPreviledge()->associate(\App\Model\Previledge::where('value','teacher')->first());
                }
                if($selectRole->value == 'pupil'){
                    $user->getPreviledge()->associate(\App\Model\Previledge::where('value','pupil')->first());
                }
                $user->save();
                $branchUser->getUser()->associate($user);
                $branchUser->getRole()->associate($selectRole);
                $branchUser->getBranch()->associate($branch);
                $branchUser->getClass()->associate(($selectClass));
                $branchUser->isActive = true;
                $branchUser->save(); //# save the branch user

                //# nambah event history
                if($branchUser->getRole->value=='teacher'){
                    addHistory($user,SelectEvent::getActiveTeacher(), "Masuk sebagai GURU pada cabang $branch->name. Dimasukan oleh {$loggedInUser->name} - {$loggedInUser->nbg}");

                }
                if($branchUser->getRole->value=='pupil'){
                    addHistory($user,SelectEvent::getActivePupil(), "Masuk sebagai MURID pada cabang $branch->name. Dimasukan oleh {$loggedInUser->name} - {$loggedInUser->nbg}");

                }

                $response->message = 'User added';
                $response->isSuccess = true;

                return response()->json($response);

            }


            if($post->cmd=='edit'){
                $post->id = isset($post->id) ? $post->id : -1;

                $user = User::find($post->id);
                if($user){


                    $this->validate($request,$this->getRegisterRules(isset($post->password) && $post->password != '', false));

                    $user->update($request->except(['password','password_confirmation']));

                    if(isset($post->password)){
                        $user->password = \Hash::make($post->password);
                        $user->update();
                    }

                    if($request->hasFile('photo')){
                        foreach ($request->file('photo') as $currentPhoto){

                            $photo = savePhoto($currentPhoto, $user->getPath());
                            $user->getPhoto()->associate($photo);
                            $user->save();
                        }
                    }


                    if($user->id == $loggedInUser->id){
                        addHistory($loggedInUser, SelectEvent::getUpdateProfile(), "Melakukan edit profile untuk diri sendiri");
                    }else{
                        addHistory($user, SelectEvent::getUpdateProfile(), "Otoritas lebih tinggi ({$loggedInUser->name} - {$loggedInUser->nbg}) melakukan edit profile");
                    }


                    $response->isSuccess = true;
                    $response->message = "Successfully update profile for $user->name" ;

                }else{
                    $response->isSuccess = false;
                    $response->message = "User not found";
                }
            }


            if($post->cmd == 'giveScore'){

                $user = User::find($post->id);
                if($user){

                    $score = new Score();

                    $score->description = $post->score;
                    $score->getPupil()->associate($user);
                    $score->getTeacher()->associate($loggedInUser);
                    $score->save();

                    $response->isSuccess = true;
                    $response->message = "Successfully give score to $user->name" ;

                }else{
                    $response->isSuccess = false;
                    $response->message = "User not found";
                }

            }


            return response()->json($response);



        }

        return "{}";


    }



    public function anyLogin(Request $request){
        $post = (object) $request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : "";

        $this->validate($request,["email"=>"required",'password'=>"required"]);

        $response = new \ApiResponse();

        $emailUser = User::whereEmail($post->email)->first();
        if(!$emailUser){
            $response->isSuccess = false;
            $response->message = "User / email belum terdaftar";
            return response()->json($response);
        }

        $isSuccess = \Auth::attempt($request->only(['email','password']));
        $response->isSuccess = $isSuccess;





        $user = \Auth::user();
        if($user){
            $user->getPhoto;
            $user->getBranchUser;
            $user->getHistories;
            $user->getPreviledge;
            $user->getMeAsHead;
//            $user->setDefaultPreference();
            $response->data->user = $user;

        }

        $response->message = $isSuccess ? "Selamat datang $user->name" : "Password salah";
        if($request->is('api/*')) {
            return response()->json($response);
        }



    }



    public function anyLogout(){
        \Auth::logout();
        return response()->json(new \ApiResponse());
    }

    public function anyTop(Request $request){
        /** @var  $branchUser BranchUser */
        /** @var  $branchInfo Branch */

        $post = (object) $request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : "";
        $post->cmbRole = isset($post->cmbRole) ? $post->cmbRole : "";
        $post->cmbBranch = isset($post->cmbBranch) ? $post->cmbBranch : "";
        $post->cmbClass = isset($post->cmbClass) ? $post->cmbClass : "";
        $post->searchValue = isset($post->searchValue) ? $post->searchValue : "";
        $response = new \ApiResponse();
        $response->isSuccess = false;
        $response->message = "User not found";
        $loggedInUser = \Auth::user();


        if($post->cmd == 'list'){


            //region setFilter
            $filter = [];
            $filter['cmbRole'][] = ['key'=>'-- All --', 'value'=>''];
            $filter['cmbBranch'][] = ['key'=>'-- All --', 'value'=>''];
            $filter['cmbClass'][] = ['key'=>'-- All --', 'value'=>''];
            $filter['cmbSearchBy'][] = ['key'=>'-- None --', 'value'=>''];
            $filter['cmbSearchBy'][] = ['key'=>'Name', 'value'=>'name'];
            $filter['cmbSearchBy'][] = ['key'=>'Address', 'value'=>'address'];
            $filter['cmbSearchBy'][] = ['key'=>'Email', 'value'=>'email'];
            $filter['searchValue'] = '';
            foreach(SelectRole::all() as $selectRole){

                $filter['cmbRole'][] = ['key'=>$selectRole->key, 'value'=>$selectRole->value];
            }
            foreach(Branch::all() as $branch){
                $filter['cmbBranch'][] = ['key'=>$branch->name, 'value'=>$branch->id];

            }
            foreach(SelectClass::all() as $class){
                $filter['cmbClass'][] = ['key'=>$class->key, 'value'=>$class->value];

            }
            //endregion

            $users = User::where('id','!=', -1);
            //region whereCmb ketika user submitfilterform

//            $users->whereHas('getPreviledge',function($getPreviledge) use($post){
//                $getPreviledge->where('value','!=','master');
//            });

            if($post->cmbRole != ''){
                $users->whereHas('getBranchUser',function($getBranchUser) use($post){
                    $getBranchUser->whereHas('getRole',function($getRole) use($post){
                        $getRole->where('value',$post->cmbRole);
                    });
                });
            }

            if($post->cmbBranch != ''){
                $users->whereHas('getBranchUser',function($getBranchUser) use($post){
                    $getBranchUser->whereHas('getBranch',function($getBranch) use($post){
                        $getBranch->where('id',$post->cmbBranch);
                    });
                });
            }


            if($post->cmbClass != ''){
                $users->whereHas('getBranchUser',function($getBranchUser) use($post){
                    $getBranchUser->whereHas('getClass',function($getClass) use($post){
                        $getClass->where('value',$post->cmbClass);
                    });
                });
            }

            if($post->searchValue != '' && $post->cmbSearchBy!=''){
                $users->where($post->cmbSearchBy, 'LIKE', "%$post->searchValue%");
            }


            //endregion
            $users = $users->paginate(PER_PAGE);
            $users->getCollection()->transform(function ($value) {
                // Your code here
                $user = $value;
                $branchUsers = $user->getBranchUser;
                foreach ($branchUsers as $branchUser){
                    $branchUser->getBranch;
                    $branchUser->getRole;
                    $branchUser->getClass;


                }
                return $user;
            });


            //region addUser sesuai previledge
            $selectRoles = [];
            $branches = [];;

            if($loggedInUser->isTeacher()){

                //#role teacher hanya murid
                $selectRoles = SelectRole::where('value', '=', 'pupil')->get();

                foreach( $loggedInUser->getBranchUserAsTeacher()->get() as $branchAsTeacher){
                    $branches[] = ['key'=>$branchAsTeacher->getBranch->name, 'value'=>$branchAsTeacher->getBranch->id];
                }
            }
            if($loggedInUser->isMaster()){
                $selectRoles = SelectRole::all();
                foreach( Branch::all() as $branch){
                    $branches[] = ['key'=>$branch->name, 'value'=>$branch->id];
                }
            }

//            $loggedInUser->getBranchUser->all();


            $selectClasses = SelectClass::all();

            //endregion


            $response->data->filter = $filter;
            $response->data->users = $users;
            $response->data->selectRoles = $selectRoles;
            $response->data->selectClasses = $selectClasses;
            $response->data->branches = $branches;



            $response->isSuccess = true;
            $response->message = "Success";






        }



        if($post->cmd == 'detail'){
            $user = User::find($post->id);

            if($user) {
                $user->getPhoto;
                $userBranchs = $user->getBranchUser->all();
                foreach ($userBranchs as $branch) {
                    $branchInfo = $branch->getBranch;
                    $branchInfo->getHead;
                    $branchInfo->getOwner;
                    $branch->getUser;
                    $branch->getClass;
                    $branch->getRole;
                }

                $userHistories = $user->getHistories;
                foreach ($userHistories as $userHistory){
                    $userHistory->getUser;
                    $userHistory->getEvent;
                }
                $user->getPreviledge;
                $user->getMeAsHead;
                $user->getPhoto;


                $response->data->user = $user;


                //region permissions

                $isCanEditProfile = false;
                $isCanScore = false; //# memberikan penilaian
                $isCanEditNbg = false;
                $isCanChangePassword = false;
                $isCanView = false;
                $canViewReason = "";
                $canChangePasswordReason = "";
                $canEditProfileReason = "";
                $canScoreReason = "";
                $meAsPupilScores = []; //# logic dari length == 0
                $meAsTeacherScores = [];
                //# untuk edit jika userTarget adalah murid, dan loggedIn Adalah tacher
                //# logged in user == teacher dan si target adalah murid nya. maka bisa di edit
                foreach ($loggedInUser->getBranchUser as $loggedInUserBranch) {

                    /** @var $branch BranchUser */
                    if ($loggedInUserBranch->getRole->value == 'teacher') {

                        foreach ($userBranchs as $userBranch) {

                            //# if match between target and logged in as teache rpupil
                            if ($userBranch->getBranch->id == $loggedInUserBranch->getBranch->id) {

                                //#at least same SM
                                $canViewReason .= "pupilProfile, ";
                                $isCanView = true;

                                $meAsPupilScores = $user->getMeAsPupilScores;
                                if($userBranch->getRole->value == 'pupil' && $loggedInUser->getPreviledge->pupilProfile){
                                    $canEditProfileReason .= "pupilProfile, ";
                                    $isCanEditProfile = true;
                                }

                                //#pupil dan bukan diri sendiri
                                if($userBranch->getRole->value == 'pupil' && $loggedInUser->getPreviledge->pupilScore && !$loggedInUser->isMySelf($user)){
                                    $canScoreReason .= "pupilScore, ";
                                    $isCanScore = true;//# score pupil bukan diri sndiri

                                }

                                break;
                            }
                        }
                    }
                }


                //#isIamHeadBranch
                if($loggedInUser->isMeHeadBranch()){
                    $canViewReason .= "imHeadBranch, ";
                    $isCanView = true;
                }


                //endregion untuk teacher edit pupil
                //#isMySelf
                if($loggedInUser->id == $user->id){
                    $canEditProfileReason .= "mySelf, ";
                    $isCanEditProfile = true;
                    $meAsTeacherScores =  $user->getMeAsTeacherScores;
                    $meAsPupilScores = $user->getMeAsPupilScores;
                    $isCanChangePassword = true;
                    $canChangePasswordReason.= "myself, ";
                    $canViewReason .= "myself, ";
                    $isCanView = true;

                }

                //#  previledge AllUser
                if($loggedInUser->getPreviledge->allUserProfile){
                    $canEditProfileReason .= "allUser, ";
                    $isCanEditProfile = true;
                    $canViewReason .= "alluser, ";
                    $isCanView = true;
                }

                if($loggedInUser->getPreviledge->value == 'master'){
                    $meAsTeacherScores =   $user->getMeAsTeacherScores;
                    $meAsPupilScores  = $user->getMeAsPupilScores;
                    $isCanEditNbg = true;
                    $isCanChangePassword  = true;
                    $canChangePasswordReason.= "master, ";



                }

                foreach($meAsTeacherScores as $meAsTeacherScore){
                    $meAsTeacherScore->getPupil;
                    $meAsTeacherScore->getTeacher;
                }
                foreach($meAsPupilScores as $meAsPupilScore){
                    $meAsPupilScore->getPupil;
                    $meAsPupilScore->getTeacher;
                }

                $response->data->isCanEditProfile = $isCanEditProfile;
                $response->data->isCanEditNbg = $isCanEditNbg;
                $response->data->isCanScore = $isCanScore;
                $response->data->isCanChangePassword = $isCanChangePassword;
                $response->data->isCanView = $isCanView;
                $response->data->canChangePasswordReason = $canChangePasswordReason;
                $response->data->canEditReason = $canEditProfileReason;
                $response->data->canScoreReason = $canScoreReason;
                $response->data->canViewReason = $canViewReason;

                $response->isSuccess = true;
                $response->message = "User found";


                if(!$isCanView){

                    $response->isSuccess = false;
                    $response->data = [];
                    $response->message = "Selain kepala SM atau guru sekolah minggu $user->name tidak boleh melihat detail murid";
                }

                return response()->json($response);
            }

        }


        return response()->json($response);





    }

    private function getRegisterRules($isPassword = true, $email = true){

        $rules = [
            'address'=>'required',
            'name'=>'required',
            'phone'=>'required'
        ];
        if($email){
            $rules['email'] = 'required|email';

        }
        if($isPassword){
            $rules['password'] = 'required|confirmed';

        }

        return $rules;
    }


    public function anyAutoComplete(Request $request){

        $post = (object) $request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : "";
        $post->previledge = isset($post->previledge) ? $post->previledge : "";
        $post->keyword = isset($post->keyword) ? $post->keyword : "";

        $response = new \ApiResponse();
        $response->isSuccess = false;
        $response->message = "User not found";
        $loggedInUser = \Auth::user();


        if($request->is('api/*')){

            $user = User::where('name','like',"%$post->keyword%");

            if($post->previledge != ''){
                $user->whereHas('getPreviledge',function($getPrefiledge) use ($post){
                    $getPrefiledge->where('value', $post->previledge['selector'], $post->previledge['value']);
                });
            }
            $user = $user->take(10)->get();



            $keyValue = getKeyValue($user, 'name', 'id', function($currentUser){

                if($currentUser->getPhoto){

                    $path = asset($currentUser->getPhoto->path.$currentUser->getPhoto->nameSm);
                    return "$currentUser->name <div style='width:45px;margin-left:8px; display:inline-block;'><img src='$path' style='max-width: 100%;'/></div>";
                }
            });

            return response()->json($keyValue);
        }


    }
    public function anyDetailById(Request $request){

        $post = (object) $request->all();
        $post->cmd = isset($post->cmd) ? $post->cmd : "";
        $post->previledge = isset($post->previledge) ? $post->previledge : "";
        $post->id = isset($post->id) ? $post->id : "";

        $response = new \ApiResponse();
        $response->isSuccess = false;
        $response->message = "User not found";
        $loggedInUser = \Auth::user();


        if($request->is('api/*')){

            $user = User::where('id',"$post->id");

            if($post->previledge != ''){
                $user->whereHas('getPreviledge',function($getPrefiledge) use ($post){
                    $getPrefiledge->where('value', $post->previledge['selector'], $post->previledge['value']);
                });
            }
            $user = $user->first();

            if(!$user){
                return response()->json($response);
            }





            $response->isSuccess = true;
            $response->message = "User found";
            $response->data->user = $user;

            return response()->json($response);
        }


    }


    public function getTop(){

    }



}

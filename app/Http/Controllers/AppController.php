<?php

namespace App\Http\Controllers;

use App\Model\Branch;
use App\Model\History;
use App\Model\SelectEvent;
use App\Model\Thread;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends Controller
{
    //



    public function anyTop(Request $request){




        $post = (object) $request->all();
        $post->cmbEventType = $post->cmbEventType ??  "";


        $response = new \ApiResponse();

        $loggedInUser = Auth::user();

        if($request->is('api/*')){

            $from = getDefaultDatetime('today -  5 week');
            $to = getDefaultDatetime();
            $fromCarbon = Carbon::now()->addWeek(-5);
            $activePupil = SelectEvent::getActivePupil()->getHistories->where('created_at', '>=', $from)->count();
            $offPupil = SelectEvent::getOffPupil()->getHistories->where('created_at', '>=', $from)->count();


            $histories = null;


            $isCanHistory = false;
            $canHistoryReason = "";

            if($loggedInUser->isMaster()){
                $isCanHistory = true;
                $canHistoryReason .= "Master, ";
            }


            //region history
            if($isCanHistory){
                $histories = History::where('id', '!=', '-1');
                if($post->cmbEventType != ''){
                    $histories->whereHas('getEvent',function($getEvent) use ($post) {
                        $getEvent->where('value', $post->cmbEventType);
                    });
                }
                $histories = $histories->orderBy('created_at','desc')->paginate(PER_PAGE);;
                $histories->getCollection()->transform(function($currentHistory){
                    $currentHistory->getUser;
                    $currentHistory->getEvent;
                    return $currentHistory;

                });
            }
            //endregion


            //region branchSummary
            $branchSummary = Branch::getAllBranchSummary();
            //endregion

            //region filter

            $filter = [];
            $filter['cmbEventType'][] = ['key'=>'-- All --', 'value'=>''];
            foreach(SelectEvent::all() as $select){

                $filter['cmbEventType'][] = ['key'=>$select->key, 'value'=>$select->value];
            }
            //endregion

            //region thread

            $threads = Thread::orderBy('updated_at','desc')->paginate(5);

            $threads->getCollection()->transform(function($thread) use($loggedInUser){

                //# cek if Open
                $isAlreadyRead = false;
                $openThisThread = $loggedInUser->getThreadsOpen()->where('thread_id', $thread->id)->orderBy('created_at','desc')->first();
                if($openThisThread){
                    $threadDate = strtotime($thread->updated_at);
                    $openDate = strtotime($openThisThread->pivot->created_at);

                    if( $openDate + 100 >= $threadDate){
                        $isAlreadyRead = true;
                    }
                }
                $thread->isAlreadyRead = $isAlreadyRead;



                //# get thread data
                $thread->title = getStrLimit($thread->title, 70);
                $thread->getCreator;
                $thread->getLastReply;
                $thread->firstReply =  $thread->getReplies()->orderBy('created_at','asc')->first();
                $thread->firstReply->content = getStrLimit($thread->firstReply->content);
                $thread->firstReply->getUser;
                return $thread;
            });


            //endregion

            $response->isSuccess = true;
            $response->message = "";
            $response->data->activePupil = $activePupil;
            $response->data->offPupil = $offPupil;
            $response->data->fromMe = $from;
            $response->data->fromCarbon = $fromCarbon;
            $response->data->branchSummary = $branchSummary;
            $response->data->histories = $histories;

            $response->data->isCanHistory = $isCanHistory;
            $response->data->canHistoryReason = $canHistoryReason;
            $response->data->thread = $threads;
            $response->data->filter = $filter;

            return response()->json($response);



        }

    }



}

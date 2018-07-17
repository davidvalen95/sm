<?php

namespace App\Http\Controllers;

use App\Model\Reply;
use App\Model\Thread;
use Auth;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    //





    public function anyTop(Request $request){

        $post = (object) $request->all();

        $post->cmd = $post->cmd ?? "";
        $post->id = $post->id ?? "";

        $response = new \ApiResponse();
        $loggedInUser = Auth::user();

        if($request->is('api/*')){


            if($post->cmd == 'detail'){


                $thread = Thread::find($post->id);

                if(!$thread){
                    $response->isSuccess = false;
                    $response->message = "Thread not found";

                    return response()->json($response);
                }

                //# set read
                $thread->getUsersOpen()->detach($loggedInUser);
                $thread->getUsersOpen()->sync($loggedInUser,false);


                //# get data
                $thread->getCreator->getPhoto;
                $replies = $thread->getReplies;
                foreach($replies as $reply){
                    $reply->getUser->getPhoto;
                    $reply->getUser;
                    $reply->getAttachments;
                }



                $response->data->thread = $thread;
                $response->isSuccess = true;
                $response->message = "Thread fetched";

                return response()->json($response);


            }

        }




    }


    public function anyOp(Request $request){


        $post = (object) $request->all();

        $post->cmd = $post->cmd ?? "";
        $post->id = $post->id ?? "";

        $response = new \ApiResponse();

        $loggedInUser = Auth::user();

        if($request->is('api/*')){


            if($post->cmd == "reply"){

                $this->validate($request,[
                   "content" => 'required',
                    'id' => 'required|exists:thread,id'
                ]);

                $thread = Thread::find($post->id);

                $reply = new Reply();

                $reply->content = $post->content;
                $reply->getThread()->associate($thread);
                $reply->getUser()->associate($loggedInUser);
                $reply->save();
                $thread->getLastReply()->associate($loggedInUser);
                $thread->save();

                $thread->getUsersOpen()->detach($loggedInUser);
                $thread->getUsersOpen()->sync($loggedInUser,false);


                $response->isSuccess = true;
                $response->message = "Reply saved to this thread";

                return response()->json($response);







            }


            if($post->cmd == "addThread"){


                $this->validate($request, [
                   'title' => 'required|min:20|max:70',
                   'content' => 'required|min: 50',
                ]);


                $thread = new Thread($request->all());

                $thread->getLastReply()->associate($loggedInUser);
                $thread->getCreator()->associate($loggedInUser);
                $thread->save();

                $threadReply = new Reply($request->all());
                $threadReply->getThread()->associate($thread);
                $threadReply->getUser()->associate($loggedInUser);
                $threadReply->save();


                $thread->getUsersOpen()->detach($loggedInUser);
                $thread->getUsersOpen()->sync($loggedInUser,false);

                $response->isSuccess = true;
                $response->message = "Thread with title '$post->title' created";

                return response()->json($response);
            }



        }

    }

}

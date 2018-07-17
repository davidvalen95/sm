<?php

namespace App\Http\Controllers\WebPage;

use App\Model\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    //




    public function getContact(Request $request, $branch = ""){


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
        $data['contactUsForms'] = $this->setupContactUsForms();

        return view('page.contact',$data) ;
    }


    public function setupContactUsForms(){

        $baseForms = [];


        $name = new \BaseForm("Name", "name");
        $contact = new \BaseForm("Email / no HP", "contact");
        $subject = new \BaseForm("Subject", "subject");
        $message = new \BaseForm("Message", "message","textarea");

        $baseForms[] = $name;
        $baseForms[] = $contact;
        $baseForms[] = $subject;
        $baseForms[] = $message;

        return $baseForms;

    }
}

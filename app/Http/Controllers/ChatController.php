<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Factoid;
use Illuminate\Support\Facades\Session;
use Config;
use Carbon;

class ChatController extends Controller
{

    public function chat($id){
        $person = Person::where('id', $id)->first();
        return view('chat.index',compact('person'));

    }


    public function messageOn(Request $request, $id){

        $response = $this->search(Config::get('questions'), $request->message, $id);
        
        if(!$response) return response()->json($this->identify($request->message, $id));

        if($response[0] === "simple") return response()->json($response);
        
        if($response[0] === "hard") return response()->json($response);

    }

    public function identify( $message, $userId ){

        if(request()->session()->get('questionLevel') === null){
            return ['ERROR', 'მკითხე რამე სხვა, ან შეგიძლია ნახო ჩემი კავშირები '];
        } else {
            
            $session = request()->session()->get('questionLevel');

            if(!is_numeric($message) && !strlen($message) > 2018) return ['ERROR','აირჩიე ზემოთ ჩამოთვლილი თარიღები'];

            if($session === "factoid"){    
                $person = Person::where('id', $userId)->with(['factoids' => function($query) use($message){
                    $query->whereYear('date', $message);
                  }])->first();

                  request()->session()->forget('questionLevel');
                if(!isset($person->factoids[0])){
                    return ['ERROR', 'სამწუხაროდ ინფორმაცია ვერ მოვიძიე'];
                }else{
                    return ['object',$person->factoids[0] ];
                }
                
                }else if($session === "institution"){
                $person = Person::where('id', $userId)->with(['institutions' => function($query) use($message){
                    $query->whereYear('date', $message);
                  }])->first();

                request()->session()->forget('questionLevel');

                if(!isset($person->institutions[0])){
                    return ['ERROR', 'ინფორმაცია არ მაქვს, გთხოვ სხვა კითხვით მომმართეთ'];
                }else{
                    return ['object',$person->institutions[0] ];
                }
            }
        }
        

    }

    public function search($questionsArray, $question, $userId ){        
        
        foreach($questionsArray as $key => $value){
            
            if( stristr($key,$question) ){
                if(is_array($value))
                {
                    return ['simple',$value[1]];
                }elseif($this->isQuestionType($value)){
                        $response = $this->hardResponseGenerator($value,$userId);
                        return ['hard', $response];
                    } else {
                        $response = $this->simpleResponseGenerator($value, $userId);
                        if($response)
                            return ['simple',$response];
                        else
                            return false;
                    }


            }

        }
        

    }


    private function isQuestionType($value){
        if( $value === "factoid" || $value === "institution" ){
            return true;
        }

        return false;
    }

    public function simpleResponseGenerator($value, $userId){

        $person = Person::where('id', $userId)->first();

        if($value === "type"){
            $response = $person->type->name;
        } else if($value === "status"){
            $response = $person->status->name;
        } else if($value === "occupation" || $value === "name"){
            $response = $person->{$value};            
        } else {
            return false;
        }


        //$request->session()->pull('key', 'default')

        $getSession = request()->session()->get('questionLevel');

        if(!is_null($getSession)){
            request()->session()->forget('questionLevel');
        }

        // if($getSession === 'factoid' || $getSession === 'institution'){            
        // }

        return $response;
    }

    public function hardResponseGenerator($value, $userId){
        
        \Session::put('questionLevel', $value);        


        if($value === "factoid") {

            $data['years'] = $this->factoidYears($userId);
            if(count($data['years']))
            {
                $data['text'] = "რომელი წელი გაინტერესებს ?";    
            }else
            {
                 $data['text'] = "სამწუხაროდ ჩემზე ინფორმაცია არ მოიპოვება";
                 request()->session()->forget('questionLevel');
            }

        } else if($value === "institution"){
            $data['years'] = $this->institutionYears($userId);

            if(count($data['years']))
            {
                $data['text'] = "რომელი წელი გაინტერესებს ?";    
            }else
            {
                 $data['text'] = "სამწუხაროდ ჩემზე ინფორმაცია არ მოიპოვება";
                 request()->session()->forget('questionLevel');
            }

        }
        
        return $data;
    }

    
    public function institutionYears($userId){

        $person = Person::where('id', $userId)->with(['institutions'])->first();
        
        $years = [];
        
        foreach($person->institutions as $factoid){
            if($factoid->date !== null) 
                $years[] = date('Y', strtotime($factoid->date));
        }
        $years = array_unique(array_sort_recursive($years));
        
        return $years;
    }

    public function factoidYears($userId){

        $person = Person::where('id', $userId)->with(['factoids'])->first();

        $years = [];
        
        foreach($person->factoids as $factoid){
            if($factoid->date !== null) 
                $years[] = date('Y', strtotime($factoid->date));
        }
        $years = array_unique(array_sort_recursive($years));

        return $years;
    }

    // public function sessionCheck($value){
        
    //     $session = request()->session()->get('questionLevel');

    //         if(!$session){                                
    //             $this->sessionWrite($value);
                        
    //             return $value;
    //         }

    // }

    // public function sessionWrite($value){

    //     \Session::put('questionLevel', $value);
        
    //     return true;
    // }

    public function question(Request $request){
        
        $person = $request->person;
        $question = $request->question;

        if(strpos($question, 'რამდენ ფაქტში') !== false ){
            $person = Person::find($person);
            

            is_null($person->factoids) ? $countFactoids = 0 : $countFactoids = $person->factoids->count();
            
            if($countFactoids == 0){
                $answer = "სამწუხაროდ არცერთი ფაქტი არ მოიპოვება ჩემზე. იქნებ შენ დამეხმარო და შეავსო ინფორმაცია ჩემზე.";
            } else {
                $answer = "ვმონაწილეობდი"." ".$countFactoids. " ფაქტში.";
            }
        
            dd($answer);
            
        }

    }

}

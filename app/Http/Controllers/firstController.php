<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Factoid;

class firstController extends Controller
{
    
  
  public function index(){
    // dd('dsa');

    return view('index.index');
  }


  public function filtered($request){
    $person_id = $request->person_id;
    $factoid_type_id = $request->factoid_type_id;
    $year = $request->year;

    if(is_null($person_id)){
      return false;
    }
    
    is_null($factoid_type_id) ? $factoid_type_id = null : $factoid_type_id = $factoid_type_id;
    is_null($year) ? $year = null : $year = $year;

    if($person_id) {
      $factoids = Person::findOrFail($person_id)->factoids();
    }

    if($factoid_type_id) {
      $factoids = $factoids->where('factoid_type_id', '=', $factoid_type_id);
    }

    $person = Person::where('person_type_id', '!=', null)->where('id', $person_id);
    
    if($factoid_type_id !== null){
      $person = $person->with(['factoids' => function($query) use($factoid_type_id){
        $query->where('factoid_type_id', $factoid_type_id);
      }]);
    }

    if($year !== null){
      $person = $person->with(['factoids' => function($query) use($year){
        $query->whereYear('date', $year);
      }]);
    }

    return $person->first();
  }

  public function group(Request $request){

    $person = $this->filtered($request);
    
    if(!$person) return redirect()->back();
    
    
        $firstNode = [
          'id' => $person->id,
          'label' => $person->name,
          'x' => mt_rand(0,100),
          'y' => mt_rand(0,100),
          'size' => 300,
          'color' => '#666'
        ];
        
    
        //ყველა იმ პერსონის ერთ Node-ში გაერთიანება ვინც არჩეული პერსონის ფაქტებში მონაწილეობს
        $nodes = [];   
        // dd($person->factoids);
        
        foreach($person->factoids as $i => $factoid){
          $i = 0;
          foreach($factoid->persons as $key => $prs){
            
            if($i == 0){
              $nodes[$factoid->id][0] = [
                'id' => mt_rand(0,100000).$factoid->id,
                'label' => str_limit($factoid->text, 50 ,$end = '...'),                
                'group' => $factoid->id,
                'factoid' => $factoid->id
              ];
            }            
            $i++;

            if($person->id !== $prs->id && $person->person_type_id !== null){                                      
            $nodes[$factoid->id][$key + 1] =[
              'id' => mt_rand(0,100000).$prs->id,
              'label' => $prs->name,
              'x' => mt_rand(0,100),
              'y' => mt_rand(0,100),
              'size' => rand(100,100),
              'color' => '#666',
              'group' => $factoid->id
            ];            
          }        
          }      
        }        
        
        foreach($nodes as $key => $node){
          if(count($nodes[$key]) == 1){            
            unset($nodes[$key]);
          }
        }        

        // თუ პერსონას არ აქვს ფაქტი, ან აქვს ფაქტები, მაგრამ იმ ფაქტებში მხოლოდ თვითონაა მოხსენიებული
        if(!count($nodes)){
          $mergeNode[] =[
            'id' => $person->id,
            'label' => $person->name,
            'x' => mt_rand(0,100),
            'y' => mt_rand(0,100),
            'size' => 200,
            'color' => '#666',
            'group' => 111111
          ];
    
          $mergeEdge = null;
    
          return view('network', compact('mergeEdge', 'mergeNode'));
        }
    
  
        // dd($nodes);

        $edges = [];
        foreach($nodes as $k => $node){
          $factoid = $node[0];
          foreach($node as $key => $n){
            if( count($node) > 1){
              $edges[] = [
                'id' => mt_rand(0,100000).($k+2),
                'source' => $factoid['id'],
                'target' => $n['id'],
                'color' => "#ccc"
              ];
            }
            // $edges[] = $this->edges($node, $n, $key+1);
          }
          
        }


        $mergeEdge = $edges;
        // foreach(array_filter($edges) as $edge){
        //   foreach($edge as $e)
        //     $mergeEdge[] = $e;
        // }
        // dd($mergeEdge);
        $mergeNode = [];
        foreach($nodes as $node){
          foreach($node as $n){
            if ( $this->uniqueObject($mergeNode, $n) )
              $mergeNode[] = $n;
          }
        }
        
        $mergeNode[] = [
          'id' => $person->id,
          'label' => $person->name,
          'x' => mt_rand(0,100),
          'y' => mt_rand(0,100),
          'size' => 200,
          'color' => '#666',
          'group' => 111111
        ];
    
        $newEdge = [];
    
        foreach($nodes as $key => $node){
          foreach($node as $key => $nd){
                        
            if(array_key_exists('factoid', $nd))
            $newEdge[] = [
              'id' => mt_rand()*($key+1),
              'source' => $firstNode['id'],
              'target' => $nd['id'],
              'color' => "#ccc"
            ];
          }      
        }
    
        $mergeEdge = array_merge($mergeEdge, $newEdge);        
        
        return view('network', compact('mergeEdge', 'mergeNode'));
      }
    
    
      public function edges($nodes, $node, $key){
    
        $edges = [];
        $size = count($nodes);
        // dd($nodes);
        for($i=$key; $i<$size; $i++){
          if(array_key_exists($i, $nodes)){
            $edges[] = [
              'id' => mt_rand()*($i+2),
              'source' => $node['id'],
              'target' => $nodes[$i]['id'],
              'color' => "#ccc"
            ];
          }        
        }    
        
        return $edges;
      }
    
      public function uniqueObject($nodes, $node){
      
        if(count($nodes) > 0){
          foreach($nodes as $n){
            if($node['id'] == $n['id']){
              return false;
            }
          }
        }
    
        return true;
      }
  











  public function connect(){

    $person = Person::where('person_type_id', '!=', null)->where('id', 4485)->with(['factoids'])->first();
    
    $firstNode = [
      'id' => $person->id,
      'label' => $person->name,
      'x' => mt_rand(10,200),
      'y' => mt_rand(10,200),
      'size' => 200,
      'color' => '#666'
    ];
    
    $nodes[] = json_encode($firstNode);

    foreach($person->factoids as $factoid){
      foreach($factoid->persons as $key => $prs){        
        if($person->id !== $prs->id && $person->person_type_id !== null)
        $nodes[] = json_encode( [
          'id' => $prs->id,
          'label' => $prs->name,
          'x' => mt_rand(10,200),
          'y' => mt_rand(10,200),
          'size' => rand(100,200),
          'color' => '#666'
        ]
        );        
      }      
    }
    
    // foreach($nodes as $node)
      

    $edges = [];

    foreach(array_except($nodes, 0) as $key => $node){
      $edges[] = json_encode([
        'id' => $key,
        'source' => $firstNode['id'],
        'target' => json_decode($node)->id,
        'color' => "#ccc"
      ]); 
    }

    // dd($edges);
    // dd($nodes);
    // dd(json_encode($nodes));

    json_encode($nodes);
    json_encode($edges);
    // $factoid = Factoid::whereHas('persons',function($query){            
    //   $query->where('id', 25434);
    // })->whereHas('persons',function($query){            
    //   $query->where('id', 25435);
    // })
    // ->get();
    // foreach($edges as $edge)
    // dd($edge);
    //   dd(json_decode($edge)->id);

    return view('index', compact('nodes', 'edges'));
  }

}

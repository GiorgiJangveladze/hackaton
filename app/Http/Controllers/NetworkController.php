<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Factoid;

class NetworkController extends Controller
{
    
    public function network(){
        //1657, 1973, 438
    
        //todo empty 
    
        $person = Person::where('person_type_id', '!=', null)->where('id', 438)
        ->with(['factoids'=>function($query){
          $query->whereYear('date', 1918);
        }])
        ->first();
        
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
        // dd($person->factoids->where('date', '1918'));
        foreach($person->factoids as $i => $factoid){
          foreach($factoid->persons as $key => $prs){
            if($person->id !== $prs->id && $person->person_type_id !== null)
            $nodes[$i][$key] = json_encode( [
              'id' => $prs->id,
              'label' => $prs->name,
              'x' => mt_rand(0,100),
              'y' => mt_rand(0,100),
              'size' => rand(100,100),
              'color' => '#666',
              'group' => $i
            ]
            );        
          }      
        }
    
        // თუ პერსონას არ აქვს ფაქტი, ან აქვს ფაქტები, მაგრამ იმ ფაქტებში მხოლოდ თვითონაა მოხსენიებული
        if(!count($nodes)){
          $mergeNode[] = json_encode( [
            'id' => $person->id,
            'label' => $person->name,
            'x' => mt_rand(0,100),
            'y' => mt_rand(0,100),
            'size' => 200,
            'color' => '#666',
            'group' => 111111
          ]
          );
    
          $mergeEdge = null;
    
          return view('index', compact('mergeEdge', 'mergeNode'));
        }
    
        
        $edges = [];
        foreach($nodes as $k => $node){
          foreach($node as $key => $n){
            $edges[] = $this->edges($node, $n, $key+1, $firstNode['id']);
          }
          
        }
        
        $mergeEdge = [];
        foreach(array_filter($edges) as $edge){
          foreach($edge as $e)
            $mergeEdge[] = $e;
        }
    
        $mergeNode = [];
        foreach($nodes as $node){
          foreach($node as $n){
            if ( $this->uniqueObject($mergeNode, $n) )
              $mergeNode[] = $n;
          }
        }
        
        $mergeNode[] = json_encode( [
          'id' => $person->id,
          'label' => $person->name,
          'x' => mt_rand(0,100),
          'y' => mt_rand(0,100),
          'size' => 200,
          'color' => '#666',
          'group' => $id
        ]
        );
    
        $newEdge = [];
    
        foreach($nodes as $key => $node){
          foreach($node as $nd){
            $newEdge[] = json_encode([
              'id' => mt_rand()*($key+1),
              'source' => $firstNode['id'],
              'target' => json_decode($nd)->id,
              'color' => "#ccc"
            ]);
          }      
        }
    
        $mergeEdge = array_merge($mergeEdge, $newEdge);
        // dd($mergeNode);
        return view('network', compact('mergeEdge', 'mergeNode'));
      }
    
    
      public function edges($nodes, $node, $key, $id){
    
        $edges = [];
        $size = count($nodes);
    
        for($i=$key; $i<$size; $i++){
          if(array_key_exists($i, $nodes)){
            $edges[] = json_encode([
              'id' => mt_rand()*($i+2),
              'source' => json_decode($node)->id,
              'target' => json_decode($nodes[$i])->id,
              'color' => "#ccc"
            ]);
          }        
        }    
        
        return $edges;
      }
    
      public function uniqueObject($nodes, $node){
      
        if(count($nodes) > 0){
          foreach($nodes as $n){
            if(json_decode($node)->id == json_decode($n)->id){
              return false;
            }
          }
        }
    
        return true;
      }

}

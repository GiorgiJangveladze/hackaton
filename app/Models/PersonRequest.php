<?php

namespace App\Models;

use App\Http\Requests\Person\UpdatePerson;
use Illuminate\Database\Eloquent\Builder;
use App\Logger\Logger;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;

class PersonRequest extends Model
{
  protected $table = 'person_requests';

  protected $fillable = [ 
    'name', 
    'occupation', 
    'image', 
    'person_type_id', 
    'person_status_id',
    'request_type', 
    'gender', 
  ];

  public function original()
  {
    return $this->belongsTo('App\Models\Person', 'person_id', 'id');
  }

  public function letters()
  {
    return $this->belongsToMany('App\Models\Letter', 'person_requests_to_letters', 'person_request_id', 'letter_id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function type(){
    return $this->belongsTo('App\Models\PersonType', 'person_type_id', 'id');
  }

  public function status(){
    return $this->belongsTo('App\Models\PersonStatus', 'person_status_id', 'id');
  }
  
  public function toJson($options = 0) {
    $this->load('letters');

    return json_encode([
      [ 'request_type' => $this->request_type ],
      [ 'name' => $this->name ],
      [ 'occupation' => $this->occupation ],
      [ 'letters' => $this->letters->pluck('name')->implode(', ') ],
      [ 'image' => $this->image ]
    ]);
  }

  public static function makeEditRequest(Person $person, UpdatePerson $request) {
    $user = \Auth::user();

    $input = $request->except(['image', 'letters']);

    $input['request_type'] = 'edit';
    $requestAlreadyExists = PersonRequest::where('user_id', '=', $user->id)
      ->where('person_id', '=', $person->id)
      ->where('request_type', '=', 'edit')->first();

    if($requestAlreadyExists) {
      $personRequest = $requestAlreadyExists;
      $personRequest->fill($input);
    } else {
      $personRequest = PersonRequest::create($input);
    }

    $personRequest->user()->associate($user)->save();

    $letters = $request->input('letters');
    if($letters) $personRequest->letters()->sync($letters);

    $personRequest->original()->associate($person)->save();

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $path = 'storage/' . $image->storePublicly('persons', ['disk' => 'public']);
      $personRequest->fill(['image' => $path ])->save();
      Image::make($path)->resize(320, null, function ($constraint) {
        $constraint->aspectRatio();
      })->save($path);
    }

    Logger::log("create", "personRequest", $personRequest->toJson());
  }

  public static function makeDeleteRequest(Person $person) {
    $user = \Auth::user();

    $requestAlreadyExists = PersonRequest::where('user_id', '=', $user->id)
      ->where('person_id', '=', $person->id)
      ->where('request_type', '=', 'delete')->first();

    if($requestAlreadyExists) $requestAlreadyExists->delete(); // Renew request

    $personRequest = PersonRequest::create([
      'request_type' => 'delete',
      'name' => $person['name'],
      'occupation' => $person['occupation'],
      'image' => $person['image'],
      'gender' => $person['gender']
    ]);

    $personRequest->user()->associate($user)->save();

    $letters = $person->letters->pluck('id')->toArray();
    if($letters) $personRequest->letters()->sync($letters);

    $personRequest->original()->associate($person)->save();

    Logger::log("create", "personRequest", $personRequest->toJson());
  }
}

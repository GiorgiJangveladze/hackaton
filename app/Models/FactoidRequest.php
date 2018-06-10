<?php

namespace App\Models;

use App\Http\Requests\Factoid\UpdateFactoid;
use App\Logger\Logger;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;

class FactoidRequest extends Model
{
  protected $table = 'factoid_requests';

  protected $fillable = [ 'text', 'date', 'image', 'request_type' ];

  protected $dates = [ 'date' ];

  public function original()
  {
    return $this->belongsTo('App\Models\Factoid', 'factoid_id', 'id');
  }

  public function type()
  {
    return $this->belongsTo('App\Models\FactoidType', 'factoid_type_id', 'id');
  }

  public function source()
  {
    return $this->belongsTo('App\Models\Source', 'source_id', 'id');
  }

  public function unpublishedSource()
  {
    return $this->belongsTo('App\Models\SourceRequest', 'source_request_id', 'id');
  }

  public function persons()
  {
    return $this->belongsToMany('App\Models\Person', 'factoid_requests_to_persons', 'factoid_request_id', 'person_id');
  }

  public function unpublishedPersons()
  {
    return $this->belongsToMany('App\Models\PersonRequest', 'factoid_requests_to_persons', 'factoid_request_id', 'person_request_id');
  }

  public function places()
  {
    return $this->belongsToMany('App\Models\Place', 'factoid_requests_to_places', 'factoid_request_id', 'place_id');
  }

  public function unpublishedPlaces()
  {
    return $this->belongsToMany('App\Models\Place', 'factoid_requests_to_places', 'factoid_request_id', 'place_request_id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function toJson($options = 0) {
    $this->load('type');
    $this->load('source');
    $this->load('persons');
    $this->load('places');

    return json_encode([
      [ 'text' => $this->text ],
      [ 'date' => $this->date ? $this->date->format('Y-m-d') : '-' ],
      [ 'places' => $this->places ? $this->places->pluck('name')->implode(', ') : '-'],
      [ 'type' => $this->type ? $this->type->name : '-'],
      [ 'source' => $this->source ? $this->source->name : '-'],
      [ 'persons' => $this->persons ? $this->persons->pluck('name')->implode(', ') : '-'],
      [ 'image' => $this->image ]
    ]);
  }

  public static function makeEditRequest(Factoid $factoid, UpdateFactoid $request) {
    $user = \Auth::user();

    $input = $request->only(['text', 'date']);

    $input['request_type'] = 'edit';
    $requestAlreadyExists = FactoidRequest::where('user_id', '=', $user->id)
      ->where('factoid_id', '=', $factoid->id)
      ->where('request_type', '=', 'edit')->first();

    if($requestAlreadyExists) {
      $factoidRequest = $requestAlreadyExists;
    } else {
      $factoidRequest = new FactoidRequest();
    }

    $factoidRequest->fill($input);

    $factoidRequest->user()->associate($user);

    $factoidRequest->type()->associate($request->input('factoid_type_id'));
    $factoidRequest->source()->associate($request->input('source_id'));

    $factoidRequest->original()->associate($factoid)->save();

    $places = $request->input('places');
    if ($places) $factoidRequest->places()->sync($places);

    $persons = $request->input('persons');
    if ($persons) $factoidRequest->persons()->sync($persons);

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $path = 'storage/' . $image->storePublicly('factoids', ['disk' => 'public']);
      $factoidRequest->fill(['image' => $path ])->save();
      Image::make($path)->resize(320, null, function ($constraint) {
        $constraint->aspectRatio();
      })->save($path);
    }

    Logger::log("create", "factoidRequest", $factoidRequest->toJson());
  }

  public static function makeDeleteRequest(Factoid $factoid) {
    $user = \Auth::user();

    $requestAlreadyExists = FactoidRequest::where('user_id', '=', $user->id)
      ->where('factoid_id', '=', $factoid->id)
      ->where('request_type', '=', 'delete')->first();

    if($requestAlreadyExists) $requestAlreadyExists->delete(); // Renew request

    $factoidRequest = new FactoidRequest();
    $data = [
      'request_type' => 'delete'
    ];
    foreach($factoid['fillable'] as $field) $data[$field] = $factoid->$field;
    $factoidRequest->fill($data);

    $factoidRequest->type()->associate($factoid->factoid_type_id);
    $factoidRequest->source()->associate($factoid->source_id);

    $factoidRequest->user()->associate($user);

    $factoidRequest->original()->associate($factoid)->save();

    $places = $factoid->places->pluck('id')->toArray();
    if ($places) $factoidRequest->places()->sync($places);

    $persons = $factoid->persons->pluck('id')->toArray();
    if ($persons) $factoidRequest->persons()->sync($persons);

    Logger::log("create", "factoidRequest", $factoidRequest->toJson());
  }
}

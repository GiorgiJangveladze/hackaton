<?php

namespace App\Models;

use App\Http\Requests\Place\UpdatePlace;
use App\Logger\Logger;
use Illuminate\Database\Eloquent\Model;

class PlaceRequest extends Model
{
  protected $table = 'place_requests';

  protected $fillable = [ 'name', 'description', 'lat', 'lng', 'zoom', 'note', 'request_type' ];

  public function original()
  {
    return $this->belongsTo('App\Models\Place', 'place_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function toJson($options = 0) {
    return json_encode([
      [ 'request_type' => $this->request_type ],
      [ 'name' => $this->name ],
      [ 'description' => $this->description ],
      [ 'note' => $this->note ],
      [ 'map' => [
        'lat' => $this->lat,
        'lng' => $this->lng,
        'zoom' => $this->zoom
      ]
      ]
    ]);
  }

  public static function makeEditRequest(Place $place, UpdatePlace $request) {
    $user = \Auth::user();

    $input = $request->all();

    $input['request_type'] = 'edit';
    $requestAlreadyExists = PlaceRequest::where('user_id', '=', $user->id)
      ->where('place_id', '=', $place->id)
      ->where('request_type', '=', 'edit')->first();

    if($requestAlreadyExists) {
      $placeRequest = $requestAlreadyExists;
      $placeRequest->fill($input);
    } else {
      $placeRequest = PlaceRequest::create($input);
    }

    $placeRequest->user()->associate($user)->save();

    $placeRequest->original()->associate($place)->save();

    Logger::log("create", "placeRequest", $placeRequest->toJson());
  }

  public static function makeDeleteRequest(Place $place) {
    $user = \Auth::user();

    $requestAlreadyExists = PlaceRequest::where('user_id', '=', $user->id)
      ->where('place_id', '=', $place->id)
      ->where('request_type', '=', 'delete')->first();

    if($requestAlreadyExists) $requestAlreadyExists->delete(); // Renew request

    $placeRequest = PlaceRequest::create([
      'request_type' => 'delete',
      'name' => $place['name'],
      'description' => $place['description'],
      'note' => $place['note'],
      'lat' => $place['lat'],
      'lng' => $place['lng'],
      'zoom' => $place['zoom'],
    ]);

    $placeRequest->user()->associate($user)->save();

    $placeRequest->original()->associate($place)->save();

    Logger::log("create", "placeRequest", $placeRequest->toJson());
  }
}

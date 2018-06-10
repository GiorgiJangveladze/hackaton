<?php

namespace App\Models;

use App\Http\Requests\Source\UpdateSource;
use App\Logger\Logger;
use Illuminate\Database\Eloquent\Model;

class SourceRequest extends Model
{
  protected $table = 'source_requests';

  protected $fillable = [
    'name', 'date', 'publish_number', 'publish_place', 'language', 'publisher', 'code', 'comment', 'link',
    'page_count', 'page_number', 'request_type'
  ];

  protected $dates = [ 'date' ];

  public function original()
  {
    return $this->belongsTo('App\Models\Source', 'source_id', 'id');
  }

  public function type()
  {
    return $this->belongsTo('App\Models\SourceType', 'source_type_id', 'id');
  }

  public function authority()
  {
    return $this->belongsTo('App\Models\Authority', 'authority_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function toJson($options = 0) {
    $this->load('type');
    $this->load('authority');

    return json_encode([
      [ 'request_type' => $this->request_type ],
      [ 'name' => $this->name ],
      [ 'type' => $this->type->name ],
      [ 'date' => $this->date ? $this->date->format('Y-m-d') : '-' ],
      [ 'publish_number' => $this->publish_number ],
      [ 'page_count' => $this->page_count ],
      [ 'page_number' => $this->page_number ],
      [ 'publish_place' => $this->publish_place ],
      [ 'language' => $this->language ],
      [ 'publisher' => $this->publisher ],
      [ 'authority' => $this->authority->name ],
      [ 'code' => $this->code ],
      [ 'comment' => $this->comment ],
      [ 'link' => $this->link ]
    ]);
  }

  public static function makeEditRequest(Source $source, UpdateSource $request) {
    $user = \Auth::user();

    $input = $request->except(['source_type_id', 'authority_id']);

    $input['request_type'] = 'edit';
    $requestAlreadyExists = SourceRequest::where('user_id', '=', $user->id)
      ->where('source_id', '=', $source->id)
      ->where('request_type', '=', 'edit')->first();

    if($requestAlreadyExists) {
      $sourceRequest = $requestAlreadyExists;
      $sourceRequest->fill($input);
    } else {
      $sourceRequest = new SourceRequest();
      $sourceRequest->fill($input);
    }

    $sourceRequest->user()->associate($user);

    $sourceRequest->type()->associate($request->input('source_type_id'));
    $sourceRequest->authority()->associate($request->input('authority_id'));

    $sourceRequest->original()->associate($source)->save();

    Logger::log("create", "sourceRequest", $sourceRequest->toJson());
  }

  public static function makeDeleteRequest(Source $source) {
    $user = \Auth::user();

    $requestAlreadyExists = SourceRequest::where('user_id', '=', $user->id)
      ->where('source_id', '=', $source->id)
      ->where('request_type', '=', 'delete')->first();

    if($requestAlreadyExists) $requestAlreadyExists->delete(); // Renew request

    $sourceRequest = new SourceRequest();
    $sourceRequest->fill([
      'request_type' => 'delete',
      'name' => $source['name'],
      'date' => $source['date'],
      'publish_number' => $source['publish_number'],
      'publish_place' => $source['publish_place'],
      'page_count' => $source['page_count'],
      'page_number' => $source['page_number'],
      'language' => $source['language'],
      'publisher' => $source['publisher'],
      'code' => $source['code'],
      'comment' => $source['comment'],
      'link' => $source['link']
    ]);

    $sourceRequest->user()->associate($user);

    $sourceRequest->type()->associate($source->type);
    $sourceRequest->authority()->associate($source->authority);

    $sourceRequest->original()->associate($source)->save();

    Logger::log("create", "sourceRequest", $sourceRequest->toJson());
  }
}

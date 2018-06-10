<?php

namespace App\Models;

use App\Http\Requests\Glossary\UpdateGlossary;
use App\Logger\Logger;
use Illuminate\Database\Eloquent\Model;

class GlossaryRequest extends Model
{
  protected $table = 'glossary_requests';

  protected $fillable = [ 'word', 'definition', 'request_type' ];

  public function original()
  {
    return $this->belongsTo('App\Models\Glossary', 'glossary_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function toJson($options = 0) {
    return json_encode([
      [ 'request_type' => $this->request_type ],
      [ 'word' => $this->word ],
      [ 'definition' => $this->definition ]
    ]);
  }

  public static function makeEditRequest(Glossary $glossary, UpdateGlossary $request) {
    $user = \Auth::user();

    $input = $request->all();

    $input['request_type'] = 'edit';
    $requestAlreadyExists = GlossaryRequest::where('user_id', '=', $user->id)
      ->where('glossary_id', '=', $glossary->id)
      ->where('request_type', '=', 'edit')->first();

    if($requestAlreadyExists) {
      $glossaryRequest = $requestAlreadyExists;
      $glossaryRequest->fill($input);
    } else {
      $glossaryRequest = GlossaryRequest::create($input);
    }

    $glossaryRequest->user()->associate($user)->save();

    $glossaryRequest->original()->associate($glossary)->save();

    Logger::log("create", "glossaryRequest", $glossaryRequest->toJson());
  }

  public static function makeDeleteRequest(Glossary $glossary) {
    $user = \Auth::user();

    $requestAlreadyExists = GlossaryRequest::where('user_id', '=', $user->id)
      ->where('glossary_id', '=', $glossary->id)
      ->where('request_type', '=', 'delete')->first();

    if($requestAlreadyExists) $requestAlreadyExists->delete(); // Renew request

    $glossaryRequest = GlossaryRequest::create([
      'request_type' => 'delete',
      'word' => $glossary['word'],
      'definition' => $glossary['definition']
    ]);

    $glossaryRequest->user()->associate($user)->save();

    $glossaryRequest->original()->associate($glossary)->save();

    Logger::log("create", "glossaryRequest", $glossaryRequest->toJson());
  }
}

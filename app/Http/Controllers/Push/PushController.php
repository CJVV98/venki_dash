<?php

namespace App\Http\Controllers\Push;

use App\Device;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Traits\MessagePush;
use Illuminate\Http\Request;

class PushController extends ApiController
{
  use MessagePush;

  public function sendPush(Request $request)
  {
    $tokens = [];
    $tokens = Device::all()->pluck('code')->toArray();
    $this->notificationPush($request->message, $request->title, $tokens);

    return $this->api_success(["message" => "Push enviado"]);
  }
}

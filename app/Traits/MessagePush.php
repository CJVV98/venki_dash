<?php

/**
 * Created by PhpStorm.
 * User: ricar
 * Date: 26/03/2019
 * Time: 1:29 PM
 */

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;


trait MessagePush
{
    protected function sendPush($message, $deviceToken, $name = "Usuario")
    {
        try {
            $messaging = app('firebase.messaging');
            $title = $name . " dice: ";
            $body = $message;

            $notification = Notification::fromArray([
                'title' => $title,
                'body' => $body,
            ]);
            $message = CloudMessage::withTarget('token', $deviceToken)
                ->withNotification($notification)
                ->withData(["id" => "mensaje"]);

            $messaging->send($message);
        } catch (NotFound $th) {
            Log::error($th);
        }
    }

    protected function notificationPush($message, $title, $tokens)
    {
        try {
            $messaging = app('firebase.messaging');
            $title = $title;
            $body = $message;

            $notification = Notification::fromArray([
                'title' => $title,
                'body' => $body,
            ]);
            $message = CloudMessage::new()->withNotification($notification);
            $messaging->sendMulticast($message, $tokens);
        } catch (NotFound $th) {
            Log::error($th);
        }
    }
}

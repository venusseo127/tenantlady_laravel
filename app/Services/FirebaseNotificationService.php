<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    public function __construct(
        protected ?Messaging $messaging = null
    ) {
        try {
            $this->messaging = app('firebase.messaging');
        } catch (\Throwable $e) {
            Log::warning('Firebase Messaging not configured: ' . $e->getMessage());
        }
    }

    public function sendToUser(User $user, string $title, string $body, array $data = []): bool
    {
        if (!$user->fcm_token || !$this->messaging) {
            return false;
        }

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::withTarget('token', $user->fcm_token)
                ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);
            return true;
        } catch (\Throwable $e) {
            Log::error('FCM send failed: ' . $e->getMessage());
            return false;
        }
    }

    public function sendToTokens(array $tokens, string $title, string $body, array $data = []): bool
    {
        $tokens = array_filter(array_unique($tokens));
        if (empty($tokens) || !$this->messaging) {
            return false;
        }

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data);

            $report = $this->messaging->sendMulticast($message, $tokens);
            return $report->successes()->count() > 0;
        } catch (\Throwable $e) {
            Log::error('FCM multicast failed: ' . $e->getMessage());
            return false;
        }
    }
}

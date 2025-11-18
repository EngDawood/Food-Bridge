<?php

namespace App\Contracts\Services;

use App\Models\SystemNotification;

interface NotificationServiceInterface
{
    public function send(int $userId, string $message, string $type = 'update'): SystemNotification;

    public function markAsRead(int $notificationId): void;

    public function listForUser(int $userId, int $perPage = 15);
}


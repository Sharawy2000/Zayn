<?php
namespace App\Repositories\SQL;

use App\Models\Notification;
use App\Repositories\Contract\NotificationRepositoryInterface;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    protected $notification;

    public function __construct(Notification $notification){
        parent::__construct($notification);
        $this->notification = $notification;
    }
    
}
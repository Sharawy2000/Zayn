<?php 
namespace App\Services;

use App\Repositories\Contract\NotificationRepositoryInterface;

class NotificationService extends BaseService
{
    protected $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository){
        parent::__construct($notificationRepository);
        $this->notificationRepository=$notificationRepository;
    }
}
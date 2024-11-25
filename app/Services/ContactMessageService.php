<?php 
namespace App\Services;

use App\Repositories\Contract\ContactMessageRepositoryInterface;

class ContactMessageService extends BaseService
{
    protected $contactMessageRepository;

    public function __construct(ContactMessageRepositoryInterface $contactMessageRepository){
        parent::__construct($contactMessageRepository);
        $this->contactMessageRepository=$contactMessageRepository;
    }
}
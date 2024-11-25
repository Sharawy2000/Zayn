<?php
namespace App\Repositories\SQL;

use App\Models\ContactMessage;
use App\Repositories\Contract\ContactMessageRepositoryInterface;

class ContactMessageRepository extends BaseRepository implements ContactMessageRepositoryInterface
{
    protected $contactMessage;

    public function __construct(ContactMessage $contactMessage){
        parent::__construct($contactMessage);
        $this->contactMessage = $contactMessage;
    }
    
}
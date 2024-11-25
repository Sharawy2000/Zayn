<?php 
namespace App\Services;

use App\Repositories\Contract\SettingRepositoryInterface;

class SettingService extends BaseService
{
    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository){
        parent::__construct($settingRepository);
        $this->settingRepository=$settingRepository;
    }

    
    
    
}
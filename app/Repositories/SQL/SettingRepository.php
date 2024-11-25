<?php
namespace App\Repositories\SQL;

use App\Models\Setting;
use App\Repositories\Contract\SettingRepositoryInterface;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    protected $setting;

    public function __construct(Setting $setting){
        parent::__construct($setting);
        $this->setting = $setting;
    }
    
}
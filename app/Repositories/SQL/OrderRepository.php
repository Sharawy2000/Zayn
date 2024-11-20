<?php
namespace App\Repositories\SQL;

use App\Models\Order;
use App\Repositories\Contract\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected $order;

    public function __construct(Order $order){
        parent::__construct($order);
        $this->order = $order;
    }
    
}
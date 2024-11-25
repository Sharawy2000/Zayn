<?php
namespace App\Repositories\SQL;

use App\Models\PaymentMethod;
use App\Repositories\Contract\PaymentMethodRepositoryInterface;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodRepositoryInterface
{
    protected $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod){
        parent::__construct($paymentMethod);
        $this->paymentMethod = $paymentMethod;
    }
    
}
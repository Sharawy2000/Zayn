<?php 
namespace App\Services;

use App\Repositories\Contract\PaymentMethodRepositoryInterface;

class PaymentMethodService extends BaseService
{
    protected $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository){
        parent::__construct($paymentMethodRepository);
        $this->paymentMethodRepository=$paymentMethodRepository;
    }

    
    
    
}
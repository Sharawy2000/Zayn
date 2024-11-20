<?php

namespace App\Enums;

enum OrderStatus:int
{
    case Pending = 0;
    case Accepted = 1;
    case Rejected = 2;
    case Received = 3;
    case Cancelled = 4;
    case Delivered = 5;
    
}

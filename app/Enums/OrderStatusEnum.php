<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case CREATED = 'Created';

    case COMPLETED = 'Completed';

    case CANCELLED = 'Cancelled';
}

<?php

namespace App\Enums;

enum PlateRequestStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Issued = 'issued';
    case Rejected = 'rejected';
}
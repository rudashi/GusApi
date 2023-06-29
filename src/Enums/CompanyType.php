<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Enums;

enum CompanyType: string
{
    case COMPANY = 'P';
    case PERSON = 'F';
    case LOCAL_COMPANY = 'LP';
    case LOCAL_PERSON = 'LF';
}

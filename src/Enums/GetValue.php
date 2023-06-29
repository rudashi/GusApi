<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Enums;

enum GetValue: string
{
    case DATA_STATUS = 'StanDanych';
    case MESSAGE_CODE = 'KomunikatKod';
    case MESSAGE_CONTENT = 'KomunikatTresc';
    case SESSION_STATUS = 'StatusSesji';
    case SERVICE_STATUS = 'StatusUslugi';
    case SERVICE_MESSAGE = 'KomunikatUslugi';
}

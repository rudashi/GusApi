<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Enums;

use Rudashi\GusApi\Services\FullReport;
use Rudashi\GusApi\Services\GetValue;
use Rudashi\GusApi\Services\Login;
use Rudashi\GusApi\Services\Logout;
use Rudashi\GusApi\Services\SearchData;
use Rudashi\GusApi\Services\Soap\SoapCallInterface;

enum Action: string
{
    case LOGIN = 'Zaloguj';
    case LOGOUT = 'Wyloguj';
    case GET_VALUE = 'GetValue';
    case SEARCH_DATA = 'DaneSzukajPodmioty';
    case FULL_REPORT = 'DanePobierzPelnyRaport';
    //    case BULK_REPORT = 'DanePobierzRaportZbiorczy';

    public function service(): SoapCallInterface
    {
        return match ($this) {
            self::LOGIN => new Login($this),
            self::LOGOUT => new Logout($this),
            self::GET_VALUE => new GetValue($this),
            self::SEARCH_DATA => new SearchData($this),
            self::FULL_REPORT => new FullReport($this),
        };
    }
}

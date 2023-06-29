<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Enums;

enum RequestParameter: string
{
    case USER_KEY = 'pKluczUzytkownika';
    case SESSION_ID = 'pIdentyfikatorSesji';
    case PARAM_NAME = 'pNazwaParametru';
    case SEARCH = 'pParametryWyszukiwania';
    case REGON = 'pRegon';
    case REPORT_NAME = 'pNazwaRaportu';
    case REPORT_DATE = 'pDataRaportu';
}

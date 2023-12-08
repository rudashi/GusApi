# PHP GUS API
![GitHub](https://img.shields.io/github/license/rudashi/gusapi)
![GitHub repo size](https://img.shields.io/github/repo-size/rudashi/gusapi)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/rudashi/GusApi/php.yml)

PHP GUS API is a wrapper to get information from [Portal API GUS](https://api.stat.gov.pl/Home/RegonApi) based on official BIR1 API.  
Official API REGON [documentation](https://api.stat.gov.pl/Home/RegonApi#menu3).

## Installation
Use [Composer](https://getcomposer.org/), to install:

```bash
composer require rudashi/gusapi
```

## Supported Versions
| Version | PHP version | BIR service version               |
|---------|-------------|-----------------------------------|
| 1.x     | ^8.1        | BIR1.1 (available since May 2019) |
| ---     | ---         | BIR1 (available from 2015)        |


## General usage

```php
$api = new \Rudashi\GusApi\GusApi('GUS API KEY');

$company = $api->login()->getByNip('xxx');

$api->logout();
```

## Methods
| BIR Method                | Parameter       | PHP method        | Description                                                                            |
|---------------------------|-----------------|-------------------|----------------------------------------------------------------------------------------|
| Zaloguj                   |                 | login             | Login with user key                                                                    |
| Wyloguj                   |                 | logout            | Termination of session activity                                                        |
| ---                       |                 | isLogged          | Verification if the user is logged in                                                  |
| ---                       |                 | getSessionId      | Returns the session identifier                                                         |
| ---                       |                 | setSessionId      | Sets the session identifier                                                            |
| DaneSzukajPodmioty        | Krs             | getByKrs          | Searches the REGON database looking for a record by KRS identifier                     |
| DaneSzukajPodmioty        | Krsy            | getByKrses        | Searches the REGON database looking for records using several KRS identifiers          |
| DaneSzukajPodmioty        | Nip             | getByNip          | Searches the REGON database looking for a record by NIP identifier                     |
| DaneSzukajPodmioty        | Nipy            | getByNips         | Searches the REGON database looking for records using several NIP identifiers          |
| DaneSzukajPodmioty        | Regon           | getByRegon        | Searches the REGON database looking for a record by REGON identifier                   |
| DaneSzukajPodmioty        | Regony14zn      | getByRegons       | Searches the REGON database looking for records using several 9char REGON identifiers  |
| DaneSzukajPodmioty        | Regony9zn       | getByRegons14     | Searches the REGON database looking for records using several 14char REGON identifiers |
| DanePobierzPelnyRaport    |                 | getFullReport     | Fetches data regarding an activity registered in CEIDG or a legal entity               |
| DanePobierzRaportZbiorczy |                 | ---               | ---                                                                                    |
| GetValue                  | StanDanych      | dataStatus        | Returns the status date                                                                |
| GetValue                  | KomunikatKod    | getMessageCode    | Returns the message code                                                               |
| GetValue                  | KomunikatTresc  | ---               | ---                                                                                    |
| GetValue                  | StatusSesji     | getSessionStatus  | Returns the session status                                                             |
| GetValue                  | StatusUslugi    | getServiceStatus  | Returns the service status                                                             |
| GetValue                  | KomunikatUslugi | getServiceMessage | Returns the service message                                                            |

## Authors
* **Borys Żmuda** - Lead designer - [LinkedIn](https://www.linkedin.com/in/boryszmuda/), [Portfolio](https://rudashi.github.io/)

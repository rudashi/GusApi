# PHP GUS API
![GitHub](https://img.shields.io/github/license/rudashi/gusapi)
![GitHub repo size](https://img.shields.io/github/repo-size/rudashi/gusapi)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/rudashi/gusapi/build)

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

## Authors
* **Borys Żmuda** - Lead designer - [LinkedIn](https://www.linkedin.com/in/boryszmuda/), [Portfolio](https://rudashi.github.io/)

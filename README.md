# DNS Checker
Application to analyze dns information ...

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cloudtux/dns/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cloudtux/dns/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/cloudtux/dns/badges/build.png?b=master)](https://scrutinizer-ci.com/g/cloudtux/dns/build-status/master)
[![Maintainability](https://api.codeclimate.com/v1/badges/d5ca0577dfdb1d14ff2d/maintainability)](https://codeclimate.com/github/cloudtux/dns/maintainability)

## Analyse a web page using Laravel framework

```php
<?php 
use Cloudtux\Dns\Dns;

class MyController
{

    private $dns;

    public function __construct(Dns $dns)
    {
        $this->dns = $dns;
    }

    public function index(Request $request)
    {

        $dns = $this->dns->analyze($request->get('url'));

        return response()->json($dns);

    }

}

```

## Analyse a web page without framework

```php
<?php
$dns = new Cloudtux\Dns\Dns();
header('Content-Type: application/json');
echo json_encode($dns->analyze('github.com'));
````
# DNS Checker
Application to analyze dns information ...

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
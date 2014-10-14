IsTor?
======

Detect whether a visitor is accessing your site from the Tor network.

```php
$filename = sys_get_temp_dir() . '/ips.ip';
$ip = $_SERVER['REMOTE_ADDR'];

$storage = new Storage\FileStorage;
$engine = new Engine;
$subscriptions = new Subscriptions($engine, $storage);
$assessor = new Assessor($engine, $storage);

//This needs to be run from within a cron job so that the file is kept up to date
//ip address of the server
$ip = '11.12.13.14';
$subscriptions->addSubscription(new Tor($ip))
              ->setName($filename)
              ->retrieve();


//This needs to be ran on each of the
$ip = $_SERVER['REMOTE_ADDR'];

if ($assessor->setName($filename)->isTor($ip)) {
    //the current visitor is accessing your site through the Tor network
}

//the current visitor is not accessing your site through the Tor network
```

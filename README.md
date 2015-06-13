IsTor?
======

Detect whether a visitor is accessing your site from the Tor network.

Usage
=====

Getting the Tor ip addresses
```php
$filename = sys_get_temp_dir() . '/ips.ip';
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
```

Checking the user
```php
$filename = sys_get_temp_dir() . '/ips.ip';
$storage = new Storage\FileStorage;
$engine = new Engine;
$subscriptions = new Subscriptions($engine, $storage);
$assessor = new Assessor($engine, $storage);

//This needs to be ran on each of the requests that are received from users
//Ideally the isTor method responses can be cached in APC (or other caching system)
$ip = $_SERVER['REMOTE_ADDR'];

if ($assessor->setStorageName($filename)->isTor($ip)) {
    //the current visitor is accessing your site through the Tor network
}

//the current visitor is not accessing your site through the Tor network
```


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/mic2100/is-tor/trend.png)](https://bitdeli.com/free "Bitdeli Badge")


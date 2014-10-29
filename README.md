# CSP nonce-source for PHP

[![Build Status](https://travis-ci.org/kenjis/php-csp-nonce-source.svg?branch=master)](https://travis-ci.org/kenjis/php-csp-nonce-source)
[![Code Coverage](https://scrutinizer-ci.com/g/kenjis/php-csp-nonce-source/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/kenjis/php-csp-nonce-source/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kenjis/php-csp-nonce-source/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kenjis/php-csp-nonce-source/?branch=master)

CSP (Content Security Policy) nonce-source library for PHP.

## What is CSP nonce-source?

It is one of CSP 2 features to prevent XSS.

If you don't know, please see [CSP for the web we have | Mozilla Security Blog](https://blog.mozilla.org/security/2014/10/04/csp-for-the-web-we-have/).

## Requirement

* PHP 5.4 or lator

## Installation

~~~
$ git clone https://github.com/kenjis/php-csp-nonce-source.git
$ cd php-csp-nonce-source
$ composer install
~~~

## How to use

~~~php
<?php
require __DIR__ . '/bootstrap.php';
Csp::sendHeader();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sample of CSP nonce-source</title>
</head>
<body>

<script type="text/javascript" nonce="<?= Csp::getNonce() ?>">
    alert('This works!');
</script>

<script type="text/javascript">
    alert('This does not work!');
</script>

</body>
</html>
~~~

You can test it with PHP built-in web server.

~~~
$ php -S localhost:8000
~~~

And browse <http://localhost:8000/>.

You can see CSP violation report in `csp-report.log` file.

### (Optional) Add other polices

~~~php
require __DIR__ . '/bootstrap.php';
Csp::addPolicy('default-src', 'self');
Csp::addPolicy('default-src', 'http://example.com');
Csp::sendHeader();
~~~

### (Optional) Report Only

~~~php
require __DIR__ . '/bootstrap.php';
Csp::addPolicy('default-src', 'self');
Csp::setReportOnly();
Csp::sendHeader();
~~~

You can see CSP violation report in `csp-report.log` file.

## License

MIT License. See LICENSE.md.

## Reference

* Content Security Policy Level 2 http://www.w3.org/TR/2014/WD-CSP2-20140703/
* Firefox Notes Version 31.0 https://www.mozilla.org/en-US/mobile/31.0/releasenotes/
* CSP for the web we have | Mozilla Security Blog https://blog.mozilla.org/security/2014/10/04/csp-for-the-web-we-have/

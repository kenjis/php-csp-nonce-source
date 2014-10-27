# PHP Sample of CSP nonce-source

A PHP Sample of CSP (Content Security Policy) nonce-source.

## Requirement

* PHP 5.4 or lator

## How to use

~~~php
<?php
require __DIR__ . '/bootstrap.php';
Csp::setHeader();
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

## License

MIT License. See LICENSE.md.

## Reference

* Content Security Policy Level 2 http://www.w3.org/TR/2014/WD-CSP2-20140703/
* Firefox Notes Version 31.0 https://www.mozilla.org/en-US/mobile/31.0/releasenotes/

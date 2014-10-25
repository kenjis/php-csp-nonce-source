<?php
require __DIR__ . '/vendor/autoload.php';
header("Content-Security-Policy: script-src 'nonce-sXXD/nluT6AqhuVwL0IJqA=='");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sample of CSP nonce-source</title>
</head>
<body>

<script type="text/javascript" nonce="sXXD/nluT6AqhuVwL0IJqA==">
    alert('This works!');
</script>

<script type="text/javascript">
    alert('This does not work!');
</script>

<?php
$classifier = new \Woothee\Classifier;
$r = $classifier->parse($_SERVER['HTTP_USER_AGENT']);
var_dump($r);
?>

</body>
</html>

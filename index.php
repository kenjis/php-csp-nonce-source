<?php
require __DIR__ . '/Csp.php';
Csp::setHeader();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sample of CSP nonce-source</title>
</head>
<body>
<div>

<?php
if (isset($_GET['username'])) {
    echo 'Your name is ' . $_GET['username'] . '.' . "\n";
?>
<script type="text/javascript" nonce="<?= Csp::getNonce() ?>">
alert('This works!');
</script>
<?php
}
?>

<form action="index.php">
name: <input type="text" name="username">
<input type="submit">
</form>
</div>
</body>
</html>

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

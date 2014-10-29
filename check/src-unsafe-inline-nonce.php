<?php
header("Content-Security-Policy: script-src 'unsafe-inline' 'nonce-sXXD/nluT6AqhuVwL0IJqA=='; report-uri /csp-report.php");
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

<a href="./">Back</a>
</body>
</html>

<?php
require_once './vendor/autoload.php';

use App\v1\App;
use Database\v1\Database;

$app = new App();
$database = new Database();

$logs = $app->getLogs('20210123');
$database->insert($logs);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<pre>
    <?php
    echo print_r($logs);
    ?>
</pre>
</body>
</html>


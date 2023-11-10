<html>

<body>
    <?php
    date_default_timezone_set("Asia/Tehran");
    echo date("Y-M-d D h:i:s");
    $time=10000000;
    echo "<br/>";
    echo date("Y-M-d D h:i:s",$time-86400);
     ?>
</body>

</html>
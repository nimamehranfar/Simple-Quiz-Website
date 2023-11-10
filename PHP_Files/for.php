<html>
    <body>
        <?php
        
        echo "<table style='border:solid 1px black' >";
        for($i=1;$i<=10;$i++)
        {
            echo "<tr>";
            for($j=1;$j<=10;$j++)
                echo "<td style='border:solid 1px black'>" . $i*$j . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        ?>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
<?php
    function listStuff($num1, $num2)
    {
        echo '<ul>';
            for($i=1;$num1>=$i;$i++)
            {
                echo"\n<li>$i</li>";
                echo"\n<ul>";
                for($j=1;$num2>=$j;$j++)
                {
                    echo"\n<li>$j</li>";
                }
                echo"</ul>";
            }
        echo '</ul>';
    }
?>
    <head>
        <title>Nested List</title>
    </head>
    <body>
        <?php 
        echo listStuff(4, 5)
        ?> 

    </body>
</html>
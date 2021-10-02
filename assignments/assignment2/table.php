<!DOCTYPE html>
<html lang="en">
<?php
    function makeTable($numRows, $numCells)
    {
        echo '<table border="1">';
            for($i=1;$numRows>=$i;$i++)
            {
               echo"<tr>";
                for($j=1;$numCells>=$j;$j++)
                {
                    echo"<td>Row $i Cell $j</td>";
                }
               echo"</tr>";
            }
        echo '</table>';
    }
?>
    <head>
        <title>Nested List</title>
    </head>
    <body>
        <?php 
        echo makeTable(15, 5)
        ?> 

    </body>
</html>
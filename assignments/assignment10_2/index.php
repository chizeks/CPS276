<?php
require_once('pages/routes.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Final Project</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" 
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
              crossorigin="anonymous">
    </head>
    <body class="container p-3 my-3">
        <?php   //make html
            echo $nav;        //navigation stuff
            echo $result[0];  //page banner
            echo $result[1];  //page content
        ?>
    </body>
</html> 

<?php
if(!empty($_GET))
    {
        if($_GET['page']==="login")
        {
             //go to login page
            $result[0]="login.php";
        }   
        else if($_GET['page']=== "display")
        {  
             $result[0]="displayRecords.php";
        }   
        else if($_GET['page']==="form")
        {   
             $result[0]="form.php";
        }
        else
        {
            $result[0]='login.php';
        }
    }
    else
    {
        $result[0]='login.php';
    }
?>
<!doctype html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Assignment 10</title>
    </head>
    <body>
    
        <a href="index.php?page=login"></a>
        <?php
            include($result[0]);
        ?>
    </body>

</html>
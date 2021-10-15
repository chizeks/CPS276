<?php

class AddNames
    {

        function addNames()
        {
        if(isset($_POST['addName']))
        {
            $namesList=$_POST['namelist'];
            $aName=$_POST['addName'];
           
            $namesList.="{$aName}\n";
        }
         return $namesList;
        }
    }

?>


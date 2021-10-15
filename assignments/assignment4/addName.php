<?php

class AddNames
    {
        function addNames()
        {
           $output="";
           $input = <<<HTML
           $output.={$_POST["addName"]};
           $output.="\n";
           HTML;
            return $output;
        }
    }

?>


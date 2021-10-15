<?php

class AddNames
    {

        function addNames()
        {
        
        if(isset($_POST['addButton']))
        {
            //put info from client into vars
            $namesList=$_POST['namelist'];
            $aName=$_POST['addName'];
            $tempList="";

            $sep1=" ";
            $sep2="\n";
            //$sep3=","; 

            //format newly submitted name
            //fiddled with this formatting stuff a bunch trying to figure it out before seeing explode in the docs
            $nameExploded=explode($sep1, $aName, PHP_INT_MAX);
            for($i=0;$i<sizeOf($nameExploded);$i++)
            {
                $nameExploded[$i]=ucfirst($nameExploded[$i]); //handy string func that makes first letter of string uppercase. found on php manual
            }
            
            $aName="$nameExploded[1], $nameExploded[0]";
            $namesList.="{$aName}\n";
            //format list
            $namesExploded=explode($sep2, $namesList);
            sort($namesExploded, SORT_STRING); //sort method found under php contril-structures on the manual
            foreach($namesExploded as $key => $val)
            {
                $tempList.=$val."\n";
            }
           
            $namesList=$tempList;
            $tempList="";
        }
        if(isset($_POST['clearButton']))
        {
            $namesList="";
        }
         return $namesList;
        }
    }

?>


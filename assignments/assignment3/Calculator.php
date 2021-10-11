<?php


class Calculator
    {
           
        function calc($operator, $num1, $num2)
        {
           switch($operator)
           {
            case "+":
                $output= $num1 + $num2;
                echo nl2br("The addition of the numbers is $output\n");
                break;
            case "-":
                $output =$num1 - $num2;
                echo nl2br("The subtration of the numbers is $output\n");
                break;
            case "/":
                try 
                {
                $output=$num1/$num2;
                echo nl2br("The division of the numbers is $output \n");
                }
                catch(DivisionByZeroError $e)
                {
                    echo nl2br("Cannot divide by zero\n");
                }
                break;
            case "*":
                $output = $num1 * $num2;
                echo nl2br("The multiplucation of the numbers is $output \n");
                break;
           }
        }
    }
?>
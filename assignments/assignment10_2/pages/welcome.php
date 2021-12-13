<?php

//welcome page. show them their name

function init(){
    //$message = ;
    return ["<h1>Welcome</h1>" , "<p>Welcome {$_SESSION['fname']}.</p>"];
}

?>
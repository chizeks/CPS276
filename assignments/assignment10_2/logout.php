<?php

//gotta start the session before you can kill it
session_start();

setcookie("PHPSESSID", "", time() - 3600, "/"); //get rid of cookie
session_destroy();                              //get rid of session vars
header('Location: index.php');                  //goto index

?>
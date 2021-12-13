<?php
//routes page


session_start();

$path = "index.php?page=login";


// Why does it complaion but work? -I think I fixed it
$nav=''; //define variable outside of ifs so it's not undefined

if(isset($_SESSION['access'])) //check if access is set in session so we aren't accidentally accessing an undefined index
{
    if((($_SESSION['access'] === "admin") || ($_SESSION['access'] === "staff")) && ($_GET['page'] !== "login")){

    $nav=<<<HTML1
        <nav class="nav">
            <a class="nav-link" href="index.php?page=addContact">Add Contact</a>
            <a class="nav-link" href="index.php?page=deleteContacts">Delete Contact(s)</a>
HTML1;

    if($_SESSION['access'] === "admin"){

    $nav.=<<<HTML2
            <a class="nav-link" href="index.php?page=addAdmin">Add Admin</a>
            <a class="nav-link" href="index.php?page=deleteAdmin">Delete Admin(s)</a>
HTML2;

    }

    $nav.=<<<HTML3
            <a class="nav-link" href="logout.php">Logout</a>
        </nav>
HTML3;

}
else if ($_GET['page'] !== "login"){
    header('location: '.$path);
}
}

//next look for a valid page request, if there isn't one return to index page to generate 
//the welcome page.

if(isset($_GET)){
    if($_GET['page'] === "login"){             //login page
        require_once('pages/login.php');
        $result = init();
    }
    
     else if($_GET['page'] === "welcome"){           //welcome page
        require_once('pages/welcome.php');
        $result = init();

    }
    else if(($_GET['page'] === "addAdmin") && ($_SESSION['access'] === "admin")){      // add admin page
        require_once('pages/addAdmin.php');
        $result = init();
    }

     else if(($_GET['page'] === "deleteAdmin") && ($_SESSION['access'] === "admin")){   //delete admin
        require_once('pages/deleteAdmin.php');
        $result = init();
    }
    else if($_GET['page'] === "addContact"){             //add contacts
        require_once('pages/addContact.php');
        $result = init();
    }
    
    else if($_GET['page'] === "deleteContacts"){    //delete contacts
        require_once('pages/deleteContacts.php');
        $result = init();
    }

   
    else {
        header('location: '.$path);     // if it isn't a valid route, send to default page                                       
    }
}

else {
    header('location: '.$path);         // $_GET is not set so send the default page.
}

?>
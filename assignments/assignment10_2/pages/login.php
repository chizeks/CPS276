<?php

//get the sticky form in here

   require_once('classes/StickyForm.php');

   $stickyForm = new StickyForm();
   
// init is called from index.php 


function init(){

  global $elementsArr, $stickyForm;


  if(isset($_POST['submit'])){

    /*THIS METHODS TAKE THE POST ARRAY AND THE ELEMENTS ARRAY (SEE BELOW) AND
     PASSES THEM TO THE VALIDATION FORM METHOD OF THE STICKY FORM CLASS.  IT
     UPDATES THE ELEMENTS ARRAY AND RETURNS IT, THIS IS STORED IN THE $postArr
     VARIABLE */
    
    $postArr = $stickyForm->validateForm($_POST, $elementsArr);
    
    /* THE ELEMENTS ARRAY HAS A MASTER STATUS AREA. IF THERE ARE ANY ERRORS
       FOUND THE STATUS IS CHANGED TO "ERRORS" FROM THE DEFAULT OF "NOERRORS".
       DEPENDING ON WHAT IS RETURNED DEPENDS ON WHAT HAPPENS NEXT.  IN THIS CASE
       THE RETURN MESSAGE HAS "NO ERRORS" SO WE HAVE NO PROBLEMS WITH OUR VALIDATION \
       AND WE CAN SUBMIT THE FORM */
    
    if($postArr['masterStatus']['status'] == "noerrors"){
      
      /*addData() IS THE METHOD TO CALL TO ADD THE FORM INFORMATION TO THE DATABASE 
      (NOT WRITTEN IN THIS EXAMPLE) THEN WE CALL THE GETFORM METHOD WHICH RETURNS AND 
      ACKNOWLEDGEMENT AND THE ORGINAL ARRAY (NOT MODIFIED). THE ACKNOWLEDGEMENT IS THE 
      FIRST PARAMETER THE ELEMENTS ARRAY IS THE ELEMENTS ARRAY WE CREATE (AGAIN SEE BELOW) */
      
      return checkLogin($_POST);

    }
    else{

      /* IF THERE WAS A PROBLEM WITH THE FORM VALIDATION THEN THE MODIFIED ARRAY ($postArr) 
      WILL BE SENT AS THE SECOND PARAMETER.  THIS MODIFIED ARRAY IS THE SAME AS THE ELEMENTS 
      ARRAY BUT ERROR MESSAGES AND VALUES HAVE BEEN ADDED TO DISPLAY ERRORS AND MAKE IT STICKY */
    
      return getForm("",$postArr);
    }
    
  }    // *** this is the end of the if from testing for "Submit" ***

  /* THIS CREATES THE FORM BASED ON THE ORIGINAL ARRAY THIS IS CALLED WHEN THE PAGE FIRST 
     LOADS BEFORE A FORM HAS BEEN SUBMITTED */
  
  else {
      return getForm("", $elementsArr);
    } 
}

/* THIS IS THE DATA OF THE FORM.  IT IS A MULTI-DIMENTIONAL ASSOCIATIVE ARRAY THAT IS USED 
   TO CONTAIN FORM DATA AND ERROR MESSAGES.   EACH SUB ARRAY IS NAMED BASED UPON WHAT FORM 
   FIELD IT IS ATTACHED TO. FOR EXAMPLE, "name" GOES TO THE TEXT FIELDS WITH THE NAME ATTRIBUTE 
   THAT HAS THE VALUE OF "NAME". NOTICE THE TYPE IS "TEXT" FOR TEXT FIELD.  DEPENDING ON WHAT 
   HAPPENS THIS ASSOCIATE ARRAY IS UPDATED.*/

$elementsArr = [
  "masterStatus"=>[
    "status"=>"noerrors",
    "type"=>"masterStatus"
  ],
	"email"=>[
		"errorMessage"=>"<span style='color: red; margin-left: 15px;'>Email address cannot be blank and must be a valid email address</span>",
    "errorOutput"=>"",
    "type"=>"text",
		"value"=>"admin@admin.com",
		"regex"=>"email"
  ],
  "password"=>[
		"errorMessage"=>"<span style='color: red; margin-left: 15px;'>Password cannot be blank and must be a valid password</span>",
    "errorOutput"=>"",
    "type"=>"password",
		"value"=>"admin",
		"regex"=>"password"
  ]
];


// If the entered data is valid 
function checkLogin($post){
  
  global $elementsArr;  
  
  // IF EVERYTHING WORKS ADD THE DATA HERE TO THE DATABASE HERE USING THE $_POST SUPER GLOBAL ARRAY */
      require_once('classes/PdoMethods.php');

      //sql stuff
      $pdo = new PdoMethods();
      $sql = "SELECT * FROM admin WHERE email = '{$post['email']}';";
      $records = $pdo->selectNotBinded($sql);

      if((count($records) != 0) && ($_POST['password'] == $records[0]['password'])){
    
        session_start();                           
        
        //set access and store name
        $_SESSION['access'] = $records[0]['status'];    
        $_SESSION['fname'] = $records[0]['name'];       
    
        //go to welcome page
        header('location: index.php?page=welcome');    
      }
      else 
       {
        //incorrect username/password
        return getForm("<span style='color: red; margin-left: 15px;'>Invalid Login</span>", $elementsArr);
      }     
}
//form stuff
function getForm($acknowledgement, $elementsArr){
global $stickyForm;

$form = <<<HTML
    <h1>Login</h1>
    <form method="post" action="index.php?page=login">
        
    <div class="form-group">
      <label for="email">Email {$elementsArr['email']['errorOutput']}</label>
      <input type="text" class="form-control" id="email" name="email" value="{$elementsArr['email']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="password">Password {$elementsArr['password']['errorOutput']}</label>
      <input type="password" class="form-control" id="password" name="password" value="{$elementsArr['password']['value']}" >
    </div>
    
    <div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
HTML;

return [$acknowledgement, $form];
}

?>
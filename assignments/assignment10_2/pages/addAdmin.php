<?php
//GET THE STICKYFORM IN HERE
require_once('classes/StickyForm.php');
$stickyForm = new StickyForm();

//INIT
function init(){
  global $elementsArr, $stickyForm;
    //check for form submission
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
      
      return addData($_POST);

    }
    else{

      /* IF THERE WAS A PROBLEM WITH THE FORM VALIDATION THEN THE MODIFIED ARRAY ($postArr) 
      WILL BE SENT AS THE SECOND PARAMETER.  THIS MODIFIED ARRAY IS THE SAME AS THE ELEMENTS 
      ARRAY BUT ERROR MESSAGES AND VALUES HAVE BEEN ADDED TO DISPLAY ERRORS AND MAKE IT STICKY */
      
      return getForm("",$postArr);
    }
    
  }

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
	"name"=>[
	  "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Name cannot be blank and must be a standard name</span>",
    "errorOutput"=>"",
    "type"=>"text",
    "value"=>"",
		"regex"=>"name"
	],
	"email"=>[
		"errorMessage"=>"<span style='color: red; margin-left: 15px;'>Email address cannot be blank and must be a valid email address</span>",
    "errorOutput"=>"",
    "type"=>"text",
		"value"=>"",
		"regex"=>"email"
  ],
  "password"=>[
		"errorMessage"=>"<span style='color: red; margin-left: 15px;'>Password cannot be blank and must be a valid password</span>",
    "errorOutput"=>"",
    "type"=>"text",
		"value"=>"",
		"regex"=>"password"
  ],
  "status"=>[
    "type"=>"select",
    "options"=>["staff"=>"Staff","admin"=>"Admin"],
		"selected"=>"staff",
		"regex"=>"name"
	]
];


//add data to db
function addData($post){
  global $elementsArr;  
  
  // IF EVERYTHING WORKS ADD THE DATA HERE TO THE DATABASE HERE USING THE $_POST SUPER GLOBAL ARRAY */     
      require_once('classes/PdoMethods.php');
      $pdo = new PdoMethods();
      $sql = "SELECT * FROM admin WHERE email = '{$post['email']}';";
      $records = $pdo->selectNotBinded($sql);

    if(count($records) !== 0){
      return getForm("<p>Admin already exists</p>", $elementsArr);
    }

      $sql = "INSERT INTO admin (name, email, password, status) VALUES (:name, :email, :password, :status)";

      $bindings = [
        [':name',$post['name'],'str'],
        [':email',$post['email'],'str'],
        [':password',$post['password'],'str'],
        [':status',$post['status'],'str'],
      ];

      $result = $pdo->otherBinded($sql, $bindings);

      if($result == "error"){
        return getForm("<p>Something went wrong processing your form</p>", $elementsArr);
      }
      else {
        return getForm("<p>Admin Information Added</p>", $elementsArr);
      }
      
}
   

/* THIS IS THE GET FORM FUCTION WHICH WILL BUILD THE FORM BASED UPON UPON THE (UNMODIFIED
   OF MODIFIED) ELEMENTS ARRAY. */

function getForm($acknowledgement, $elementsArr){

global $stickyForm;

if(isset($elementsArr['state'])){ //make it not complain at me by checking arr before using
$options = $stickyForm->createOptions($elementsArr['state']);
}
/* CREATE FORM AND ADD APPROPRIATE VALUES*/

$form = <<<HTML
    <h1>Add Admin</h1>
    <form method="post" action="index.php?page=addAdmin">
    
    <div class="form-group">
      <label for="name">Name (letters only){$elementsArr['name']['errorOutput']}</label>
      <input type="text" class="form-control" id="name" name="name" value="{$elementsArr['name']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="email">Email {$elementsArr['email']['errorOutput']}</label>
      <input type="text" class="form-control" id="email" name="email" value="{$elementsArr['email']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="password">Password {$elementsArr['password']['errorOutput']}</label>
      <input type="text" class="form-control" id="password" name="password" value="{$elementsArr['password']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="status">Status</label>
      <select class="form-control" id="status" name="status">
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
      </select>
    </div>
    
    <div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
HTML;

/* HERE I RETURN AN ARRAY THAT CONTAINS AN ACKNOWLEDGEMENT AND THE FORM.  THIS IS 
   DISPLAYED ON THE INDEX PAGE. */

return [$acknowledgement, $form];

}

?>
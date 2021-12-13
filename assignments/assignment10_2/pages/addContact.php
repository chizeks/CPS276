<?php

require_once('classes/StickyForm.php');
error_reporting(0); //my wonky way of handling contacts causes warnings. not very pretty
$stickyForm = new StickyForm();

// THE init() function
// it is called from index.php
function init(){

  global $elementsArr, $stickyForm;
  //did it sumbit?
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
    "value"=>"Sara",
		"regex"=>"name"
	],
	"address"=>[
	  "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Address cannot be blank and must be a standard address</span>",
    "errorOutput"=>"",
    "type"=>"text",
    "value"=>"354 ABC Ln",
		"regex"=>"address"
	],
	"city"=>[
	  "errorMessage"=>"<span style='color: red; margin-left: 15px;'>City cannot be blank and must be a standard city name</span>",
    "errorOutput"=>"",
    "type"=>"text",
    "value"=>"Ypsilanti",
		"regex"=>"name"
	],
  "state"=>[
    "type"=>"select",
    "options"=>["AL"=>"Alabama","AK"=>"Alaska","CA"=>"California","MI"=>"Michigan","OH"=>"Ohio","PA"=>"Pennslyvania","TX"=>"Texas","WV"=>"West Virginia"],
		"selected"=>"MI",
		"regex"=>"name"
	],
  "phone"=>[
		"errorMessage"=>"<span style='color: red; margin-left: 15px;'>Phone cannot be blank and must be a valid phone number</span>",
    "errorOutput"=>"",
    "type"=>"text",
		"value"=>"999.999.9999",
		"regex"=>"phone"
  ],
  "email"=>[
	  "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Email cannot be blank and must be a standard email format</span>",
    "errorOutput"=>"",
    "type"=>"text",
    "value"=>"email@email.com",
		"regex"=>"email"
	],
	"dobirth"=>[
	  "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Date of Birth cannot be blank and must be in a standard format</span>",
    "errorOutput"=>"",
    "type"=>"text",
    "value"=>"05/05/1935",
		"regex"=>"date"
	],
	"contact"=>[
    "type"=>"checkbox",
    "action"=>"notRequired",
    "status"=>["news"=>"", "email"=>"", "text"=>""]
  ],
  "ageRange"=>[
    "errorMessage"=>"<span style='color: red; margin-left: 15px;'>You must select an age range</span>",
    "errorOutput"=>"",
    "action"=>"required",
    "type"=>"radio",
    "value"=>["10-18"=>"", "19-30"=>"", "30-50"=>"", "51+"=>""]
  ]
 
];


/*THIS FUNCTION CAN BE CALLED TO ADD DATA TO THE DATABASE */

function addData($post){
  
  global $elementsArr;  
  
  // IF EVERYTHING WORKS ADD THE DATA HERE TO THE DATABASE HERE USING THE $_POST SUPER GLOBAL ARRAY
      
  //print_r($_POST);
  
  require_once('classes/PdoMethods.php');

  $pdo = new PdoMethods();

  $sql = "INSERT INTO contacts (name, address, city, state, phone, email, dateOfBirth, contactType, ageRange)
          VALUES (:name, :address, :city, :state, :phone, :email, :dateOfBirth, :contactType, :ageRange)";

  // this converts the checkbox contact info into a string, idk if this is the best way to 
  //solve this?            
    $contactType = "";
    foreach($post['contact'] as $var)
    {
    $contactType .= $var.",";
    }    
    $contactType = substr($contactType, 0, -1);

      //set bindings
      $bindings = [
        [':name',$post['name'],'str'],
        [':address',$post['address'],'str'],
        [':city',$post['city'],'str'],
        [':state',$post['state'],'str'],
        [':phone',$post['phone'],'str'],
        [':email',$post['email'],'str'],
        [':dateOfBirth',$post['dobirth'],'str'],
        [':contactType',$contactType,'str'],
        [':ageRange',$post['ageRange'],'str']
      ];

      $result = $pdo->otherBinded($sql, $bindings);

      if($result == "error")
      {
        return getForm("<p>There was a problem processing your form</p>", $elementsArr);
      }
      else 
      {
        return getForm("<p>Contact Information Added</p>", $elementsArr);
      }
      
}

// ************************************************************************************
//
// getForm() builds the form using the $elementsArr with standard testing inputs 
// (unmodified array) or hand entered testing inputs (modified array).
//
// ************************************************************************************

function getForm($acknowledgement, $elementsArr){

global $stickyForm;

$options = $stickyForm->createOptions($elementsArr['state']);

//create form so we can add data to the contacts list

$form = <<<HTML
    <h1>Add Contact</h1>
    <form method="post" action="index.php?page=addContact">
    
    <div class="form-group">
      <label for="name">Name (letters only){$elementsArr['name']['errorOutput']}</label>
      <input type="text" class="form-control" id="name" name="name" value="{$elementsArr['name']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="address">Address (just number and street) {$elementsArr['address']['errorOutput']}</label>
      <input type="text" class="form-control" id="address" name="address" value="{$elementsArr['address']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="city">City{$elementsArr['city']['errorOutput']}</label>
      <input type="text" class="form-control" id="city" name="city" value="{$elementsArr['city']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="state">State:</label>
      <select class="form-control" id="state" name="state">
        $options
      </select>
    </div>
    
    <div class="form-group">
      <label for="phone">Phone (format 999.999.9999) {$elementsArr['phone']['errorOutput']}</label>
      <input type="text" class="form-control" id="phone" name="phone" value="{$elementsArr['phone']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="email">Email address{$elementsArr['email']['errorOutput']}</label>
      <input type="text" class="form-control" id="email" name="email" value="{$elementsArr['email']['value']}" >
    </div>
    
    <div class="form-group">
      <label for="dobirth">Date of birth{$elementsArr['dobirth']['errorOutput']}</label>
      <input type="text" class="form-control" id="dobirth" name="dobirth" value="{$elementsArr['dobirth']['value']}" >
    </div>
    
    <!-- 
    -->
    
    <p class="mb-1">Please check all contact types you would like (optional):{$elementsArr['contact']['errorOutput']}</p>
    <div class="input-group mb-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="contact[]" id="contact1" value="newsletter" {$elementsArr['contact']['status']['newsletter']}>
        <label class="form-check-label" for="contact1">Newsletter</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="contact[]" id="contact2" value="email" {$elementsArr['contact']['status']['emailupdate']}>
        <label class="form-check-label" for="contact2">Email Updates</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="contact[]" id="contact3" value="text" {$elementsArr['contact']['status']['textupdate']}>
        <label class="form-check-label" for="contact3">Text Updates</label>
      </div>
    </div>
    
    <!--
    --> 
    <p class="mb-1">Please select an age range (you must select one):{$elementsArr['ageRange']['errorOutput']}</p>
    <div class="input-group mb-3">
    
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="ageRange" id="ageRange1" value="10-18"  {$elementsArr['ageRange']['value']['10-18']}>
        <label class="form-check-label" for="ageRange1">10-18</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="ageRange" id="ageRange2" value="19-30"  {$elementsArr['ageRange']['value']['19-30']}>
        <label class="form-check-label" for="ageRange2">19-30</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="ageRange" id="ageRange3" value="30-50"  {$elementsArr['ageRange']['value']['30-50']}>
        <label class="form-check-label" for="ageRange3">30-50</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="ageRange" id="ageRange4" value="51+"  {$elementsArr['ageRange']['value']['51+']}>
        <label class="form-check-label" for="ageRange4">51+</label>
      </div>
    </div>
    
    <div>
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
HTML;

//
// Return array that contains an acknowledgement and the form to be displayed on the index.php page
//

return [$acknowledgement, $form];

}

?>

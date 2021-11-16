<!doctype html>
<html lang="en">
  <head>
<?php
require_once 'PdoMethods.php';
if (isset( $_POST["sendFile"])){
	processFile();
}
else {
	$output = "";
}

function processFile(){
	global $output;
	
	//check to make sure a file was uploaded. if error == 4, no file was uploaded or i did something wrong somewhere in here?
	if ($_FILES["file"]["error"] == 4)
    {
		$output = "No file was uploaded. Make sure you choose a file to upload.";
	}
	//check for valid file type (PDF)
	elseif ($_FILES["file"]["type"] != "application/pdf" ) 
    {
		$output = "<p>Please only upload PDF files...</p>";
	}
	/*check for file too big*/
	elseif($_FILES["file"]["size"] > 100000 || $_FILES["file"]["error"] == 1)
    {
		$output = "This file is too large...";
	}
	//finally, "add" the file
	else 
    {
        addFile();
		$output = "<p>File is acceptable & added</p>";
	}

}


function addFile(){
	
    $pdo = new PdoMethods();
    /* sql statement */
    $sql = "INSERT INTO files (file_name, file_path) VALUES (:fileID, :filePath)";
      
    $filePath = "files/newsletterorform1.pdf";
    $file=$_POST['fileName'];
 
    $bindings = [
        [':fileID',$file,'str'],
        [':filePath',$filePath,'str']
    ];

    /* pdo method */
    $result = $pdo->otherBinded($sql, $bindings);
    /* success/failure checking */
    if($result === 'error'){
        return 'There was an error adding the name';
    }
    else {
        return 'File has been added';
    }
}

?>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>File Upload</title>
    
  </head>
  <body>
    <main class="container">
      <h1>File Upload</h1>
	<p>
		<a href="listFilesProc.php">Show File List</a><br>
	</p>
	<div> <?php echo $output; ?></div>
      <form action="fileUploadProc.php" method="post" enctype="multipart/form-data">
      	<div class="form-group">
      		<label for="fileName">File Name</label>
      		<input type="text" class="form-control" name="fileName" id="fileName">
      	</div>
      	<div class="form-group">
      		<label for="file">Your file:</label>
      		<input type="file" name="file" id="file">
      	</div>
      	<div class="form-group">
      		<input type="submit" class="btn btn-primary" name="sendFile" value="Upload File" />
      	</div>
		</form>
    </main>
</body>
</html>
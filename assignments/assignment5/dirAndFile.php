<?php

$output = "";
$error = "";
$fileHREF = "";

/*if(count($_POST) > 0){*/
if(isset($_POST['submit'])){
    require_once 'dirs2.php';
    $myDir = new dirs2();
    $myDir->createDirectoryAndFile();
    $error = $myDir->getError();
    $fileURL = $myDir->getFileURL();

    if ($fileURL!="") {
        $fileHREF = "<a href=\"".$fileURL."\">".$fileURL."</a>";
    }
    else {
        $fileHREF = "";
    }
}






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>File and Directory Assignment</title> 

  </head>
<body>
<main class="container">
<h1>File and Directory Assignment </h1>

<?php echo ($fileHREF); ?>
<p>Enter a folder name and contents of a file.  Folder name should contain alpha numeric characters only.</p>
<?php echo ("<p>".$error."</p>"); ?>
<form action="dirAndFile.php" method="post">
<div class="form-group">
        <label for="dirName">Folder Name</label>
        <input type="text" class="form-control" name="dirName" id="dirName" value="">
</div>

<div class="form-group">
        <label for="fileContents">File Content</label>
        <textarea name="fileContents" type="password" class="form-control" id="fileContents" rows="4" cols="50"><?php echo $output?></textarea>
</div>

<div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" id="s1" value="Submit" >
</div>  


</form>
</main>
</body>
</html>
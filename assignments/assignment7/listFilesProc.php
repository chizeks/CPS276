<!doctype html>
<html lang="en">
<?php
require 'PdoMethods.php';
$output = getFiles();


function getFiles(){
		
    /* sql stuff*/
    $pdo = new PdoMethods();
    $sql = "SELECT * FROM files";
    $files = $pdo->selectNotBinded($sql);

    /*check if something went wonky*/
    if($files == 'error'){
        return 'There has been and error processing your request';
    }
    else {
        if(count($files) != 0){
          return(createList($files));
        }
        else {
            return 'no names found';
        }
    }
}

function createList($files){
    $list = '<ul>';
    foreach ($files as $row)
    {
        $list .= "<li><a target='_blank' href='{$row['file_path']}'>{$row['file_path']}</a></li>";
    }
    $list .= '</ul>';
    return $list;
}

?>  

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>List Files</title>
  </head>
  <body>
    <main class="container">
        <h1>List Files</h1>
        <a href="file_upload.php">Add File</a><br>
		<div> <?php echo $output; ?></div>
    </main>
</body>
</html>
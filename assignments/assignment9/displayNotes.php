<?php
$output = "";
if(count($_POST) > 0)
{
    require_once 'noteProc.php';
    $noteProc = new noteProc();
    $output = $noteProc->getNotes();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>Display Notes</title>

    </head>

    <body>
        <main class="container">
            <h1>Display Notes</h1>

            <a href="addNote.php">Add Note</a><br>  
  
            <form action="displayNotes.php" method="post">

             <div class="form-group">
                <label for="begDate">Beginning Date</label>
                <input type="date" class="form-control" id="begDate" name="begDate">
             </div>

            <div class="form-group">
                <label for="endDate">Ending Date</label>
                <input type="date" class="form-control" id="endDate" name="endDate"> 
            </div>   
  
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="getNotes" id="s1" value="Get Notes" >
            </div>     
  
            <?php echo $output ?>


            </form>
        </main>
    </body>
</html>
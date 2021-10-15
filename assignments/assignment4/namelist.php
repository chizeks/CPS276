<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Assignment 4 - Sara Chizek</title>
    <?php
        $output=" ";
        if(count($_POST) > 0){
            require_once 'addName.php';
            $addName = new AddNames();
            $output = $addName->addNames();
           }
    ?>
   </head>
    <body>
        <div class="mx-auto" style="width: 700px;">
        <h1>Add Names</h1>
        
        <form action="namelist.php" method="post">
           <label for="addName" class="form-label">Name</label>
             <div class="d-flex flex-row">
                <div class="px-1">
                <input type="submit" class="btn btn-success" name="addButton" id="addButton" value="Add" />
                </div>
                <div class="px-1">
                <input type="submit" class="btn btn-success" name="clearButton" id="clearButton" value="Clear" />
                </div>
        </div>
                
            <input type="text" class="form-control" id="addName" name="addName">
           
        </form>
    <textarea style="height: 500px;" class="form-control"
    id="namelist" name="namelist"><?php echo $output ?></textarea>
    </div>
    </body>
</html>
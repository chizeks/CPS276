<?php
    if(count($_REQUEST)>1)
    {
        include_once("classes/db.php");
        include_once("validate.php");
        
    }
?>
<form method="POST" action="index.php">
    <div class="form-group">
        <label for="name">Name 
        
        </label>
        <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?=(isset($_REQUEST['name'])) ? $_REQUEST['name'] : ""?>">
    </div>
    <button type="submit" class="btn btn-primary" value="submit">Submit</button>
</form>
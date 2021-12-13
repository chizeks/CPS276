<?php
    if(count($_REQUEST)>1)
    {
        include_once("db.php");
        include_once("validate.php");
        $db = new Db();
        $output = $db->login();
    }
?>
<form method="POST" action="index.php">
    <div class="form-group">
        <label for="email">Email 
        
        </label>
        <input type="text" class="form-control" name="email" placeholder="enter email" value="<?=(isset($_REQUEST['email'])) ? $_REQUEST['email'] : ""?>">
    
        <label for="password">Password 
        
        </label>
        <input type="password" class="form-control" name="password" placeholder="enter password" value="<?=(isset($_REQUEST['password'])) ? $_REQUEST['password'] : ""?>">
    </div>
    <button type="submit" class="btn btn-primary" value="login">login</button>
</form>
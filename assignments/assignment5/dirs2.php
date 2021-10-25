<?php
class dirs2 {
    
  
    private $dirName="dirName not set.";
    private $fileContents = "fileContents not set";
    private $errMssg = "";

    private $dirRoot = "./directories";
    private $bURL = "http://143.244.183.226/CPS276/assignments/assignment5/directories/";
    private $fileURL = "";

    public function getDebug() {
        return("debug=<".$this->debug."> \n errorMesasge=".$this->errMssg.">");

    }

    public function getError() {
        return($this->errMssg);

    }

    public function getfileURL() {
        return($this->fileURL);

    }


    /*
        Event handler for form.  
        When submit button is pressed, create a new 
    */
    public function createDirectoryAndFile () {

        $this->errMssg = "Something blew up unexpectedly.";
        $this->fileURL="";

        /* user has selected adding a name to our list */
        if(isset($_POST['submit'])){

            // get the directory name - if not set, return with error
            if(isset($_POST['dirName'])) {

                // make sure there is something in the directory name text box
                if (trim($_POST['dirName']) === '') {
                    $this->errMssg = "Cannot process request. No directory name provided.";
                    return($this->errMssg);
                }
                $this->dirName = $this->dirRoot."/".$_POST['dirName'];
            }
            else { //check dirName
                $this->errMssg = "dirName not set";
                return($this->errMssg);
            }

            // get the file contents - if not set, return with error
            if(isset($_POST['fileContents'])) {
 
                $this->fileContents = $_POST['fileContents'];
            }
            else {
                $this->errMssg = "Please provide text to be written to file.";
                return($this->errMssg);
            }


            //create directory
            if (!file_exists($this->dirName)) {
                mkdir( $this->dirName, 0777, true);  
                chmod($this->dirName, 0777);              
            }
            else {
                $this->errMssg = "A directory already exists with that name.";
                return($this->errMssg);
            }


            // write message to file          
            $fileName = $this->dirName."/readme.txt";

            $fp = fopen($fileName, "w");
            if ( !$fp ) { 
                $this->errMssg = "Could not process request. Unable to open file for write!";
                return($this->errMssg);       
            }
            else {
                fwrite($fp,$this->fileContents);
                fclose( $fp);
            }            

        }        


        $this->fileURL = $this->bURL.$_POST['dirName']."/readme.txt";
        
$this->debug = "fileURL=".$this->fileURL;    

        $this->errMssg = "";
        return($this->errMssg);
        
    }
}
?>  
    
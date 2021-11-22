<?php

require './classes/PdoMethods.php';

class noteProc  extends PdoMethods {
    public $debug="addNote";


    public function addNote(){

        error_reporting(0); //make it stop warning me about relying on system time for my time stamps.
        //make pdo 
        $pdo = new PdoMethods();

        //get note date from site
        $noteTimeStamp = strtotime($_POST['dateTime']);
        if ($noteTimeStamp) 
        {
            $noteTimeStampStr = date('Y-m-d', $noteTimeStamp);
            $this->debug .=  "noteTimeStampStr=".$noteTimeStampStr. " ";
        } else 
        {
            return('Invalid or Missing Date.' . $_POST['dateTime']);
        } 
     
        $n_txt = $_POST['n_txt'];
        if (strlen($n_txt)>0) 
        {
            $this->debug .=  "n_txt=".$n_txt. " "; 
        }
        else
        {
            return('Missing Note.');
        } 
		//sql stuff
		$sql = "insert into  notes values ( :note_time_stamp,:note_text) ";
        $bindings = 
        [
			[':note_time_stamp',$noteTimeStamp,'int'] ,
            [':note_text',$n_txt,'str'] 
		];
		//process it
		$records = $pdo->otherBinded($sql,$bindings);
		//if something went wrong let user/me know
		if($records == 'error')
        {
			return 'There has been and error processing your request';
		}
		else 
        {
				return 'Note has been added';
		}
	}

    public function getNotes(){
        error_reporting(0); //make it stop warning me about relying on system time for my time stamps.
		//can't forget the pdo
		$pdo = new PdoMethods();

        //get the start date
        $startTimeStamp = strtotime($_POST['begDate']);
        if ($startTimeStamp) 
        {
          $startTimeStr = date('Y-m-d', $startTimeStamp);
          $this->debug .=  "startTimeStr=".$startTimeStr. " ";
        } else 
        {
           return('Invalid Begin Date: ' . $_POST['begDate']);
        } 

        //get the end date
        $endTimeStamp = strtotime($_POST['endDate']);
        if ($endTimeStamp) 
        {
          $endTimeStr = date('Y-m-d', $endTimeStamp);
          $this->debug .=  "endTimeStr=".$endTimeStr. " ";
        } else 
        {
           return('Invalid End Date: ' . $_POST['endDate']);
        } 

		//sql go
		$sql = "SELECT * FROM notes where time_stamp >= :start_time_stamp and time_stamp <= :end_time_stamp  order by time_stamp";
        $bindings = 
        [
			[':start_time_stamp',$startTimeStamp,'int'] ,
            [':end_time_stamp',$endTimeStamp,'int'] 
		];
		//process it
		$records = $pdo->selectBinded($sql,$bindings);
		//if something went wrong...
		if($records == 'error')
        {
			return 'There has been and error processing your request';
		}
		else 
        {
			if(count($records) != 0)
            {
				return $this->getNotesTable($records);	
			}
			else //no notes found
            {
				return 'No notes found for date range selected';
			}
		}
	}

    private function getNotesTable($records){    
		$output = "<table class='table table-bordered table-striped'> <thead> <tr>";
		$output .= "<th>Date and Time</th> <th>Note</th> <tbody>";
		foreach ($records as $row)
        {
            $d = $row['time_stamp'];
            $ds = date("n\/d\/Y h:i a", $d );
			$output .= "<tr> <td> {$ds} </td>";
			$output .= "<td> {$row['note_text']} </td> </tr>";
		}	
		$output .= "</tbody></table>";
		return $output;
	}      
    
}
?>
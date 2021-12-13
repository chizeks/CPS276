<?php



class Validation{
	// $error is true if any errors are found, start out false assuming no errors
	private $error = false;       

	/* 
	CHECK FORMAT IS BASCALLY A SWITCH STATEMENT THAT TAKES A VALUE AND THE NAME 
	OF THE FUNCTION THAT NEEDS TO BE CALLED FOR THE REGULAR EXPRESSION
	*/

	public function checkFormat($value, $regex)
	{
		switch($regex){
			case "name": return $this->name($value); break;
			case "address": return $this->address($value); break;
			case "phone": return $this->phone($value); break;
			case "email": return $this->email($value); break;
			case "date": return $this->date($value); break;
			case "password": return $this->password($value); break;
					
		}
	}

  //i made or got my regex expressions from regexr.com
  //the site has a useful tool for testing your regex so you can do the testing there
	private function name($value)
    {
		$match = preg_match('/^[a-z ,.\'-]+$/i', $value);
		return $this->setError($match);
	}

	private function address($value)
    {
		$match = preg_match('/^\d{1,}\s((\D+\s+)|(\d+\D+\s+))/', $value);
		return $this->setError($match);		
	}

	private function phone($value)
    {
		$match = preg_match('/^\d{3}\.\d{3}.\d{4}$/', $value);
		return $this->setError($match);
	}



	private function email($value)
    {
        $match = preg_match('/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/', $value);
		return $this->setError($match);
	}

	private function date($value)
    {
		$match = preg_match('/^(0[1-9]|1[0-2])[\/](0[1-9]|[12]\d|3[01])[\/](19|20)\d{2}$/', $value);
	    return $this->setError($match);
	}

	private function password($value)
    {
		$match = preg_match('/^[A-Za-z0-9]{8,20}$/', $value);
		return $this->setError($match);
	}


    //ERROR STUFF
	private function setError($match){

		if(!$match){

			$this->error = true;
			return "error";
		}
		else {

			return "";

		}
	}


	/* THE SET MATCH FUNCTION ADDS THE KEY VALUE PAR OF THE STATUS TO THE ASSOCIATIVE ARRAY */
	
	public function checkErrors(){

		return $this->error;

	}
	
}
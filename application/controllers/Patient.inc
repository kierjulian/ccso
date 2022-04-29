<?php

class Patient
{
	const ID = 0;
	const NAME = 1;
	const SEX = 2;
	const BIRTHDAY = 3;
	const CONTACT_NO = 4;
	const ADDRESS = 5;
	const PHYSICIAN = 6;
	const EDUC_ATTAINMENT = 7;
	const ADMISSION = 8;
	const AGE = 9;
	
	const ADMITTED = 1;
	const NOT_ADMITTED = 0;
	const MALE = 1;
	const FEMALE = 0;
	
	const HS_UNDERGRAD = 0;
	const HS_GRAD = 1;
	const COLL_UNDERGRAD = 2;
	const COLL_GRAD = 3;
	
	// Array of patient data
	private $data;
	
	/**
	 * Accepts an SQL array data and parses and shit.
	 */
	function __construct($patient)
	{
		// Fill up object's array data from SQL's array data
		$this->data = array
		(
			$patient->id,
			$patient->name,
			$patient->sex,
			$patient->bday,
			$patient->contact_num,
			$patient->address,
			$patient->physician,
			$patient->educ_attainment,
			$patient->is_admitted
		);
	}
	
	function get($field)
	{
		switch ($field)
		{
			case self::ID:
			case self::NAME:
			case self::BIRTHDAY:
			case self::CONTACT_NO:
			case self::ADDRESS:
			case self::PHYSICIAN:
				return $this->data[$field];
			
			case self::SEX:
				return ($this->data[self::SEX] == self::MALE ? "Male" : "Female");
			
			case self::AGE:
				return ($this->age($this->data[self::BIRTHDAY]));
				
			case self::EDUC_ATTAINMENT:
				return ($this->educAttainment($this->data[self::EDUC_ATTAINMENT]));
				
			case self::ADMISSION:
				return ($this->data[self::ADMISSION] == self::NOT_ADMITTED ? FALSE : TRUE);
				
		}
	}
	
	private function age($bday)
	{
		$today = date('Y-m-d');
		
		$todaytime = strtotime($today);
		$birthtime = strtotime($bday);
		
		$agetime = $todaytime - $birthtime;
		
		// 1 year = 31536000 seconds (non-leap year)
		return (intval($agetime/31536000));
	}
	
	private function educAttainment($educ)
	{
		switch ($educ)
		{
			case self::HS_UNDERGRAD:
				return "High School Undergraduate";
			case self::HS_GRAD:
				return "High School Graduate";
			case self::COLL_UNDERGRAD:
				return "College Undergraduate";
			case self::COLL_GRAD:
				return "College Graduate";
		}
	}
	
}

?>
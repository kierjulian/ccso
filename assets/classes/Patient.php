<?php

class Patient
{
	// Headers of SQL table	
	const TABLE_NAME = "patients";
	const TRUE_ID = "true_id";					
	const LAST_NAME = "last_name";
	const FIRST_NAME = "first_name";
	const MIDDLE_NAME = "middle_name";	
	const SEX = "sex";
	const BIRTHDAY = "birthday";
	const CONTACT_NUM = "contact_num";
	const ADDRESS = "address";
	const PHYSICIAN = "physician";
	const EDUC_ATTAINMENT = "educ_attain";
	const NATIONALITY = "nationality";
	const STATUS = "status";
	const PWD = "pwd";	
	const CREATION_DATE = "creation_date";
	const CREATION_NUM = "creation_num";
	
	
	// PWD-ness types
	const NOT_PWD = 0;
	const IS_PWD = 1;
	
	// Status types
	const FREE = 0;
	const ON_QUEUE = 1;
	const SCHEDULED = 2;
	
	// Sex
	const MALE = 1;
	const FEMALE = 2;
	
	// Educational attainment
	const NONE = 0;
	const ELEM_UNDERGRAD = 1;
	const ELEM_GRAD = 2;
	const HS_UNDERGRAD = 3;
	const HS_GRAD = 4;
	const COLL_UNDERGRAD = 5;
	const COLL_GRAD = 6;
	
	/**
	 *	Concatenates the creation year and its creation number
	 *	to generate the CCSO Patient ID.
	 *	Current format: "yyyy-nnnnnnnnn"
	 */
	static function getPatientID($creationDate, $creationNum)
	{
		$year = date("Y", strtotime($creationDate));
		$num = sprintf("%'.06d\n", $creationNum);
		
		return "$year-$num";
	}
	
	/**
	 *	Concatenates the name parts into one single string.
	 *	Current format:	"LAST, First Middle"
	 */
	static function getFullName($last, $first, $middle)
	{				
		return sprintf("%s, %s %s", strtoupper($last), ucwords(strtolower($first)), ucwords(strtolower($middle))); 
	}
	
	/**
	 *	Returns the display name of the sex of the patient.
	 */ 
	static function getSex($sex)
	{
		return ($sex == self::MALE ? "Male" : "Female");
	}
	
	/**
	 *	Returns the age of the patient by his/her birthday.
	 */
	static function getAge($birthday)
	{
		$today = new DateTime(date('Y-m-d'));
		$birth = new DateTime($birthday);
		
		$age = ($today->diff($birth));

		return sprintf("%d year%s, %d month%s, %d day%s", $age->y, ($age->y != 1 ? "s" : ""), $age->m, ($age->m != 1 ? "s" : ""), $age->d, ($age->d != 1 ? "s" : ""));
	}
	
	static function isSuki($creationDate)
	{
		$today = new DateTime(date('Y-m-d'));
		$date = new DateTime($creationDate);
		
		$sukiyears = ($today->diff($date));

		return $sukiyears->y;
	}
	
	/**
	 *	Returns the display name of the birthday of the patient.
	 */
	 static function getBirthday($birthday)
	 {
		 return (date("j M Y", strtotime($birthday)));
	 }
	
	/**
	 *	Returns whether the patient is a senior citizen or not.
	 */
	static function isSrCitizen($birthday)
	{	
		if (self::getAge($birthday) >= 60)
			return true;
		return false;
	}
	
	/**
	 *	Returns the string representation of the
	 *	educational attainment of the patient.
	 */
	static function getEducAttainment($educAttainment)
	{
		switch ($educAttainment)
		{
			case self::NONE:
				return "No Grade Completed";
			case self::ELEM_UNDERGRAD:
				return "Elementary Undergraduate";
			case self::ELEM_GRAD:
				return "Elementary Graduate";
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
	
	/**
	 *	Returns the current queue status of the patient.
	 */
	static function getStatus($status)
	{
		switch ($status)
		{
			case self::FREE:
				return "Free";
			case self::ON_QUEUE:
				return "On-queue";
			case self::SCHEDULED:
				return "Scheduled";
		}
	}
}

?>
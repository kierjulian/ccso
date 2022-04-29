<?php
	class Appointment
	{
		// Table headers
		const TABLE_NAME = "appointments";
		const TRUE_ID = "true_id";		// Appointment::TRUE_ID == Patient::TRUE_ID
		const VISIT_NUMBER = "visit_num";		
		const APPOINTMENT_DATE = "appoint_date";
		const TIME_IN = "time_in";
		const TIME_OUT = "time_out";
		
		/**
		 *	Returns the time in/out of the patient in 12-hour format.
		 */
		static function getTime($time)
		{		
			return (date("h:i:s A", strtotime($time)));
		}
		
		/**
		 *	Returns the display name of the appointment date of the patient.
		 */
		static function getDate($date)
		{
			return (date("j M Y", strtotime($date)));
		}
	}

?>
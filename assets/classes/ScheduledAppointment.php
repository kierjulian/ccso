<?php
	class ScheduledAppointment
	{
		// Table headers
		const TABLE_NAME = "appointments_sched";
		const TRUE_ID = "true_id";
		const SCHEDULE_ID = "sched_id";
		const SCHEDULE_DATE = "sched_date";
		const SCHEDULE_TIME = "sched_time";
		const REMARKS = "remarks";
		const STATUS = "status";
		
		// Schedule status
		const UPCOMING = 1;
		const CANCELLED = 2;
		const OVERDUE = 3;
		
		
		static function getScheduleTime($time)
		{	
			return (date("h:i:s A", strtotime($time)));
		}
		
		/**
		 *	Returns the display name of the appointment date of the patient.
		 */
		static function getScheduleDate($date)
		{
			return (date("j M Y", strtotime($date)));
		}
		
		static function getStatus($status, $date)
		{			
			if ($status == self::UPCOMING)
			{
				$today = new DateTime(date('Y-m-d'));
				$anotherDay = new DateTime($date);
				
				return ($today > $anotherDay? self::OVERDUE: self::UPCOMING);
			}
			
			return self::CANCELLED;
		}
	}

?>
<?php

	/**
	 * 	class Message
	 *		- contains constants for returning appropriate messages
	 *		to be displayed on the site
	 */
	 
	 class Message{
	 
		/*
			variable identifiers
		 */
		public const
		
			FORM_ALPHASPACE			= 1,
			FORM_NUMBER				= 2,
			
			INVALID_DATE			= 3,
			INVALID_RECORD			= 4
			
		;
			
		/*
			message variables
		 */
	 
		private	
			
			$form_alphaspace	,					// used for the form fields where only letters and spaces are allowed
			$form_number		,					// used for the form fields where only numbers are allowed
		
			$invalidDate		, 					// used for inputs where only a set range of date is allowed
			$invalidRecord							// used for errors in inserting a record in the database
		
		;
		
		/*
			constructor
		 */
		public __construct($messageArray) {
		
			foreach ( $messageArray as $key => $val ) {
				$this -> $key = $val;
			}
		
		}
		
		/*
			getter
		 */
		public getMessage($message) {
			return $this -> $message;
		}

	}


?>
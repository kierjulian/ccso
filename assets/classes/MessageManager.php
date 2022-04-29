<?php
	/**
	 * 	class MessageManager
	 *		- contains constants and functionalities for returning appropriate messages
	 *		to be displayed on the site
	 */
	
	class MessageManager {
	 
		/*
			Supported Languages
		 */
		const			US_ENGLISH			= "us_en";
	 
		/*
		 *	constructor
		 */
		 
		function __construct($language = self::US_ENGLISH) {
			$this -> setLanguage( $language );
		}
		
		/*
		 *	Set the language to be used for messages.
		 *	Default is US English.
		 */
		public function setLanguage($language) {
			$functionName = "set_to_";
			switch($language) {
				default		: $functionName .= strval(self::US_ENGLISH);
			}
			$this -> $functionName();
		}
		
		/*
		 *	Message getter
		 */
		public function getMessage($message) {
			return $this -> $message;
		}
		
		/*
		 *	Set messages to US English
		 */
		private function set_to_us_en() {
			$this -> no_direct_access	= "No direct link access.";
				
			$this -> form_alphaspace	= "Only letters and space allowed in this field.";
			$this -> form_number		= "Only numbers are allowed in this field.";
			
			$this -> invalid_date		= "Invalid date provided.";
			$this -> invalid_record		= "Profile does not exist.";
			
			$this -> add_success		= "Click <a href='".base_url()."profile/view/%d'>here</a> to view the created record.%s <br>Click <a href='".base_url()."admit/add'>here</a> to add another record.";
			$this -> add_fail			= "Error saving patient record to database.";
			
			$this -> edit_success		= "Click <a href='".base_url()."profile/view/%d'>here</a> to view the edited record.%s <br>Click <a href='".base_url()."profile/edit/%d'>here</a> to go back to the edit form.";
			$this -> edit_fail			= "Error saving changes to profile.";
			
			$this -> queue_success		= "Click <a href='".base_url()."queue'>here</a> to view the consultation page.%s <br>Click <a href='".base_url()."profile/view/%d'>here</a> to view the patient record.";
			$this -> queue_add_fail		= "Error adding patient to queue.";
			$this -> queue_remove_fail	= "Error removing patient from queue.";
			
			$this -> patient_is_in_queue= "Patient is already queued.";
			
			$this -> schedule_success	= "Click <a href='".base_url()."schedule/index'>here</a> to view the scheduled consultation page.%s <br>Click <a href='".base_url()."profile/view/%d'>here</a> to view the patient record.";
			$this -> schedule_fail		= "Error saving schedule record to database.";
			
			$this -> upload_success		= "Click <a href='".base_url()."profile/view/%d'>here</a> to go back to the patient's profile.%s";
			$this -> upload_fail		= "Error uploading image to database";
			
			$this -> go_back_to_profile = "Go Back to Profile";
			
			$this -> get_printable		= "Get printable version";
		}
	 
	}
	
	/* Template
	
		this -> no_direct_access	= ;
				
		$this -> form_alphaspace	= ;
		$this -> form_number		= ;
		
		$this -> invalid_date		= ;
		$this -> invalid_record		= ;
		
		$this -> add_success		= ;
		$this -> add_fail			= ;
		
		$this -> edit_success		= ;
		$this -> edit_fail			= ;
		
		$this -> queue_success		= ;
		$this -> queue_add_fail		= ;
		$this -> queue_remove_fail	= ;
		
		$this -> patient_is_in_queue= ;
		
		$this -> schedule_success	= ;
		$this -> schedule_fail		= ;
		
		$this -> upload_success		= ;
		$this -> upload_fail		= ;
		
		$this -> go_back_to_profile = ;
		
		$this -> get_printable		= ;

	*/


?>
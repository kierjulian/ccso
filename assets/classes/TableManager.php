<?php	
	
	class TableManager {

		/* variable tableName
		 *		- name of the table this object will manage
		 *		@type string
		 */
		private 		$tableName;
		
		/* variable controller
		 *		- the CodeIgniter controller that will be used by this object
		 *		@type CI_Controller
		 */
		private			$controller;
		
		/* constructor
		 *		- the class constructor
		 *		@param		controller	: the CodeIgniter controller
		 *			@type 	CI_Controller		
		 *		@param		tableName	: the table name
		 *			@type	string
		 */
		function __construct( $controller, $tableName ) {
			$this -> controller 	= $controller;
			$this -> tableName		= $tableName;
		}
		
		/* function addRecord
		 *		- adds a record to the table
		 *		@param		data		: an array containing the keys representing the column names and the values
		 *								representing column values
		 *			@type	associative array
		 *
		 *		@return		boolean		: true if successful, else false
		 */
		public function addRecord( $data ) {

			// form the parenthesis part of the insert query
			$columnNames 	= "(";
			$columnValues	= "(";
			foreach( $data as $key => $val )  {
				$columnNames 	.= "$key, ";
				$columnValues	.= "$val, ";
			}	
			
			// replace the last comma found in the strings with a space
			$columnNames[ strlen($columnNames) - 2] = ' ';
			$columnValues[ strlen($columnValues) - 2] = ' ';
			
			$columnNames	.= ")";
			$columnValues	.= ")";
			
			$insertQuery 	= "INSERT INTO {$this -> tableName} $columnNames VALUES $columnValues;"; 
			
			return $this -> controller -> db -> query( $insertQuery );
		}
		
		/* function updateRecord
		 *		- updates a record found in the table
		 *		@param		data		: an array containing the keys representing the column names and the values
		 *								representing column values
		 *			@type	associative array
		 *		@param		restrictions: an array similar to the data array, but will be used to identify the records
		 *								to be modified
		 *			@type 	associative array
		 *
		 *		@return		boolean		: true if successful, else false
		 */
		public function updateRecord( $data, $restrictions = null ) {
		
			// form the update part of the update query
			$updateString = "";
			foreach( $data as $key => $val )  {
				$updateString 	.= "$key = $val, ";
			}	
			
			//replace the last comma found in the string with a space
			$updateString[ strlen($updateString) - 2] = ' ';
			
			$restrictString = $this -> formRestrictions($restrictions);
			$updateQuery = "UPDATE {$this -> tableName} SET $updateString $restrictString;";

			return $this -> controller -> db -> query( $updateQuery );	
		}
		
		/* function retrieveRecord
		 *		- retrieves records found in the table based on arguments passed
		 *		@param		columns		: array if containing the names of the columns to be retrieved
		 *			@type	numeric array
		 *		@param		restrictions: an array used to identify which records to retrieve.
		 *			@type 	array
		 *
		 *		@return		the array of records retrieved
		 */
		public function retrieveRecord( $columns = null, $restrictions = null ) {
		
			// form the select part of the query. all if null, else use columns
			if ( $columns == null ) {
				$selectString = "*";
			} else {
				$selectString = "(";
				foreach ( $columns as $val ) {
					$selectString .= $val . ", ";
				}
				
				// remove the last comma, replace with space
				$selectString[ strlen($selectString) - 2] = ' ';
				$selectString .= ")";
			}
		
			$restrictString = $this -> formRestrictions($restrictions);
			$retrieveQuery = "SELECT $selectString FROM {$this -> tableName} $restrictString;";
			
			return $this -> controller -> db -> query( $retrieveQuery );
		}
		
		/* function getNumOfRecords
		 *		- performs this class' retrieveRecord function and counts the number
		 *		of rows returned
		 *		@param		restrictions: an array used to identify which records to retrieve.
		 *			@type 	array
		 *		@return		the number of records retrieved
		 */
		public function getNumOfRecords( $restrictions = null ) {
			return $this -> retrieveRecord($column = null, $restrictions) -> num_rows();
		}
		
		/* 	function getTableName
		 *		- returns the table name
		 *		@returns	string	: the name of the table 
		 */
		public function getTableName() {
			return $this -> tableName;
		}
		
		/*	auxilliary function formRestrictions
		 *		- used to form the restrictions found in queries
		 *		- returns the formed string
		 *		- will immediately append the WHERE keyword if passed argument is not null
		 */
		private function formRestrictions($restrictions) {
			$restrictString = "";
			if ( $restrictions != null ) {
				$restrictString = "WHERE ";
			
				foreach( $restrictions as $key => $val )  {
					$restrictString 	.= "$key = $val AND ";
				}
				
				// remove the last AND in the string and replaces it with space
				$restrictLength = strlen($restrictString);
				for ($counter = $restrictLength - 4; $counter < $restrictLength - 1; $counter++) {
					$restrictString[$counter] = ' ';
				}
			}
			return $restrictString;
		}
		
	}

	/** Dev Log
	
		TableManager class
			- Allows the addition, retrieval, removal and the counting of
			record of the table associated with the object.
			
			> v0.0.0	; November 4, 2015
				- Copied this off the DatabaseManager class. Will try to generalize
				methods
				- Have generalized methods. Restrictions currently only support the "AND" keyword
				- DOES NOT SANITIZE ARGUMENTS. FEED IT WITH PC-BREAKING CODE AT YOUR OWN RISK.
			
	*/

?>



	












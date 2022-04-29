<?php	

	require_once "Image.php";
	require_once "TableManager.php";
	
	class ImageTableManager extends TableManager {
		
		function __construct( $controller, $tableName ) {
			parent::__construct($controller, $tableName);
		}
		
		public function addImageRecord( $imagedata, $profileID, $dateAdded = null ) {
		
			if ( $dateAdded == null ) {
				$dateAdded 		= "now()";
			} else {
				$dateAdded		= mysql_real_escape_string($dateAdded);
			}
			
			$data = array (
					Image::TABLE_PROFILEID 	=> mysql_real_escape_string($profileID),
					Image::TABLE_TITLE		=> $imagedata['title'],
					Image::TABLE_IMAGEPATH	=> $imagedata['path'],
					Image::TABLE_CONTENT	=> $imagedata['content'],
					Image::TABLE_CATEGORY	=> $imagedata['category'],
					Image::TABLE_TAGS		=> "' {$imagedata['tags']},'",
					Image::TABLE_DATEADDED	=> $dateAdded,
					Image::TABLE_DATEMODDED => $dateAdded
				);
		
			return $this -> addRecord( $data );
			
		}
		
		public function updateImageRecord ( $dataArray, $profileID, $imageID, $dateModified = null ) {
		
			if ( $dateModified == null ) {
				$dateModified 	= "now()";
			} else {
				$dateModified	= mysql_real_escape_string($dateModified);
			}

			$data = array (
					Image::TABLE_DATEMODDED 	=> $dateModified,
				);
				
			foreach ( $dataArray as $key => $val ) {
				$data[$key] = $val;
			
			}
		
			$restrictions = array (
					Image::TABLE_PROFILEID		=> mysql_real_escape_string($profileID),
					Image::TABLE_IMAGEID		=> mysql_real_escape_string($imageID)
				);
		
			return $this -> updateRecord( $data, $restrictions );
			
		}
		
		public function retrieveImageRecord( $profileID, $imageID = null ) {
		
			$restrictions = array(
					Image::TABLE_PROFILEID 	=> mysql_real_escape_string($profileID)
				);
			
			if ( $imageID != null ) {
				array_push( $restrictions, Image::TABLE_IMAGEID, mysql_real_escape_string($imageID) );
			}
		
			return $this -> retrieveRecord($columns = null, $restrictions);
		
		}
		
		public function getNumOfRecords( $profileID = null ) {
		
			if ( $profileID == null ) {
				$array = null;
			} else {
				$array = array( Image::TABLE_PROFILEID => $profileID );
			}
			return parent::getNumOfRecords($array);
			
		}
		
	}

	
	/** Dev Log
	
		DatabaseManager class
			- responsible for updating the database associated with the 
			uploaded image
			
			> v0.0.0	; Oct 20, 2015
				- created the class
				- creates a table for storing image data, if table is non-existent
				- has functions for inserting and updating image data
				- *TAGS ARE NOT YET IMPLEMENTED*
				
			> v0.0.1	; Oct 20, 2015
				- Renamed and repurposed to a database manager class
				(previous version was an uploader class)
				
						; Oct 21, 2015
				- Finished the class. Creates table to DB if non-existent. Table references to profile ID found in the main table.
				Basic Retrieve, Update and Add Record operations.
				
			> v0.1.0	; Oct 26, 2015
				- Modified this class to remove dependency from the now-deprecated ImageData class
				- Parameters with the name 'imagedata' will now be considered as an array
				
			> v0.1.1	; Oct 27, 2015
				- Merged a few methods with the same functionality but different parameters
					- retrieveSpecificImageRecord && retrieveAllImageRecord 		--> retrieveImageRecord
					- getTotalNumOfRecords && getSpecificNumOfRecords 				--> getNumOfRecords
					- updateImageRecord_userinputs && updateImageRecord_onefield	--> updateImageRecord
					
			> v0.2.0	; Nov 4, 2015
				- Rearranged the codes to match the parent class "TableManager"
			
	*/

?>



	












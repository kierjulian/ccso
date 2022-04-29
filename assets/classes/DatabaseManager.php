<?php

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
				- merged a few methods with the same functionality but different parameters
					- retrieveSpecificImageRecord && retrieveAllImageRecord 		--> retrieveImageRecord
					- getTotalNumOfRecords && getSpecificNumOfRecords 				--> getNumOfRecords
					- updateImageRecord_userinputs && updateImageRecord_onefield	--> updateImageRecord
			
	*/
	
	require_once "UploaderLibConstants.php";
	
	class DatabaseManager {
	
	
		/*
		 *
		 *
		 */
		private 		$imageTableName		= Image::TABLE_NAME;
						
		private			$controller;
		private			$mainTableName;
		private			$mainColumnName;
	
		function __construct( $controller, $maintablename, $primaryCol ) {
			$this -> controller 	= $controller;
			$this -> mainTableName	= mysql_real_escape_string($maintablename);
			$this -> mainColumnName	= mysql_real_escape_string($primaryCol);
		}
		
		public function addImageRecord( $imagedata, $profileID, $dateAdded = null ) {
			
			$imageTableName		= $this -> imageTableName;
			
			$profileID			= mysql_real_escape_string($profileID);
			
			if ( $dateAdded == null ) {
				$dateAdded 		= "now()";
			} else {
				$dateAdded		= mysql_real_escape_string($dateAdded);
			}
			
			$pidname			= Image::TABLE_PROFILEID;
			$iidname			= Image::TABLE_IMAGEID;
			$imagename			= Image::TABLE_TITLE;
			$imagepath			= Image::TABLE_IMAGEPATH;
			$content			= Image::TABLE_CONTENT;
			$category			= Image::TABLE_CATEGORY;
			$dateaddname		= Image::TABLE_DATEADDED;
			$datemodname		= Image::TABLE_DATEMODDED;
			
			//$imagename_val		= $imagedata -> get( UploaderLibConstants::USERINPUT_HTMLID['title'] );
			//$content_val		= $imagedata -> get( UploaderLibConstants::USERINPUT_HTMLID['content'] );
			//$category_val		= $imagedata -> get( UploaderLibConstants::USERINPUT_HTMLID['category'] );
			//$imagepath_val		= $imagedata -> get( UploaderLibConstants::IMAGE_HTMLID );
			
			$imagename_val		= $imagedata['title'];
			$content_val		= $imagedata['content'];
			$category_val		= $imagedata['category'];
			$imagepath_val		= $imagedata['path'];
			$imageID_val		= $this -> getNumOfRecords( $profileID );
			
			
			$insertQuery = "INSERT INTO $imageTableName 
									($pidname	, $imagename		, $content		, $category		, $dateaddname	, $datemodname	, $imagepath) 
							VALUES	($profileID	, '$imagename_val'	, '$content_val', '$category_val', $dateAdded	, $dateAdded	, '$imagepath_val')
							;";
							
			$this -> controller -> db -> query( $insertQuery );
			
		}
		
		public function updateImageRecord ( $dataArray, $profileID, $imageID, $dateModified = null ) {
		
			$datemodname		= Image::TABLE_DATEMODDED;
			$pidname			= Image::TABLE_PROFILEID;
			$iidname			= Image::TABLE_IMAGEID;
			
			$profileID			= mysql_real_escape_string($profileID);
			$imageID			= mysql_real_escape_string($imageID);
			
			if ( $dateModified == null ) {
				$dateModified 	= "now()";
			} else {
				$dateModified	= mysql_real_escape_string($dateModified);
			}
			
			$insertQuery 		= "UPDATE $imageTableName SET ";
							
		
			foreach ( $dataArray as $key => $val ) {
				$insertQuery = 	$insertQuery 					. " " 	. 
								mysql_real_escape_string($key) 	. " = " . 
								mysql_real_escape_string($val) 	. ", "	;
			}
			$insertQuery	.= "$datemodname = $dateModified WHERE $pidname = $profileID AND $iidname = $imageID;";

			return $this -> controller -> db -> query( $insertQuery );	

		}
		
		/*
		public function updateImageRecord_userinputs( $imagedata, $profileID, $imageID, $dateModified ) {
			
			$imageTableName		= $this -> imageTableName;
			
			
			
			$imagename			= UploaderLibConstants::IMAGETABLE['title'];
			$content			= UploaderLibConstants::IMAGETABLE['content'];
			$category			= UploaderLibConstants::IMAGETABLE['category'];
			
			$imagename_val		= $imagedata['title'];
			$content_val		= $imagedata['content'];
			$category_val		= $imagedata['category'];
			
			//$imagename_val		= $imagedata -> get($imagename);
			//$content_val		= $imagedata -> get($content);
			//$category_val		= $imagedata -> get($category);
			
			$insertQuery = "UPDATE '$imageTableName' 
							SET	$imagename 	= '$imagename_val',
								$content	= '$content_val',
								$category	= '$category_val',
								$datemodname= $dateModified
							WHERE $pidname = $profileID AND $iidname = $imageID
							;";
							
			$this -> controller -> db -> query( $insertQuery );	
		
		}
		
		public function updateImageRecord_onefield( $columnName, $columnVal, $profileID, $imageID, $dateModified ) {
		
			$imageTableName	= $this -> imageTableName;
			$mainTableName	= $this -> mainTableName;
			
			$profileID			= mysql_real_escape_string($profileID);
			$imageID			= mysql_real_escape_string($imageID);
			$dateModified		= mysql_real_escape_string($dateModified);
			$columnName			= mysql_real_escape_string($columnName);
			$columnVal			= mysql_real_escape_string($columnVal);
			
			$insertQuery = "UPDATE '$imageTableName' 
							SET	$columnName		= '$columnVal',
								$datemodname	= $dateModified
							WHERE $pidname = $profileID AND $iidname = $imageID
							;";
							
			$this -> controller -> db -> query( $insertQuery );	
		
		}
		*/
		
		public function retrieveImageRecord( $profileID, $imageID = null ) {
		
			$imageTableName		= $this -> imageTableName;
			
			$profileID			= mysql_real_escape_string($profileID);
			$pidname			= Image::TABLE_PROFILEID;
			$retrieveQuery		= "SELECT * FROM $imageTableName WHERE $pidname = $profileID";

			if ( $imageID != null ) {
				$iidname			= Image::TABLE_IMAGEID;
				$imageID			= mysql_real_escape_string($imageID);
				$retrieveQuery		.=  "AND $iidname = $imageID";
			}
			$retrieveQuery		.= ";";
			
			return $this -> controller -> db -> query( $retrieveQuery );
		}
		/*
		public function retrieveSpecificImageRecord( $profileID, $imageID ) {
		
			$imageTableName		= $this -> imageTableName;
			
			$profileID			= mysql_real_escape_string($profileID);
			$imageID			= mysql_real_escape_string($imageID);
			
			$pidname			= UploaderLibConstants::IMAGETABLE['profile_id'];
			$iidname			= UploaderLibConstants::IMAGETABLE['image_id'];
			
			$retrieveQuery		= "SELECT * FROM '$imageTableName' WHERE $pidname = $profileID AND $iidname = $imageID";
			
			return $this -> controller -> db -> query( $retrieveQuery );

		}
		
		public function retrieveAllImageRecord( $profileID ) {
		
			$imageTableName		= $this -> imageTableName;
			
			$profileID			= mysql_real_escape_string($profileID);
			$pidname			= UploaderLibConstants::IMAGETABLE['profile_id'];
			
			$retrieveQuery		= "SELECT * FROM '$imageTableName' WHERE $pidname = $profileID";
			
			return $this -> controller -> db -> query( $retrieveQuery );
			
		}
		*/
		
		public function getNumOfRecords( $profileID = null ) {
		
			$imageTableName = $this -> imageTableName;
			
			$pidname		= Image::TABLE_PROFILEID;
			
			$query			= "SELECT $pidname FROM $imageTableName";
			
			if ( $profileID != null ) {
				$pidname	= Image::TABLE_PROFILEID;
				$query		.= " WHERE $pidname = $profileID";
			}
			$query 			.= ";";
		
			return $this -> controller -> db -> query( $query ) -> num_rows();
		}
		/*
		public function getTotalNumOfRecords() {
			$imageTableName = $this -> imageTableName;
			return $this -> controller -> db -> query( "SELECT COUNT(*) from $imageTableName;" ) -> num_rows();
		}
		
		public function getSpecificNumOfRecords( $profileID ) {
			$imageTableName = $this -> imageTableName;
			$pidname		= UploaderLibConstants::IMAGETABLE['profile_id'];
			$query			= "SELECT $pidname FROM $imageTableName WHERE $pidname = $profileID";
			
			return $this -> controller -> db -> query( $query ) -> num_rows();
		}
		
		private function createImageTable() {
			
			$imageTableName 	= $this -> imageTableName;
			$mainTableName		= $this -> mainTableName;
			$mainColumnName		= $this -> mainColumnName;
			
			$maxLength			= UploaderLibConstants::IMAGETABLE['maxlength'];
			$maxLengthLong		= UploaderLibConstants::IMAGETABLE['maxlengthlong'];
			
			$pidname			= UploaderLibConstants::IMAGETABLE['profile_id'];
			$iidname			= UploaderLibConstants::IMAGETABLE['image_id'];
			$imagepath			= UploaderLibConstants::IMAGETABLE['image_path'];
			$imagename			= UploaderLibConstants::IMAGETABLE['title'];
			$content			= UploaderLibConstants::IMAGETABLE['content'];
			$category			= UploaderLibConstants::IMAGETABLE['category'];
			$daddname			= UploaderLibConstants::IMAGETABLE['date_added'];
			$dmodname			= UploaderLibConstants::IMAGETABLE['date_modified'];
	
			$createTableQuery = 
					" CREATE TABLE IF NOT EXISTS $imageTableName (" 			.
					"	$pidname 	bigint NOT NULL, "		.
					"	$iidname	mediumint, "	.
					" 	$imagename 	varchar($maxLength), "		.
					" 	$imagepath 	varchar($maxLength), "		.
					" 	$content 	varchar($maxLengthLong), "	.
					" 	$category	tinyint,"					.
					"	$daddname 	date,"						.
					"	$dmodname 	date,"						.
					"	PRIMARY KEY($pidname, $iidname),"		.
					"	FOREIGN KEY($pidname) REFERENCES $mainTableName($mainColumnName) " .
					");"
					;
					
					$this -> controller -> db -> query( $createTableQuery );

		}
		*/
	
	}


?>













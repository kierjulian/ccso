<?php

	/**

		UploaderLibConstants class
			- contains constants used by the library and can be used outside the library for sync-ing purposes.
			
			> v0.0.0; Oct 20, 2015
				- created the class
			
			> v0.0.1; Oct 29, 2015
				- name change: 	UploaderLibConstants --> Image
				- kinalas ang array
	
	*/

	class Image {
	
		/*
			le const
		*/
			const
	
		/*					
			HTML names for view 'patientview'
		*/					
			HTML_TITLE			= "ultitle",
			HTML_CONTENT		= "ulcontent",
			HTML_CATEGORY		= "ulcategory",
			HTML_TAGS			= "ultags",
			HTML_FILE 			= "ulimagepath",
			HTML_SUBMITBUTTON	= "ulsubmit",
			HTML_ADDTAGBUTTON 	= "uladdtag",
							
		/*				
			Table constants
		*/			
			TABLE_PROFILEID		= "profile_id",
			TABLE_IMAGEID		= "image_id",
			TABLE_IMAGEPATH		= "image_path",
			TABLE_DATEADDED		= "date_added",
			TABLE_DATEMODDED	= "date_modif",
			TABLE_IMAGETAGS		= "image_tags",
			TABLE_TITLE			= "image_name",
			TABLE_CONTENT		= "image_comments",
			TABLE_CATEGORY		= "image_category",
			TABLE_TAGS			= "image_tags",
			TABLE_NAME			= "images",

			
		/*
			Tags choices values
		*/
			
			COLOR				= "color",
			GROSS				= "gross",
			INTRA_PRESS			= "iop",
			
			NT_EOG				= "neurophy_eog",
			NT_VER				= "neurophy_ver",
			
			OCC_ULTRA			= "utz",
			
			OCT_DISC			= "oct_disc",
			OCT_MACULA			= "oct_macula",
			OCT_OTHER			= "oct_other",
			
			POST_POLES			= "posterior_pole",
			PUPIL_EXAM			= "pupils",
						
			REFRACTION			= "refraction",
			
			RET_IMAGING			= "ret_img",
			
			STEREOACUITY		= "stereoacuity",
			
			SLIT_LAMP			= "slit_lamp",
			STRAB_DUCTION		= "strab_duction",
			STRAB_FUS_AMPLITUDE = "strab_fusional_amplitude",
			STRAB_MEASUREMENT	= "strab_measurement",
			STRAB_VERSION		= "strab_version",
			
			VISUAL_ACUITY		= "visual_acuity",
			
			VISUAL_FIELDS		= "visual_field",
			
			AT_OTHERS			= "others",
		/*
			Category values
		*/
			PROFILEPICTURE		= 1,
			RESULT				= 2,
			EYE_EXAM			= 3,
			ANCILLARY_TEST      = 4,
			OTHERS				= 5

			;
		
		const BASEPATH = "/assets/img/profiles/";
		
			
		/*
		 *
		 *
		 */
		public static function getCategory($category) {
			switch($category) {
				case self::PROFILEPICTURE 	: return "Profile Picture";
				case self::RESULT 			: return "Result";
				case self::EYE_EXAM			: return "Eye Exam";
				case self::ANCILLARY_TEST   : return "Ancillary Test";
				case self::OTHERS	 		: return "Others";
			}
		}
		
		/*
		 *
		 *
		 */
		public static function trimTitle($title, $limit = 25) {
		
			if ( strlen($title) > $limit ) {
				return substr($title, 0, $limit) . "...";
			} else {
				return $title;
			}
		
		}
		
		public static function getFilename()
		{
			return ((string) strtotime(date("Y-m-d h:i:s A")));
		}
		
		public static function getDirectory($id)
		{
			return sprintf("%s%s/", self::BASEPATH, $id);
		}
		


			
							
	}


?>
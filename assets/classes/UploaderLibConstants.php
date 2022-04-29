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

	class UploaderLibConstants {
	
				const 		USERINPUT_HTMLID = array (
								'title' 	=> "ultitle",
								"content"	=> "ulcontent",
								"category"	=> "ulcategory",
								"tags"		=> "ultags"
							),
							
							
							
							IMAGE_HTMLID 		= "ulimagepath",
							PROFILE_DBID		= "ulprofileid",
							SUBMITBUTTON_HTMLID	= "ulsubmit",
							
							//BASEPATH			= "assets/img/profiles/",
							
							IMAGETABLE = array (
								"maxlength" 	=> 200,
								"maxlengthlong"	=> 2000,
								
								"profile_id"	=> "profile_id",
								"image_id"		=> "image_id",
								"image_path"	=> "image_path",
								"date_added"	=> "date_added",
								"date_modified"	=> "date_modif",
								"image_tags"	=> "image_tags",
								
								"title"			=> "image_name",
								"content"		=> "image_comments",
								"category"		=> "image_category",
								"tags"			=> "image_tags",
								
								"table_name"	=> "tu_imagetable"
							)
							
							
							
							;	
							
	}


?>
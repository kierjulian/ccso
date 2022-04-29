<?php
	header('Content-disposition: attachment;
	filename=Preop Instructions.pdf');
	header('Content-type:application/pdf');
	readfile('Preop Instructions.pdf');
?>

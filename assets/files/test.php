<?php
header('Content-disposition: attachment;filename=test.txt');header('Content-type:application/txt');readfile('test.txt');
?>
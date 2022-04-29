<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('table_create'))
{
	function table_create($table = array())
	{
		$str = '<table ';
		foreach ($table as $key => $val)
		{
			$str .= $key . '="' . $val . '" ' ;
		}
		$str .= '>'."\n";
		return $str;
	}
}
if ( ! function_exists('tr'))
{
	function tr($row = array())
	{
		$str = '<tr>'."\n";
		foreach($row as $col)
		{
			$str .= '<th>'.$col.'</th>'."\n";
		}
	$str .= '</tr>'."\n";
	return $str;
	}
}
if ( ! function_exists('table_end'))
{
	function table_end()
	{
		return '</table>';
	}
}


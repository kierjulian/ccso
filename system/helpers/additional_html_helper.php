<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->helper('url');
$this->load->helper('additional_html');

if ( ! function_exists('a_tag'))
{
	function a_tag($link, $data)
	{
		return '<a href = "'.base_url().$link.'">'.$data.'</a>';
		
	}
}
if ( ! function_exists('font'))
{
	function font($id = '', $label = '')
	{
		return "\n".'<font id="'.$id. '">'. $label.'</font><br>';
	}
}
if ( ! function_exists('div'))
{
	function div($id = '', $align = '')
	{
		return "\n".'<div id="'.$id. '" align ="'.$align.'">';
	}
}
if( ! function_exists('add_tag'))
{
	function add_tag($name, $array)
	{
		$str = "\n".'<'.$name.' ';
		if(is_array($array))
		{
			foreach($array as $key => $val)
			{
				$str .= $key . '="' . $val . '" ' ;
			}
		}
		$str .= '>'."\n";
		return $str;
	}	
}	
if( ! function_exists('end_tag'))
{
	function end_tag($name)
	{
		$str = '</'.$name.'>'."\n";
		return $str;
	}	
}
if( ! function_exists('sing_tag'))
{
	function sing_tag($name, $label)
	{
		$str = "\n".'<'.$name.'>'.$label.'</'.$name.'>'."\n";
		return $str;
	}	
}	
?>
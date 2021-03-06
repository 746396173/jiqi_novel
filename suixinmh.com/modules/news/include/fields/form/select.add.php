<?php 
if(!$maxlength) $maxlength = 10;
$fieldtype = $setting[fieldtype];
$defaultvalue = $setting[defaultvalue];
$multiple = $setting[multiple];//是否多选列表框
if(!$multiple){
	if($fieldtype == 'INT')
	{
		$defaultvalue = intval($defaultvalue);
		if($defaultvalue > 2147483647) $defaultvalue = 0;
		if($maxlength > 10) $maxlength = 11;
	}
	else if($fieldtype == 'MEDIUMINT')
	{
		$defaultvalue = intval($defaultvalue);
		if($defaultvalue > 8388607) $defaultvalue = 0;
		if($maxlength > 6) $maxlength = 7;
	}
	else if($fieldtype == 'SMALLINT')
	{
		$defaultvalue = intval($defaultvalue);
		if($defaultvalue > 32767) $defaultvalue = 0;
		if($maxlength > 4) $maxlength = 5;
	}
	else if($fieldtype == 'TINYINT')
	{
		$defaultvalue = intval($defaultvalue);
		if($defaultvalue > 127) $defaultvalue = 0;
		if($maxlength > 2) $maxlength = 3;
	}
	$sql = "ALTER TABLE `$tablename` ADD `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$defaultvalue'";
}else{
	$sql = "ALTER TABLE `$tablename` ADD `$field` ";
	$maxlength = max(intval($maxlength), 0);
	$sql .= ($maxlength && $maxlength <= 255) ? "VARCHAR( $maxlength ) NOT NULL DEFAULT '{$defaultvalue}'" : "MEDIUMTEXT NOT NULL";
}
$_SGLOBAL['db']->db->query($sql);
?>
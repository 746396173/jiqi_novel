<?php
$sql = "ALTER TABLE `$tablename` ADD `$field` ";
$maxlength = max(intval($maxlength), 0);
$sql .= ($maxlength && $maxlength <= 1000) ? "VARCHAR( $maxlength ) NOT NULL DEFAULT '{$setting[defaultvalue]}'" : "MEDIUMTEXT NOT NULL";
$_SGLOBAL['db']->db->query($sql);
?>
<?php
function get_post($con, $var)
{
	return $con->real_escape_string($_POST[$var]);
}
function get_get($con, $var)
{
	return $con->real_escape_string($_GET[$var]);
}
?>
<?php
ob_start();
session_start();
mysql_connect("localhost","root","");
mysql_select_db("jobsearch2") or die ("No Database");
?>
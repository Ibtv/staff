<?php
	$DB_HOST = "localhost";
	$DB_USER = "root_sql_en";
	$DB_PASS = "ibtv_rootmysql";
	$DB_NAME = "ibtv_staff";
	$con = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	mysql_select_db($DB_NAME);
	mysql_query('set names utf8');
	if (!$con)
	  {
	  	die('错误: ' . mysql_error());
	  }
	  	/*员工信息*/
	$staff = array();$s=0;
	$Staff_sql = "SELECT `s_Name`,`s_Position`,`s_Image`,`s_Content` FROM `i_staff` order by `s_Id` DESC";
  	$Staff_sql_result = mysql_query($Staff_sql) or die("员工信息查询失败!");
		while($S_message = mysql_fetch_array($Staff_sql_result)){
					$staff[$s]['id'] =$S_message['s_Id'];
					$staff[$s]['image'] =$S_message['s_Image'];
					$staff[$s]['name'] =$S_message['s_Name'];
					$staff[$s]['position'] =$S_message['s_Position'];
					$staff[$s]['content'] =$S_message['s_Content'];
					$s++;
		}
?>

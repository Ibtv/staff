<?php
	error_reporting(E_ALL);
	$i=isset($_GET['i']) ? intval($_GET['i']) : 0;
	require_once("../My_SQL/_link.php");
	//  防止全局变量造成安全隐患
	$TZZS = false;
	//  启动会话
	session_start();
	@$session_path = "../_Sessionpath/".$_SESSION['TZZS'];//上传路径  
	if(!file_exists($session_path))  
	{  
		//检查是否有该文件夹，如果没有就创建，并给予最高权限  
		mkdir("$session_path", 0700);  
	}
	session_save_path(realpath($session_path)); 
	@setcookie(session_name(),session_id(),time()+900,"/".$_SESSION['TZZS']);  	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />
<title>后台管理系统</title>
<link rel = "stylesheet" href = "css/main.css">
<?php 
	//  判断是否登陆
	if (isset($_SESSION['TZZS']) and $_SESSION['TZZS'] != 0)
	{
			$id = $_SESSION['TZZS'];
			$group = $_SESSION['GroupId'];
			$name = $_SESSION['UserName'];
			$regdate = date("Y-m-d H:i:s", time());
			$ip = $_SERVER['REMOTE_ADDR'];
		if($_SESSION['land']!= 0)
		{
			$_SESSION['land'] = 0;
			$update_sql = "update `i_user` set u_Lasttime = u_Thistime , u_Thistime = '$regdate' , u_LastIp = u_ThisIp , u_ThisIp = '$ip', u_Number = u_Number + 1  where u_Id = $id";
			$down_path = "../file/";//上传路径  
			if(!file_exists($down_path))  
			{  
				//检查是否有该文件夹，如果没有就创建，并给予最高权限  
				mkdir("$down_path", 0700);  
			}
			mysql_query($update_sql,$con);	
		}
	}
	else
	{
		$_SESSION["TZZS"] = $_SESSION['land'] = $_SESSION['GroupId'] = $_SESSION['UserName'] = $_SESSION['Number'] = $group = $name = $TZZS;	
		die("<div align = 'center' style = 'margin-top:20%'><h1>登陆超时，请重新登陆<h1></div>");
	}
?>
</head>
<body>
<!--[if IE]>    
        <div style = "left:50%; margin-left:-20px; margin-top:15%;">本后台暂不支持IE内核浏览器。请使用其它浏览器。如Google Chrome、Opera、Maxthon、火狐浏览器等最新版本浏览器已完美展示本页面</div>
   		<meta http-equiv = "Refresh" content = "1;URL = index.html" />
<![endif]-->
    <div align = "center"></div>
    <div id = "top">
    	<h2>你好<?php echo $name;?></h2>
        <div class = jg></div>
        <div id = "topTags">
            <ul><li><?php 
				if		($i == 0 ){$Top_Title = '欢迎访问投资招商杂志（电子版）后台管理系统';}
				else if ($i == 10 ){$Top_Title = '个人资料';}
				else if ($i == 11 ){$Top_Title = '个人信息修改';}
				else if ($i == 20 ){$Top_Title = '用户管理';}
				else if ($i == 21 ){$Top_Title = '添加新用户';}
				else if ($i == 22 ){$Top_Title = '用户删除';}
				else if ($i == 30 ){$Top_Title = '企业员工';}
				else if ($i == 31 ){$Top_Title = '添加员工信息';}
				else if ($i == 32 ){$Top_Title = '删除员工信息';}
				else if ($i == 200){$Top_Title = '退出登录';}
				else			   {$Top_Title = '提示信息';}
				echo $Top_Title;
			?></li></ul>
        </div>
    </div>
<div id = "main"> 
<div id = "leftMenu">
<ul>
<a href = "?i=0  "><li>后台首页</li></a>
<a href = "?i=10 "><li>个人资料</li></a>
<a href = "?i=20 "><li>用户管理</li></a>
<a href = "?i=30"><li>企业员工</li></a>
<a href = "?i=200"><li>退出登录</li></a>
</ul>
</div>
<div class = jg></div>
<div id = "content">
    <div id = "welcome" class = "content" style = "display:block;">
<?php
switch($i){
case 0:
?>
        <div align = "center">
            <br /><br />
                <script charset = "Shift_JIS" src = "js/honehone_clock.js"></script>
            <br /><br />

                <?php
$User_sql = "SELECT `u_Id`,`u_LastIp`,`u_Lasttime`,`u_ThisIp` FROM `i_user` order by u_Id ";
$User_result = mysql_query($User_sql) or die("个人资料查询失败!");
$User_row = mysql_fetch_array($User_result);
?>
<table align = "center" width = "700" border = "0">
  <tr>
    <td style = "width:90px">欢迎您</td><td style = "width:180px"><?php echo $name;?></td>
    <td style = "width:90px">登陆次数</td><td style = "width:180px"><?php echo $_SESSION['Number'];?></td>
  </tr>
  <tr>
    <td>操作系统</td><td><?php echo PHP_OS;?></td>
    <td>运行环境</td><td><?php echo $_SERVER["SERVER_SOFTWARE"];?></td>
  </tr>
  <tr>
    <td>PHP运行方式</td><td><?php echo php_sapi_name();?></td>
    <td>MYSQL版本</td><td><?php echo mysql_get_server_info();?></td>
  </tr>
  <tr>
    <td>上传附件限制</td><td><?php echo ini_get('upload_max_filesize');?></td>
    <td>执行时间限制</td><td><?php if(!ini_get('max_execution_time')){echo '无限制';}else{echo ini_get('max_execution_time');};?></td>
  </tr>
  <tr>
    <td>文件地址</td><td><?php echo $_SERVER["DOCUMENT_ROOT"];?></td>
    <td>剩余空间</td><td><?php echo round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M';?></td>
  </tr>
  <tr>
    <td>本次登陆时间</td><td style = "width:185px"><?php echo date("Y-m-d", time());?></td>
    <td>本次登陆IP</td><td style = "width:185px"><?php echo $ip;?></td>
  </tr>
  <tr>
    <td>上次登陆时间</td><td><?php echo $User_row['u_Lasttime'];?></td>
    <td>上次登陆IP</td><td><?php echo $User_row['u_LastIp'];?></td>
  </tr>
</table>

        </div>
    </div>
<?php
break;
case 10:
$User_sql = "SELECT `u_Id`,`u_Name`,`u_Sex`,`u_GroupId`,`u_CreateDate`,`u_Address`,`u_QQ`,`u_Phone`,`u_Mailbox`,`u_LastIp`,`u_Lasttime`,`u_ThisIp` FROM `i_user` order by u_Id ";
$User_result = mysql_query($User_sql) or die("个人资料查询失败!");
$User_group = 0;
while ($User_row = mysql_fetch_array($User_result)) 
{
	if(250 < $User_row['u_GroupId']){$User_group = '超级管理员';}
	if(250 == $User_row['u_GroupId']){$User_group = '高级管理员';}
	if(200 == $User_row['u_GroupId']){$User_group = '普通管理员';}
	if(150 == $User_row['u_GroupId']){$User_group = '信息审核员';}
	if(100 == $User_row['u_GroupId']){$User_group = '信息发布员';}
	if(50 == $User_row['u_GroupId']){$User_group = '无权限';}
	if(50 > $User_row['u_GroupId']){$User_group = '游客';}
	if ($_SESSION['TZZS'] == $User_row['u_Id'])
	{?>
<table align = "center" width = "700" border = "1">
  <tr>
    <td style = "width:80px">用户ID</td><td style = "width:185px"><?php echo $User_row['u_Id'];?></td>
    <td style = "width:80px">用户名</td><td style = "width:185px"><?php echo $User_row['u_Name'];?></td>
  </tr>
  <tr>
    <td>性别</td><td><?php echo $User_row['u_Sex'];?></td>
    <td>用户权限</td><td><?php echo $User_group;?></td>
  </tr>
  <tr>
    <td>电话</td><td><?php echo $User_row['u_Phone'];?></td>
    <td>地址</td><td><?php echo $User_row['u_Address'];?></td>
  </tr>
  <tr>
    <td>QQ</td><td><?php echo $User_row['u_QQ'];?></td>
    <td>邮箱</td><td><?php echo $User_row['u_Mailbox'];?></td>
  </tr>
  <tr>
    <td>注册日期</td><td><?php echo $User_row['u_CreateDate'];?></td>
    <td>上次登陆IP</td><td><?php echo $User_row['u_LastIp'];?></td>
  </tr>
  <tr>
    <td>上次登陆时间</td><td><?php echo $User_row['u_Lasttime'];?></td>
    <td>本次登陆IP</td><td><?php echo $User_row['u_ThisIp'];?></td>
  </tr>
</table>

<?php
	}
}
?>
<div style="text-align:center;">
<a href = "?i=11" class="dilog_bmit">修改资料</a>
<a href = "?i=12" class="dilog_bmit">修改密码</a>
</div>
<?php
mysql_free_result($User_result);
break;
case 11:
$User_select_sql = "SELECT `u_Id`,`u_Name`,`u_Sex`,`u_Password`,`u_CreateDate`,`u_Address`,`u_QQ`,`u_Phone`,`u_Mailbox`,`u_Lasttime`,`u_LastIp`,`u_ThisIp`FROM `i_user` order by u_Id ";
$User_result = mysql_query($User_select_sql) or die("个人信息修改查询失败!");
while ($User_row = mysql_fetch_array($User_result)) 
{
	if ($_SESSION['TZZS'] == $User_row['u_Id'])
	{
		?>
<form name = "RegForm" method = "post" action = "?i=16" onSubmit = "return InputCheck(this)">
<table align = "center" width = "700" border = "1">
  <tr>
    <td style = "width:80px">用户ID</td><td style = "width:165px"><input name = "u_Id" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_Id'];?>" readonly /></td>
    <td style = "width:80px">用户名</td><td style = "width:165px"><input name = "u_Name" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_Name'];?>" readonly /></td>
  </tr>
  <tr>
    <td>性别</td>
    <td>
        <select name = "u_Sex" class = "table_Name" type = "text" >
            <?php
				if($User_row['u_Sex'] == '女')
				{
					?>
                        <option selected>男</option>
                        <option selected>女</option>
                    <?php
					}
					
				if($User_row['u_Sex'] == '男')
				{
					?>
                        <option selected>女</option>
                        <option selected>男</option>
                    <?php
					}
			?>
        </select>
	</td>
    <td>电话</td>
    <td><input name = "u_Phone" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_Phone'];?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength = 13 /></td>
  </tr>
  <tr>
</table>
<table align = "center" width = "700" border = "1" style="margin-top:-1px;">
    <td style = "width:110px">地址</td>
    <td>
        <select id="s_province" name = "u_Province" style="width:187px;" selected></select>
        <select id="s_city" name = "u_City" style="width:186px;" selected></select>	
        <select id="s_county" name = "u_County" style="width:186px;" selected></select>	
		<script class="resources library" src="js/area.js" type="text/javascript"></script>
        <script type="text/javascript">_init_area();</script>
     </td>
  </tr>
</table>
<table align = "center" width = "700" border = "1" style="margin-top:-1px;">
  <tr>
    <td style = "width:110px">QQ</td>
    <td><input name = "u_QQ" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_QQ'];?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength = 10/></td>
    <td>邮箱</td>
    <td><input name = "u_Mailbox" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_Mailbox'];?>" /></td>
  </tr>
  <tr>
    <td>注册日期</td>
    <td><input name = "u_Id" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_CreateDate'];?>" readonly /></td>
    <td>上次登陆IP</td>
    <td><input name = "u_LastIp" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_LastIp'];?>" readonly /></td>
  </tr>
  <tr>
    <td>上次登陆时间</td>
    <td><input name = "u_Lasttime" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_Lasttime'];?>" readonly /></td>
    <td>本次登陆IP</td>
    <td><input name = "u_ThisIp" type = "text" class = "table_Name"  value = "<?php echo $User_row['u_ThisIp'];?>" readonly /></td>
  </tr>
</table>
    <div style="text-align:center;">
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
        <input type = "Submit" id="btnSubmit" name = "btnSubmit" class="submitStyle" value = "确定" />
    </div>
</form>

		<?php
	}
}
mysql_free_result($User_result);
break;
case 12:
?>
<form name = "RegForm" method = "post" action = "?i=17" onSubmit = "return InputCheck(this)">
<table align = "center" width = "500" border = "1">
  <tr>
    <td style = "width:80px">旧密码<a style = "float:right">*</a></td>
    <td style = "width:165px"><input type = "password"  name = "temp_Password" class = "table_Name" maxlength = "32" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;" required = "required" /></td>
  </tr>
<tr>
    <td>密码<a style = "float:right">*</a></td>
    <td><input type = "password" class = "table_Name" name = "u_Password" maxlength = "32" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;" required = "required" /></td>
</tr>
<tr>
    <td>确认密码<a style = "float:right">*</a></td>
    <td><input type = "password" class = "table_Name" name = "u_Password2" maxlength = "32" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;" required = "required" /></td>
    </tr>
</table>
    <div style="text-align:center;">
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
        <input type = "Submit" id="btnSubmit" name = "btnSubmit" class="submitStyle" value = "确定" />
    </div>
</form>
<?php
break;
case 16:
if(!isset($_REQUEST['btnSubmit'])){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">非法访问</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   	break;
}

$sex = $_REQUEST['u_Sex'];
$phone = $_REQUEST['u_Phone'];
$province = $_REQUEST['u_Province'];
$city = $_REQUEST['u_City'];
$county = $_REQUEST['u_County'];
if($province == '省份')
{$province='';}
if($city == '地级市')
{$city='';}
if($county == '市、县级市')
{$county='';}
$address = $province.'-'.$city.'-'.$county;
$qq = $_REQUEST['u_QQ'];
$mailbox = $_REQUEST['u_Mailbox'];
$uesr_update_sql = "update i_user set 
u_Sex = '$sex',
u_Address = '$address',
u_QQ = '$qq',
u_Phone = '$phone',
u_Mailbox = '$mailbox'
where u_Id = $id";
if(mysql_query($uesr_update_sql,$con))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">个人信息修改成功</h4>
        <a href = "?i=10" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
} 
else {
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">添加数据失败</h4>
    	<h4 style="margin:10px 0"><?php mysql_error();?></h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
}
break;
case 17:
if(!isset($_REQUEST['btnSubmit'])){
	?>
    <div style="text-align:center;">
    	
    	<h4 style="margin:10px 0">非法访问</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   	break;
}
$temp_Password = $_REQUEST['temp_Password'];
$temp_Password2 = sha1($name.md5($_REQUEST['temp_Password']));
$password = sha1($name.md5($_REQUEST['u_Password']));
$password2 = sha1($name.md5($_REQUEST['u_Password2']));
if ($temp_Password)
{
 $sql = "SELECT * FROM i_user WHERE (u_Name = '$name') and (u_Password ='$temp_Password2')";
 $res = mysql_query($sql);
 $rows = mysql_num_rows($res);
 if(!$rows)
 {
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">旧密码错误</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
	 break;
 }
}else
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">密码不能为空</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
	}
if($password != $password2)
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">两次输入的密码不一致</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
}
$uesr_update_sql = "update i_user set u_Password = '$password' where u_Id = $id";
if(mysql_query($uesr_update_sql,$con))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户密码修改成功</h4>
        <a href = "?i=10" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
} 
else {
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">添加数据失败</h4>
    	<h4 style="margin:10px 0"><?php mysql_error();?></h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
}
break;
case 20:
?>
	<table width = "1200" border = "1">
  <tr>
    <td style = "width:20px">ID</td>
    <td style = "width:80px">用户名</td>
    <td style = "width:30px">性别</td>
    <td style = "width:60px">用户权限</td>
    <td style = "width:140px">注册日期</td>
    <td style = "width:250px">地址</td>
    <td style = "width:70px">QQ</td>
    <td style = "width:70px">电话</td>
    <td style = "width:90px">邮箱</td>
    <td style = "width:135px">上次登陆时间</td>
    <td style = "width:80px">上次登陆IP</td>
  </tr>
  <?php
	$User_select_sql = "SELECT `u_Id`,`u_Name`,`u_Sex`,`u_GroupId`,`u_CreateDate`,`u_Address`,`u_QQ`,`u_Phone`,`u_Mailbox`,`u_Lasttime`,`u_LastIp`FROM `i_user` order by u_Id ";
  	$User_result = mysql_query($User_select_sql) or die("用户管理查询失败!");
	$User_group = 0;
	while ($User_row = mysql_fetch_array($User_result)) 
	{ 
	if(250 < $User_row['u_GroupId']){$User_group = '超级管理员';}
	if(250 == $User_row['u_GroupId']){$User_group = '高级管理员';}
	if(200 == $User_row['u_GroupId']){$User_group = '普通管理员';}
	if(150 == $User_row['u_GroupId']){$User_group = '信息审核员';}
	if(100 == $User_row['u_GroupId']){$User_group = '信息发布员';}
	if(50 == $User_row['u_GroupId']){$User_group = '无权限';}
	if(50 > $User_row['u_GroupId']){$User_group = '游客';}
	?>
<tr>
    <td><?php echo $User_row['u_Id'];?></td>
    <td><?php echo $User_row['u_Name'];?></td>
    <td><?php echo $User_row['u_Sex'];?></td>
    <td><?php echo $User_group;?></td>
    <td><?php echo $User_row['u_CreateDate'];?></td>
    <td><?php echo $User_row['u_Address'];?></td>
    <td><?php echo $User_row['u_QQ'];?></td>
    <td><?php echo $User_row['u_Phone'];?></td>
    <td><?php echo $User_row['u_Mailbox'];?></td>
    <td><?php echo $User_row['u_Lasttime'];?></td>
    <td><?php echo $User_row['u_LastIp'];?></td>
</tr>
 		<?php
	}
?>
</table>
<div style="text-align:center;">
    <a href = "?i=21" class="dilog_bmit">添加用户</a>
    <a href = "?i=22" class="dilog_bmit">删除用户</a>
    <a href = "?i=23" class="dilog_bmit">权限修改</a>
</div>
<?php 
	mysql_free_result($User_result);
break;
case 21:
	$User_result = mysql_query("select * from `i_user`");
	list($User_result_count) = mysql_fetch_row($User_result);
	if($User_result_count >= 10)
	{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户数量达到上限。请删除后在添加</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
	}
	
	else
?>
<form name = "RegForm" method = "post" action = "?i=26" onSubmit = "return InputCheck(this)">
<table align = "center" width = "700" border = "1">
  <tr>
    <td style = "width:80px">用户名<a style = "float:right">*</a></td><td style = "width:165px"><input name = "u_Name" class = "table_Name"  onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" onKeypress="javascript:if(event.keyCode == 32)event.returnValue = false;" maxlength = 16 required = "required" /></td>
    <td>权限<a style = "float:right">*</a></td>
    <td>
    <select name = "u_GroupId" class = "table_Name" type = "text" >
            <option selected>高级管理员</option>
            <option selected>普通管理员</option>
            <option selected>信息审核员</option>
            <option selected>信息发布员</option>
            <option selected>无权限</option>
            <option selected>游客</option>
    </select>
    </td>
  </tr>
  <tr>
    <td style = "width:80px">密码<a style = "float:right">*</a></td><td style = "width:165px"><input type = "password" class = "table_Name" name = "u_Password"  maxlength = 32 required = "required" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;"/></td>
    <td style = "width:80px">再次输入<a style = "float:right">*</a></td><td style = "width:165px"><input type = "password" class = "table_Name" name = "u_Password2"  maxlength = 32 required = "required" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;"/></td>
  </tr>
  <tr>
    <td>性别</td><td>
        <select name = "u_Sex" class = "table_Name" type = "text" >
            <option selected>女</option>
            <option selected>男</option>
        </select></td>
    <td>电话</td><td><input name = "u_Phone" class = "table_Name" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength = 12/></td>
  </tr>
  <tr>
    <td>QQ</td><td><input name = "u_QQ" class = "table_Name" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength = 10/></td>
    <td>邮箱</td><td><input name = "u_Mailbox" type = "text" class = "table_Name" /></td>
  </tr>
  </table>
<table align = "center" width = "700" border = "1" style="margin-top:-1px;">
    <td style = "width:110px">地址</td>
    <td>
        <select id="s_province" name = "u_Province" style="width:187px;" selected></select>
        <select id="s_city" name = "u_City" style="width:186px;" selected></select>	
        <select id="s_county" name = "u_County" style="width:186px;" selected></select>	
		<script class="resources library" src="js/area.js" type="text/javascript"></script>
        <script type="text/javascript">_init_area();</script>
     </td>
  </tr>
</table>
    <div style="text-align:center;">
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
        <input type = "Submit" id="btnSubmit" name = "btnSubmit" class="submitStyle" value = "确定" />
    </div>
</form>
<?php
	mysql_free_result($User_result);
break;
case 22:
?>
<form name = "RegForm" method = "post" action = "?i=27" onSubmit = "return InputCheck(this)">
<table align = "center" width = "500" border = "1">
<tr>
	<td style = "width:80px">用户ID<a style = "float:right">*</a></td>
    <td style = "width:165px"><input name = "u_Id" class = "table_Name" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength = 3 required = "required" /></td>
    </tr>
<tr>
	<td>用户名<a style = "float:right">*</a></td>
    <td><input name = "u_Name" class = "table_Name" onkeyup = "value = value.replace(/[\W]/g,'') " onbeforepaste = "clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" maxlength = 16 required = "required" /></td>
    </tr>
    <tr>
	<td>权限<a style = "float:right">*</a></td>
    <td>
    <select name = "u_GroupId" class = "table_Name" type = "text" >
            <option selected>高级管理员</option>
            <option selected>普通管理员</option>
            <option selected>信息审核员</option>
            <option selected>信息发布员</option>
            <option selected>无权限</option>
            <option selected>游客</option>
    </select></td>
</tr>
<tr>
	<td>密码<a style = "float:right">*</a></td>
    <td><input name = "u_Password" type = "password" class = "table_Name" maxlength = 32 required = "required" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;"/></td>
    </tr>
    <tr>
	<td>再次输入<a style = "float:right">*</a></td>
    <td><input name = "u_Password2" type = "password" class = "table_Name" maxlength = 32 required = "required" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;"/></td>
</tr>
  <tr>
    <td>注</td><td><input class = "table_Name" value = "带*号为必填项目" readonly/></td>
  </tr>
</table>
    <div style="text-align:center;">
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
        <input type = "Submit" id="btnSubmit" name = "btnSubmit" class="submitStyle" value = "确定" />
    </div>
</form>
<?php
break;
case 23:
?>
<form name = "RegForm" method = "post" action = "?i=28" onSubmit = "return InputCheck(this)">
<table align = "center" width = "500" border = "1">
<tr>
	<td style = "width:80px">用户ID<a style = "float:right">*</a></td>
    <td style = "width:165px"><input name = "u_Id" class = "table_Name" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength = 3 required = "required" /></td>
    </tr>
<tr>
	<td>用户名<a style = "float:right">*</a></td>
    <td><input name = "u_Name" class = "table_Name" onkeyup = "value = value.replace(/[\W]/g,'') " onbeforepaste = "clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" maxlength = 16 required = "required" /></td>
    </tr>
    <tr>
	<td>权限<a style = "float:right">*</a></td>
    <td>
    <select name = "u_GroupId" class = "table_Name" type = "text" >
            <option selected>高级管理员</option>
            <option selected>普通管理员</option>
            <option selected>信息审核员</option>
            <option selected>信息发布员</option>
            <option selected>无权限</option>
            <option selected>游客</option>
    </select></td>
</tr>
<tr>
	<td>密码<a style = "float:right">*</a></td>
    <td><input name = "u_Password" type = "password" class = "table_Name" maxlength = 32 required = "required" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;"/></td>
    </tr>
    <tr>
	<td>再次输入<a style = "float:right">*</a></td>
    <td><input name = "u_Password2" type = "password" class = "table_Name" maxlength = 32 required = "required" onKeypress = "javascript:if(event.keyCode == 32)event.returnValue = false;"/></td>
</tr>
  <tr>
    <td>注</td><td><input class = "table_Name" value = "带*号为必填项目" readonly/></td>
  </tr>
</table>
    <div style="text-align:center;">
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
        <input type = "Submit" id="btnSubmit" name = "btnSubmit" class="submitStyle" value = "确定" />
    </div>
</form>
<?php
break;
case 26:
if(!isset($_REQUEST['btnSubmit'])){
	?>
    <div style="text-align:center;">
    	
    	<h4 style="margin:10px 0">非法访问</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   	break;
}

$Username = $_REQUEST['u_Name'];
$temp_Password = $_REQUEST['u_Password'];
$password = sha1($Username.md5($_REQUEST['u_Password']));
$password2 = sha1($Username.md5($_REQUEST['u_Password2']));
$permissions = $_REQUEST['u_GroupId'];
	if($permissions == '高级管理员'){$groupid = 250;}
	if($permissions == '普通管理员'){$groupid = 200;}
	if($permissions == '信息审核员'){$groupid = 150;}
	if($permissions == '信息发布员'){$groupid = 100;}
	if($permissions == '无权限'){$groupid = 50;}
	if($permissions == '游客'){$groupid = 0;}
$sex = $_REQUEST['u_Sex'];
$province = $_REQUEST['u_Province'];
$city = $_REQUEST['u_City'];
$county = $_REQUEST['u_County'];
if($province == '省份')
{$province='';}
if($city == '地级市')
{$city='';}
if($county == '市、县级市')
{$county='';}
$address = $province.'-'.$city.'-'.$county;
$qq = $_REQUEST['u_QQ'];
$phone = $_REQUEST['u_Phone'];
$mailbox = $_REQUEST['u_Mailbox'];
if(!$temp_Password){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">密码不能为空</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
}
if(!preg_match('/^[\w\x80-\xff]{4,16}$/', $Username))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户名需大于4个字符并小于16个字符</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
if($password != $password2)
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">两次输入的密码不一致</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
if(strlen($temp_Password) < 6 and strlen($temp_Password) > 32){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">密码长度需大于6个字符并小于32个字符</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
$check_query = mysql_query("select u_Name from i_user where u_Name = '$Username' limit 1");
if(mysql_fetch_array($check_query))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户名"<?php echo $Username;?>"已存在</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
if($groupid >= $group)
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">添加人员权限不得大于当前用户权限</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}

if(!$mailbox == "")   
{   
	preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/",$mailbox);
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">邮箱地址不正确</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php 
    break;
	  
}

$User_into_sql = "INSERT INTO `i_user`(
u_Name,u_Password,u_Sex,u_GroupId,u_CreateDate,u_Address,u_QQ,u_Phone,u_Mailbox,u_number)VALUES(
'$Username','$password','$sex','$groupid','$regdate','$address','$qq','$phone','$mailbox','0')";

if(mysql_query($User_into_sql,$con)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户添加成功</h4>
        <a href = "?i=20" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
} 
else {
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">添加数据失败</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
break;
case 27:
if(!isset($_REQUEST['btnSubmit'])){
	?>
    <div style="text-align:center;">
    	
    	<h4 style="margin:10px 0">非法访问</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   	break;
}
$UserId = $_REQUEST['u_Id'];
$Username = $_REQUEST['u_Name'];
$temp_Password = $_REQUEST['u_Password'];
$password = sha1($Username.md5($_REQUEST['u_Password']));
$password2 = sha1($Username.md5($_REQUEST['u_Password2']));
$permissions = $_REQUEST['u_GroupId'];
	if($permissions == '高级管理员'){$groupid = 250;}
	if($permissions == '普通管理员'){$groupid = 200;}
	if($permissions == '信息审核员'){$groupid = 150;}
	if($permissions == '信息发布员'){$groupid = 100;}
	if($permissions == '无权限'){$groupid = 50;}
	if($permissions == '游客'){$groupid = 0;}

if(!$temp_Password){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">提示:密码不能为空</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
}
if(strlen($temp_Password) < 6 and strlen($temp_Password) > 32){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">密码长度需大于6个字符并小于32个字符</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
//检测用户名是否已经存在
$check_query = mysql_query("select u_Id from i_user where u_Id = '$UserId'");
if(!mysql_fetch_array($check_query)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户ID"<?php echo $UserId;?>"不存在</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
$check_query = mysql_query("select u_Id from i_user where u_Id = '$UserId' and u_Name = '$Username'");
if(!mysql_fetch_array($check_query)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户名"<?php echo $Username,'"与"',$UserId;?>"不匹配，请输入正确的用户ID</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
if($name == $Username){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">不可以删除自己</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
//删除信息判断
$check_query = mysql_query("select u_Id from i_user where u_Id = '$UserId' and u_Name = '$Username' and  u_GroupId = '$groupid'");
if(!mysql_fetch_array($check_query)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户权限错误，无法删除"<?php echo $Username;?>"</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
if($group < $groupid)
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户权限小于对方，无法删除"<?php echo $Username;?>"</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
if($password != $password2)
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">两次输入的密码不一致</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
$check_query = mysql_query("select u_Id from i_user where u_Id = '$UserId' and u_Name = '$Username' and  u_Groupid >= '$groupid' and u_Password = '$password'");
if(!mysql_fetch_array($check_query))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户名"<?php echo $Username;?>"的密码不正确,无法进行删除操作，请重新输入</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}

//删除数据

	$User_delete_sql = "DELETE FROM i_user WHERE  u_Id = '$UserId' and u_Name = '$Username' and u_Password = '$password' and  u_GroupId = '$groupid'";
	if(mysql_query($User_delete_sql,$con))
	{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户删除成功</h4>
        <a href = "?i=20" class="dilog_bmit">返回</a>
    </div>
    <?php
    	break;
	}
	else
	{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">添加数据失败</h4>
    	<h4 style="margin:10px 0"><?php mysql_error();?></h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   		break;
	}
break;
case 28:
if(!isset($_REQUEST['btnSubmit'])){
	?>
    <div style="text-align:center;">
    	
    	<h4 style="margin:10px 0">非法访问</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   	break;
}
$UserId = $_REQUEST['u_Id'];
$Username = $_REQUEST['u_Name'];
$temp_Password = $_REQUEST['u_Password'];
$password = sha1($Username.md5($_REQUEST['u_Password']));
$password2 = sha1($Username.md5($_REQUEST['u_Password2']));
$permissions = $_REQUEST['u_GroupId'];
	if($permissions == '高级管理员'){$groupid = 250;}
	if($permissions == '普通管理员'){$groupid = 200;}
	if($permissions == '信息审核员'){$groupid = 150;}
	if($permissions == '信息发布员'){$groupid = 100;}
	if($permissions == '无权限'){$groupid = 50;}
	if($permissions == '游客'){$groupid = 0;}

if(!$temp_Password){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">提示:密码不能为空</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
}
if(strlen($temp_Password) < 6 and strlen($temp_Password) > 32){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">密码长度需大于6个字符并小于32个字符</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
if($name == $Username){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">不可以修改自己的权限</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}

if($password != $password2)
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">两次输入的密码不一致</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
//检测用户名是否已经存在
$check_query = mysql_query("select u_Id from i_user where u_Id = '$UserId'");
if(!mysql_fetch_array($check_query)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户ID"<?php echo $UserId;?>"不存在</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
$check_query = mysql_query("select u_Id from i_user where u_Id = '$UserId' and u_Name = '$Username'");
if(!mysql_fetch_array($check_query)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户名"<?php echo $Username,'"与"',$UserId;?>"不匹配，请输入正确的用户ID</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}

$check_query = mysql_query("select u_Id from i_user where u_Id = '$UserId' and u_Name = '$Username' and  u_GroupId <= 'group'");
if(!mysql_fetch_array($check_query))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户权限小于对方，无法修改"<?php echo $Username;?>"</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
$check_query = mysql_query("select u_Id from i_user where u_Id = '$UserId' and u_Name = '$Username' and  u_GroupId <= '$group' and  u_Password = '$password'");
if(!mysql_fetch_array($check_query))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户名"<?php echo $Username;?>"的密码不正确,无法进行修改操作，请重新输入</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
    break;
}
$uesr_update_sql = "update i_user set 
u_GroupId = '$groupid'
where 
u_Id = '$UserId' and 
u_Name = '$Username' and 
u_GroupId <= '$group'  and 
u_Password = '$password'";
if(mysql_query($uesr_update_sql,$con))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">用户权限修改成功</h4>
        <a href = "?i=20" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
} 
else {
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">数据修改失败</h4>
    	<h4 style="margin:10px 0"><?php mysql_error();?></h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
}
break;
case 30:
?>
<table align = "center" width = "805" border = "1">
  <tr>
    <td style = "width:30px">序号</td>
    <td style = "width:50px">姓名</td>
    <td style = "width:80px">职务</td>
    <td style = "width:400px">简介</td>
  </tr>
    <?php
	$Page_size=5; 
	$result=mysql_query('select * from i_staff'); 
	$count = mysql_num_rows($result); 
	$page_count = ceil($count/$Page_size); 
	$init=1; 
	$page_len=9; 
	$max_p=$page_count; 
	$pages=$page_count; 
	//判断当前页码 
	if(empty($_REQUEST['page'])||$_REQUEST['page']<0){ 
	$page=1; 
	}else { 
	$page=$_REQUEST['page']; 
	} 
	$offset=$Page_size*($page-1); 
	$staff_select_sql = "SELECT `s_Id`,`s_Name`,`s_Position`,`s_Image`,`s_Content` FROM `i_staff` order by s_Id limit $offset,$Page_size";
  	$staff_result = mysql_query($staff_select_sql) or die("员工信息查询失败!");
	while ($staff_row = mysql_fetch_array($staff_result)) 
	{
	?>
<tr>
    <td><?php echo $staff_row['s_Id'];?></td>
    <td><a target="_blank" href="<?php echo $staff_row['s_Image']?>"><?php echo $staff_row['s_Name'];?></a></td>
    <td><?php echo $staff_row['s_Position'];?></td>
    <td><?php echo mb_substr($staff_row['s_Content'],0,256,'utf-8');?></td>
</tr>
	<?php
	}
	$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数 
	$pageoffset = ($page_len-1)/2;//页码个数左右偏移量 
	
	$key='<div class="page">'; 
	$key.="<span>$page/$pages</span> "; //第几页,共几页 
	if($page!=1){ 
	$key.="<a href=\"".$_SERVER['PHP_SELF']."?i=30&page=1\">|<<</a> "; //第一页 
	$key.="<a href=\"".$_SERVER['PHP_SELF']."?i=30&page=".($page-1)."\"><</a>"; //上一页 
	}else { 
	$key.="|<< ";//第一页 
	$key.="<"; //上一页 
	} 
	if($pages>$page_len){ 
	//如果当前页小于等于左偏移 
	if($page<=$pageoffset){ 
	$init=1; 
	$max_p = $page_len; 
	}else{//如果当前页大于左偏移 
	//如果当前页码右偏移超出最大分页数 
	if($page+$pageoffset>=$pages+1){ 
	$init = $pages-$page_len+1; 
	}else{ 
	//左右偏移都存在时的计算 
	$init = $page-$pageoffset; 
	$max_p = $page+$pageoffset; 
	} 
	} 
	} 
	for($f=$init;$f<=$max_p;$f++){ 
	if($f==$page){ 
	$key.=' <span>'.$f.'</span>'; 
	} else { 
	$key.=" <a href=\"".$_SERVER['PHP_SELF']."?i=30&page=".$f."\">".$f."</a>"; 
	} 
	} 
	if($page!=$pages){ 
	$key.=" <a href=\"".$_SERVER['PHP_SELF']."?i=30&page=".($page+1)."\">></a> ";//下一页 
	$key.="<a href=\"".$_SERVER['PHP_SELF']."?i=30&page={$pages}\">>>|</a>"; //最后一页 
	}else { 
	$key.=" > ";//下一页 
	$key.=">>|"; //最后一页 
	} 
	$key.='</div>'; 
  ?>
</table>
<div align="center"><?php echo $key?></div>
<div style="text-align:center;">
    <a href = "?i=31" class="dilog_bmit">添加信息</a>
    <a href = "?i=32" class="dilog_bmit">删除信息</a>
</div>
<?php
mysql_free_result($staff_result);
break;
case 31:
if($group < 100)
{
	 	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">权限不足，无法执行该操作</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
	break;
}
?>
<form name = "RegForm" method = "post" action = "?i=36" onSubmit = "return InputCheck(this)" enctype = "multipart/form-data" action = "<?php $_SERVER['PHP_SELF']?>?submit = 1" >
<table align = "center" width = "500" border = "1">
  <tr>
    <td style = "width:80px">姓名<a style = "float:right">*</a></td>
    <td style = "width:165px"><input name = "s_Name" type = "text" class = "table_Name"  required = "required" maxlength = 12/></td>
  </tr>
  <tr>
    <td>职务<a style = "float:right">*</a></td>
    <td><input name = "s_Position" type = "text" class = "table_Name"  required = "required" maxlength = 12/></td>
  </tr>
  <tr>
    <td>介绍<a style = "float:right">*</a></td>
    <td><textarea name = "s_Content" type = "text" class = "textarea_Name" required = "required"  rows="20"></textarea></td>
  </tr>
  <tr>
    <td>照片<a style = "float:right">*</a></td>
    <td><input name = "s_Image" type = "file">(500 KB max)</td>
  </tr>
  <tr>
</table>
    <div style="text-align:center;">
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
        <input type = "Submit" id="btnSubmit" name = "btnSubmit" class="submitStyle" value = "确定" />
    </div>
</form>
<?php 
break;
case 32:
if($group < 150)
{
	 	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">权限不足，无法执行该操作</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
	break;
}
?>
<form name = "RegForm" method = "post" action = "?i=37" onSubmit = "return InputCheck(this)">
<table align = "center" width = "500" border = "1">
  <tr>
    <td style = "width:80px">序号<a style = "float:right">*</a></td>
    <td style = "width:165px"><input name = "s_Id"  class = "table_Name" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength = 3 required = "required" /></td>
  </tr>
  <tr>
    <td style = "width:80px">姓名<a style = "float:right">*</a></td>
    <td style = "width:165px"><input name = "s_Name" type = "text" class = "table_Name"  required = "required" maxlength = 12/></td>
  </tr>
<tr>
<td>注意！</td>
<td><input class = "table_Name" value = "删除操作不可恢复。请慎重操作" readonly/></td>
</tr>
</table>
    <div style="text-align:center;">
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
        <input type = "Submit" id="btnSubmit" name = "btnSubmit" class="submitStyle" value = "确定" />
    </div>
</form>
<?php
break;
case 36:
if(!isset($_REQUEST['btnSubmit'])){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">非法访问</h4>
    </div>
    <?php
    header("refresh:1;url = ?i=0");
   	break;
}

$Staffname = $_REQUEST['s_Name'];
$Staffposition = $_REQUEST['s_Position'];
$Staffcontent = $_REQUEST['s_Content'];
$Staff_image_path = "../Staff/";        //幻灯片图片上传路径  
if(!file_exists($Staff_image_path))  
{  
	//检查是否有该文件夹，如果没有就创建，并给予最高权限  
	mkdir("$Staff_image_path", 0700);  
} 
//允许上传的文件格式  
$Staff_image_type = array("image/gif","image/jpeg","image/pjpeg","image/bmp");  
//检查上传文件是否在允许上传的类型  
if(!in_array($_FILES["s_Image"]["type"],$Staff_image_type))
{ 
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">员工照片格式不正确</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php  
	break;  
} 
if($_FILES["s_Image"]["name"])
{  
		$Staff_image_type1 = $_FILES["s_Image"]["name"];  
		$Staff_image_type2 = $Staff_image_path.time().$Staff_image_type1;
}
if($_FILES["s_Image"]["size"]>500000)  
{ 
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">图片文件大小不得超过500KB</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   	break;
}
if(!preg_match('/^[\w\x80-\xff]{4,80}$/', $Staffname)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">标题长度需大于4个字并小于20个字</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
	break;
}
$check_query = mysql_query("select s_Name from i_slide where s_Name = '$Staffname' limit 1");
if(mysql_fetch_array($check_query)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">员工"<?php echo $Staffname;?>"已存在</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
	break;
}
if(!$Staffcontent){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">员工简介不能为空</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
		break;
}
if(@preg_match("/[\x7f-\xff]/","$Staff_image_type2"))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">图片文件名称不能含有中文字符</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   	break;
}else{
	$Staff_image_type = move_uploaded_file($_FILES["s_Image"]["tmp_name"],$Staff_image_type2);
}
$Staff_into_sql = "INSERT INTO `i_staff`(s_Name,s_Author,s_Position,s_Image,s_GroupId,s_PublishIp,s_Publishtime,s_Content)
								VALUES('$Staffname','$name','$Staffposition','$Staff_image_type2','$group','$ip','$regdate','$Staffcontent')";

if(mysql_query($Staff_into_sql,$con)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">员工信息发布成功</h4>
        <a href = "?i=30" class="dilog_bmit">返回</a>
    </div>
    <?php
	break;
} else {
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">添加数据失败</h4>
    	<h4 style="margin:10px 0"><?php mysql_error();?></h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
	break;
}
break;
case 37:
if(!isset($_REQUEST['btnSubmit'])){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">非法访问</h4>
    </div>
    <?php
    header("refresh:1;url = ?i=0");
   	break;
}
$Staffid = $_REQUEST['s_Id'];
$Staffname = $_REQUEST['s_Name'];
//验证ID
$check_query = mysql_query("select s_Id from i_staff where s_Id = '$Staffid'");
if(!mysql_fetch_array($check_query)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">员工编号"<?php echo $Staffid;?>"不存在</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   		break;
}
//验证ID所对应作者
$check_query = mysql_query("select s_Id from i_staff where s_Id = '$Staffid' and s_Name = '$Staffname'");
if(!mysql_fetch_array($check_query)){
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">员工编号"<?php echo $Staffid,'"与员工姓名 ："',$Staffname;?>"不匹配</h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
   		break;
}

//删除的文件
$delete_image = mysql_query("select s_Image from i_staff where s_Id = '$Staffid' and s_Name = '$Staffname' ");
$delete_file = mysql_fetch_array($delete_image);
$file = $delete_file['s_Image'];
if (file_exists($file))
{
    $delete_ok = unlink ($file);
}
//删除数据
$Staff_delete_sql = "DELETE FROM i_staff WHERE s_Id = '$Staffid' and s_Name = '$Staffname'";
if(mysql_query($Staff_delete_sql,$con))
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">企业员工删除成功</h4>
        <a href = "?i=30" class="dilog_bmit">返回</a>
    </div>
    <?php
	break;
}
else
{
	?>
    <div style="text-align:center;">
    	<h4 style="margin:10px 0">添加数据失败</h4>
    	<h4 style="margin:10px 0"><?php mysql_error();?></h4>
        <a href = "javascript:history.back(-1);" class="dilog_bmit">返回</a>
    </div>
    <?php
	break;
}
break;
case 200:
?>
        <div align = "center" style = "margin-top:15%">
			<?php
			//注销登录
			function deldir($dir)
			{
			   $dh = opendir($dir);
			   while ($file = readdir($dh))
			   {
				  if ($file != "." and $file != "..")
				  {
					 $fullpath = $dir . "/" . $file;
					 if (!is_dir($fullpath))
					 {
						@unlink($fullpath);
					 } else
					 {
						deldir($fullpath);
					 }
				  }
			   }
			   closedir($dh);
			   if (@rmdir($dir))
			   {
				  return true;
			   } else
			   {
				  return false;
			   }
			} 
			deldir($session_path); 
			session_unset(); 
			session_destroy();
            echo '<h2>成功注销登录<h2>';

break;
default:
	$i=0;
break;
}
?>
</div>
</div>
</div>
</div>
    <div id = "footer">
        Copyright &copy; 2014 
        <a href="http://staff.ibtv.cc/" target="_blank" style="color:#000">员工简介</a> by
        <a href="http://t.qq.com/wzxaini9" target = "_blank" style="color:#000">"Powerless"</a>
        All Rights Reserved.
    </div>
</body>
</html>
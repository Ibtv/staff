<?php
require_once("../My_SQL/_link.php");
	session_start(); 
//  声明一个名为 admin 的变量，并赋空值。
$_SESSION['TZZS'] = 0;
error_reporting(0);
$name=$_POST['name'];
$passowrd=sha1($name.md5($_POST['password']));
if ($name && $passowrd)
{
 $sql = "SELECT * FROM i_user WHERE (u_Name = '$name') and (u_Password ='$passowrd')";
 $res = mysql_query($sql);
 $rows = mysql_num_rows($res);
	if($rows)
	{
		$sql = "SELECT `u_Id`,`u_Name`,`u_GroupId`,`u_Number` FROM `i_user`";
		$result = mysql_query($sql) or die("查询失败!");
		while ($row=mysql_fetch_array($result)) 
		{
			if($row['u_Name'] == $name || $row['u_Id'] == $name)
			{
				$_SESSION['TZZS'] = $row['u_Id'];
				$_SESSION['land'] = $row['u_Id'];
				$_SESSION['GroupId'] = $row['u_GroupId'];
				$_SESSION['UserName'] = $row['u_Name'];
				$_SESSION['Number'] = $row['u_Number']+1;
		   }
		   else if(!$row['u_Name'] == $name || $row['u_Id'] == $name)
		   {
				$_SESSION["TZZS"] = $_SESSION['land'] = $_SESSION['GroupId'] = $_SESSION['UserName'] =  $_SESSION['Number'] = 0;  
				?>
				<script language="javascript"> 
					function clock(){
					if(i==0){ 
					clearTimeout(st); 
					window.opener=null; 
					window.parent.window.close();} 
					i = i - 1; 
					st = setTimeout("clock()",1000);
					}
					var i=3 
					clock(); 
				</script>
				<?php
			}
		}
		$session_path = "../_Sessionpath/".$_SESSION['TZZS'];//上传路径  
		if(!file_exists($session_path))  
		{  
			//检查是否有该文件夹，如果没有就创建，并给予最高权限  
			mkdir("$session_path", 0700);  
		}
		session_save_path(realpath($session_path)); 
		setcookie(session_name(),session_id(),time()+300,"/".$_SESSION['TZZS']); 
		mysql_free_result($result);
	
	   //  注册登陆成功的 TZZS 变量，并赋值为用户ID
	   header("refresh:0;url=main.php");//跳转页面，注意路径
	   exit;
	 }
 	echo "<script language=javascript>alert('用户名密码错误');history.back();</script>";
}
else
{
 echo "<script language=javascript>alert('用户名密码不能为空');history.back();</script>";
 header("refresh:0;url=enter.html");//跳转页面，注意路径
}
mysql_free_result($res);
?>

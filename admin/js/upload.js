function checkfm(form){ 
var uploadfile = form.uploadfile.value; 
if(uploadfile!=""){ 
var types = ["jpg","gif","bmp","png","swf","avi","3gp","f4v","mp4","rmvb"]; 
var ext = uploadfile.substring(uploadfile.length-3).toLowerCase(); 
var sing = false; 
for(var i=0; i<types.length;i++){ 
if (ext==types[i]){ 
sing = true; 
} 
} 
if(!sing){ 
alert("只允许上传图片/flash动画/AVI视频/3GP视频/F4V视频/MP4视频/RMVB视频"); 
return false; 
}	
} 
//window.close(); 
return true; 
} 
//判断成功与否 
function onloads(){ 
var isok='<%=isSuccess%>'; 
if(isok=='success'){ 
alert("上传文件成功！"); 
doclose(); 
} 
if(isok=='sizeerror'){ 
alert("文件上传失败，大小不能超过4MB！"); 
} 
if(isok=='fail'){ 
alert("上传文件失败！"); 
} 
} 
//关闭本窗口 
function doclose(){ 
window.close(); 
try{ 
   window.opener.window.refresh_article(); //firefox 
}catch(e){ 
   window.dialogArguments.refresh_article(); //ie8 
} 
} 
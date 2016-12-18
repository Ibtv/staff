<?php
	require_once("My_SQL/_link.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wb="http://open.weibo.com/wb">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta http-equiv="Content-Language" content="zh-CN">
    <meta name="author" content="Powerless"> 
    <title>员工一览┊国际商务电视台</title>
    <meta name="Copyright" content="Powerless">
	<meta name="keywords" content="国际商务电视台,员工" />
	<meta name="description" content="国际商务电视台全体正式签订劳动合同的员工" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="GENERATOR" content="MSHTML 9.00.8112.16533">
    <link rel="shortcut icon" href="ico.png" type="Styles/res/x-icon">
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<link rel="stylesheet" type="text/css" href="css/component.css" />
<script src="js/modernizr.custom.js"></script>
</head>
<body>
<!-- 代码 开始 -->
		<div class="container">
			<header class="clearfix">
				<span>STAFF.IBTV.CC<span class="bp-icon bp-icon-about" data-content="International Business Television - Staff List"></span></span>
				<h1>国际商务电视台 - 员工一览</h1>
				<nav>
					<!--a href="http://www.nnatv.com/" target="_blank" class="bp-icon bp-icon-prev" data-info="国际商务电视台中文频道"><span>Previous</span></a>
					<a href="http://www.nnvtv.com" target="_blank" class="bp-icon bp-icon-drop" data-info="国际商务电视台英文文频道"><span>back to the Codrops article</span></a>
					<a href="http://www.intbtv.com/" target="_blank" class="bp-icon bp-icon-archive" data-info="国际商务电视台杂志栏目"><span>lanrentuku</span></a-->
					<a href="http://www.ibtv.cc" target="_blank" class="bp-icon bp-icon-drop" data-info="国际商务电视台"><span>back to the Codrops article</span></a>
				</nav>
			</header>
			<div id="grid-gallery" class="grid-gallery">
				<section class="grid-wrap">
					<ul class="grid">
						<!-- for Masonry column width -->
		<?php
			for($i=0; $i<count($staff); $i++){
				echo '<li>
				<figure>
					<img src="'.$staff[$i]['image'].'" alt="'.$staff[$i]['name'].'"/>
					<figcaption><h3>'.$staff[$i]['position'].':'.$staff[$i]['name'].'</h3><p>'.mb_substr($staff[$i]['content'],0,32,'utf-8').'</p></figcaption>
				</figure>
				</li>';
			}
		?>
					</ul>
				</section><!-- // grid-wrap -->
				<section class="slideshow">
					<ul>
		<?php
			for($i=0; $i<count($staff); $i++){
				
						echo '<li>
							<figure>
								<figcaption>
									<dl> 
                                       <dt><img src="'.$staff[$i]['image'].'" alt="'.$staff[$i]['name'].'"  width="380"/></dt> 	
                                        <div class="zhusinabg"><wb:follow-button uid="'.$staff[$i]['id'].'" type="red_2" width="136" height="24" ></wb:follow-button></div>									
									　 <dd>
											<h3>'.$staff[$i]['position'].':'.$staff[$i]['name'].'</h3>
									<p>'.$staff[$i]['content'].'</p>
										</dd>   
									</dl>
								</figcaption>
							</figure>
						</li>';			
		}
		?>
        
        
					</ul>
					<nav>
						<span class="icon nav-prev"></span>
						<span class="icon nav-next"></span>
						<span class="icon nav-close"></span>
					</nav>
				</section><!-- // slideshow -->
			</div><!-- // grid-gallery -->
		</div>
		<script src="js/imagesloaded.pkgd.min.js"></script>
		<script src="js/masonry.pkgd.min.js"></script>
		<script src="js/classie.js"></script>
		<script src="js/cbpgridgallery.js"></script>

<!-- 代码 结束 -->
<script>
	new CBPGridGallery( document.getElementById( 'grid-gallery' ) );
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?b44b7f38bca00dd7d7faa2835302d590";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>
</html>
<?php 
require_once __DIR__.'/config.php';
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://html5-templates.com/" />
    <title>Example League Website</title>
    <meta name="description" content="Free responsive website HTML theme with sticky sidebar for both desktop and mobile. ">

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>
	    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!--     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
    
    	<?php 
	//cache bust css.(should evade caching same filename when contents changes)
	$cssHash = hash_file('crc32',FS_ROOT.'assets/css/style-1.css');
	$cssHashUrl= '?m='.$cssHash;
	?>
    
   	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/style-1.css<?php echo $cssHashUrl;?>"/>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/scripts-1.js"></script>

</head>
<body>
<header>
	<div id="header">
		<div id="mobileMenuToggle" title="Menu">M</div>
		<a href="<?php echo BASE_URL;?>" id="mobileLogo">Example League Website</a>
		<div id="headerLeft">
			<div id="menuToggle">&equiv;</div>
		</div>
		<div id="headerRight">
			<nav>  
				<ul>
					<li><a href="<?php echo BASE_URL;?>">Home</a>
				</ul>
			</nav>
		</div>
	</div>
	
	
</header>



<div id="wrapall">
	<div id="sidebar">
		<div id="stickThis">
			<div id="sidebarContent">
				<a id="logo" href="https://html5-templates.com/">Example League Website</a>
				<aside>
					<div>Sidebar 1</div>
					<div>Sidebar 2</div>
					<div>Sidebar 3</div>
					<div>Sidebar 4</div>
					<div>Sidebar 5</div>
					<div>Sidebar 6</div>
					<div>Sidebar 7</div>
					<a class="back2Top" href="#">⮝&nbsp;Back to&nbsp;top&nbsp;⮝</a>
				</aside>
			</div>
		</div>
		<div id="stick-here"></div>
	</div>
	<div id="main">
		<section id="page">
			<main>
				<article>
					<div>Score Carousel
						<?php include FS_ROOT.'component/ScoreCarousel.php'; ?>	
					</div>			
				</article>
				<article>
					<div>Waivers Mini
						<?php include FS_ROOT.'component/MiniWaivers.php'; ?>	
					</div>					
				</article>
				<article>
					<div style="width:65%">News
						<?php include FS_ROOT.'News.php'; ?>	
					</div>		
				</article>
				<article>
					<div style="width:75%">Next Games Mini
						<?php //include FS_ROOT.'MiniNextGames.php'; ?>	
					</div>						
				</article>
				<article>
					<div>Top 5 Mini
						<?php include FS_ROOT.'component/MiniLeaders.php'; ?>	
					</div>	
				</article>
				<article>
					<div style="width:50%">Full Standings Mini
                        <?php include FS_ROOT.'component/MiniStandings.php';?>
					</div>
				</article>
				<article>
					<div style="width:50%">Playoff Tree Mini
						<?php include FS_ROOT.'component/MiniStandingsTree.php';?>
					</div>
				</article>
				
			</main>			
			<footer>
				<p>&copy; You can copy, edit and publish this template but please leave a visible link to&nbsp;our&nbsp;website. <a rel="nofollow" href="https://html5-templates.com/" target="_blank" rel="nofollow">HTML5&nbsp;Templates</a></p>
			</footer>
		</section>
	</div>
</div>
</body>
</html>

<style>
	
	html,body,div,span,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,abbr,address,cite,code,del,dfn,em,img,ins,kbd,q,samp,small,strong,sub,sup,var,b,i,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,figcaption,figure,footer,header,hgroup,menu,nav,section,summary,time,mark,audio,video{margin:0;padding:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent}
body{line-height:1;font-family:arial}
h1{font-size:25px}
h2{font-size:21px}
h3{font-size:18px}
h4{font-size:16px}
article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}
nav ul{list-style:none}
blockquote,q{quotes:none}
blockquote:before,blockquote:after,q:before,q:after{content:none}
a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent}
ins{background-color:#ff9;color:#000;text-decoration:none}
mark{background-color:#ff9;color:#000;font-style:italic;font-weight:bold}
del{text-decoration:line-through}
abbr[title],dfn[title]{border-bottom:1px dotted;cursor:help}
table{border-collapse:collapse;border-spacing:0}
hr{display:block;height:1px;border:0;border-top:1px solid #ccc;margin:1em 0;padding:0}
input,select{vertical-align:middle}
body,html{background-color:#FFF}
header{background:#6f9898;padding:10px 30px;margin:auto;position:fixed;left:0;right:0;top:0;z-index:999;height:40px}
nav{display:inline-block}
nav ul li a{background:#fff;padding:2px 6px;font-size:14px;text-decoration:none;font-weight:bold;color:#344;border-radius:5px}
nav ul li a:hover{color:#000}
nav ul li{display:inline-block;margin:10px}
nav ul{list-style:none}
article{border-bottom:2px dotted #998;padding-bottom:20px;margin-bottom:20px}
article h2{font-weight:normal;margin-bottom:12px}
footer{background:#344;max-width:1000px;margin:0 -20px;clear:both;text-align:right}
footer p{padding:20px;color:#FFF}
address{padding:10px 20px 30px 10px}
aside > div{margin:10px auto;background:#344;min-height:150px;padding:30px 10px;text-align:center;color:#FFF}
a#logo{vertical-align:middle;font-size:40px;color:#344;font-weight:bold;display:block;text-decoration:none;text-align:center;line-height:40px;padding:60px 5px}
body > section{max-width:1000px;margin:auto;padding:30px 0px;border-bottom:1px solid #999;color:#333}
#sidebarBackTop{background:#286983;color:#FFF;opacity:0.8;cursor:pointer;display:block;padding:5px}
#sidebar a.back2Top{text-decoration:none;text-align:center;background:#344;color:#FFF;font-weight:bold;padding:5px;display:block}
#sidebar a.back2Top:hover{background:#456}
#sidebarContent{width:300px;background:#9dc1c1;padding:10px}
footer a{color:#FFF}
#main{margin-left:320px}
#wrapall{padding-top:60px}
#header{max-width:1000px;overflow:hidden;height:40px}
#wrapall,#header{max-width:1100px;margin:0 auto}
#headerLeft,#headerRight{display:inline-block;vertical-align:middle}
#headerLeft{text-align:center;width:100px}
#headerRight{height:40px}
#sidebar{float:left;position:absolute}
#page{padding:20px}
#menuToggle,#mobileMenuToggle{background:#FFF;cursor:pointer;display:inline-block;font-size:40px;width:40px;font-weight:bold;text-align:center;height:40px;line-height:40px;color:#344;border-radius:10px}
#mobileMenuToggle,#mobileLogo{vertical-align:middle;display:none;font-size:30px}
#menuToggle:hover{color:#FFF;background:#344}
.socialButtons{float:right;padding-top:8px}
.socialButtons a{display:inline-block;cursor:pointer;background:#0570e6;padding:2px;width:33px;text-align:center;height:20px;font-weight:bold;color:#FFF;text-decoration:none;line-height:20px;font-size:20px;border-radius:5px;vertical-align:middle}
.socialButtons a.linkedin{background:#24568e}
.socialButtons a.youtube{background:#c00}
.socialButtons a svg{width:16px;height:16px;fill:#FFF}
.stick #sidebarContent{position:fixed;z-index:900;bottom:0px}
#stick-here{background:red}
.sidebarToggle #sidebar{display:none}
.sidebarToggle #main{margin-left:0}
@media screen and (max-width:1100px){header{padding:10px}
#headerLeft{width:auto}
#headerRight{width:60%}
}
@media screen and (max-width:820px){#sidebar{display:none}
#main{margin-left:0}
.sidebarToggle #sidebar{background:red;display:block}
.stick #sidebarContent{bottom:auto}
a#logo{font-size:20px;line-height:20px;padding:10px 5px}
aside > div{min-height:20px;padding:10px}
.sidebarToggle #menuToggle{background:#344;color:#FFF}
}
@media screen and (max-width:600px){#headerLeft{float:right}
#headerRight{height:auto;position:absolute;width:auto;top:46px;background:#6f9898;left:0;display:none}
.showMobileMenu #headerRight{display:block}
nav ul li a{display:block;background:transparent;color:#FFF;text-align:center;font-size:16px;padding:3px 29px;line-height:25px}
.showMobileMenu #mobileMenuToggle{background:#344;color:#FFF}
nav ul li{display:block;margin:0}
.socialButtons{display:none}
header{padding:3px 10px}
#page{padding: 20px 10px}
#wrapall{padding-top:46px}
#sidebarContent{right:0;background:#6f9898}
#mobileLogo{display:inline-block;font-size:17px;padding:0 3px 0 10px;font-weight:bold;color:#FFF;text-decoration:none}
#mobileMenuToggle{display:inline-block}
}
	
	</style>

<script>
$(document).ready(function () {
	$(".back2Top").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
		$('#stickThis').height("auto");
		$('body').removeClass('stick');
        return false;
    });
	$("#menuToggle").click(function(event) {
        $("body").toggleClass("sidebarToggle");
		$("body").removeClass("showMobileMenu");
    });	
	$("#mobileMenuToggle").click(function(event) {
        $("body").toggleClass("showMobileMenu");
		$("body").removeClass("sidebarToggle");
    });	
	
	
});

function sticktothebottom() {
    var h = window.innerHeight;
    var window_top = $(window).scrollTop();
    var top = $('#stick-here').offset().top;
    var panelh = $("#stickThis").height();
    if (window_top + h > top) {
		$('#stickThis').height($('#stickThis').height());
        $('body').addClass('stick');
    } else {
		$('#stickThis').height("auto");
		$('body').removeClass('stick');
	}
}
$(function() {
    $(window).scroll(sticktothebottom);
    sticktothebottom();
});

</script>
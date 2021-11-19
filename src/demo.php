<?php 
require_once 'config.php';

if(DEMO_MODE){
    
 if(isset($CurrentHTML) && ($CurrentHTML == 'index.php' || !str_starts_with($CurrentHTML,'Team2') )){?>

<style>
.floating-menu-main {
	background-color: rgba(255, 255, 255, 0.5);
	margin-top: 100px;
	padding: 0px;
	margin-left: 5px;
	width: 100px;
	z-index: 100;
	position: fixed;
}

.floating-menu-main .btn-sm {
	background-color: transparent
}

.floating-menu {
	background-color: white;
}

.floating-menu a, .floating-menu h3 {
	font-size: 0.9em;
	display: block;
	margin: 1em 0.5em;
	color: black;
}
</style>


<div class="floating-menu-main">
    <button class="btn-sm" type="button" data-toggle="collapse" data-target="#demo-nav" aria-expanded="false" aria-controls="demo-nav">
        <span class="font-weight-bold">Demo Options</span>
    </button>
    <nav class="floating-menu collapse" id="demo-nav">
        <h3 class="text-left font-weight-bold">Theme</h3>
        <a href="javascript:window.location.href = addParameterToURL('theme','blue')">Blue</a>
        <a href="javascript:window.location.href = addParameterToURL('theme','green')">Green</a>
        <a href="javascript:window.location.href = addParameterToURL('theme','red')">Red</a>
         <a href="javascript:window.location.href = addParameterToURL('theme','teal')">Teal</a>
        <a href="javascript:window.location.href = addParameterToURL('theme','dark')">Dark</a>
        <h3 class="text-left font-weight-bold">Nav Mode</h3>
        <a href="javascript:window.location.href = addParameterToURL('navbarMode','1')">Full</a>
        <a href="javascript:window.location.href = addParameterToURL('navbarMode','0')">None</a>
        <a href="javascript:window.location.href = addParameterToURL('navbarMode','2')">Simple</a>
        <a href="javascript:window.location.href = addParameterToURL('navbarMode','3')">Simple Min</a>
    	<h3 class="text-left font-weight-bold">Language</h3>
    	<a href="javascript:window.location.href = addParameterToURL('lang','EN')">English</a>
		<a href="javascript:window.location.href = addParameterToURL('lang','FR')">French</a>

    </nav>
</div>

<?php }
}
?>
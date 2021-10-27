<?php 

if(!isset($LOAD_BASE_SCRIPTS)) $LOAD_BASE_SCRIPTS = true;
if(!isset($LOAD_DT_SCRIPTS)) $LOAD_DT_SCRIPTS = true;
if(!isset($LOAD_SLICK_SCRIPTS)) $LOAD_SLICK_SCRIPTS = false;

if(!isset($BASE_SCRIPTS_LOADED)) $BASE_SCRIPTS_LOADED = false;
if(!isset($DT_SCRIPTS_LOADED)) $DT_SCRIPTS_LOADED = false;
if(!isset($SLICK_SCRIPTS_LOADED)) $SLICK_SCRIPTS_LOADED = false;
    
if($LOAD_BASE_SCRIPTS && !$BASE_SCRIPTS_LOADED){
    if(CDN_SUPPORT) {?>
    	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600"/>
    	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css"/>
    	<?php }else{?>
    	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/fonts.css"/>
    	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/font-awesome-all.css"/>
    	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/animate.css"/>
    	<?php }?>
    	
    	<!-- Font support //TODO ADD TO LOCAL -->
    	<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
         
         <!-- JQuery and bootstrap init -->
        <?php if(CDN_SUPPORT) {?>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
    	<?php }else{?>
    	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/popper.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.tablesorter.min.js"></script>
    	<?php 
    }

	?>
     

	 <!-- Other scripts -->
	<?php if(CDN_SUPPORT) {?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
	<?php }else{?>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/wow.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.waypoints.min.js"></script>
	<?php }
} //base scripts end

if($LOAD_DT_SCRIPTS && !$DT_SCRIPTS_LOADED){
?>


	<?php if(isset($dataTablesRequired) && $dataTablesRequired) {?>
    	<?php if(CDN_SUPPORT) {?>
    	<!-- Datatables support -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.bootstrap4.min.css"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"/>
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
	
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<?php }else{?>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/datatables/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/datatables/fixedColumns.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/datatables/buttons.dataTables.min.css"/>
	
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/dataTables.fixedColumns.min.js"></script>
	
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/buttons.print.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/jszip.min.js"></script>
    	<?php }
	}
	$DT_SCRIPTS_LOADED=true;
} //dt scripts end

if($LOAD_SLICK_SCRIPTS && !$SLICK_SCRIPTS_LOADED){
    
  if(CDN_SUPPORT) {?>
	<link rel="stylesheet" type="text/css"	href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <script type="text/javascript"	src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<?php }else{?>
	<link rel="stylesheet" type="text/css"	href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <script type="text/javascript"	src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
   <?php }
   
   $SLICK_SCRIPTS_LOADED = true;
}
	//site js/css. needs to be loaded last
if($LOAD_BASE_SCRIPTS && !$BASE_SCRIPTS_LOADED){
    	//cache bust css.(should evade caching same filename when contents changes)
    	$cssHash = hash_file('crc32',FS_ROOT.'assets/css/style-1.css');
    	$cssMediaHash = hash_file('crc32',FS_ROOT.'assets/css/media-queries-1.css');
    	$jsHash = hash_file('crc32',FS_ROOT.'assets/js/scripts-1.js');
    
    	$cssHashUrl= '?m='.$cssHash;
    	$jsHashUrl= '?m='.$jsHash;
    	$cssMediaHashUrl= '?m='.$cssMediaHash;
    	?>
    
	<!-- Custom scripts and styling and overrides (load last)-->
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/style-1.css<?php echo $cssHashUrl;?>"/>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/media-queries-1.css<?php echo $cssMediaHashUrl;?>"/>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/scripts-1.js<?php echo $jsHashUrl;?>"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141959083-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-141959083-1');
    </script>

	
	<!-- css legacy browser (IE 9+ support) polyfill for unsupported css vars -->
	<?php if(CDN_SUPPORT) {?>
<!-- 	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/css-vars-ponyfill@1"></script> -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/css-vars-ponyfill/2.4.3/css-vars-ponyfill.min.js"></script>
	<?php }else{?>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/css-vars-ponyfill@1.js"></script>
	<?php }?>

	<!-- polyfill for var support -->
	<script type="text/javascript">
	cssVars({
	  onlyLegacy: true,
      rootElement: document // default
    });
    </script>
<?php 
$BASE_SCRIPTS_LOADED=true;
}
?>
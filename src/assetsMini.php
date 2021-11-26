<?php 

if(!isset($LOAD_BASE_SCRIPTS)) $LOAD_BASE_SCRIPTS = true;
if(!isset($LOAD_DT_SCRIPTS)) $LOAD_DT_SCRIPTS = true;
if(!isset($LOAD_SLICK_SCRIPTS)) $LOAD_SLICK_SCRIPTS = false;
if(!isset($LOAD_JQUERY)) $LOAD_JQUERY = true;
if(!isset($LOAD_BOOTSTRAP)) $LOAD_BOOTSTRAP = true;

if(!isset($BASE_SCRIPTS_LOADED)) $BASE_SCRIPTS_LOADED = false;
if(!isset($DT_SCRIPTS_LOADED)) $DT_SCRIPTS_LOADED = false;
if(!isset($SLICK_SCRIPTS_LOADED)) $SLICK_SCRIPTS_LOADED = false;
if(!isset($JQUERY_LOADED)) $JQUERY_LOADED = false;
if(!isset($BOOTSTRAP_LOADED)) $BOOTSTRAP_LOADED = false;

if($LOAD_JQUERY && !$JQUERY_LOADED) { ?>

<script async>

	
  if (!window.jQuery){
    const URL = 'https://code.jquery.com/jquery-3.3.1.min.js';

    const onMomentReady = () => {
      console.log('jQuery.js is loaded!');
      console.log(typeof jQuery);
    }
    
    var newScriptTag = document.createElement('script');
    newScriptTag.onload = onMomentReady;
    newScriptTag.src = URL;
    // newScriptTag.type = 'text/javascript'; // no need for this
    
    // optional
    newScriptTag.async = true;
    //document.head.appendChild(newScriptTag);
          currDoc = document.scripts[document.scripts.length - 1];
          currDoc.parentElement.insertBefore(newScriptTag, currDoc.nextSibling);
  }else {
    console.log("jQuery already exists.")
  }
  

    
</script>
<?php 
    $JQUERY_LOADED = true;
}
    

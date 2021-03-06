
</div> <!-- end site container -->

<?php include_once 'config.php'?>

<style>

#btn-back-to-top {
  position: fixed;
  bottom: 30px;
  right: 13px;
  display: none;
  opacity: 0.5;
  
  padding-bottom: 0px;
  padding-left: 8px;
  padding-right: 8px;
  padding-top: 0px;

}

.fhl-view-original {
    position:absolute;
     bottom:0;
     left:0;
}

.fhl-view-original>a {
   color: white;
}

.lang-select{
    position:absolute;
     bottom:0;
     right:0;

}
.lang-select>a{
     color: white;
}

</style>

<footer class="footer" id = "page-footer">
	<div class="container">
		<div class="row no-gutters">
			
			<div class="col text-center">
        		<div class="fhl-view-original">
                   <?php 
                   if(isset($OrigHTML) && $OrigHTML) {
                       
                       echo '<a href="'.$OrigHTML.(isset($currentTeam) ? '#'.$currentTeam : '').'" target="_blank">'.$allOriginal.'</a>';
                   }
                   ?>
            	</div>
				<span><?php echo FOOTER_TEXT?></span>
				<div class="lang-select">
		
					<a href="javascript:window.location.href = addParametersToURL({'lang': 'EN'})">EN</a> 
					<span>/</span>
					<a href="javascript:window.location.href = addParametersToURL({'lang': 'FR'})">FR</a> 
				
				</div>
			</div>
		</div>
	</div>
	
    <button type="button" class="btn btn-primary btn-floating btn-lg" id="btn-back-to-top">
      		<i class="fas fa-arrow-up"></i>
    </button>
    

</footer>	

<script>

//Get the button
let backToTopButton = document.getElementById("btn-back-to-top");

window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 200 ||
    document.documentElement.scrollTop > 200
  ) {
    //backToTopButton.style.display = "block";
    $('#btn-back-to-top').fadeIn()
  } else {
    //backToTopButton.style.display = "none";
    $('#btn-back-to-top').fadeOut()
  }
  
  
}
//button to scroll to the top of the document
backToTopButton.addEventListener("click", backToTop);

const scrollToTop = () => {
  // Let's set a variable for the number of pixels we are from the top of the document.
  const c = document.documentElement.scrollTop || document.body.scrollTop;
   
  if (c > 0) {
    window.requestAnimationFrame(scrollToTop);
    window.scrollTo(0, c - c / 10);
  }
};

function backToTop() {

  // Let's set a variable for the number of pixels we are from the top of the document.
  let c = document.documentElement.scrollTop || document.body.scrollTop;
   
  if (c > 0) {
    window.requestAnimationFrame(scrollToTop);
    window.scrollTo(0, c - c / 10);
  }
}

</script>
	
	

</body>

</html>
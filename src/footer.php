
</div> <!-- end site container -->

<?php require_once 'config.php'?>

<style>

#btn-back-to-top {
  position: fixed;
  bottom: 15px;
  right: 15px;
  display: none;
  opacity: 0.5;
}

</style>

<footer class="footer" id = "page-footer">
	<div class="container">
		<div class="row no-gutters">
			
			<div class="col text-center">
				<span><?php echo FOOTER_TEXT?></span>
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
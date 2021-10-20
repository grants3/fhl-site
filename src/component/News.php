<?php
require_once __DIR__.'/../config.php';
include FS_ROOT.'newsConfig.php'?>

<style>

#news-carousel .carousel-inner{
 
}

#news-carousel .carousel-control-prev,
#news-carousel .carousel-control-next{
      bottom: 75%; /* Aligns it at the top */
}

</style>
<div class="container-fluid fhlElement px-0">
 
    <div id="news-carousel" class="carousel slide" data-ride="carousel" data-interval="5000">
    
      <!-- Indicators -->
      <ul class="carousel-indicators">
        <li data-target="#news-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#news-carousel" data-slide-to="1"></li>
        <li data-target="#news-carousel" data-slide-to="2"></li>
      </ul>
    
      <!-- The slideshow -->
      <div class="carousel-inner">
        <div class="carousel-item active">
           <div class="card">
              <img class="card-img-top" src="<?php echo $news1Image;?>" alt="News Image">
              <div class="card-body">
                <h5 class="card-title"><?php echo $news1Title;?></h5>
                
                <?php foreach(preg_split("/\r\n|\n|\r/", $news1Text) as $paragraph){?>
                	  <p class="small-paragraph text-left"><?php echo $paragraph;?></p>
                <?php }?>
                
              </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
              <img class="card-img-top" src="./assets/img/backgrounds/1.jpg" alt="News Image">
              <div class="card-body">
                <h5 class="card-title">Example New Title 1</h5>
                
                <p class="small-paragraph text-left">Example paragraph 1</p>
            
            	<p class="small-paragraph text-left">Example paragraph 2</p>
              	
              	<p class="small-paragraph text-left">Example paragraph 3</p>
            
              </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
              <img class="card-img-top" src="./assets/img/news/cup.jpg" alt="News Image">
              <div class="card-body">
                <h5 class="card-title">Example New Title 1</h5>
                
                <p class="small-paragraph text-left">Example paragraph 1</p>
            
            	<p class="small-paragraph text-left">Example paragraph 2</p>
              	
              	<p class="small-paragraph text-left">Example paragraph 3</p>
            
              </div>
            </div>
        </div>
      </div>
    
      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#news-carousel" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#news-carousel" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    
    </div>
</div>
<script>

function carouselNormalization() {
  var items = $('#news-carousel .carousel-item'), //grab all slides
    heights = [], //create empty array to store height values
    tallest; //create variable to make note of the tallest slide

  if (items.length) {
    function normalizeHeights() {
      items.each(function() { //add heights to array
        heights.push($(this).height());
      });
      tallest = Math.max.apply(null, heights); //cache largest value
      items.each(function() {
        $(this).css('min-height', tallest + 'px');
      });
    };
    normalizeHeights();

    $(window).on('resize orientationchange', function() {
      tallest = 0, heights.length = 0; //reset vars
      items.each(function() {
        $(this).css('min-height', '0'); //reset min-height
      });
      normalizeHeights(); //run it again 
    });
  }
}

/**
 * Wait until all the assets have been loaded so a maximum height 
 * can be calculated correctly.
 */
window.onload = function() {
  carouselNormalization();
}

</script>


<?php
require_once __DIR__.'/../config.php';
include FS_ROOT.'newsConfig.php';

include FS_ROOT.'assets.php';
?>

<style>

#news-carousel .carousel-inner{
 
}

#news-carousel .carousel-control-prev,
#news-carousel .carousel-control-next{
      bottom: 75%; /* Aligns it at the top */
}

#news-carousel .carousel-control-prev-icon{
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23ff0000' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z'/%3e%3c/svg%3e");
    }

#news-carousel .carousel-control-next-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23ff0000' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3e%3c/svg%3e");
    }

</style>
<div class="container-fluid fhlElement px-0">
 
 	<?php 
 	if(!isset($newsInterval) || !$newsInterval) $newsInterval = 10000;
 	?>
 
    <div id="news-carousel" class="carousel slide" data-ride="carousel" data-interval="<?php echo $newsInterval;?>">
    
      <!-- Indicators -->
      <ul class="carousel-indicators">
        <li data-target="#news-carousel" data-slide-to="0" class="active"></li>
        <?php if(isset($news2Text) && $news2Text){ echo '<li data-target="#news-carousel" data-slide-to="1"></li>';}?>
        <?php if(isset($news3Text) && $news3Text){ echo '<li data-target="#news-carousel" data-slide-to="2"></li>';}?>
        <li data-target="#news-carousel" data-slide-to="2"></li>
      </ul>
    
      <!-- The slideshow -->
      <div class="carousel-inner">
      	<?php if(isset($news1Text) && $news1Text){?>
        <div class="carousel-item active">
           <div class="card">
              <img class="card-img-top" style="height:100%;" src="<?php echo $news1Image;?>" alt="News Image">
              <div class="card-body">
                <h5 class="card-title"><?php echo $news1Title;?></h5>
                
                <?php foreach(preg_split("/\r\n|\n|\r/", $news1Text) as $paragraph){?>
                	  <p class="small-paragraph text-left"><?php echo $paragraph;?></p>
                <?php }?>
                
              </div>
            </div>
        </div>
        <?php }?>
      	<?php if(isset($news2Text) && $news2Text){?>
        <div class="carousel-item">
           <div class="card">
              <img class="card-img-top" style="height:100%;" src="<?php echo $news2Image;?>" alt="News Image">
              <div class="card-body">
                <h5 class="card-title"><?php echo $news2Title;?></h5>
                
                <?php foreach(preg_split("/\r\n|\n|\r/", $news2Text) as $paragraph){?>
                	  <p class="small-paragraph text-left"><?php echo $paragraph;?></p>
                <?php }?>
                
              </div>
            </div>
        </div>
        <?php }?>
        <?php if(isset($news3Text) && $news3Text){?>
        <div class="carousel-item">
           <div class="card">
              <img class="card-img-top" style="height:100%;" src="<?php echo $news3Image;?>" alt="News Image">
              <div class="card-body">
                <h5 class="card-title"><?php echo $news3Title;?></h5>
                
                <?php foreach(preg_split("/\r\n|\n|\r/", $news3Text) as $paragraph){?>
                	  <p class="small-paragraph text-left"><?php echo $paragraph;?></p>
                <?php }?>
                
              </div>
            </div>
        </div>
        <?php }?>
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


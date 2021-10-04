<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once 'classes/TeamAbbrHolder.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>

  	<meta charset="UTF-8"/>
  	<meta name="viewport" content="width=device-width, initial-scale=0.85, maximum-scale=3.0, minimum-scale=0.85"/>
  	<title>Canadian Elite Hockey League</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>

	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/style-5.css"/>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/media-queries-04182019.css"/>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/scripts-1.js"></script>

</head>
<body>
<?php //include 'component/ScoreCarousel.php'; ?>

<?php 
$fileName = getLeagueFile($folder, '', 'TeamScoring.html', 'TeamScoring');
$test = new TeamAbbrHolder($fileName);

error_log($test->teamAbbrArray['Toronto']);

?>
</body>



</html>
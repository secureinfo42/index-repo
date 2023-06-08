<?php

$ROOT_DIR = $_SERVER["DOCUMENT_ROOT"];

$EXCLUDED_ITEMS = array(
	"index.php",
	".",
	"..",
	".DS_Store",
	"backup",
	"assets",
	"FILES.lst",
);

$CATEGORIES = array();

$PROT = $_SERVER["REQUEST_SCHEME"];
$HOST = $_SERVER["SERVER_NAME"];


function print_item($item) {

	$icon="📘"; // 📂";
	if( is_file($item) ) $icon="🔖";
	echo <<< EOD
	<tr>
		<td nowrap>&nbsp;&nbsp;&nbsp;</td>
		<td width='100%' class='category'>$icon &nbsp;<a href="$item" class='item'>$item</a></td>
	</tr>
EOD;
}


function print_root_dir($item) {
	global $PROT, $HOST;
	$quer = $_SERVER["REQUEST_URI"]; # query
	$href = "$HOST/$quer/$item";
	$href = str_replace("///","/",$href);
	$href = str_replace("//","/",$href);
	$href = "$PROT://$href";
	$item = ucfirst($item);

	$icon="📘"; // 📂";
	if( is_file($item) ) $icon="🔖";
	echo <<< EOD
	<tr>
		<td nowrap>&nbsp;&nbsp;&nbsp;</td>
		<td width='100%' class='category'>$icon &nbsp;<a href='$href' class='item'>$item</a></td>
	</tr>
EOD;
}

function get_root_dirs($dir) {
	global $EXCLUDED_ITEMS, $CATEGORIES;
	// $dir = dirname(__FILE__);
	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			if ( !in_array($entry,$EXCLUDED_ITEMS) ) {
				if( is_dir("$dir/$entry") ) {
					array_push($CATEGORIES, $entry);
				}
			}
		}
		closedir($handle);
	}	
	return(sort($CATEGORIES));
}


function browse_dir($dir=".") {
	global $EXCLUDED_ITEMS;
	$ITEMS = array();
	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			if ( !in_array($entry,$EXCLUDED_ITEMS) ) {
				array_push($ITEMS,$entry);
			}
		}
		closedir($handle);
	}
	sort($ITEMS);
	foreach($ITEMS as $entry) {
		print_item($entry);
	}
}

function show_root_dirs() {
	global $CATEGORIES;
	global $PROT, $HOST, $PORT;
	$request = $_SERVER["REQUEST_URI"];
	echo "<p class='text5'><i>Sites : </i>";
	foreach( $CATEGORIES as $category ) {
		$str_category = ucfirst($category);
		$href = "$HOST/$category";
		$href = str_replace("///","/",$href);
		$href = str_replace("//","/",$href);
		$href = "$PROT://$href";
		$css_cat  = "category";

		$cat = basename($request);
		if( strtolower($cat) == strtolower($category) ) {
			$css_cat = "focused_category";
		}
		echo "<a class=\"$css_cat\" href=\"$href\">$str_category</a>&nbsp;|&nbsp;";
	}
}

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>XAMPP Local</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

	@font-face {
  	font-family:'VictorMono-Light';
  	src: url('/assets/VictorMono-Light.otf') format('opentype');
	}

	* {
		font-family: VictorMono-Light;
	}

	body {
		color: rgb(174, 174, 174);
		background-color: rgb(34,34,34);
	}

	a {
		color: lime;
		text-decoration: none;
	}

	a:hover {
		background-color: darkgreen;
		color: white;
		text-decoration: underline;
	}

	hr {
		border: 0;
		height: 1px;
		background-color: white;
	}

	#title {
		font-size: 1.5em;
		color: lightgreen;
	}

	.item {
		color: white;
	}

	.category {
		color: lime;
		text-shadow: 1px 1px 2px black;
	}

	.focused_category {
		color: yellow;
		text-transform: uppercase;
		text-shadow: 2px 2px 3px black;
		font-weight: bold;
	}

	.title {
		font-family: VictorMono-Light;
		color: white;	
	}

	.hr_green {
	  background-image:  linear-gradient(to right, rgba(0, 32, 0, 1), rgba(0, 128, 0, 1), rgba(255, 255, 255, 1), rgba(0, 128, 0, 1), rgba(0, 32, 0, 1));
	}

</style>
</head>

<body>

	<div align="center">
	<br />

	<center>
		<p id='title'>
			[
		  <a href="http://localhost/"  class="title">Serveur WEB local : HTTP</a> /
		  <a href="https://localhost/" class="title">HTTPS</a>
		  ]
		</p>
		<?php
		get_root_dirs($ROOT_DIR);
		if(count($CATEGORIES) > 1) {
			show_root_dirs();
		}
		?>
		</center>
	</div>


	<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
	<hr class="hr_green" />
	<?php browse_dir("."); ?>
	<br>

</body>
</html>

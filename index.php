<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Parser for http://myshows.me/view/187/</h1>
		<p>You can replace http://myshows.me/view/<b>187</b>/ For example http://myshows.me/view/2/ is a Big Bang Theory</p>
<?php
// Include the library
include('html_dom/simple_html_dom.php');
 
// Retrieve the DOM from a given URL
$html = file_get_html('http://myshows.me/view/187/');

//Get usefull data from $html.
$counter = 0;
$result = array("");
foreach($html->find('main.col8>div.clear>p') as $e){//, main.col8>-div.clear>form
    if($counter < 21){//Line with not usefull content.
	    $counter++;
		if($counter > 3){//Hides lines with not usefull content.
			$string = strip_tags($e->innertext);//Delete html-attributes.
			switch ($counter) {
                case 4:
				    $publishDates = substr($string, 22)."<br>";
					echo $publishDates;
                    break;
                case 5:
				    $country = substr($string, 14);
                    echo $country."<br>";
                    break;
				case 6:
				    $genres = substr($string, 14);
                    echo $genres."<br>";
                    break;
                case 7:
                    $channel = substr($string, 11, 4);
					echo $channel."<br>";
                    break;
                case 8:
                    $viewersAmount = substr($string, 19);
					echo $viewersAmount."<br>";
                    break;
				case 9:
                    $generalDuration = substr($string, 37);
					echo $generalDuration."<br>";
                    break;
                case 10:
				    $averageDuration = substr($string, 37);
                    echo $averageDuration."<br>";
                    break;
                case 11:
				    $ratingIMDB = substr($string, 20);
                    echo $ratingIMDB."<br>";
                    break;
				case 12:
				    $ratingKinopoisk = substr($string, 37);
                    echo $ratingKinopoisk."<br>";
                    break;
				case 13:
				    $ratingMyShows = substr($string, 185);
                    echo $ratingMyShows."<br>";
                    break;
                case 16:
                    $summary = $string;
					echo $summary."<br>";
                    break;
                default:
            } 
		}		
	}	
} 
$episodesAddress = 'main.col8>-div.clear>form.row.col6.widerCont>ul>li>a>span._name';
$seasonsAddress = 'main.col8>-div.clear>form.row.col2.widerCont>h4';
$counter = 0;
foreach($html->find($seasonsAddress) as $season){//Get all episodes names.
    $currentSeason = preg_replace("/[^0-9,.]/", "", $season->innertext);//Delete all non-numeric characters.
	if($counter == 0){
		$counter = 1;
		$seasonsAmount = $currentSeason;
		echo '<h4> Seasons amount is '.$seasonsAmount.'</h4>';
	}
	echo $currentSeason."<br>";//Print every episode.
	//Push every episode in the array.
	foreach($html->find($episodesAddress) as $episode){//Get all episodes names of the current season.
        echo $episode->innertext."<br>";//Print every episode.
	    //Push every episode in the array.
    }
}

//Put variables in the database.   
?>
    </body>
</html>
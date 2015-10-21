<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Parser for http://myshows.me/view/187/</h1>
        <p>You can replace http://myshows.me/view/<b>187</b>/ For example http://myshows.me/view/2/ is a Big Bang Theory</p>
<?php
/*

Configuration begine. Connecting to the DB.

*/
$wgDBserver = 'localhost';
$wgDBuser = 'myUserName';
$wgDBpassword = 'myPassword';
$wgDBname = 'myDBName';

$mysqli = new mysqli( $wgDBserver, $wgDBuser, $wgDBpassword );

if ( mysqli_connect_errno() ) {
    die( "Failed:" . mysqli_connect_error() );
}

if ( $mysqli->select_db( $wgDBname) ) {
    echo 'Connected and DB selected.';
} else {
    echo 'Something went from (select_db())';
}
echo $mysqli->host_info . "\n";
/*

Configuration. The end.

*/



/*

Parser begine.

*/

// Include the library
include('/home/mangal/data/www/mangal.biz/vizitka/wordpress/wp-admin/html_dom.php');

// Retrieve the DOM from a given URL
$html = file_get_html('https://afisha.mail.ru/series_756802_vo_vse_tyazhkie/');
$counter = 0;
foreach ($html->find('.movieabout__info__tab>table>tbody>tr') as $e) { 
    if($counter < 15){
	   $counter++;
	   $string = strip_tags($e->innertext); //Delete html-tags.
	    if($counter > 3){
		    switch($counter){//$serialStatus, $directors, $actors, $producers, $screenwriter, $operators, $musician, $premiere, $averageDuration, $channel
			    case 4:
				    $serialStatus = substr($string, 12);
			        echo $serialStatus.'<br>';
			        break;
				case 6:
				    $directors = substr($string, 18);
				    echo $directors.'<br>';
			        break;
				case 7:
				    $actors = substr($string, 13);
				    echo $actors.'<br>';
			        break;
				case 8:
				    $producers = substr($string, 18);
				    echo $producers.'<br>';
			        break;
				case 9:
				    $screenwriter = substr($string, 20);
				    echo $screenwriter.'<br>';
			        break;
				case 10:
				    $operators = substr($string, 18);
				    echo $operators.'<br>';
			        break;
				case 11: 
				    $musician = substr($string, 20);
                    echo $musician.'<br>';
			        break;				
				case 12:
				    $premiere = substr($string, 16);
				    echo $premiere.'<br>';
			        break;
				case 13:
				    $averageDuration = substr($string, 35);
                    echo $averageDuration . "<br>";
			        break;
				case 15: 
                    $channel = substr($string, 26);
                    echo $channel . "<br>";
			        break;	
                default:				
		    }	       
	    }
	}
}



$result = $mysqli->query("SELECT * FROM afisha WHERE serial_name == 'Breaking Bad';");
if ($result->num_rows > 0) {//$serialStatus, $directors, $actors, $producers, $screenwriter, $operators, $musician, $premiere, $averageDuration, $channel
    echoDataFromDB(); //If such row is exist, then update its data.
} else {
    echo "Adding data to the db.<br>";
	$mysqli->query("INSERT INTO afisha (serial_status, directors, actors, producers, screenwriter, operators, musician, premiere, average_duration, channel)
    VALUES ('$serial_status', '$directors', '$actors', '$producers', '$screenwriter', '$operators', '$musician', '$premiere', '$averageDuration', '$channel');");
    echoDataFromDB();//Display just created row from the DB.
}
$mysqli->close();

function echoDataFromDB(){
	$res = $mysqli->query("SELECT * FROM afisha ;");
	while($row = $res->fetch_assoc()) {
        echo "serialStatus: ".$row["serial_status"]." directors".$row["directors"]
		."actors: ".$row["actors"]." producers: ".$row["producers"]." screenwriter: ".$row["screenwriter"]
		." operators: ".$row["operators"]." musician: ".$row["musician"]." channel "." premiere: "
		.$row["premiere"]." averageDuration: ".$row["averageDuration"].$row["channel"]."<br>";
	}
	$mysqli->query("UPDATE afisha SET serial_status = $serialStatus, directors=$directors, actors=$actors, producers=$producers, screenwriter=$screenwriter, operators=$operators, musician=$musician, premiere=$premiere, averageDuration=$average_duration, channel=$channel");
}
/*

Parser. The end..

*/

?>
   </body>
</html>

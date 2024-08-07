<?php 
//app specific functions i.e functions for particular project different from general functions
function fa_fa_stars($rating) {
    $rem = 5-$rating;
    list($whole, $decimal) = sscanf($rating, '%d.%d');
    for($i=0; $i<$whole; $i++) {
        echo "<i class='fa fa-star primary'></i>";
    }
    if(isset($decimal) && $decimal > 0) {
        echo "<i class='fa fa-star-half-o primary'></i>";
        for($i=0; $i<$rem-1; $i++) {
            echo "<i class='fa fa-star-o primary'></i>";
        }
    } else {
        for($i=0; $i<$rem; $i++) {
            echo "<i class='fa fa-star-o primary'></i>";
        }
    }
}


function get_random_string_max($length) {

	$array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$text = "";

	$length = rand(4,$length);

	for($i=0;$i<$length;$i++) {

		$random = rand(0,61);
		
		$text .= $array[$random];

	}

	return $text;
}

function check_message()
{

	if(isset($_SESSION['error']) && $_SESSION['error'] != "")
	{
		echo $_SESSION['error'];
		unset($_SESSION['error']);
	}
}


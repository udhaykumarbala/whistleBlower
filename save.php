<?php


if(isset($_POST['submit']))
{
	
}






function randomNumber(16) {
    $result = '';

    for($i = 0; $i < 16; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}

?>
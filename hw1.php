<?php

// Create an input string using heredoc syntax
$inputString
    = <<<MYSTR
Can you feel the pulse in your wrist? For humans the normal pulse is 70 heartbeats per minute.
Elephants have a slower pulse of 27 and for a canary it is 1000!
If all the blood vessels in your body were laid end to end, they would reach about 60,000 miles.
In one day your heart beats 100,000 times.
Half your body’s red blood cells are replaced every seven days.
By the time you are 70.5 you will have easily drunk over 12,000 gallons of water.
Coughing can cause air to move through your windpipe faster than the speed of sound – over a thousand feet
per second, this is a true statement!
Germs only cause disease, right? But a common bacterium, E. Coli, found in the intestine helps us digest
green vegetables and beans (also making gases – pew!). These same bacteria also make vitamin K, which
causes blood to clot. If we didn’t have these germs we would bleed to death whenever we got a small cut!
It takes more muscles to frown than it does to smile, this is not false and a fact.
That dust on rugs and your furniture is not only dirt. It’s mostly made of dead skin cells.
Everybody loses millions of skin cells every day which fall on the floor and get kicked up to
land on all the surfaces in a room. You could say, “That’s me all over.”
It takes food 7.64 seconds to go from the mouth to the stomach via the esophagus.
MYSTR;
$countArray = array('num_numeric' => 0, 'num_string' => 0, 'num_bool' => 0);

$replace= str_replace("\n", " ", $inputString);
$replace= str_replace(",", "", $replace); //removes commas, helpful for int evaluation
$words = explode(" ", $replace); //converts $replace from string into array

//setting counter
$num=0;
$string=0;
$bool=0;

foreach($words as $element) {
	$element = strtolower($element);
	if(is_numeric($element)) {
		++$num;
		$countArray['num_numeric'] = $num;
		//echo $num." num: ".$element."\n";
	}
	elseif(is_string($element)){
		if ($element != 'false' && $element != 'true') {
	 		//using preg_match to ensure that the string is a word
	 		//will exlude elements that are special characters, ex. " - "
	 		if (preg_match("/[a-zA-Z]/", $element)){
	 		//could have done "/A-Z/i"  -- i stands for insensitive 
	 			++$string;
	 			$countArray['num_string'] = $string;
	 			//echo "$string word: $element \n";
	 		}
	 	} else{
	 		++$bool;
	 		$countArray['num_bool'] = $bool;
			//echo $bool." bool: $element \n";
		}
	}
}

echo "Within the string, there are: \n\t$num numbers, $string words, and $bool booleans.\n";
//print_r($countArray);


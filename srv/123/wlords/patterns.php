<?
$pattStr = '';
$pattStr2 = '';
//unset $extrawild;

foreach ($symbols as $tReel => $t)
	foreach ($t as $tRow => $e) {
		if ($symbols[$tReel][$tRow] == 1 or $symbols[$tReel][$tRow] == 13 or $symbols[$tReel][$tRow] == 14 or $symbols[$tReel][$tRow] == 15)
			$symbols[$tReel][$tRow] = round(rand(9, 11));
	}

if ($lastAction == "SWORD") {

	if ($patternIndex == 0) {
		//	    $winComb=round(rand(0,2));

		if ($winComb == 0)	$pattStr = "0_1_2_-_-"; //0
		if ($winComb == 1)	$pattStr = "-_0_1_2_-"; //1
		if ($winComb == 2)	$pattStr = "-_-_0_1_2"; //2
	}

	if ($patternIndex == 1) {
		//	    $winComb=round(rand(0,2));
		if ($winComb == 0)	$pattStr = "2_1_0_-_-"; //0
		if ($winComb == 1)	$pattStr = "-_2_1_0_-"; //1
		if ($winComb == 2)	$pattStr = "-_-_2_1_0"; //2
	}

	if ($patternIndex == 4) {
		//	    $winComb=round(rand(0,7));
		if ($winComb == 0)	$pattStr = "0_1_-_-_-"; //0
		if ($winComb == 1)	$pattStr = "-_0_1_-_-"; //1
		if ($winComb == 2)	$pattStr = "-_-_0_1_-"; //2
		if ($winComb == 3)	$pattStr = "-_-_-_0_1"; //3

		if ($winComb == 4)	$pattStr = "1_2_-_-_-"; //4
		if ($winComb == 5)	$pattStr = "-_1_2_-_-"; //5
		if ($winComb == 6)	$pattStr = "-_-_1_2_-"; //6
		if ($winComb == 7)	$pattStr = "-_-_-_1_2"; //7
	}

	if ($patternIndex == 5) {
		//	    $winComb=round(rand(0,7));
		if ($winComb == 0)	$pattStr = "-_-_-_1_0";
		if ($winComb == 1)	$pattStr = "-_-_1_0_-";
		if ($winComb == 2)	$pattStr = "-_1_0_-_-";
		if ($winComb == 3)	$pattStr = "1_0_-_-_-";

		if ($winComb == 4)	$pattStr = "-_-_-_2_1";
		if ($winComb == 5)	$pattStr = "-_-_2_1_-";
		if ($winComb == 6)	$pattStr = "-_2_1_-_-";
		if ($winComb == 7)	$pattStr = "2_1_-_-_-";
	}

	if ($patternIndex == 9) {
		//	    $winComb=round(rand(0,4));
		//3
		//	    if($winComb==0)	$pattStr ="-_1_2_1_-";//0	//wrong

		//	    if($winComb==1)	$pattStr ="-_2_1_2_-";//1	//wrong
		//5
		if ($winComb == 2) {
			$pattStr = "-_0_1_0_-"; //2
			$pattStr2 = "-_2_-_2_-";
		}

		if ($winComb == 3)	$pattStr = "2_1_0_1_2"; //3

		if ($winComb == 4)	$pattStr = "0_1_2_1_0"; //4
	}

	if ($patternIndex == 10) {
		//	    $winComb=round(rand(0,8));
		if ($winComb == 0)	$pattStr = "0_0_0_-_-"; //0
		if ($winComb == 1)	$pattStr = "-_0_0_0_-"; //1
		if ($winComb == 2)	$pattStr = "-_-_0_0_0"; //2
		if ($winComb == 3)	$pattStr = "1_1_1_-_-"; //3
		if ($winComb == 4)	$pattStr = "-_1_1_1_-"; //4
		if ($winComb == 5)	$pattStr = "-_-_1_1_1"; //5
		if ($winComb == 6)	$pattStr = "2_2_2_-_-"; //6
		if ($winComb == 7)	$pattStr = "-_2_2_2_-"; //7
		if ($winComb == 8)	$pattStr = "-_-_2_2_2"; //8
	}

	//echo "PI=".$patternIndex." winC=".$winComb." str=".$pattStr;

}

if ($lastAction == "HAMMER") {
	//	    $winComb=round(rand(0,7));
	if ($winComb == 0) {
		$pattStr = "0_0_-_-_-"; //0
		$pattStr2 = "1_1_-_-_-";
	}
	if ($winComb == 1) {
		$pattStr = "-_0_0_-_-"; //1
		$pattStr2 = "-_1_1_-_-";
	}
	if ($winComb == 2) {
		$pattStr = "-_-_0_0_-";
		$pattStr2 = "-_-_1_1_-";
	}
	if ($winComb == 3) {
		$pattStr = "-_-_-_0_0";
		$pattStr2 = "-_-_-_1_1";
	}
	if ($winComb == 4) {
		$pattStr = "1_1_-_-_-";
		$pattStr2 = "2_2_-_-_-";
	}
	if ($winComb == 5) {
		$pattStr = "-_2_2_-_-";
		$pattStr2 = "-_1_1_-_-";
	}
	if ($winComb == 6) {
		$pattStr = "-_-_2_2_-";
		$pattStr2 = "-_-_1_1_-";
	}
	if ($winComb == 7) {
		$pattStr = "-_-_-_2_2";
		$pattStr2 = "-_-_-_1_1";
	}
}

if ($lastAction == "ARROW") {
	//	$steps=round(rand(2,5));
	$x = round(rand(0, 4));
	$y = round(rand(0, 2));
	$x1 = round(rand(0, 4));
	$y1 = round(rand(0, 2));
	if ($x == $x1 and $y == $y1) {
		if ($y == 1) $y1 = 0;
		if ($y == 0) $y1 = 2;
		if ($y == 2) $y1 = 1;
	}
	$extrawild[$x][$y] = 1;
	$extrawild[$x1][$y1] = 1;
	$arrowsLog = $x . "," . $y . ";" . $x1 . "," . $y1 . ";";
	for ($i = 0; $i < $steps; $i++) {
		$x = round(rand(0, 4));
		$y = round(rand(0, 2));
		$extrawild[$x][$y] = 1;
		$arrowsLog .= ";" . $x . "," . $y;
	}
}

$patt = explode("_", $pattStr);
foreach ($patt as $e => $v) if ($v != "-") $extrawild[$e][$v] = 1;
if ($pattStr2 != '') {
	$patt = explode("_", $pattStr2);
	foreach ($patt as $e => $v) if ($v != "-") $extrawild[$e][$v] = 1;
}

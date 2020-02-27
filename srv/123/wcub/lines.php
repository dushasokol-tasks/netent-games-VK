<?

foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
}

//$extrawild[0][1]=1;//	$extrawild[2][1]=1;	$extrawild[4][1]=1;	$extrawild[3][1]=1; $extrawild[1][1]=1;
//$extrawild[4][1]=1;
//$symbols[0][1]=3;	$symbols[1][1]=3;	$symbols[2][1]=3;	$symbols[3][1]=3;	$symbols[4][1]=5;

//$symbols[0][0]=4;	$symbols[1][0]=4; $symbols[2][0]=4;


//line matches


$linePatterns[0] = "1_1_1_1_1"; //1
$linePatterns[1] = "0_0_0_0_0"; //2
$linePatterns[2] = "2_2_2_2_2"; //3
$linePatterns[3] = "0_1_2_1_0"; //4
$linePatterns[4] = "2_1_0_1_2"; //5
$linePatterns[5] = "0_0_1_0_0"; //6
$linePatterns[6] = "2_2_1_2_2"; //7
$linePatterns[7] = "1_2_2_2_1"; //8
$linePatterns[8] = "1_0_0_0_1"; //9
$linePatterns[9] = "1_0_1_0_1"; //10
$linePatterns[10] = "1_2_1_2_1"; //11
$linePatterns[11] = "0_1_0_1_0"; //12
$linePatterns[12] = "2_1_2_1_2"; //13
$linePatterns[13] = "1_1_0_1_1"; //14
$linePatterns[14] = "1_1_2_1_1"; //15
$linePatterns[15] = "0_1_1_1_0"; //16
$linePatterns[16] = "2_1_1_1_2"; //17
$linePatterns[17] = "0_2_0_2_0"; //18
$linePatterns[18] = "2_0_2_0_2"; //19
$linePatterns[19] = "0_2_2_2_0"; //20

//////////////
//blizzard feature
/////////////
if ($lastAction == 'freespin' and $symbols[0][0] == $symbols[0][1] and $symbols[0][0] == $symbols[0][2]) {
	$dop2 .= "BLZRD!";
	$overlaySym = $symbols[0][0];
	for ($i = 0; $i < 3; $i++) {
		if ($symbols[4][$i] == $symbols[0][$i]) {
			$symbols[1][$i] = $symbols[0][$i];
			$symbols[2][$i] = $symbols[0][$i];
			$symbols[3][$i] = $symbols[0][$i];
		} elseif ($symbols[3][$i] == $symbols[0][$i]) {
			$symbols[1][$i] = $symbols[0][$i];
			$symbols[2][$i] = $symbols[0][$i];
		} elseif ($symbols[2][$i] == $symbols[0][$i]) {
			$symbols[1][$i] = $symbols[0][$i];
		}
	}
}
//////////////

//$output.= "<br><br>";

for ($i = 0; $i < 20; $i++) {
	$logger = '';
	$oldwin = 0;
	$linePattern = explode("_", $linePatterns[$i]);
	$is_wild = "";
	$symbs[$i] = 0;
	if ($extrawild[0][1] == 1) $is_wild = "_1";
	elseif ($symbs[0] == 0) $symbs[0] = $symbols[0][1];

	for ($j = 0; $j < 5; $j++) {
		if ($extrawild[$j][$linePattern[$j]] == 1) $is_wild = "_1";
		elseif ($symbs[$i] == 0) $symbs[$i] = $symbols[$j][$linePattern[$j]];
	}
	if ($symbs[$i] == 0) $symbs[$i] = 1;

	if ($symbols[0][$linePattern[0]] == $symbs[$i] or $extrawild[0][$linePattern[0]] == 1) {
		if ($symbols[1][$linePattern[1]] == $symbs[$i] or $extrawild[1][$linePattern[1]] == 1) {
			$linewin[$i] = 0;
			$linewin[$i] = $lineWinMarix[2][$symbs[$i]] * $betDB;
			if ($linewin[$i] != 0) {
				$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1];
				$logger = '2xSYM' . $symbs[$i] . "=" . $linewin[$i];
			}

			if ($symbols[2][$linePattern[2]] == $symbs[$i] or $extrawild[2][$linePattern[2]] == 1) {
				$linewin[$i] = 0;
				$linewin[$i] = $lineWinMarix[3][$symbs[$i]] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = '3xSYM' . $symbs[$i] . "=" . $linewin[$i];
				}

				if ($symbols[3][$linePattern[3]] == $symbs[$i] or $extrawild[3][$linePattern[3]] == 1) {
					$linewin[$i] = 0;
					$linewin[$i] = $lineWinMarix[4][$symbs[$i]] * $betDB;
					if ($linewin[$i] != 0) {
						$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
						$logger = '4xSYM' . $symbs[$i] . "=" . $linewin[$i];
					}

					if ($symbols[4][$linePattern[4]] == $symbs[$i] or $extrawild[4][$linePattern[4]] == 1) {
						$linewin[$i] = 0;
						$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
							$logger = '5xSYM' . $symbs[$i] . "=" . $linewin[$i];
						}
					}
				}

				$win[$i] .= $is_wild;
			}
		}
	}

	//    $oldwin=$linewin[$i];

	//    $logger.=" wm ".($lineWinMarix[3][1]*$betDB);

	if ($symbols[0][$linePattern[0]] == 1 and $symbols[1][$linePattern[1]] == 1 and $symbols[2][$linePattern[2]] == 1) {

		if ($symbols[3][$linePattern[3]] == 1 and $symbols[4][$linePattern[4]] == 1) {
			if (($lineWinMarix[5][1] * $betDB) > $linewin[$i]) {

				$linewin[$i] = $lineWinMarix[5][1] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
					$logger = "5xWLD=" . $linewin[$i];
				}
			}
		} elseif ($symbols[3][$linePattern[3]] == 1) {
			if (($lineWinMarix[4][1] * $betDB) > $linewin[$i]) {
				$linewin[$i] = $lineWinMarix[4][1] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
					$logger = "4xWLD=" . $linewin[$i];
				}
			}
		} else {
			if (($lineWinMarix[3][1] * $betDB) > $linewin[$i]) {
				$linewin[$i] = $lineWinMarix[3][1] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = "3xWLD=" . $linewin[$i];
				}
			}
		}



		/*
	if(($lineWinMarix[3][1]*$betDB)>$linewin[$i])
	    {
	    $linewin[$i]=$lineWinMarix[3][1]*$betDB;
	    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2]; $logger="3xWLD=".$linewin[$i];}

	    if($symbols[3][$linePattern[3]]==1)
		{
		$linewin[$i]=$lineWinMarix[4][1]*$betDB;
		if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2].";3,".$linePattern[3]; $logger="4xWLD=".$linewin[$i];}

		if($symbols[4][$linePattern[4]]==1)
		    {
		    $linewin[$i]=$lineWinMarix[5][1]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2].";3,".$linePattern[3].";4,".$linePattern[4]; $logger="5xWLD=".$linewin[$i];}
		    }
		}
	    }
*/
	}



	if ($logger != '') $symb_combs .= $logger . ";";
}

foreach ($linewin as $v) {
	$total_win += $v;
}

$total_winCents = $total_win * $denomDB;

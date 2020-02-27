<?

//foreach($lineWinMarix as $e => $v)  {echo "<tr><td>$e</td>";foreach ($v as $e1 => $v1)echo "<td>".$e1." ".$v1."</td>";echo "</tr>";}

if ($lastAction == "freespin") foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
}

//foreach($symbols as $e => $v)  foreach ($v as $e1 => $v1) $symbols[$e][$e1]=5;

//$extrawild[0][1]=1;//	$extrawild[2][1]=1;	$extrawild[4][1]=1;	$extrawild[3][1]=1; $extrawild[1][1]=1;
//$extrawild[4][1]=1;
//$symbols[0][1]=3;	$symbols[1][1]=3;	$symbols[2][1]=3;	$symbols[3][1]=3;	$symbols[4][1]=5;

//$symbols[0][0]=4;	$symbols[1][0]=4; $symbols[2][0]=4;

unset($linewin);
unset($win);
//$symb_combs='';
//line matches


$linePatterns[0] = "1_1_1_1_1";
$linePatterns[1] = "0_0_0_0_0";
$linePatterns[2] = "2_2_2_2_2";
$linePatterns[3] = "0_1_2_1_0";
$linePatterns[4] = "2_1_0_1_2";
$linePatterns[5] = "1_0_1_0_1";
$linePatterns[6] = "1_2_1_2_1";
$linePatterns[7] = "0_1_0_1_0";
$linePatterns[8] = "2_1_2_1_2";
$linePatterns[9] = "0_2_0_2_0";
$linePatterns[10] = "2_0_2_0_2";
$linePatterns[11] = "0_1_1_1_2";
$linePatterns[12] = "2_1_1_1_0";
$linePatterns[13] = "0_0_1_2_2";
$linePatterns[14] = "2_2_1_0_0";
$linePatterns[15] = "0_0_2_0_0";
$linePatterns[16] = "2_2_0_2_2";
$linePatterns[17] = "1_2_1_0_1";
$linePatterns[18] = "1_0_1_2_1";
$linePatterns[19] = "0_1_1_1_1";

//echo "<br><br>";

for ($i = 0; $i < 20; $i++) {
	$logger = '';
	$linePattern = explode("_", $linePatterns[$i]);
	$is_wild = "";
	$symbs[$i] = 0;
	if ($extrawild[0][1] == 1) $is_wild = "_1";
	elseif ($symbs[0] == 0) $symbs[0] = $symbols[0][1];

	for ($j = 0; $j < 5; $j++) {
		if ($extrawild[$j][$linePattern[$j]] == 1) $is_wild = "_1";
		elseif ($symbs[$i] == 0) $symbs[$i] = $symbols[$j][$linePattern[$j]];
	}
	if ($symbs[$i] == 0) $symbs[$i] = 3;

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
	if ($logger != '') $symb_combs .= $logger . ";";
}

//echo "<BR>".$symb_combs;


//echo "<br><br>";

//foreach ($linewin as $v =>$e) {$total_win+=$v; echo $v." => ".$e."<br>"; }

foreach ($linewin as $v) {
	$total_win += $v;
}
$total_winCents = $total_win * $denomDB;

if ($lastAction == "freespin") unset($extrawild);

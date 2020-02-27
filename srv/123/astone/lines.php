<?

//	hasColossal: 0 - no colossal, -1 - already explosed colossal in this drop, 1 - colossal anwhere exept -1 floor, 2 - in -1 floor in 'drop1'

$lastSy = '';
$explode_colossal = 0;
$move_colossal = 0;
$crushMul = 1;
$dropColossal = 0;

$symbolsOriginal = $symbols;

include('oldmask.php');


$symbolsOverlayed = $symbols;
$symbolsShifted = $symbols;

foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) {
		$extrawild[$e][$e1] = 1;
	}
}
/*
$syms_colossal_af="<br>colossal array after<br>";
    for($j=0;$j<3;$j++)
 {
for($i=0;$i<5;$i++)
    {
$syms_colossal_af.="[".$colossal[$i][$j]."]\t\t\t\t";
    }
$syms_colossal_af.="<br>";
 }
*/

if ($move_colossal == 1) {
	foreach ($colossal as $e => $v)  foreach ($v as $e1 => $v1) {
		if ($colossal[$e][$e1] == -1) {
			$symbolsOverlayed[$e][$e1] = $symbolsOriginal[$e][$e1];
			$symbols[$e][$e1] = $symbolsOriginal[$e][$e1];
			$symbolsShifted[$e][$e1] = $symbolsOriginal[$e][$e1];
			unset($colossal[$e][$e1]);
		}
	}
	$move_colossal = 0;
}

$syms_mod = "<br>syms modify<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_mod .= "[" . $symbols[$i][$j] . "]\t\t\t\t";
	}
	$syms_mod .= "<br>";
}

//echo "cr:$crushMul";

if (!isset($fs_left) and $colossalSym != 0)
	foreach ($symbolsOverlayed as $e => $v)  foreach ($v as $e1 => $v1) {
		if ($colossal[$e][$e1] == 1) {
			$symbolsOverlayed[$e][$e1] = 0;
		}
	}


if ($colossalSym != 0 and $hasColossal > 0) {
	for ($i = $colossalFinalX; $i < ($colossalSize + $colossalFinalX); $i++)
		for ($j = $colossalFinalY; $j < ($colossalSize + $colossalFinalY); $j++) {
			$symbols[$i][$j] = $colossalSym;
		}
}

//is move colossal????
//$move_colossal=0;



include('winblock.php');

if ($move_colossal == 0) {
	if ($explode_colossal == 1) {
		for ($i = $colossalFinalX; $i < ($colossalSize + $colossalFinalX); $i++)
			for ($j = $colossalFinalY; $j < ($colossalSize + $colossalFinalY); $j++) {
				if ($colossal[$i][$j] == 2) $symbolsShifted[$i][$j] = 1;
				else $symbolsShifted[$i][$j] = 0;
			}
	}
}

//echo "hasCol=$hasColossal&ColFinalY=$colossalFinalY,dropCol=$dropColossal,crush=$crush,mcrush=$megaCrush<br><br>";
//$crushedStr='';"0|3,1_1|4,1_";


$syms_crush = "<br>crushed array after<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_crush .= "[" . $crushSyms[$i][$j] . "]\t\t\t\t";
	}
	$syms_crush .= "<br>";
}

/*
$syms_colossal_af="<br>colossal array after<br>";
    for($j=0;$j<3;$j++)
 {
for($i=0;$i<5;$i++)
    {
$syms_colossal_af.="[".$colossal[$i][$j]."]\t\t\t\t";
    }
$syms_colossal_af.="<br>";
 }
*/

$symsSH_before = "<br><br>SHIFTED before syms<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$symsSH_before .= "[" . $symbolsShifted[$i][$j] . "]\t\t\t\t";
	}
	$symsSH_before .= "<br>";
}

//$lastSymsStr='';
/*
 for($i=0;$i<5;$i++)
   {
    for($j=0;$j<3;$j++)
    {
	if($symbolsShifted[$i][$j]==0)   $str="null";
	    else $str="SYM".$symbols[$i][$j];
	if($lastSyms[$i]=='')$lastSyms[$i]=$str; else $lastSyms[$i].=",".$str;///////////////////////////////////
    }
   }
*/

/*
 foreach($lastSyms as $e=>$v) $lastSymsStr.=$e."|".$v."_";
*/


for ($i = 0; $i < 5; $i++) {
	for ($j = 0; $j < 3; $j++) {
		$symsLast2DB .= $symbolsShifted[$i][$j] . ",";
	}
	$symsLast2DB .= "_";
}



for ($i = 0; $i < 5; $i++)
	for ($j = 2; $j >= 0; $j--) {

		if ($symbolsShifted[$i][$j] == 0) {
			if ($j == 2) {
				$symbolsShifted[$i][2] = $symbolsShifted[$i][1];
				$symbolsShifted[$i][1] = $symbolsShifted[$i][0];
				$symbolsShifted[$i][0] = 0;
				if ($symbolsShifted[$i][2] == 0) {
					$symbolsShifted[$i][2] = $symbolsShifted[$i][1];
					$symbolsShifted[$i][1] = $symbolsShifted[$i][0];
					$symbolsShifted[$i][0] = 0;
				}
			}
			if ($j == 1) {
				$symbolsShifted[$i][1] = $symbolsShifted[$i][0];
				$symbolsShifted[$i][0] = 0;
			}
		}
	}

/*
$lastSymsStr='';

 for($i=0;$i<5;$i++)
   {
    for($j=0;$j<3;$j++)
    {
	if($symbolsShifted[$i][$j]==0)   $str="null";
	    else $str="SYM".$symbols[$i][$j];
	if($lastSyms[$i]=='')$lastSyms[$i]=$str; else $lastSyms[$i].=",".$str;
    }
   }

 foreach($lastSyms as $e=>$v) $lastSymsStr.=$e."|".$v."_";
*/


if ($hasColossal > 0)
	if ($move_colossal == 0) {
		if ($explode_colossal == 0) {
			for ($i = $colossalFinalX; $i < ($colossalSize + $colossalFinalX); $i++)
				for ($j = $colossalFinalY; $j < ($colossalSize + $colossalFinalY); $j++) {
					if ($symbolsShifted[$i][$j] == 0) {
						if ($symbolsShifted[$i][$j + 1] == 0) {
							$symbolsShifted[$i][$j + 2] = 0;
							$symbolsShifted[$i][$j] = $colossalSym;
						} else {
							$symbolsShifted[$i][$j + 1] = 0;
							$symbolsShifted[$i][$j] = $colossalSym;
						}
					}
				}
		}
	}

/*
$lastSymsStr='';

 for($i=0;$i<5;$i++)
   {
    for($j=0;$j<3;$j++)
    {
	if($symbolsShifted[$i][$j]==0)   $str="null";
	    else $str="SYM".$symbols[$i][$j];
	if($lastSyms[$i]=='')$lastSyms[$i]=$str; else $lastSyms[$i].=",".$str;
    }
   }

 foreach($lastSyms as $e=>$v) $lastSymsStr.=$e."|".$v."_";

// foreach($lastSyms as $e=>$v) $lastSymsStr.=$e."|null,null,null_";
*/

//echo "<br>$colossalSize $colossalY <br>";
$wild_depth[5] = 1;

if ($colossalSym == 1 and $explode_colossal == 1 and $hasColossal > 0) {

	/*
	    for ($i=$colossalFinalX;$i<($colossalSize+$colossalFinalX);$i++)
		for ($j=$colossalFinalY;$j<($colossalSize+$colossalFinalY);$j++)
		{
		}
*/

	if ($colossalSize == 2) {
		if ($colossalFinalY == -1) //$wilds=$colossalX.",".
		{
			$wild_depth[$colossalX] = 1;
			$wild_depth[$colossalX + 1] = 1;
			$wild_depth[5] = 0;
		}
		/*
		 elseif($colossalY==0)
		 {
//		    $wild_depth[$colossalX+1]=1;
//		    $wild_depth[5]=0;
		 }
		 elseif($colossalY==1)
		 {
//		    $wild_depth[$colossalX+1]=1;
//		    $wild_depth[5]=0;
		 }
*/
	} elseif ($colossalSize == 3) {
		if ($colossalFinalY == -1) {
			$wild_depth[$colossalX] = 1;
			$wild_depth[$colossalX + 1] = 1;
			$wild_depth[$colossalX + 2] = 1;
			$wild_depth[5] = 0;
		} elseif ($colossalFinalY == -2) {
			$wild_depth[$colossalX] = 2;
			$wild_depth[$colossalX + 1] = 2;
			$wild_depth[$colossalX + 2] = 2;
			$wild_depth[5] = 0;
		}
		/*
		 elseif($colossalFinalY==0)
		    {
//			$wild_depth[$colossalX+2]=1;
//			$wild_depth[5]=0;
		    }
*/
	}
}

//    if(!isset($wild_depthDB))$wild_depthDB='';
//    else
if ($wild_depthDB != '') {
	$temp = explode("_", $wild_depthDB);
	foreach ($temp as $e => $v) {
		$temp2 = explode(",", $v);
		$wild_depth[$temp2[0]] = $temp2[1];
		//		echo "<br>$wild_depth[$temp2[0]] $temp2[1]<br>";
		$wild_depth[5] = 0;
	}
}


if ($wild_depth[5] == 0)
	for ($i = $colossalFinalX; $i < ($colossalSize + $colossalFinalX); $i++) {
		for ($j = 2; $j >= 0; $j--) {
			if ($symbolsShifted[$i][$j] == 0)
				if ($wild_depth[$i] > 0) {
					$wild_depth[$i]--;
					$symbolsShifted[$i][$j] = 1;
				}
		}
	}




$wild_depthDB = '';

for ($i = 0; $i < 5; $i++)
	if (isset($wild_depth[$i])) $wild_depthDB .= $i . "," . $wild_depth[$i] . "_";

for ($i = 0; $i < 5; $i++) {
	for ($j = 0; $j < 3; $j++) {
		$symsOrigDB .= $symbolsOverlayed[$i][$j] . ",";
	}
	$symsOrigDB .= "_";
}

for ($i = 0; $i < 5; $i++) {
	for ($j = 0; $j < 3; $j++) {
		$symsShiftedDB .= $symbolsShifted[$i][$j] . ",";
	}
	$symsShiftedDB .= "_";
}

//echo "SymSDB=$symsShiftedDB&";


$syms_after = "<br>syms after<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_after .= "[" . $symbols[$i][$j] . "]\t\t\t\t";
	}
	$syms_after .= "<br>";
}

$symsSH_after = "<br><br>SHIFTED after syms<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$symsSH_after .= "[" . $symbolsShifted[$i][$j] . "]\t\t\t\t";
	}
	$symsSH_after .= "<br>";
}





//echo "<br>CCCCC: $crushMul<br>";
/*
echo $syms_before;
echo $syms_old;
echo $syms_crush;
echo $syms_colossal;
echo $syms_colossal_af;
echo $syms_mod;

echo $syms_after;
echo $symsSH_before;
echo $symsSH_after;
*/
//echo $lastSy."<br><br>";

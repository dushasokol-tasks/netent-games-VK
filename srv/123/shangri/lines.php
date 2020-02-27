<?
/*$syms_after="<br>symsORIG<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$symbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";

$syms_after="<br>OLDORIG<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$oldSymbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";*/




if ($lastAction != "random_subs" and $lastAction != "pre_r_s" and $lastAction != "pre_s_s" and $lastAction != "cancel_r_s" and $lastAction != "freespin") $symbolsOverlayed = $symbols;
else {
	foreach ($add_symbols as $e => $v) {
		foreach ($v as $e1 => $v1) {
			if ($symbols[$e][$e1] != $v1) {
				$symbols[$e][$e1] = $v1;
				//		echo "set ".$symbols1[$e][$e1]."($e $e1) =>".$v1."<br>";
				if ($lastAction != "pre_s_s" and $lastAction != "freespin")	$feature_triggered = "true";

				if ($oldSymbols[$e][$e1] != 11) {
					if ($feature_positions == '') $feature_positions = "$e:$e1";
					else $feature_positions .= ",$e:$e1";
				}
				//		echo "FEAT $e $e1 <br>";
			}
		}
	}
	if ($lastAction == "freespin") {
		$fs_feature_positions = $feature_positions;
		//	echo "SAVE FEAT $fs_feature_positions <br>";
		for ($i = 0; $i < 6; $i++)
			for ($j = 0; $j < 5; $j++) {
				if ($oldSymbols[$i][$j] != '') $symbols[$i][$j] = $oldSymbols[$i][$j];
			}
	}
}

if ($lastAction == 'respin') {
	for ($i = 0; $i < 6; $i++)
		for ($j = 0; $j < 5; $j++) {
			if ($oldSymbols[$i][$j] != '') $symbols[$i][$j] = $oldSymbols[$i][$j];
			if ($symbols[$i][$j] == $respinSymbol)
				if ($feature_positions == '') $feature_positions = "$i:$j";
				else $feature_positions .= ",$i:$j";
		}
	$symbolsOverlayed = $symbols;
}

//echo "FEATURE ".$feature_positions."<br>";
/*$syms_after="<br>syms<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$symbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";*/

for ($i = 0; $i < 6; $i++) {
	for ($j = 3; $j < 12; $j++) {
		$symbols_count[$i][$j] = 0;
		if ($symbols[$i][0] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][1] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][2] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][3] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][4] == $j) $symbols_count[$i][$j]++;
	}
}

$highSymVal = 0;
$highSym = 0;
for ($j = 3; $j < 12; $j++) {
	$symbolsOverallCount[$j] = $symbols_count[0][$j] + $symbols_count[1][$j] + $symbols_count[2][$j] + $symbols_count[3][$j] + $symbols_count[4][$j] + $symbols_count[5][$j];
	if ($symbolsOverallCount[$j] > $highSymVal) {
		$highSymVal = $symbolsOverallCount[$j];
		$highSym = $j;
	}
}

for ($j = 3; $j < 10; $j++) if (($symbolsOverallCount[$j] + $symbolsOverallCount[11]) < 9) unset($symbolsOverallCount[$j]);

$group = 1;

foreach ($symbolsOverallCount as $e => $v) {
	if ($e != 11) {
		for ($i = 0; $i < 6; $i++)
			for ($j = 0; $j < 5; $j++) $prestackGroup[$i][$j] = "x";

		for ($i = 0; $i < 6; $i++) {
			for ($j = 0; $j < 5; $j++) {
				if ($symbols[$i][$j] == $e) {
					if (($symbols[($i - 1)][($j)] == $e and isset($symbols[($i - 1)][($j)]))		or
						($symbols[($i)][($j - 1)] == $e and isset($symbols[($i)][($j - 1)]))		or
						($symbols[($i + 1)][($j)] == $e and isset($symbols[($i + 1)][($j)]))		or
						($symbols[($i)][($j + 1)] == $e and isset($symbols[($i)][($j + 1)]))
					) {
						$prestackSyms[$i][$j] = $e;
					}
				}
			}
		}

		for ($j1 = 0; $j1 < 5; $j1++) {
			for ($i1 = 0; $i1 < 6; $i1++) {
				$syms_after1 .= "[" . $prestackGroup[$i1][$j1] . "]\t\t\t\t";
			}
			$syms_after1 .= "<br>";
		}
	}
}

/*
$syms_after="<br>PRESTACK SYMS<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$prestackSyms[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }

echo $syms_after;
*/
//echo "<br>";
//echo $syms_after1;

/*
function creeper($prestackGroup,$symbols,$baseX,$baseY,$symb,$curGroup)
{
    if($prestackGroup[$baseX][$baseY]=='x')$prestackGroup[$baseX][$baseY]=$curGroup;
    else return $prestackGroup;

    if($symbols[($baseX)][($baseY+1)]==$symb and isset($symbols[($baseX)][($baseY+1)]))
	$prestackGroup=creeper($prestackGroup,$symbols,$baseX,($baseY+1),$symb,$curGroup);
    if($symbols[($baseX+1)][($baseY)]==$symb and isset($symbols[($baseX+1)][($baseY)]))
	$prestackGroup=creeper($prestackGroup,$symbols,($baseX+1),($baseY),$symb,$curGroup);

*/
/*
$syms_after="<br>it $curGroup<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$prestackGroup[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";
*/
/*
    if($symbols[($baseX)][($baseY-1)]==$symb and isset($symbols[($baseX)][($baseY-1)])) 
//	echo $curGroup.": ".$baseX." ; ".($baseY)." => ".$symbols[($baseX)][($baseY)]." === ".$baseX." ; ".($baseY-1)." => ".$symbols[($baseX)][($baseY-1)]."<br>";
	$prestackGroup=creeper($prestackGroup,$symbols,$baseX,($baseY-1),$symb,$curGroup);
    if($symbols[($baseX-1)][($baseY)]==$symb and isset($symbols[($baseX-1)][($baseY)]))
	$prestackGroup=creeper($prestackGroup,$symbols,($baseX-1),($baseY),$symb,$curGroup);


 return $prestackGroup;
}
*/

foreach ($prestackSyms as $e => $v)  foreach ($v as $e1 => $v1) //if($v1!='x')
{
	$prestackGroup = creeper($prestackGroup, $symbols, $e, $e1, $symbols[$e][$e1], $group);
	$group++;
}


for ($i = 0; $i < 6; $i++) {
	for ($j = 0; $j < 5; $j++) {
		if (is_numeric($prestackGroup[$i][$j])) {
			$groups[$prestackGroup[$i][$j]]++;
		}
	}
}


$ws_line = 0;
foreach ($groups as $e => $v) {
	if ($v > 8) {
		$ws_ani = '';
		$ws_symb = '';
		//	    echo "group $e has $v <br>";
		for ($i = 0; $i < 6; $i++) {
			for ($j = 0; $j < 5; $j++) {
				if ($prestackGroup[$i][$j] == $e) {
					$ws_symb = $symbols[$i][$j];
					if ($ws_ani == '')    $ws_ani = $i . "," . $j;
					else $ws_ani .= ";" . $i . "," . $j;
					//			echo "SS".$s_s_symbols[$i][$j].";";

					if ($s_s_symbols[$i][$j] == 11) {
						$winGr[$ws_symb][$ws_line][$i][$j] = $s_s_symbols[$i][$j];
						//			     echo "AAAA";
					}
				}
			}
		}
		$linewin[$ws_line] = $lineWinMarix[$v][$ws_symb] * $betDB;
		$win[$ws_line] = $linewin[$ws_line] . "_" . $ws_ani . "_" . $ws_symb;
		//	    if($ws_symb==3)$ws_symb=14;if($ws_symb==4)$ws_symb=15;if($ws_symb==5)$ws_symb=20;
		$symbOverlays[$ws_line] = $ws_symb;

		$ws_line++;
		$winGroup[$ws_symb] = 1;
		//	    $winGr[$ws_line]=$e;////////////
	}

	if ($v > 4) {
		$subs_sym = 0;
		for ($i = 0; $i < 6; $i++) {
			for ($j = 0; $j < 5; $j++) {
				if ($prestackGroup[$i][$j] == $e) {
					$subs_sym = $symbols[$i][$j];
				}
			}
		}
		$randomSub[$e] = $subs_sym;
		$randomSubSym[$subs_sym]++;
	}

	//	if($v>4 and $v<9 and $lastActionDB!='respin' and $lastAction!='freespin' and $lastAction!='pre_s_s')
	if ($v > 4 and $v < 9 and $lastActionDB != 'respin' and $lastAction != 'freespin' and $lastAction != 'initfreespin' and $lastAction != 'forceSpin' and $lastAction != 'forceFreespin' and $lastAction != 'pre_s_s' and $substSymbCount == 0) {
		$lastAction = "pre_respin";
		if (!isset($respinSym))
			for ($i = 0; $i < 6; $i++) {
				for ($j = 0; $j < 5; $j++) {
					if ($prestackGroup[$i][$j] == $e) {
						$respinSym = $symbols[$i][$j];
					}
				}
			}
	}
}

if ($lastAction != 'respin' and $lastAction != 'lastrespin') ////////check for freespins
{
	$sameClusters = 0;
	foreach ($randomSubSym as $e => $v) {
		foreach ($winGroup as $e1 => $v1) {
			if ($v == 2 and $e1 != $e) $sameClusters = -1;
		}
		if ($v == 2 and $substSymbCount == 0) {
			//	echo "<b>pRS: $e => $v TUTU</b>";
			if (rand(0, 1000) < $randomSubsRate and $e != 3 and $e != 4 and $e != 5) {
				$lastAction = "pre_r_s";
				$randomSubsRate = 1001;
			} else $lastAction = "cancel_r_s";
		}
	}
}
/*
if($lastAction=='pre_r_s' and round(rand(0,1000)<1200))
{
	$lastAction="spin";
}
else 		$lastAction="pre_r_s";
*/
//////////// symbol sybst


if (($lastAction == 'spin' or $lastAction == 'freespin') and $substSymbCount > 0) {
	$lastAction = "pre_s_s";
	$s_s_symbols = $symbols;
	//    $overlaySym=$highSym;/////////
}

//    $lastAction="pre_s_s";
//echo "LA: $lastAction HS = $highSym HSV = $highSymVal ; RSC $respinSymCount<br>";
//echo " $symbolsOverallCount[3] <br>";


/*$syms_after="<br>MYgroups<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$prestackGroup[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";
echo "&";*/

///////////respins

if ($lastAction == 'pre_respin' and $bonusSymbCount == 0) {
	if ($highSymVal > 9 and !isset($win)) {
		if (rand(0, 1000) < $respinRate and $respinSym != 3) {
			$lastAction = "respin";
			$reelset = "respin1";
			$overlaySym = $respinSym;
			for ($i = 0; $i < 6; $i++) {
				for ($j = 0; $j < 5; $j++) {
					if ($symbols[$i][$j] == $respinSym) if ($wilds == '') $wilds = $i . ":" . $j;
					else $wilds .= "," . $i . ":" . $j;
				}
			}
		}
		//     else
		//     echo "<b>WE HAVE CANCELED RESPIN</b><br>";
	}
} elseif ($lastAction == 'respin') {

	if ($highSymVal > $respinSymCount and !isset($win) and $highSym == $respinSym)
	//    if($highSymVal>$respinSymCount and !isset($win))
	{
		$reelset = "respin2";
		$clientAction = "respin";
		$rs_Id = "respin1";
		$overlaySym = $respinSym;
		for ($i = 0; $i < 6; $i++) {
			for ($j = 0; $j < 5; $j++) {
				if ($symbols[$i][$j] == $respinSym) if ($wilds == '') $wilds = $i . ":" . $j;
				else $wilds .= "," . $i . ":" . $j;
			}
		}
	} else {
		$reelset = "respin4";
		$lastAction = "lastrespin";
		$overlaySym = $respinSym;
	}
}



/*
elseif($lastAction=='freespin')
{
    do
    {
	 $i=round(rand(0,5));     $j=round(rand(0,4));
	 if($symbols[$i][$j]==11)
	    {
		$symbolsOverallCount[11]--;
		if($wilds=='') $wilds=$i.":".$j;else $wilds.=",".$i.":".$j;
		$symbols[$i][$j]=12;
	    }
    }
    while($symbolsOverallCount[11]>4);
}
*/

/*
	for($i=0;$i<6;$i++)
	{
	    for($j=0;$j<5;$j++)
	    {


		    if($symbols[$i][$j]==$respinSym)
			{
			    $destroyOS=0;
			    if($symbolsOverallCount[11]>2){$destroyOS=1; echo "has destroy $i $j <br>";}
			    $symbolsOverallCount[11]--;
			    if($destroyOS==0)
			    {
				if($wilds=='') $wilds=$i.":".$j;else $wilds.=",".$i.":".$j;
				$symbols[$i][$j]=12;
			    }
			}
	    }
	}
*/

//echo "sam: $sameClusters<br>";

if ($lastAction != 'respin' and $lastAction != 'lastrespin') {
	foreach ($randomSubSym as $e1 => $v1) {
		//  echo "<b>".$e1." to ".$v1."</b><br>";
		if ($lastAction == 'pre_r_s' and $v1 == 1) {
			$lastAction = "random_subs";
		}

		if ($v1 == 2) {
			//   foreach($randomSub as $e=>$v)
			//    {
			//    echo $e." => ".$v."<br>";
			//    foreach($prestackGroup as $gE=>$gV) foreach($gV as $gE1=>$gV1)
			//    }
			$overlaySym = $e1;
		}
	}
}

if ($lastAction == 'pre_r_s' and $sameClusters == -1) $lastAction = "cancel_r_s";

/*$syms_after="<br>groups<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$prestackGroup[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";
echo "&";*/
//echo "&";





foreach ($win as $e => $v) {
	//echo "DDDDDSSSSS ".$v."<br>";
	$winInfo = explode("_", $v);

	//	    echo "0(".$winInfo[0]." "."1(".$winInfo[1]."2(".$winInfo[2]."3(".$winInfo[3]."<br>";

	if ($lastAction == 'lastrespin' and $winInfo[2] != $overlaySym) {
		unset($win[$e]);
		//echo "!!drop<br>";
	} else

		$total_win += $winInfo[0];
}
if ($logger != '')
	foreach ($logger as $e => $v) $symb_combs .= $v . ";";


$total_winCents = $total_win * $denomDB;

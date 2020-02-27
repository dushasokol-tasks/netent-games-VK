<?

//	hasColossal: 0 - no colossal, -1 - already explosed colossal in this drop, 1 - colossal anwhere exept -1 floor, 2 - in -1 floor in 'drop1'
$crushSymNum = 0;
/*
if($symsShiftedDB!='')
 {
    $oldRls=explode('_',$symsShiftedDB);
    foreach($oldRls as $oldRlNum=>$oldRl)
    {
	 if($oldRl!='')
	 {
	    $oldSyms=explode(',',$oldRl);
	    foreach($oldSyms as $oldSymsNum=>$oldSym)
	    {
		 if($oldSym!='')$old_symbols[$oldRlNum][$oldSymsNum]=$oldSym;
	    }
	 }
    }
 }
*/

$syms_before = "<br>syms orig%%*<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_before .= "[" . $symbols[$i][$j] . "]\t\t\t\t";
	}
	$syms_before .= "<br>";
}

$syms_old = "<br>old mask<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_old .= "[" . $old_symbols[$i][$j] . "]\t\t\t\t";
	}
	$syms_old .= "<br>";
}



for ($i = 0; $i < 5; $i++)
	for ($j = 0; $j < 3; $j++) {
		if ($old_symbols[$i][$j] != 0) $symbols[$i][$j] = $old_symbols[$i][$j];
	}

/*
if($hasColossal<0 and $wildsDB)	// explosive wild
{
    $oldRls=explode('_',$wildsDB);
    foreach($oldRls as $oldRlNum=>$oldRl)
    {
	 if($oldRl!='')
	 {
	    $oldSyms=explode(',',$oldRl);
	    $symbols[$oldSyms[0]][$oldSyms[1]]=1;
	 }
    }
}
*/

if ($hasColossal > 0) {
	for ($i = $colossalFinalX; $i < ($colossalSize + $colossalFinalX); $i++) {
		for ($j = $colossalFinalY; $j < ($colossalSize + $colossalFinalY); $j++) {
			if ($old_symbols[$i][$j] == 0) $symbols[$i][$j] = $colossalSym;
			/*
		if($old_symbols[$i][$j]==0)$symbols[$i][$j]=$colossalSym;
		elseif($old_symbols[$i][$j]==$colossalSym)$symbols[$i][$j]=$colossalSym;
		elseif(isset($old_symbols[$i][$j]))
		{
//		    $crushedStr.=$crushedSymNum."|".$i.",".$j."_";
		    $crushSyms[$i][$j]=1;
		    $crushedSymNum++;
		    $move_colossal=1;
		}
*/
			$colossal[$i][$j] = 1;
		}
		if (isset($old_symbols[$i][$colossalFinalY + $colossalSize])) {
			if ($old_symbols[$i][$colossalFinalY + $colossalSize] == 0)
				$crushSyms[$i][$colossalFinalY + $colossalSize] = 1;
			else $crushSyms[$i][$colossalFinalY + $colossalSize] = 2;
		}
		if (isset($old_symbols[$i][$colossalFinalY + 1 + $colossalSize])) {
			if ($old_symbols[$i][$colossalFinalY + 1 + $colossalSize] == 0)    	$crushSyms[$i][$colossalFinalY + 1 + $colossalSize] = 1;
			else $crushSyms[$i][$colossalFinalY + 1 + $colossalSize] = 2;
		}
		if (isset($old_symbols[$i][$colossalFinalY + 2 + $colossalSize])) {
			if ($old_symbols[$i][$colossalFinalY + 2 + $colossalSize] == 0)    	$crushSyms[$i][$colossalFinalY + 2 + $colossalSize] = 1;
			else $crushSyms[$i][$colossalFinalY + 2 + $colossalSize] = 2;
		}
	}

	/*

 for($i=0;$i<5;$i++)
   {
    for($j=0;$j<3;$j++)
    {
	if($old_symbols[$i][$j]==0)   $str="null";
	    else $str="SYM".$symbols[$i][$j];
	if($lastSyms[$i]=='')$lastSyms[$i]=$str; else $lastSyms[$i].=",".$str;
    }
     $lastSy.="rs.i0.r.i".$i.".lastsyms=".$lastSyms[$i]."&";
   }
     $lastSy="rs.i0.r.i0.lastsyms=".$lastSyms[0]."&";
     $lastSy.="rs.i0.r.i1.lastsyms=".$lastSyms[1]."&";
     $lastSy.="rs.i0.r.i2.lastsyms=null,null,null&";
     $lastSy.="rs.i0.r.i3.lastsyms=null,null,null&";
     $lastSy.="rs.i0.r.i4.lastsyms=null,null,null&";
*/
}

$lastRow = 0;
for ($i = 0; $i < 5; $i++)
	for ($j = 0; $j < 3; $j++) {
		if (isset($crushSyms[$i][$j])) {
			if ($crushSyms[$i][$j] == 1) {
				$move_floor[$j] = 1;
				//	    $crushMul++;
				$move_colossal = 1;
				$lastRow = $j;
				$symbols[$i][$j] = $colossalSym;
			}
			//	if($crushSyms[$i][$j]==2 and $colossalSym==1)

			//	$full_floor[$j]=1;
		}
	}

//echo "exC:$extraCrush";

if ($extraCrush > 0) {
	if ($symsOrigDB != '') {
		$oldRls = explode('_', $symsOrigDB);
		foreach ($oldRls as $oldRlNum => $oldRl) {
			if ($oldRl != '') {
				$oldSyms = explode(',', $oldRl);
				foreach ($oldSyms as $oldSymsNum => $oldSym) {
					if ($oldSym != '') $orig_symbols[$oldRlNum][$oldSymsNum] = $oldSym;
				}
			}
		}
	}

	for ($j = 1; $j <= $extraCrush; $j++) {
		if (($colossalSize == 3 and $colossalFinalY == -3 and $lastRow == 0) or ($colossalSize == 2 and $colossalFinalY == -2 and $lastRow == 0)) {
			$move_floor[$j] = 1;

			for ($i = $colossalFinalX; $i < ($colossalSize + $colossalFinalX); $i++) {
				$old_symbols[$i][0] = $orig_symbols[$i][0];
				$old_symbols[$i][$j] = $orig_symbols[$i][$j];
			}
		}
	}
}

foreach ($move_floor as $e => $v) {
	$crMu = 0;
	$colossalFinalY += $v;
	//	 $crushMul++;
	for ($i = 0; $i < 5; $i++)
		if ($crushSyms[$i][$e] == 2) {
			$crushedOut .= "crushedSymbol" . $crushSymNum . "=" . $i . "," . $e . "&";
			$crushSymNum++;
			if ($crMu == 0) $crMu = 1;
		}
	$crushMul = $crushMul + $crMu;
}

if ($move_colossal == 1) {
	for ($i = 0; $i < 5; $i++)
		for ($j = 0; $j < 3; $j++) {
			if ($colossal[$i][$j] == 1) $colossal[$i][$j] = -1;
		}
	//echo "!".$colossalFinalY." [ ".($colossalSize+$colossalFinalY)."<br>";
	for ($i = $colossalFinalX; $i < ($colossalSize + $colossalFinalX); $i++) {
		for ($j = $colossalFinalY; $j < ($colossalSize + $colossalFinalY); $j++) {
			$colossal[$i][$j] = 1;
			if ($colossalSym == 1) $symbols[$i][$j] = $colossalSym;
		}
	}
}

//echo "<br>CCCCC: $crushMul<br>";

$syms_crush = "<br>crushed array<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_crush .= "[" . $crushSyms[$i][$j] . "]\t\t\t\t";
	}
	$syms_crush .= "<br>";
}

$syms_colossal = "<br>colossal array<br>";
for ($j = 0; $j < 3; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_colossal .= "[" . $colossal[$i][$j] . "]\t\t\t\t";
	}
	$syms_colossal .= "<br>";
}



/*
   if($hasColossal>0)
    {
	for ($i=$colossalFinalX;$i<($colossalSize+$colossalFinalX);$i++)
	    for ($j=$colossalFinalY;$j<($colossalSize+$colossalFinalY);$j++)
	    {
		$symbols[$i][$j]=$colossalSym;
		$colossal[$i][$j]=1;
	    }
    }
*/
//else $crushedStr='';

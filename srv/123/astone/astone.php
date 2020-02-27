<?
header('Access-Control-Allow-Origin: *');
////////////////////////////////////////////////////////////////////////////////
//reels
//	5	wild stacks vari
//	6	random_wild	symbol_transform	symbol_overlay
//	7	symbol_overlay combinations vari
//	8	bonus type vari
//bonus
//	5	coinwin value
////////////////////////////////////////////////////////////////////////////////
$gameover = "true";
$wilds = '';
$buster7 = '';
$buster8 = '';
$buster10 = '';
$buster12 = '';

////////////////////////////////////
//correct action check
////////////////////////////////////
if ($_GET['action'] == "drop" and $lastActionDB != "drop" and $lastActionDB != "drop1" and $lastActionDB != "freespin" and $lastActionDB != "paytable") exit;

if ($_GET['action'] == "initfreespin" and $lastActionDB != "startfreespin" and $lastActionDB != "paytable") exit;


if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "initfreespin" and $lastActionDB != "drop" and $lastActionDB != "drop1" and $lastActionDB != "paytable") exit; //&&

////////////////////////////////////

if ($_GET['action'] == "init") {
	include($gamePath . 'init.php');
	include($gamePath . 'common.php');
	$lastAction = "init";
	$lastRs = $lastRsDB;
}

if ($_GET['action'] == "paytable") {
	if ($answer == '') $table_locked = 0;
	else {
		$table_locked = 1;
		$answ = $answer;
	}
	include($gamePath . 'payt.php');
	$lastAction = "paytable";
	$lastRs = $lastRsDB;
	$answ .= "crushMul=1;";
	$answ .= "hasColossal=0;";
	$answ .= "startFS=0;";
	$startFS = 0;
}




if ($_GET['action'] == "spin" or $_GET['action'] == "drop" or $_GET['action'] == "freespin" or $_GET['action'] == "initfreespin") {
	$gameover = "true";
	$overlaySym = "";
	$table_locked = 1;

	$lines_again = 0;

	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}

	$hotlines = explode(",", $anBetVarDB);

	$lastAction = "spin";

	if (isset($fs_left) and $fs_left > 0) {
		if ($lastActionDB == "initfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
		if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	}

	if ($lastActionDB == "startfreespin" and $_GET['action'] == "initfreespin") $lastAction = "initfreespin";

	////////////////////
	//symbol generation
	////////////////////

	if (isset($fs_left) and $fs_left > 0) {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' order by id asc;";
		if ($lastAction == "freespin") {
			$fs_left--;
			$fs_played++;
		}
	} else	$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

	$result = mysql_query($query);

	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$reels['id']] = explode("_", $reels['symbols']);
	}

	for ($i = 0; $i < 5; $i++) {
		$length = (count($reel[$i]) - 1);
		$pos = round(rand(0, $length));

		$symbols[$i][0] = $reel[$i][$pos];
		if ($pos == $length) {
			$symbols[$i][1] = $reel[$i][0];
			$symbols[$i][2] = $reel[$i][1];
		} elseif ($pos == ($length - 1)) {
			$symbols[$i][1] = $reel[$i][$length];
			$symbols[$i][2] = $reel[$i][0];
		} else {
			$symbols[$i][1] = $reel[$i][$pos + 1];
			$symbols[$i][2] = $reel[$i][$pos + 2];
		}
	}

	$multiplier = $crushMul;

	if (isset($symsShiftedDB) and $symsShiftedDB != '') {
		$oldRls = explode('_', $symsShiftedDB);
		foreach ($oldRls as $oldRlNum => $oldRl) {
			if ($oldRl != '') {
				$oldSyms = explode(',', $oldRl);
				foreach ($oldSyms as $oldSymsNum => $oldSym) {
					if ($oldSym != '') $old_symbols[$oldRlNum][$oldSymsNum] = $oldSym;
				}
			}
		}
	}


	//make colossal
	$colossalFreespinGameCreateRate = $reel[9][0]; // generate colossal in FS
	$colossalWildFreespinCreateRate = $reel[9][1]; // generate wild  in FS

	$colossalDropGameCreateRate = $reel[9][2]; // generate colossal in drop in both types of games
	$colossalDropWildCreateRate = $reel[9][3]; // droped colossal is wild in FS

	$colossalMainGameCreateRate = $reel[9][4]; // generate colossal in main
	$freespinMainGameCreateRate = $reel[9][5]; // generate FS starter

	$createFreespinInFS = $reel[9][9];

	$extraCrush = 0;
	$addFS = 0;

	if ($hasColossal == 0) {
		$wild_depthDB = '';

		if ($lastActionDB != 'drop1' and $lastActionDB != 'drop') //no drop game
		{

			if (isset($fs_left)) //in fs
			{
				if (rand(0, 1000) < $colossalFreespinGameCreateRate) {
					if (rand(0, 1000) < $createFreespinInFS) //ok
					{

						$colossalMainGameSize = 3;
						$colossalX = round(rand(0, 2));
						$colossalY = 0;
						$colossalMainGameSymbol = 0;
						$addFS = 1;
					} else {
						if (rand(0, 1000) < $colossalWildFreespinCreateRate) $colossalMainGameSymbol = 1;
						else {
							$temp = explode(",", $reel[6][0]);
							$colossalMainGameSymbol = $temp[round(rand(0, (count($temp) - 1)))];
						}

						if (rand(0, 1000) < $reel[9][7])	$colossalMainGameSize = 3;
						else $colossalMainGameSize = 2;

						if ($colossalMainGameSize == 2) {
							$colossalX = round(rand(0, 3));
							$colossalY = round(rand(-1, 2));
						} elseif ($colossalMainGameSize == 3) {
							$colossalX = round(rand(0, 2));
							$colossalY = round(rand(-2, 2));
						}
					}

					$colossalSym = $colossalMainGameSymbol;
					$colossalSize = $colossalMainGameSize;
					$colossalFinalX = $colossalX;
					$colossalFinalY = $colossalY;

					$hasColossal = 1;
				}
			} // in maingame
			else {
				if (rand(0, 1000) < $colossalMainGameCreateRate) {
					if (rand(0, 1000) < $freespinMainGameCreateRate and !isset($fs_left)) //starts FS
					{
						$colossalMainGameSymbol = 12;
						$colossalMainGameSize = 3;
						$startFS = 1;
					} else {
						$temp = explode(",", $reel[6][0]);
						$colossalMainGameSymbol = $temp[round(rand(0, (count($temp) - 1)))];

						if (rand(0, 1000) < $reel[9][6])	$colossalMainGameSize = 3;
						else $colossalMainGameSize = 2;
					}

					if ($colossalMainGameSize == 2) {
						$colossalX = round(rand(0, 3));
						$colossalY = round(rand(-1, 2));
					} elseif ($colossalMainGameSize == 3) {
						$colossalX = round(rand(0, 2));
						$colossalY = round(rand(-2, 2));
					}

					if ($startFS == 1) {
						$colossalX = round(rand(1, 2));
						$colossalY = round(rand(-2, 2));
					};

					$colossalSym = $colossalMainGameSymbol;
					$colossalSize = $colossalMainGameSize;
					$colossalFinalX = $colossalX;
					$colossalFinalY = $colossalY;

					$hasColossal = 1;
				}
			}
		} else {
			if (rand(0, 1000) < $colossalDropGameCreateRate) {
				$nonEmptyReelsCount = 0;
				$extraCrush = 0;
				for ($i = 0; $i < 5; $i++) {
					if ($old_symbols[$i][0] != 0) {
						$nonEmptyReels[$nonEmptyReelsCount] = $i;
						$nonEmptyReelsCount++;
					}
				}
				if (($nonEmptyReelsCount) > 0) {

					if (isset($fs_left)) {
						if (rand(0, 1000) < $colossalDropWildCreateRate) $colossalDropGameSymbol = 1;
						else {
							$temp = explode(",", $reel[6][1]);
							$colossalDropGameSymbol = $temp[round(rand(0, (count($temp) - 1)))];
						}
					} else {
						$temp = explode(",", $reel[6][1]);
						$colossalDropGameSymbol = $temp[round(rand(0, (count($temp) - 1)))];
					}

					if (rand(0, 1000) < $reel[9][8])	$colossalDropGameSize = 3;
					else $colossalDropGameSize = 2;

					if ($colossalDropGameSize == 2)		$colossalY = -2;
					elseif ($colossalDropGameSize == 3)	$colossalY = -3;


					if ($colossalDropGameSize == 2) $colossalX = $nonEmptyReels[(round(rand(1, $nonEmptyReelsCount)) - 1)];
					elseif ($colossalDropGameSize == 3) $colossalX = round(rand(1, 3));

					if ($colossalX == 4) {
						if ($colossalDropGameSize == 3) $colossalX = 2;
						if ($colossalDropGameSize == 2) $colossalX = 3;
					} elseif ($colossalX == 3) {
						if ($colossalDropGameSize == 3) $colossalX = 1;
					}

					if ($colossalDropGameSize == 2)
						if ($old_symbols[$colossalX][0] == 0 and $old_symbols[$colossalX + 1][0] == 0) {
							$colossalY++;
							if ($old_symbols[$colossalX][1] == 0 and $old_symbols[$colossalX + 1][1] == 0) {
								$colossalY++;
								if ($old_symbols[$colossalX][2] == 0 and $old_symbols[$colossalX + 1][2] == 0) $colossalY++;
							}
						}

					$extraColossalY = 0;
					if ($colossalDropGameSize == 3)
						if ($old_symbols[$colossalX][0] == 0 and $old_symbols[$colossalX + 1][0] == 0 and $old_symbols[$colossalX + 2][0] == 0) {
							$extraColossalY++;
							if ($old_symbols[$colossalX][1] == 0 and $old_symbols[$colossalX + 1][1] == 0 and $old_symbols[$colossalX + 2][1] == 0) {
								$extraColossalY++;
								if ($old_symbols[$colossalX][2] == 0 and $old_symbols[$colossalX + 1][2] == 0 and $old_symbols[$colossalX + 2][2] == 0) $extraColossalY++;
								elseif ($old_symbols[$colossalX][2] == 0 or $old_symbols[$colossalX + 1][2] == 0 or $old_symbols[$colossalX + 2][2] == 0) $extraColossalY = -1;
							} elseif ($old_symbols[$colossalX][1] == 0 or $old_symbols[$colossalX + 1][1] == 0 or $old_symbols[$colossalX + 2][1] == 0) {
								$extraColossalY = -1;
							}
						}
					if ($extraColossalY != -1) {
						$colossalY = $colossalY + $extraColossalY;
						if ($colossalDropGameSize == 3) {
							if ($old_symbols[$colossalX][0] == 0 or $old_symbols[$colossalX + 1][0] == 0 or $old_symbols[$colossalX + 2][0] == 0)	$hasColossal = 1;
							$extraCrush = $reel[5][round(rand(0, (count($reel[5]) - 1)))];
						} elseif ($colossalDropGameSize == 2) {
							if ($old_symbols[$colossalX][0] == 0 or $old_symbols[$colossalX + 1][0] == 0)					$hasColossal = 1;
							$extraCrush = $reel[5][round(rand(0, (count($reel[5]) - 1)))];
						} //round(rand(0,2));}

						if ($lastActionDB != 'drop1') $extraCrush = 0;

						$colossalSym = $colossalDropGameSymbol;
						$colossalSize = $colossalDropGameSize;
						$colossalFinalX = $colossalX;
						$colossalFinalY = $colossalY;
					}
				}
			}
		}
	}


	include('./integr/busters.php');


	if ($lastAction != "initfreespin")	include($gamePath . 'lines.php');
	else {
		$symb_combs = "fake spin;" . $symb_combs;
		$symbolsOverlayed = $symbols;
		$symbolsShifted = $symbols;
	}

	if ($lastAction != "drop") {
		if ($total_win != 0 and $lastActionDB != 'drop' and $lastActionDB != 'drop1') $lastAction = 'drop1';
		elseif ($total_win != 0 and ($lastActionDB == 'drop1' or $lastActionDB == 'drop')) $lastAction = 'drop';
		elseif ($total_win == 0 and ($lastActionDB == 'drop1' or $lastActionDB == 'drop')) $lastAction = 'lastdrop';
	}




	if ($hasColossal == 1) {
		if ($colossalSym == 12)	$output1 .= "colossalType=SYM0&";
		else $output1 .= "colossalType=SYM" . $colossalSym . "&";
		$output1 .= "colossalSize=" . $colossalSize . "&";
		$output1 .= "colossalX=" . $colossalX . "&colossalY=" . $colossalY . "&";
		$output1 .= "colossalFinalX=$colossalFinalX&colossalFinalY=$colossalFinalY&";


		if ($move_colossal == 0 and $explode_colossal == 1) {
			$hasColossal = -1;
		}
	}


	if (isset($symsLastDB) and $symsLastDB != '') {

		$oldRls = explode('_', $symsLastDB);
		foreach ($oldRls as $oldRlNum => $oldRl) {
			if ($oldRl != '') {
				$oldSyms = explode(',', $oldRl);
				foreach ($oldSyms as $oldSymsNum => $oldSym) {
					if ($oldSym != '') $last_symbols[$oldRlNum][$oldSymsNum] = $oldSym;
				}
			}
		}

		$lastSy = '';
		for ($i = 0; $i < 5; $i++) {
			$str = '';
			for ($j = 0; $j < 3; $j++) {
				if ($last_symbols[$i][$j] == 0) $last_symbols[$i][$j] = 'null';
				elseif ($last_symbols[$i][$j] == 12) $last_symbols[$i][$j] = 'SYM0';
				else $last_symbols[$i][$j] = 'SYM' . $last_symbols[$i][$j];
				if ($str == '') $str = $last_symbols[$i][$j];
				else $str .= ',' . $last_symbols[$i][$j];
			}
			$lastSy .= "rs.i0.r.i" . $i . ".lastsyms=" . $str . "&";
		}
	}

	$symsLastDB = $symsLast2DB;

	if ($lastAction == 'lastdrop' and isset($fs_left)) {
		$lastAction = 'freespin';
		if ($colossalSym == 1 and $explode_colossal == 1)	$lastSy = '';
	}
	$output .= $lastSy;

	$output1 .= $crushedOut;

	//////////
	//draw rs
	//////////
	$wild = 0;

	$anim_num = 0;

	for ($i = 0; $i < 5; $i++) {
		if ($overlaySym != 0) {
			for ($j = 0; $j < 3; $j++) { {
					if ($symbols[$i][$j] == $overlaySym and $symbolsOverlayed[$i][$j] != $overlaySym) {
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
						$anim_num++;
					}
				}
			}
			$anim_num = 0;
		}

		if ($_GET['action'] != 'drop') {
			for ($temp = 0; $temp < 5; $temp++) {
				$prevSyms = '';
				for ($temp2 = 0; $temp2 < 6; $temp2++) {
					$k = round(rand(1, 10));
					if ($k == 2) $k = 16;
					$prevSyms .= ",SYM" . $k;
				}
			}
		}

		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . $prevSyms . "&";
		$output .= "rs.i0.r.i" . $i . ".hold=false&";
	}

	$output .= $lastRs;

	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;
	$temp = 0;
	$multiplier = $crushMul;

	if ($startFS == 1 or $addFS == 1) {

		$w = explode(",", '1,2,5');		//COINWIN IN FS-STONE

		foreach ($w as $e => $v) $w[$e] *= $linesDB * $betDB;

		$winFS[-1] = 'fs';
		$winFS[0] = 'fs';
		$winFS[1] = 'fs';
		$winFS[2] = $w[0];
		$winFS[3] = $w[1];
		$winFS[4] = $w[2];
		$winFS[5] = $w[1];
		$winFS[6] = $w[0];
		$winFS[7] = 'fs';
		$winFS[8] = 'fs';

		$i = round(rand(0, (count($reel[8]) - 1)));
		if ($buster7 != '') $indexFS = 8;
		elseif ($buster8 != '') $indexFS = 4;
		else
			$indexFS = $reel[8][$i];
		$winCount = 0;
		$scatterOut = '';

		$output .= "scatterCoinsToWin0=" . ($w[0] * $multiplier) . "&";
		$output .= "scatterCoinsToWin1=" . ($w[1] * $multiplier) . "&";
		$output .= "scatterCoinsToWin2=" . ($w[2] * $multiplier) . "&";

		$symb_combs = " bonus feat;" . $symb_combs;

		if (!isset($win)) {
			for ($i = 0; $i < $multiplier; $i++) {
				$scatterOut .= "scatterCoinsToWin0.step" . $i . "=" . ($w[0] * ($i + 1)) . "&";
				$scatterOut .= "scatterCoinsToWin1.step" . $i . "=" . ($w[1] * ($i + 1)) . "&";
				$scatterOut .= "scatterCoinsToWin2.step" . $i . "=" . ($w[2] * ($i + 1)) . "&";
			}

			$output .= $scatterOut;

			if ($colossalFinalY != 1 and $colossalFinalY != 2) {
				if ($winFS[$indexFS - 1] != 'fs') {
					$output .= "ws.i" . $winCount . ".reelset=basic&ws.i" . $winCount . ".sym=SYM0&ws.i" . $winCount . ".betline=null&ws.i" . $winCount . ".direction=left_to_right&ws.i" . $winCount . ".types.i0.wintype=coins&ws.i" . $winCount . ".types.i0.coins=" . ($winFS[$indexFS - 1] * $multiplier) . "&ws.i" . $winCount . ".types.i0.cents=" . ($winFS[$indexFS - 1] * $multiplier) . "&";
					$winCount++;
					$total_win += $winFS[$indexFS - 1];
					$symb_combs = "+" . $winFS[$indexFS - 1] . "," . $symb_combs;
				} else {
					$output .= "ws.i" . $winCount . ".reelset=basic&ws.i" . $winCount . ".sym=SYM0&ws.i" . $winCount . ".direction=left_to_right&ws.i" . $winCount . ".betline=null&ws.i" . $winCount . ".types.i0.freespins=5&ws.i" . $winCount . ".types.i0.wintype=freespins&ws.i" . $winCount . ".types.i0.multipliers=" . $multiplier . "&";
					$fs_left += 5;
					if ($buster10 != '') {
						$fs_left += 5;
						$symb_combs = "bust10 x 2fs;" . $symb_combs;
					}
					$winCount++;
					$lastAction = "startfreespin";
					$symb_combs = "+5fs," . $symb_combs;
				}
			}

			if ($colossalFinalY != -2 and $colossalFinalY != 2) {
				if ($winFS[$indexFS] != 'fs') {
					$output .= "ws.i" . $winCount . ".reelset=basic&ws.i" . $winCount . ".sym=SYM0&ws.i" . $winCount . ".betline=null&ws.i" . $winCount . ".direction=left_to_right&ws.i" . $winCount . ".types.i0.wintype=coins&ws.i" . $winCount . ".types.i0.coins=" . ($winFS[$indexFS] * $multiplier) . "&ws.i" . $winCount . ".types.i0.cents=" . ($winFS[$indexFS] * $multiplier) . "&";
					$winCount++;
					$total_win += $winFS[$indexFS];
					$symb_combs = "+" . $winFS[$indexFS] . "," . $symb_combs;
				} else {
					$output .= "ws.i" . $winCount . ".reelset=basic&ws.i" . $winCount . ".sym=SYM0&ws.i" . $winCount . ".direction=left_to_right&ws.i" . $winCount . ".betline=null&ws.i" . $winCount . ".types.i0.freespins=5&ws.i" . $winCount . ".types.i0.wintype=freespins&ws.i" . $winCount . ".types.i0.multipliers=" . $multiplier . "&";
					$fs_left += 5;
					if ($buster10 != '') {
						$fs_left += 5;
						$symb_combs = "bust10 x 2fs;" . $symb_combs;
					}
					$winCount++;
					$lastAction = "startfreespin";
					$symb_combs = "+5fs," . $symb_combs;
				}
			}

			if ($colossalFinalY != -2 and $colossalFinalY != -1) {
				if ($colossalFinalY == 2 or $colossalFinalY == 1) $winFS[$indexFS + 1] = $winFS[$indexFS - 1];

				if ($winFS[$indexFS + 1] != 'fs') {
					$output .= "ws.i" . $winCount . ".reelset=basic&ws.i" . $winCount . ".sym=SYM0&ws.i" . $winCount . ".betline=null&ws.i" . $winCount . ".direction=left_to_right&ws.i" . $winCount . ".types.i0.wintype=coins&ws.i" . $winCount . ".types.i0.coins=" . ($winFS[$indexFS + 1] * $multiplier) . "&ws.i" . $winCount . ".types.i0.cents=" . ($winFS[$indexFS + 1] * $multiplier) . "&";
					$winCount++;
					$total_win += $winFS[$indexFS + 1];
					$symb_combs = "+" . $winFS[$indexFS + 1] . "," . $symb_combs;
				} else {
					$output .= "ws.i" . $winCount . ".reelset=basic&ws.i" . $winCount . ".sym=SYM0&ws.i" . $winCount . ".direction=left_to_right&ws.i" . $winCount . ".betline=null&ws.i" . $winCount . ".types.i0.freespins=5&ws.i" . $winCount . ".types.i0.wintype=freespins&ws.i" . $winCount . ".types.i0.multipliers=" . $multiplier . "&";
					$fs_left += 5;
					if ($buster10 != '') {
						$fs_left += 5;
						$symb_combs = "bust10 x 2fs;" . $symb_combs;
					}
					$winCount++;
					$lastAction = "startfreespin";
					$symb_combs = "+5fs," . $symb_combs;
				}
			}

			//if($buster10!=''){$fs_left*=2;	$symb_combs="bust10 x 2fs;".$symb_combs;}

			if ($addFS == 1) $lastAction = "freespin";

			$output .= "scatterWin.index=" . $indexFS . "&"; //cursor place
			$output .= "scatterWin.count=" . $winCount . "&"; //hilight win
			$total_winCents = $total_win * $multiplier;
		}
	} {
		foreach ($win as $e => $v) {
			$tmp = explode("_", $v);

			if (isset($fs_left)) $output .= "ws.i" . $anim_num . ".reelset=freespin&";
			else
				$output .= "ws.i" . $anim_num . ".reelset=basic&";

			if (!isset($fs_left))
				if ($buster12 != '') {
					$tmp[0] *= 2;
					$symb_combs .= " bus=$buster12, " . $tmp[0] . ";";
				}

			$right_coins = $tmp[0] * $denomDB;

			$output .= "ws.i" . $anim_num . ".sym=SYM" . $symbOverlays[$e] . "&";

			$output .= "ws.i" . $anim_num . ".direction=left_to_right&";
			$output .= "ws.i" . $anim_num . ".betline=" . $e . "&";
			$output .= "ws.i" . $anim_num . ".types.i0.coins=" . $tmp[0] . "&";
			$output .= "ws.i" . $anim_num . ".types.i0.wintype=coins&";

			$output .= "ws.i" . $anim_num . ".types.i0.cents=" . $right_coins . "&";


			$total_win += $tmp[0];

			$ani = explode(";", $tmp[1]);
			$i = 0;


			foreach ($ani as $smb) {
				$output .= "ws.i" . $anim_num . ".pos.i" . $i . "=" . $smb . "&";
				$i++;
			}

			$anim_num++;
		}
	}


	if (isset($fs_totalwin)) $fs_totalwin += $total_win;


	if ($lastAction == "initfreespin") {

		$output = "next.rs=freespin&" . $output;
		$output = "current.rs.i0=freespin&" . $output;
		$output = "rs.i0.id=freespin&" . $output;

		$gameover = "false";
		$hasColossal = 0;

		$output .= "rs.i0.r.i5.hold=false&rs.i0.r.i6.hold=true&rs.i0.r.i7.hold=true&rs.i0.r.i8.hold=true&rs.i0.r.i9.hold=true&";
		$output .= "rs.i1.r.i5.hold=false&rs.i1.r.i6.hold=true&rs.i1.r.i8.hold=true&rs.i1.r.i7.hold=true&rs.i1.r.i9.hold=true&";

		$output .= "bet.betlevel=1&";
		$output .= "bet.denomination=1&";
		$output .= "bet.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

		$output .= "freespins.initial=$fs_initial&";
		$output .= "freespins.total=$fs_total&";
		$output .= "freespins.left=$fs_left&";

		$output .= "freespins.betlevel=1&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

		$output .= "rs.i0.r.i0.syms=SYM3%2CSYM7%2CSYM5%2CSYM4%2CSYM3%2CSYM1%2CSYM6%2CSYM5&";
		$output .= "rs.i0.r.i1.syms=SYM3%2CSYM10%2CSYM7%2CSYM10%2CSYM3%2CSYM4%2CSYM10%2CSYM7&";
		$output .= "rs.i0.r.i2.syms=SYM6%2CSYM6%2CSYM8%2CSYM3%2CSYM5%2CSYM4%2CSYM3%2CSYM1&";
		$output .= "rs.i0.r.i3.syms=SYM6%2CSYM6%2CSYM9%2CSYM5%2CSYM6%2CSYM6%2CSYM3%2CSYM6&";
		$output .= "rs.i0.r.i4.syms=SYM9%2CSYM4%2CSYM5%2CSYM1%2CSYM9%2CSYM6%2CSYM4%2CSYM10&";

		$output .= "rs.i0.r.i5.syms=SYM12%2CSYM12%2CSYM16&";
		$output .= "rs.i0.r.i6.syms=SYM12%2CSYM12%2CSYM16&";
		$output .= "rs.i0.r.i7.syms=SYM16%2CSYM16%2CSYM16&";
		$output .= "rs.i0.r.i8.syms=SYM16%2CSYM16%2CSYM16&";
		$output .= "rs.i0.r.i9.syms=SYM16%2CSYM16%2CSYM16&";

		$output .= "rs.i1.r.i0.syms=SYM10%2CSYM10%2CSYM7%2CSYM3%2CSYM9%2CSYM10%2CSYM5%2CSYM6&";
		$output .= "rs.i1.r.i1.syms=SYM8%2CSYM10%2CSYM9%2CSYM7%2CSYM10%2CSYM9%2CSYM10%2CSYM5&";
		$output .= "rs.i1.r.i2.syms=SYM0%2CSYM0%2CSYM0%2CSYM10%2CSYM6%2CSYM3%2CSYM8%2CSYM3&";
		$output .= "rs.i1.r.i3.syms=SYM0%2CSYM0%2CSYM0%2CSYM5%2CSYM1%2CSYM5%2CSYM7%2CSYM9&";
		$output .= "rs.i1.r.i4.syms=SYM0%2CSYM0%2CSYM0%2CSYM4%2CSYM1%2CSYM7%2CSYM3%2CSYM7&";
		$output .= "rs.i1.r.i5.syms=SYM16%2CSYM16%2CSYM16&";
		$output .= "rs.i1.r.i6.syms=SYM16%2CSYM16%2CSYM16&";
		$output .= "rs.i1.r.i7.syms=SYM12%2CSYM12%2CSYM12&";
		$output .= "rs.i1.r.i8.syms=SYM12%2CSYM12%2CSYM12&";
		$output .= "rs.i1.r.i9.syms=SYM12%2CSYM12%2CSYM12&";

		$output .= "rs.i0.r.i0.lastsyms=null&rs.i0.r.i1.lastsyms=null&rs.i0.r.i2.lastsyms=null&rs.i0.r.i3.lastsyms=null&rs.i0.r.i4.lastsyms=null&";
		$output .= "rs.i1.r.i0.lastsyms=null&rs.i1.r.i1.lastsyms=null&rs.i1.r.i2.lastsyms=null&rs.i1.r.i3.lastsyms=null&rs.i1.r.i4.lastsyms=null&";

		$output .= "restoreScatter.colossalType=SYM0&";
		$output .= "restoreScatter.colossalSize=3&";
		$output .= "restoreScatter.scatterWin.count=3&";
		$output .= "restoreScatter.scatterWin.index=2&";
		$output .= "restoreScatter.colossalFinalX=2&";
		$output .= "restoreScatter.colossalFinalY=0&";
		$output .= "restoreScatter.scatterCoinsToWin0=20&";
		$output .= "restoreScatter.scatterCoinsToWin1=40&";
		$output .= "restoreScatter.scatterCoinsToWin2=100&";

		$output .= "clientaction=initfreespin&";
		$output .= "nextaction=freespin&";

		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "rs.i1.id=basic&";


		$botAction = "freespin";
	} elseif ($lastAction == "freespin") {

		$fs_total = $fs_left + $fs_played;
		$hasColossal = 0;

		if ($fs_left > 0) {
			$gameover = "false";

			$output = "next.rs=freespin&" . $output;
			$output = "current.rs.i0=freespin&" . $output;
			$output = "rs.i0.id=freespin&" . $output;

			$output .= "nextaction=freespin&";

			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";

			$botAction = "freespin";
		} else {

			$output = "next.rs=basic&" . $output;
			$output = "current.rs.i0=basic&" . $output;
			$output = "rs.i0.id=freespin&" . $output;

			$output .= "nextaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.current=basic&";

			$lastAction = "endfreespin";
			$table_locked = 0;

			$botAction = "spin";
		}

		$output .= "gamestate.history=basic%2Cfreespin&";
		$output .= "freespins.denomination=1.000&";

		$output .= "freespins.initial=" . $fs_initial . "&";
		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.played=" . $fs_played . "&";
		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";


		$output .= "freespins.betlevel=1&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.multiplier=1&";

		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&freespins.wavecount=1&freespins.multiplier=1&";

		$output .= "last.rs=freespin&";

		$output .= "previous.rs.i0=freespin&";
		if ($lastActionDB == 'drop1' or $lastActionDB == 'drop') $output .= "clientaction=drop&";
		else $output .= "clientaction=freespin&";
	} elseif ($lastAction == "startfreespin") {
		$fs_totalwin = 0;
		$fs_initial = $fs_left;
		$fs_multiplier = 1;
		$fs_played = 0;
		$fs_total = $fs_played + $fs_left;

		$gameover = "false";

		$output = "next.rs=freespin&" . $output;
		$output = "current.rs.i0=freespin&" . $output;
		$output = "rs.i0.id=basic&" . $output;


		if ($lastActionDB == 'drop' or $lastActionDB == 'drop1') $output .= "clientaction=drop&";
		else $output .= "clientaction=spin&";
		$output .= "gameover=false&";
		$output .= "nextaction=freespin&";

		$output .= "freespins.initial=$fs_initial&";
		$output .= "freespins.total=$fs_total&";
		$output .= "freespins.left=$fs_left&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.multiplier=$multiplier&";

		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "gamestate.history=basic&";

		$startFS = 0;

		$wilds = '';
		$table_locked = 1;
		$botAction = "freespin";
	} elseif ($lastAction == "lastdrop") {
		$output = "next.rs=basic&" . $output;
		$output = "current.rs.i0=basic&" . $output;
		$output = "rs.i0.id=basic&" . $output;



		$output .= "clientaction=drop&";
		$output .= "gamestate.current=basic&";

		$output .= "gamestate.stack=basic&";
		$output .= "nextaction=spin&";


		$crushMul = 1;
		$startFS = 0;
		$crushedStr = '';
		$lastSymsStr = '';
		$hasColossal = 0;
		$table_locked = 0;
		$gameover = "true";

		$botAction = "spin";
	} elseif ($lastAction == "drop") {

		if ($fs_left > 0) {
			$output .= "rs.i0.id=freespin&";
			$output .= "current.rs.i0=freespin&";
			$output .= "next.rs=freespin&";
			$output .= "last.rs=freespin&";

			$output .= "gamestate.history=basic&";
			$output .= "gamestate.current=freespin&";
			$output .= "clientaction=drop&";
			$output .= "gamestate.stack=basic%2Cfreespin&";

			$output .= "freespins.initial=$fs_initial&";
			$output .= "freespins.total=$fs_total&";
			$output .= "freespins.left=$fs_left&";
			$output .= "freespins.totalwin.coins=$fs_totalwin&";
			$output .= "freespins.totalwin.cents=$fs_totalwin&";
			$output .= "freespins.betlevel=1&";
			$output .= "freespins.denomination=1.000&";
			$output .= "freespins.win.coins=0&";
			$output .= "freespins.win.cents=0&";
			$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
			$output .= "freespins.wavecount=1&";
			$output .= "freespins.multiplier=$fs_multiplier&";
		} else {
			$output .= "rs.i0.id=basic&";
			$output .= "current.rs.i0=basic&";
			$output .= "gamestate.current=basic&";
			$output .= "clientaction=drop&";
			$output .= "gamestate.stack=basic&";
		}
		$output .= "nextaction=drop&";

		$table_locked = 0;
		$gameover = "false";

		$botAction = "drop";
	} elseif ($lastAction == "drop1") {
		if ($fs_left > 0) {
			$output .= "rs.i0.id=freespin&";
			$output .= "current.rs.i0=freespin&";

			$output .= "gamestate.current=freespin&";
			$output .= "clientaction=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";


			$output .= "freespins.initial=$fs_initial&";
			$output .= "freespins.total=$fs_total&";
			$output .= "freespins.left=$fs_left&";
			$output .= "freespins.totalwin.coins=$fs_totalwin&";
			$output .= "freespins.totalwin.cents=$fs_totalwin&";
			$output .= "freespins.betlevel=1&";
			$output .= "freespins.denomination=1.000&";
			$output .= "freespins.win.coins=0&";
			$output .= "freespins.win.cents=0&";
			$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
			$output .= "freespins.wavecount=1&";
			$output .= "freespins.multiplier=$fs_multiplier&";
		} else {
			$output .= "rs.i0.id=basic&";
			$output .= "current.rs.i0=basic&";

			$output .= "gamestate.current=basic&";
			$output .= "clientaction=spin&";
			$output .= "gamestate.stack=basic&";
		}

		$output .= "nextaction=drop&";

		$table_locked = 0;
		$gameover = "false";

		$botAction = "drop";
	} else {
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=basic&";

		$output .= "gamestate.current=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";
		$output .= "gamestate.stack=basic&";


		$crushMul = 1;
		$crushedStr = '';
		$lastSymsStr = '';
		$hasColossal = 0;
		$startFS = 0;
		$table_locked = 0;

		$botAction = "spin";
	}


	$output .= $output1;

	if ($lastSy == '') $output .= "rs.i0.r.i0.lastsyms=null&rs.i0.r.i1.lastsyms=null&rs.i0.r.i2.lastsyms=null&rs.i0.r.i3.lastsyms=null&rs.i0.r.i4.lastsyms=null&";

	$spincost = 0;
	if ($lastAction != 'initfreespin' and $lastAction != 'freespin' and $lastAction != 'endfreespin' and $lastAction != 'drop1' and $lastAction != 'drop') {
		$spin_to_history = 1;
		$spincost = $betDB * $linesDB * $denomDB * 0.01;
	}

	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	$credit -= $spincost;

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	$totalWinsDB = $total_win;


	if ($hasColossal > 0) {
		$colossalY = $colossalFinalY;
		if ($lastAction == "drop1" or $lastAction == "drop") {
			$answ .= "colossalSym=$colossalSym;colossalSize=$colossalSize;colossalX=$colossalX;colossalY=$colossalY;colossalFinalX=$colossalFinalX;colossalFinalY=$colossalFinalY;";
		}
	} elseif (isset($fs_left) and $hasColossal < 0) $answ .= "colossalSym=$colossalSym;colossalSize=$colossalSize;colossalX=$colossalX;colossalY=$colossalY;colossalFinalX=$colossalFinalX;colossalFinalY=$colossalFinalY;";

	if ($lastAction == 'drop1' or $lastAction == 'drop') {
		$answ .= "symsShiftedDB=" . $symsShiftedDB . ";";
		$answ .= "symsOrigDB=" . $symsOrigDB . ";";
		$answ .= "symsLastDB=" . $symsLastDB . ";";
		if (isset($fs_left))  $answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
	}

	$answ .= "startFS=$startFS;";

	$answ .= "hasColossal=" . $hasColossal . ";";
	if ($wild_depthDB != '') $answ .= "wild_depthDB=" . $wild_depthDB . ";";
}

if ($lastAction == "freespin" or $lastAction == "startfreespin" or $lastAction == "initfreespin") {
	if ($lastAction == "initfreespin") $answ = '';
	if ($fs_left > 0) {
		$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
	}
	$symb_combs = "win=" . $fs_totalwin . ";fspins=" . $fs_played . ";remain=" . $fs_left . ";" . $symb_combs;
}

if ($lastAction == "endfreespin") {
	$symb_combs = "FS ENDS: win=" . $fs_totalwin . ";fspins=" . $fs_played . ";" . $symb_combs;
	$wilds = '';
	$botAction = "spin";
}

////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if ($lastAction == 'spin' or $lastAction == 'initfreespin' or ($lastAction == 'drop1' and !isset($fs_left))) {
		$freeRoundsLeft--;
		if ($lastAction == 'spin' or $lastAction == 'initfreespin') {
			$output .= "freeRoundsLeft=$freeRoundsLeft&";
			$output .= "gameroundid=$freeRoundsLeft&";
		}
	}
	$freeRoundsWin += $real_win * 100;

	if ($freeRoundsLeft == 0) {
		if ($lastAction != 'endfreespin' or $lastAction != 'spin') {
			$answ .= "freeRoundsWin=" . $freeRoundsWin . ";";
			$answ .= "freeRoundsLeft=" . $freeRoundsLeft . ";";
		}
	} else {
		$answ .= "freeRoundsWin=" . $freeRoundsWin . ";";
		$answ .= "freeRoundsLeft=" . $freeRoundsLeft . ";";
	}
}
/////




$query = "answer='" . $answ . "'";

$query .= ", lastAction='" . $lastAction . "',wilds='" . $wilds . "', lastRs='" . $lastRs . "'";

$query .= ", locked='" . $table_locked . "'";

$query = "UPDATE ns.states set " . $query . " where sessionId='" . $_GET['sessid'] . "';";

$result = mysql_query($query);

<?
function makeNewWorldJson($cardNum)
{
    $json = '{
     "id":"' . $cardNum . '",
     "gameSpins":"0",
     "gameBSpins":"0",
     "gameWinSpins":"0",
     "gameBigwin":"0",
     "gameFullwin":"0",
     "gameInitFs":"0",
     "gameFs":"0",

     "stats": {
	 "0": { "perc":"0", "status":"0" },
	 "1": { "perc":"0", "status":"0" },
	 "2": { "perc":"0", "status":"0" }
     }
    }';

    return $json;
}

function discoverTaskProgress($conditionString, $variables)
{
    foreach ($variables as $e => $v)
        if ($v != '' and $e != '') {
            $$e = $v;
            //	    echo "var $e => $v <br>";
        }

    $temp = explode(";", $conditionString);
    $achieve_complete = 1;
    foreach ($temp as $e => $v)
        if ($v != '') {

            $temp2 = explode(":", $v);

            //echo "<br>POPA".$temp2[0]."!!!<br>";

            /*
    if($temp2[0]=="gameFs")
    {
//	$progerssPercent=$variables['gameSpins']/$temp2[2]*100;
    echo "<br>@@@@".$variables['gameSpins']." / ".$temp2[2]."<br>";
    }
*/
            $progerssPercent = round($variables[$temp2[0]] / $temp2[2] * 100, 2);

            if ($temp2[0] == "gameBigwin" or $temp2[0] == "curLevel" or $temp2[0] == "gameWinSpins" or $temp2[0] == "gameFrounds" or $temp2[0] == "Event") {
                if ($progerssPercent < 100) $progerssPercent = 0;
            }

            //    echo "<br>".$v." : ".$temp2[0]." - ".$temp2[1]." - ".$temp2[2]." - >";
            //    echo "(".$wheelSpin.")";
            /*
    if($temp2[1]=="more")
    {
//	echo $$temp2[0]."<br>";
//	echo "make more ".$$temp2[0]." <> ".$temp2[2]." + ";
	if($$temp2[0]>=$temp2[2]) {}//echo "ok";
	else $achieve_complete=0;
    }
    elseif($temp2[1]=="less")
    {
//	echo "make less ";
	if($$temp2[0]<$temp2[2]) {}//echo "ok";
	else $achieve_complete=0;
    }
    else $achieve_complete=0;
*/
        }
    return ($progerssPercent);
}




function checkConditions3($conditionString, $variables)
{
    foreach ($variables as $e => $v)
        if ($v != '' and $e != '') {
            $$e = $v;
            //	    echo "var $e => $v <br>";
        }

    $temp = explode(";", $conditionString);
    $achieve_complete = 1;
    foreach ($temp as $e => $v)
        if ($v != '') {

            $temp2 = explode(":", $v);

            //    echo "<br>".$v." : ".$temp2[0]." - ".$temp2[1]." - ".$temp2[2]." - >";
            //    echo "(".$wheelSpin.")";

            if ($temp2[1] == "equal") {
                if ($$temp2[0] == $temp2[2]) {
                } //echo "ok";
                else $achieve_complete = 0;
            } elseif ($temp2[1] == "more") {
                //	echo $$temp2[0]."<br>";
                //	echo "make more ".$$temp2[0]." <> ".$temp2[2]." + ";
                if ($$temp2[0] >= $temp2[2]) {
                } //echo "ok";
                else $achieve_complete = 0;
            } elseif ($temp2[1] == "less") {
                //	echo "make less ";
                if ($$temp2[0] < $temp2[2]) {
                } //echo "ok";
                else $achieve_complete = 0;
            } else $achieve_complete = 0;
        }
    return ($achieve_complete);
}




function checkConditions2($conditionString, $variables)
{
    foreach ($variables as $e => $v)
        if ($v != '' and $e != '') {
            $$e = $v;
        }

    $temp = explode(",", $conditionString);
    foreach ($temp as $e => $v)
        if ($v != '') {
            $achieve_complete = 1;
            $temp2 = explode(":", $v);

            //    echo $temp2[0]." - ".$temp2[1]." - ".$temp2[2]." - ";
            //    echo "(".$wheelSpin.")";

            if ($temp2[1] == "more") {
                //	echo $$temp2[0]."<br>";
                //	echo "make more ".$$temp2[0]." <> ".$temp2[2]." + ";
                if ($$temp2[0] >= $temp2[2]) {
                } //echo "ok";
                else $achieve_complete = 0;
            } elseif ($temp2[1] == "less") {
                //	echo "make less ";
                if ($$temp2[0] < $temp2[2]) {
                } //echo "ok";
                else $achieve_complete = 0;
            } else $achieve_complete = 0;
        }
    return ($achieve_complete);
}




function checkConditions($conditionString, $credsWin, $curLevel, $questSpins, $questWin, $bustersUse)
{
    $temp = explode(",", $conditionString);
    foreach ($temp as $e => $v)
        if ($v != '') {
            $achieve_complete = 1;
            $temp2 = explode(":", $v);

            //    echo $temp2[0]." - ".$temp2[1]." - ".$temp2[2]." - ";
            //    echo "(".$questSpins.")";

            if ($temp2[1] == "more") {
                //	echo $$temp2[0]."<br>";
                //	echo "make more ".$$temp2[0]." <> ".$temp2[2]." + ";
                if ($$temp2[0] >= $temp2[2]) {
                } //echo "ok";
                else $achieve_complete = 0;
            } elseif ($temp2[1] == "less") {
                //	echo "make less ";
                if ($$temp2[0] < $temp2[2]) {
                } //echo "ok";
                else $achieve_complete = 0;
            } else $achieve_complete = 0;
        }
    return ($achieve_complete);
}


function makeEffects($effectString) ///check
{
    //echo $effectString."<br>";
    $Info = explode(";", $effectString);
    foreach ($Info as $e => $v)
        if ($v != '') {
            $a = explode("=", $v);
            $$a[0] = $a[1];
            //        }
            if ($add_chips) $reward['add_chips'] = $add_chips;
            if ($add_wheel) $reward['add_wheel'] = $add_wheel;
            if ($open_game) $reward['open_game'] = $open_game;
            if ($add_denom) $reward['add_denom'] = $add_denom;
            if ($add_buster) $reward['add_buster'] = $add_buster;
            if ($game_status) {
                $b = explode(":", $game_status);
                $reward['game_status'][$b[0]] = $b[1];
                //	    $reward['game_status']=123;
            }
            if ($if_game_status) {
                //	    $b=explode(":",$game_status);
                //	    $reward['game_status'][$b[0]]=$b[1];
                $reward['if_game_status'] = $if_game_status;
            }
            if ($next_world_deposit) {
                $reward['next_world_deposit'] = $next_world_deposit;
            }
        }
    //	if($get_achiev) $reward['get_achiev']=$get_achiev;
    return $reward;
}

<?
header('Access-Control-Allow-Origin: *');
////////////////////////////////////////////////////////////////////////////////
//selectors
////////////////////////////////////////////////////////////////////////////////
$gameover = "true";
$wilds = '';
$buster7 = '';
$buster8 = '';
$buster10 = '';
$buster11 = '';

////////////////////////////////////
//correct action check
////////////////////////////////////

if ($_GET['action'] == "respin" and $lastActionDB != "spin" and $lastActionDB != "respin" and $lastActionDB != "endfreespin" and $lastActionDB != "paytable") exit;

if ($_GET['action'] == "freespin" and ($lastActionDB == "spin" or $lastActionDB == "pHaze" or $lastActionDB == "respin" or $lastActionDB == "endbonus")) exit;
if ($_GET['action'] == "bonusaction" and ($lastActionDB == "spin" or $lastActionDB == "pHaze" or $lastActionDB == "respin" or $lastActionDB == "endbonus")) exit;

if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "bonusaction" and $lastActionDB == "paytable" and $answer == '') exit;

if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;
if ($_GET['action'] == "bonusaction" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "startfreespin" and $lastActionDB != "paytable") exit;

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
}


if ($lastActionDB == "paytable" and isset($restoreAction)) {
    $lastActionDB = $restoreAction;
    $wildsDB = $wildStcks;
}

if ($_GET['action'] == "bonusaction" and ($lastActionDB == "initfreespin" or $lastActionDB == "bonusaction")) {
    //////////////////////////////
    $lastAction = "bonusaction";
    /////////////////////////////

    $table_locked = 1;

    if ($wildsDB != '') {
        $COINwinSymbs = 0;
        $FS1winSymbs = 0;
        $FS2winSymbs = 0;
        $FS3winSymbs = 0;
    }


    $query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " and id=5;";
    $result = mysql_query($query);
    $reels = mysql_fetch_assoc($result);
    $reel = explode("_", $reels['symbols']);
    $length = (count($reel) - 1);
    $i = round(rand(0, $length));

    $fgType = $reel[$i];

    include('./integr/busters.php');
    if ($buster7 != '') {
        $fgType = "FS1";
    }
    //    $symb_combs.="$FS1winSymbs";

    /*
    $select[0]="COINWIN";
    $select[1]="FS1";
    $select[2]="FS2";
    $select[3]="FS3";

    $fgType=$select[$i];
*/
    //    $fgType="COINWIN";///////////////////////////////////////////////////////////////////////
    //    $fgType="FS1";///////////////////////////////////////////////////////////////////////

    $isEnd = "-1";
    if ($wildsDB == '') $wilds = $_GET['selection'] . "%2C" . $fgType . "%2C" . $isEnd;
    else $wilds = $wildsDB . "%2C" . $_GET['selection'] . "%2C" . $fgType . "%2C" . $isEnd;

    //echo $wilds;

    $selectionInfo = explode("%2C", $wilds);
    foreach ($selectionInfo as $e => $v)
        if ($v != '') {
            if ($v == "COINWIN") $COINwinSymbs++;
            if ($v == "FS1") $FS1winSymbs++;
            if ($v == "FS2") $FS2winSymbs++;
            if ($v == "FS3") $FS3winSymbs++;
        }

    include('./integr/busters.php');

    //echo $FS3winSymbs;

    //    echo "!". $reels['symbols']."?";
    //    $coinWin=$reel[$pos]*$betDB; //critical!!!!!!!!!!!!!


    //    $i=floor(rand(0,3));

    $num = round(rand(1, 2));

    $overallSymbs = 14 - ($COINwinSymbs + $FS1winSymbs + $FS2winSymbs + $FS3winSymbs);

    if ($COINwinSymbs > 2 or $FS1winSymbs > 2 or $FS2winSymbs > 2 or $FS3winSymbs > 2) {


        $fs_init = floor(rand(6, 12));
        if ($buster10 != '') {
            $fs_init *= 2;
            $symb_combs .= " bus10=$buster10, $fs_init;";
        }

        if ($buster7 != '') {
            //	    if($COINwinSymbs>2){$COINwinSymbs=0;$FS1winSymbs=3;}
            $symb_combs .= " bus7=$buster7, $fs_init;";
        }

        if ($COINwinSymbs > 2) {

            $query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " and id=6;";
            $result = mysql_query($query);
            $reels = mysql_fetch_assoc($result);
            $reel = explode("_", $reels['symbols']);
            $length = (count($reel) - 1);
            $i = round(rand(0, $length));


            $total_win = $reel[$i] * $betDB * $linesDB;
            $real_win = $total_win * $denomDB * 0.01;
            $totalWinsDB = $total_win;
            $credit += $total_win * $denomDB;
            $fs_totalwin = $total_win;
            $bonus_totalwin = $total_win;
            $total_winCents = $total_win * $denomDB;

            $lastAction = "endfreespin";

            $output .= "selectionsMade=" . $wilds . "&";
            $output .= "coinwinmultiplier=" . $reel[$i] . "&";

            $output .= "winningfeature=COIN&";

            $wilds = "";
            $symb_combs .= "mp=" . $reel[$i] . ";fb=" . ($betDB * $linesDB) . ";";

            $output .= "gamestate.history=basic%2Cbonus&";
            $output .= "gamestate.current=basic&";
            $output .= "gamestate.stack=basic&";

            $output .= "nextaction=spin&";

            $output .= "previous.rs.i0=basic&";
            $output .= "last.rs=basic&";

            $output .= "gameover=true&";
            $output .= "availableSelections=" . $overallSymbs . "&";
            $output .= "clientaction=bonusaction&";

            $output .= "bonusgame.coinvalue=0.02&";
            $output .= "bonuswin.coins=600&";
            $output .= "bonuswin.cents=1200&";
            $output .= "totalbonuswin.coins=600&";
            $output .= "totalbonuswin.cents=1200&";
        } elseif ($FS1winSymbs > 2) {
            $fs_init = 6;

            $output .= "selectionsMade=" . $wilds . "&";
            $output .= "freespins.multiplier=1&";

            $output .= "winningfeature=FS1&";
            $output .= "freespinfeature=FS1&";

            $output .= "nextaction=freespin&";
            $output .= "nextactiontype=pickbonus&";

            $output .= "next.rs=FS1&";
            $output .= "last.rs=basic2&";
            $output .= "current.rs.i0=FS1&";
            $output .= "previous.rs.i0=basic2&";

            $output .= "freespins.total=" . $fs_init . "&";
            $output .= "freespins.left=" . $fs_init . "&";

            $output .= "bonusgame.coinvalue=0.01&";

            $output .= "freespins.initial=" . $fs_init . "&";
            $output .= "freespins.wavecount=1&";
            $output .= "freespins.denomination=1.000&";
            $output .= "freespins.betlevel=1&";
            $output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

            $output .= "gamestate.stack=basic%2Cfreespin&";
            $output .= "gamestate.history=basic%2Cbonus&";
            $output .= "gamestate.current=freespin&";

            $output .= "gameover=false&";
            $output .= "availableSelections=" . $overallSymbs . "&";
            $output .= "clientaction=bonusaction&";

            $output .= "freespins.win.coins=0&";
            $output .= "freespins.win.cents=0&";
            $output .= "freespins.totalwin.coins=0&";
            $output .= "freespins.totalwin.cents=0&";

            $output .= "totalbonuswin.coins=0&";
            $output .= "totalbonuswin.cents=0&";

            $answ .= "fs_left=" . $fs_init . ";fs_played=0;fs_totalwin=0;fgType=" . $fgType . ";";
            $lastAction = "startfreespin";
        } elseif ($FS2winSymbs > 2) {
            $output .= "selectionsMade=" . $wilds . "&";
            $output .= "freespins.multiplier=1&";

            $output .= "winningfeature=FS2&";
            $output .= "freespinfeature=FS2&"; //

            $output .= "nextaction=freespin&";
            $output .= "nextactiontype=pickbonus&";

            $output .= "next.rs=FS2_" . $num . "&";
            $output .= "last.rs=basic2&";
            $output .= "current.rs.i0=FS2_" . $num . "&";
            $output .= "previous.rs.i0=basic2&";


            $output .= "freespins.total=" . $fs_init . "&"; //
            $output .= "freespins.left=" . $fs_init . "&";

            $output .= "bonusgame.coinvalue=" . ($betDB * 0.01) . "&";

            $output .= "freespins.initial=" . $fs_init . "&"; //

            $output .= "freespins.wavecount=1&";
            $output .= "freespins.denomination=1.000&";
            $output .= "freespins.betlevel=1&";
            $output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

            $output .= "gamestate.stack=basic%2Cfreespin&";
            $output .= "gamestate.history=basic%2Cbonus&";
            $output .= "gamestate.current=freespin&";

            $output .= "gameover=false&";
            $output .= "availableSelections=" . $overallSymbs . "&";
            $output .= "clientaction=bonusaction&";

            $output .= "freespins.win.coins=0&";
            $output .= "freespins.win.cents=0&";
            $output .= "freespins.totalwin.coins=0&";
            $output .= "freespins.totalwin.cents=0&";

            $output .= "totalbonuswin.coins=0&";
            $output .= "totalbonuswin.cents=0&";

            //	$answ="fgType=".$fgType.";fs_left=6;fs_played=0;fs_totalwin=0;";
            //	$answ="fgType=".$fgType.";fs_left=".($fs_init-1).";fs_played=0;fs_totalwin=0;";
            $answ .= "fs_left=" . ($fs_init - 1) . ";fs_played=0;fs_totalwin=0;fgType=" . $fgType . ";";
            $lastAction = "startfreespin";
        } elseif ($FS3winSymbs > 2) {

            $output .= "selectionsMade=" . $wilds . "&";
            $output .= "freespins.multiplier=1&";

            $output .= "winningfeature=FS3&"; //
            $output .= "freespinfeature=FS3&"; //

            $output .= "nextaction=freespin&";
            $output .= "nextactiontype=pickbonus&";

            $output .= "next.rs=FS3_" . $num . "&";
            $output .= "last.rs=basic&";
            $output .= "current.rs.i0=FS3_" . $num . "&";
            $output .= "previous.rs.i0=basic2&";

            $output .= "freespins.total=" . $fs_init . "&"; //
            $output .= "freespins.left=" . $fs_init . "&";

            $output .= "bonusgame.coinvalue=" . ($betDB * 0.01) . "&";

            $output .= "freespins.initial=" . $fs_init . "&"; //
            $output .= "freespins.wavecount=1&";
            $output .= "freespins.denomination=1.000&";
            $output .= "freespins.betlevel=1&";
            $output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

            $output .= "gamestate.stack=basic%2Cfreespin&";
            $output .= "gamestate.history=basic%2Cbonus&";
            $output .= "gamestate.current=freespin&";

            $output .= "gameover=false&";
            $output .= "availableSelections=" . $overallSymbs . "&";
            $output .= "clientaction=bonusaction&";

            $output .= "freespins.win.coins=0&";
            $output .= "freespins.win.cents=0&";
            $output .= "freespins.totalwin.coins=0&";
            $output .= "freespins.totalwin.cents=0&";

            $output .= "totalbonuswin.coins=0&";
            $output .= "totalbonuswin.cents=0&";

            //	$answ="fgType=".$fgType.";fs_left=".($fs_init-1).";fs_played=0;fs_totalwin=0;";
            $answ .= "fs_left=" . ($fs_init - 1) . ";fs_played=0;fs_totalwin=0;fgType=" . $fgType . ";";
            $lastAction = "startfreespin";
        }
    } else {
        $output .= "selectionsMade=" . $wilds . "&";
        $output .= "availableSelections=14&";

        $output .= "next.rs=basic&";
        $output .= "gamestate.history=basic%2Cbonus&";
        $output .= "gamestate.bonusid=pickwin&";
        $output .= "gamestate.stack=basic%2Cbonus&";
        $output .= "gamestate.current=bonus&";

        $output .= "current.rs.i0=basic&";

        $output .= "gameover=false&";
        $output .= "nextactiontype=pickbonus&";
        $output .= "clientaction=bonusaction&";
        $output .= "nextaction=bonusaction&";

        $output .= "bonusgame.coinvalue=0.02&";
        $output .= "totalbonuswin.cents=0&";
    }
}





if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {
    $num = floor(rand(1, 3));
    $num2 = floor(rand(1, 2));

    if ($num == 1) $wrt = '';
    else $wrt = $num;

    $redGuitar = 3;
    $gameover = "true";

    $lastAction = "spin";



    if ($lastActionDB == "freespin") $lastAction = "freespin";
    elseif ($fgType == "FS1" or $fgType == "FS2" or $fgType == "FS3") $lastAction = "freespin";
    //    if($lastActionDB=="respin")$lastAction="freespin";

    //    if($_GET['action']=="respin" and $lastActionDB=="initfreespin")$lastAction="respin";




    ////////////////////
    //symbol generation
    ////////////////////
    $i = 0;

    if ($lastAction == "freespin" and $lastActionDB != "initfreespin") {
        $query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and (type=0 or type=1 or type=2 or type=3 or type=4 or type=5 or type=6 or type=7  or type=8) order by type asc;";

        $fs_left--;
        $fs_played++;
        //echo "<br><br>left ".$fs_left."<br>";
    } else    $query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

    $result = mysql_query($query);

    //echo "<br><br>left ".$query."<br>";


    while ($reels = mysql_fetch_assoc($result)) {
        $reel[$i] = explode("_", $reels['symbols']);
        $i++;
    }

    //if($lastAction=="freespin" and $wildsDB=='poor') $reel[0]=$reel[5];

    //foreach($reel[5] as $e) echo $e."!";

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

    //if($lastAction!="freespin" and $lastAction!="initfreespin" and $lastActionDB!="freespin"){$symbols[0][0]=0;$symbols[4][0]=0;$symbols[2][0]=0;}
    //if($lastAction!="freespin" and $lastAction!="initfreespin"){$symbols[0][1]=1;$symbols[1][1]=1;$symbols[2][1]=1;}
    //$symbols[0][0]=4;$symbols[0][1]=1;$symbols[0][2]=4;
    //$symbols[1][0]=3;$symbols[1][1]=1;$symbols[1][2]=5;
    //$symbols[2][0]=7;$symbols[2][1]=1;$symbols[2][2]=8;
    //$symbols[3][0]=12;$symbols[3][1]=1;$symbols[3][2]=11;
    //$symbols[4][0]=3;$symbols[4][1]=14;$symbols[4][2]=5;

    /*
if($lastAction!="freespin")
{

$symbols[0][0]=3;
$symbols[2][0]=3;
$symbols[3][0]=3;
$symbols[4][0]=3;

//$symbols[2][2]=0;
//$symbols[3][2]=0;
//$symbols[4][2]=0;

}
*/

    /////////////////
    //force respin
    /////////////////

    if ($lastActionDB == "spin") {

        if (($symbols[0][0] == 3 or $symbols[0][1] == 3 or $symbols[0][2] == 3) and ($symbols[4][0] == 3 or $symbols[4][1] == 3 or $symbols[4][2] == 3)) {
            $num3 = floor(rand(0, 2));
            $num4 = floor(rand(0, 4));
            $symbols[$num4][$num3] = 3;
            $num3 = floor(rand(0, 2));
            $symbols[$num4][$num3] = 3;
        }
    }
    //////////////////

    if ($lastActionDB == "respin") {
        $redGuitar = 0;
        $temp = explode('_', $wildsDB);
        foreach ($temp as $e) if ($e != '') {
            $temp2 = explode(',', $e);
            $symbols[$temp2[0]][$temp2[1]] = 3;
            $redGuitar++;
        }
    }



    $bonusSymbCount = 0;
    $redGuitarSymbCount = 0;
    foreach ($symbols as $tReel => $t)
        foreach ($t as $tRow => $e) {
            if ($symbols[$tReel][$tRow] == 0) {
                $bonusSymbCount++;
                $bonusReels[$tReel] = 1;
            }
            if ($symbols[$tReel][$tRow] == 3) {
                $redGuitarSymbCount++;
                $wilds .= $tReel . "," . $tRow . "_";
            }
        }

    if ($redGuitarSymbCount > $redGuitar and $lastActionDB != "initfreespin" and $lastActionDB != "freespin") {
        $lastAction = "respin";
    }    //////////////////////////////////////

    include('./integr/busters.php');

    if ($lastAction != "respin")
        if ($bonusSymbCount > 2 and $lastActionDB != "initfreespin") {
            $lastAction = "initfreespin";
            $wilds = "";
        }    //////////////////////////////////////

    $overlaySym = "0";
    $symbolsOverlayed = $symbols;

    if ($lastActionDB != "initfreespin") {
        include($gamePath . 'lines.php');
    } else $symb_combs .= " fake spin;";

    if ($lastAction == "respin") {
        $overlaySym = 3;
        $output .= "overlaySym=SYM" . $overlaySym . "&";
    }
    if ($lastAction == "pHaze") {
        $overlaySym = 1;
        $output .= "overlaySym=SYM" . $overlaySym . "&";
    }
    if ($lastAction == "freespin" and $fgType == "FS1") {
        $overlaySym = 30;
        $output .= "overlaySym=SYM" . $overlaySym . "&";
    }
    if ($lastAction == "freespin" and $fgType == "FS2") {
        $overlaySym = 1;
    } //$output.= "overlaySym=SYM".$overlaySym."&";}
    if ($lastAction == "freespin" and $fgType == "FS3") {
        $overlaySym = 1;
    } //$output.= "overlaySym=SYM".$overlaySym."&";}

    //////////
    //draw rs
    //////////
    $wild = 0;
    $nearwin = 0;
    $nearwinstr = '';

    if ($pHaze != -1) {
        $symbolsOverlayed[0][$pHaze] = 20;
    }



    $anim_num = 0;

    for ($i = 0; $i < 5; $i++) {
        if ($overlaySym != 0) {
            for ($j = 0; $j < 3; $j++) {
                if (($lastAction != "pHaze" and $symbols[$i][$j] == $overlaySym) or ($lastAction == "pHaze" and
                    ($symbolsOverlayed[$i][$j] == 10 or $symbolsOverlayed[$i][$j] == 11 or $symbolsOverlayed[$i][$j] == 12 or $symbolsOverlayed[$i][$j] == 13 or $symbolsOverlayed[$i][$j] == 14))) {
                    $output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
                    $output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
                    $anim_num++;
                }
            }
            $anim_num = 0;
        }
        $lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";

        $output .= "rs.i0.r.i" . $i . ".hold=false&";


        if ($bonusSymbCount > 1 and $nearwin > 1 and $lastAction != "respin") {
            if ($nearwinstr == '') $nearwinstr = $i;
            else $nearwinstr .= "," . $i;
        }
        if ($bonusReels[$i] == 1) $nearwin++;
    }
    $output .= $lastRs;

    if ($lastAction != "freespin" and $nearwinstr != '')    $output .= "rs.i0.nearwin=" . $nearwinstr . "&";

    /////////////////////////////
    //draw ws				///////////////////////odd types.i0.coins
    ///////////////////////////
    $anim_num = 0;
    $total_win = 0;

    if ($lastAction != "respin") {
        foreach ($win as $e => $v) {
            $tmp = explode("_", $v);


            if ($lastActionDB == "respin" and $lastAction = "spin") $output .= "ws.i" . $anim_num . ".reelset=RED_GUITAR3&";
            elseif ($lastAction != "freespin") $output .= "ws.i" . $anim_num . ".reelset=basic" . $num2 . "&";
            elseif ($fgType == "FS2") $output .= "ws.i" . $anim_num . ".reelset=FS2_" . $num2 . "&";

            else $output .= "ws.i" . $anim_num . ".reelset=freespin" . $wrt . "&";

            if ($lastAction != "freespin" and $lastAction != "endfreespin")
                if ($buster12 != '') {
                    $tmp[0] *= 2;
                    $symb_combs .= " bus=$buster12, " . $tmp[0] . ";";
                }

            $right_coins = $tmp[0] * $denomDB;

            $output .= "ws.i" . $anim_num . ".sym=SYM" . $overlaySym . "&";

            $output .= "ws.i" . $anim_num . ".direction=left_to_right&";
            $output .= "ws.i" . $anim_num . ".betline=" . $e . "&";
            $output .= "ws.i" . $anim_num . ".types.i0.coins=" . $tmp[0] . "&";
            $output .= "ws.i" . $anim_num . ".types.i0.wintype=coins&";

            $total_win += $tmp[0];

            $ani = explode(";", $tmp[1]);
            $i = 0;

            foreach ($ani as $smb) {
                $output .= "ws.i" . $anim_num . ".pos.i" . $i . "=" . $smb . "&";

                $output .= "ws.i" . $anim_num . ".types.i0.coins=" . $tmp[0] . "&";
                $output .= "ws.i" . $anim_num . ".types.i0.cents=" . $right_coins . "&";
                $i++;
            }

            $anim_num++;
        }
    }

    //$output.= "<br><br>".$lastAction." BK ".$bonusSymbCount." left=".$fs_left."<br>";


    if ($lastAction == "freespin") {
        $fs_total = $fs_left + $fs_played;
        $fs_totalwin += $total_win;

        if ($fs_left > 0) {
            //     $output.= "gameover=false&";
            $output .= "nextaction=freespin&";
            //     $output.= "current.rs.i0=freespin1&";
            //     $output.= "current.rs.i0=freespin2&";
            $output .= "gamestate.current=freespin&";
            $output .= "next.rs=freespin1&";
            $answFS = "fgType=" . $fgType . ";";
            $gameover = "false";
            $table_locked = 1;
        } else {
            //    $fgType="";
            //     $output.= "gameover=true&";
            $output .= "nextaction=spin&";
            $output .= "current.rs.i0=basic_0&";
            $output .= "next.rs=basic_0&";
            $output .= "gamestate.current=basic&";
            $lastAction = "endfreespin";
            $table_locked = 0;
        }

        $output .= "freespins.total=" . $fs_total . "&";
        $output .= "freespins.left=" . $fs_left . "&";


        $output .= "freespins.multiplier=1&";
        $output .= "freespins.initial=0&";

        $output .= "gamestate.history=basic%2Crespin%2Cfreespin&";
        $output .= "freespins.denomination=1.000&";
        //    $output.="last.rs=freespin1&";
        //    $output.="last.rs=freespin2&";
        $output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

        $output .= "clientaction=freespin&";
        $output .= "freespins.wavecount=1&";

        $output .= "freespins.betlevel=1&";
        //    $output.="current.rs.i0=freespin1&";
        //    $output.="current.rs.i0=freespin2&";

        //    $output.="rs.i0.id=freespin1&";

        //    $output.="previous.rs.i0=freespin1&";
        //    $output.="previous.rs.i0=freespin2&";
        $output .= "gamestate.stack=basic%2Cfreespin&";

        $output .= "freespins.win.coins=0&";
        $output .= "freespins.win.cents=0&";
        $output .= "freespins.totalwin.coins=0&";
        $output .= "freespins.totalwin.cents=0&";

        if ($fgType == "FS1") {
            $output .= "last.rs=FS1&"; //
            $output .= "freespinfeature=FS1&";
            $output .= "rs.i0.id=FS1&"; //
            $output .= "current.rs.i0=FS1&"; //
            $output .= "nextactiontype=pickbonus&";
            $output .= "previous.rs.i0=FS1&";
            //    $table_locked=0;
        }
        if ($fgType == "FS2") {
            $output .= "last.rs=FS2_" . $num2 . "&";
            $output .= "freespinfeature=FS2&";
            $output .= "rs.i0.id=FS2_" . $num2 . "&";
            $output .= "current.rs.i0=FS2_" . $num2 . "&";
            $output .= "nextactiontype=pickbonus&";
            $output .= "previous.rs.i0=FS2_" . $num2 . "&";
            //    $table_locked=0;
        }

        if ($fgType == "FS3") {
            $output .= "last.rs=FS3_" . $num2 . "&";
            $output .= "freespinfeature=FS3&";
            $output .= "rs.i0.id=FS3_2&";
            $output .= "current.rs.i0=FS3_" . $num2 . "";
            $output .= "nextactiontype=pickbonus&";
            $output .= "previous.rs.i0=FS3_" . $num2 . "&";
            $output .= "guitarchord=" . $guitarchord . "&";
            //    $table_locked=0;
        }
    } elseif ($lastAction == "respin") {

        if ($lastActionDB == "respin") {

            $gameover = "false";
            /*
	$output.="next.rs=RED_GUITAR3&";
	$output.="last.rs=RED_GUITAR3&";
        $output.="current.rs.i0=RED_GUITAR3&";
	$output.="rs.i0.id=RED_GUITAR3&";
        $output.="previous.rs.i0=RED_GUITAR3&";
	$output.="gamestate.current=basic&";
        $output.="clientaction=spin&";
	$output.="nextaction=respin&";
*/
            $num2 += 2;
            $output .= "rs.i0.id=RED_GUITAR" . $num2 . "&";
            //	$output.="next.rs=basic".$wrt."&";
            $output .= "last.rs=RED_GUITAR" . $num2 . "&";
            $output .= "current.rs.i0=RED_GUITAR" . $num2 . "&";
            $output .= "gamestate.current=RED_GUITAR&";
            $output .= "clientaction=respin&";
            $output .= "nextaction=respin&";
            $output .= "previous.rs.i0=RED_GUITAR" . $num2 . "&";
            $table_locked = 1;
        } else {
            $gameover = "false";
            $output .= "next.rs=RED_GUITAR_FIRST_RESPIN3&";
            $output .= "current.rs.i0=RED_GUITAR_FIRST_RESPIN3&";
            $output .= "gamestate.current=basic&";
            $output .= "clientaction=spin&";
            $output .= "nextaction=respin&";
            $output .= "previous.rs.i0=basic" . $wrt . "&";
            $output .= "rs.i0.id=basic&";
            $table_locked = 1;
        }
    } elseif ($lastAction == "initfreespin") {
        $gameover = "false";
        $output .= "nextaction=bonusaction&";
        $output .= "gamestate.stack=basic%2Cbonus&";
        $output .= "current.rs.i0=basic&";
        $output .= "gamestate.history=basic&";
        //    $output.="gamestate.current=bonus&";
        $output .= "gamestate.current=basic&";
        $output .= "clientaction=spin&";
        $output .= "rs.i0.id=basic&";
        $output .= "selectionsMade=&nextactiontype=pickbonus&availableSelections=15&gamestate.bonusid=pickwin&";
        $table_locked = 1;
    } else {
        if ($lastActionDB == "respin") {
            $num2 += 2;
            $output .= "rs.i0.id=RED_GUITAR" . $num2 . "&";
            $output .= "next.rs=basic" . $wrt . "&";
            $output .= "last.rs=RED_GUITAR" . $num2 . "&";
            $output .= "current.rs.i0=RED_GUITAR" . $num2 . "&";
            $output .= "gamestate.current=basic&";
            $output .= "clientaction=respin&";
            $output .= "nextaction=spin&";
            $output .= "previous.rs.i0=RED_GUITAR" . $num2 . "&";
            $wilds = '';
        } else {
            $output .= "rs.i0.id=basic" . $wrt . "&";
            $output .= "current.rs.i0=basic" . $wrt . "&";
            $output .= "last.rs=basic" . $wrt . "&";
            $output .= "gamestate.current=basic&";
            $output .= "clientaction=spin&";
            $output .= "gamestate.stack=basic&";
            $output .= "gamestate.history=basic&";
            $output .= "nextaction=spin&";
        }
        $table_locked = 0;
    }

    $spincost = 0;
    if ($lastAction != 'freespin' and $lastAction != 'respin' and $lastAction != 'endfreespin') {
        $spin_to_history = 1;
        $spincost = $betDB * $linesDB * $denomDB * 0.01;
    }

    $credit /= 100;

    $real_win = $total_win * $denomDB * 0.01;

    if (isset($freeRoundsLeft)) $spincost = 0;
    if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
        $credit -= $spincost;
    }
    if ($lastAction == 'respin' and $wilds != '') {
        $real_win = 0;
        $total_win = 0;
        $total_winCents = 0;
    }

    $credit += $real_win;

    $creditDB = $credit * 100;

    $credit *= 100;

    if ($lastAction == 'freespin') {
        $wilds = $wildsDB;
        $dop2 .= "(" . $wildsDB . ")";
    }

    if ($lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
    else $totalWinsDB = $total_win;
}




if ($lastAction == "freespin") {
    $answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
}

if ($lastAction == "endfreespin") {
    $symb_combs = $fgType . ";win=" . $fs_totalwin . ";" . $symb_combs;
}



////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
    if ($lastAction == 'spin' or $lastAction == 'initfreespin' or $lastAction == 'pHaze') {
        $freeRoundsLeft--;
        $output .= "freeRoundsLeft=$freeRoundsLeft&";
        $output .= "gameroundid=$freeRoundsLeft&";
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

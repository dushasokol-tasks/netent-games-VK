<?

//  require_once "../common.php";
//  seterr();
//  dbinit();
$lastGameId = 18;

include('../../srv/dbConnect.php');
$link = mysql_connect($db_host, $db_user, $db_pass);

//    @mysql_query("SET NAMES 'UTF8'");
//    @mysql_query("SET CHARACTER SET 'utf8'");

$myQueryText = "SELECT rfidPass FROM birjadb.rep_departments where id=214";
$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
$f = @mysql_fetch_row($q);
echo $lastReportDate = $f[0];
echo "<br><br>";

$myQueryText = "SELECT * FROM birjadb.rep_nsStats ORDER BY ts DESC LIMIT 1";
//    $myQueryText="SELECT * FROM birjadb.rep_nsStats1 where ts='1536647707' ORDER BY ts DESC LIMIT 1";
//    $myQueryText="SELECT * FROM birjadb.rep_nsStats1 where ts='1536561306' ORDER BY ts DESC LIMIT 1";


$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

if (@mysql_num_rows($q) != 0) {
	$f = @mysql_fetch_row($q);

	$report_date = date("d.m.Y H:m:i", $f[0]);
	$report_dateDB = date("d.m.Y", $f[0]);

	if ($report_dateDB == $lastReportDate) exit("twice per period");

	echo $report_date . "<br>";

	$gameData = explode("_", $f[1]);
	foreach ($gameData as $e => $v) {
		$termData = explode(";", $v);
		foreach ($termData as $e1 => $v1)
			if ($v1 != '') {
				$parsedData = explode(",", $v1);
				//		    echo $parsedData[0]." ".$parsedData[1]." ".$parsedData[2]." ".$parsedData[3]."<br>";
				$deltas[$parsedData[0]] += $parsedData[2] - $parsedData[3];
			}
	}
}

//	foreach ($deltas as $e => $v) echo $e." = ".$v."<br>";

//    echo "<br><br>";

$level = 1;

$myQueryText = "SELECT number, phone, referral, ref_credit, ref_delta FROM birjadb.rep_contracts where referral<>0";

$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
while ($f = @mysql_fetch_array($q)) {
	//    echo " // ".$f['number']." = > ".$f['referral']."<br>";
	$referral[$f['number']] = $f['referral'];
	$ref_credit[$f['number']] = $f['ref_credit'];
	$ref_delta[$f['number']] = $f['ref_delta'];
	$ref_phone = $f['phone'];

	//    $ref_phone=substr($ref_phone, 0, -4);
	$ref_phone = substr($ref_phone, 7, 4);
	$ref_phone = "*******" . $ref_phone . " / " . $f['number'];
	//    $ref_phone;
	$ref_phones[$f['number']] = $ref_phone;
}

echo "<br><br>";
$level_count = 7;

foreach ($referral as $e => $v) {
	$level1 = 0;
	$level2 = 0;
	$level3 = 0;
	$level4 = 0;
	$level5 = 0;
	$level6 = 0;
	//	    $i1=0;$i2=0;$i3=0;
	//	    $i1_html='';$i2_html;$i3_html='';

	foreach ($referral as $e1 => $v1) {
		if ($e == $v1) {
			//			$i1++;$i1_html.=" ".$e1." ".$deltas[$e1]."<br>";
			//		    echo "<br>l1: ".$e1." -> ".$v1." {".$deltas[$e1]."}; <br>";
			$stat[$e][1][$e1] = $deltas[$e1];
			$level1 += $deltas[$e1] * .2;
			foreach ($referral as $e2 => $v2) {
				if ($e1 == $v2) {
					//				$i2++;$i2_html.=" ".$e2." ".$deltas[$e2]."<br>";
					//				echo "<br>l2: ".$e2." -> ".$v2." {".$deltas[$e2]."}; ";
					$stat[$e][2][$e2] = $deltas[$e2];
					$level2 += $deltas[$e2] * .1;
					foreach ($referral as $e3 => $v3) {
						if ($e2 == $v3) {
							//					$i3++;$i3_html.="".$e3." ".$deltas[$e3]."<br>";
							//					echo "<br>l3: ".$e3." -> ".$v3." {".$deltas[$e3]."}; ";
							$stat[$e][3][$e3] = $deltas[$e3];
							$level3 += $deltas[$e3] * .05;
							foreach ($referral as $e4 => $v4) {
								if ($e3 == $v4) {
									//						$i4++;$i4_html.="".$e4." ".$deltas[$e4]."<br>";
									//						echo "<br>l4: ".$e4." -> ".$v4." {".$deltas[$e4]."}; ";
									$stat[$e][4][$e4] = $deltas[$e4];
									$level4 += $deltas[$e4] * .025;

									foreach ($referral as $e5 => $v5) {
										if ($e4 == $v5) {
											$stat[$e][5][$e5] = $deltas[$e5];
											$level5 += $deltas[$e5] * .01;
											foreach ($referral as $e6 => $v6) {
												if ($e5 == $v6) {
													$stat[$e][6][$e6] = $deltas[$e6];
													$level6 += $deltas[$e6] * .005;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	echo "<br>" . $e . " l1=" . $level1 . ", l2=" . $level2 . ", l3=" . $level3 . ", l4=" . $level4 . ", l5=" . $level5 . ", l6=" . $level6 . "<br><br>";

	$add_credit = $level1 + $level2 + $level3 + $level4 + $level5 + $level6;

	//	$ref_deltaShow[$e]="old del=".$ref_delta[$e].", ";
	$ref_deltaShow[$e] = "";

	if ($add_credit > 0) {
		$ref_delta[$e] = $ref_delta[$e] + $add_credit;
		if ($ref_delta[$e] > 0) {
			//	    $ref_deltaShow[$e].="Add ".$ref_delta[$e].", now 0";
			$ref_deltaShow[$e] .= "Добавлено " . $ref_delta[$e];
			$ref_credit[$e] += $ref_delta[$e];
			$ref_delta[$e] = 0;
		} else {
			$ref_deltaShow[$e] .= "Не добавлено, проверьте завтра";
		}
	} else {
		$ref_delta[$e] = $ref_delta[$e] + $add_credit;
		$ref_deltaShow[$e] .= "Нечего добавлять, проверьте завтра";
	}
	//	$ref_delta[$e]+=$level1+$level2+$level3;
	$sum[$e][0] = $ref_deltaShow[$e];
	$sum[$e][1] = $level1;
	$sum[$e][2] = $level2;
	$sum[$e][3] = $level3;
	$sum[$e][4] = $level4;
	$sum[$e][5] = $level5;
	$sum[$e][6] = $level6;
}



echo "<br>deltas<br>";
foreach ($ref_delta as $e => $v) {
	echo $e . " => " . $v . "<br>";
	$query[$e] = "ref_delta='" . $v . "',";
}

echo "<br>credit<br>";
foreach ($ref_credit as $e => $v) {
	echo $e . " => " . $v . "<br>";
	$query[$e] .= "ref_credit='" . $v . "'";
}



echo "<br><br><br>";

//$text_rus['owner']=@iconv("UTF-8","windows-1251","Владелец");
$text_rus['owner'] = "Владелец";
$text_rus['Lvl'] = "Ур.";
$text_rus['Aviable'] = "Доступно";
$text_rus['rCredits'] = "реферальных кредитов";
$text_rus['report'] = "Отчет на ";

foreach ($stat as $e => $v) {
	$text = '';

	$text .= '<table class="report" border=1><tr>';
	$text .= "<td colspan=" . $level_count . ">" . $text_rus['report'] . " $report_date</td><tr>";
	$text .= "<td>" . $text_rus['owner'] . "</td><td>" . $text_rus['Lvl'] . "1 20%</td><td>" . $text_rus['Lvl'] . "2 10%</td><td>" . $text_rus['Lvl'] . "3 5%</td><td>" . $text_rus['Lvl'] . "4 2.5%</td><td>" . $text_rus['Lvl'] . "5 1%</td><td>" . $text_rus['Lvl'] . "6 0.5%</td><tr>";
	$text .= "<td>" . $ref_phones[$e] . "</td>";
	foreach ($v as $e1 => $v1) {
		$text .= "<td>";

		foreach ($v1 as $e2 => $v2) $text .= $ref_phones[$e2] . " => " . $v2 . "<br>";

		$text .= "</td>";
	}
	$text .= "<tr>";
	foreach ($sum[$e] as $e1 => $v1)
		$text .= "<td>" . $v1 . "</td>";
	if ($ref_credit[$e] >= 50)
		$text .= "<tr><td colspan=" . ($level_count - 1) . ">" . $text_rus['Aviable'] . " " . $ref_credit[$e] . " " . $text_rus['rCredits'] . "</td><td class=\"buttons\" style=\"display: table-cell;\"><a href=\"refBallsTrans.php\"><img src=\"/img/gift.png\"></a></td>";
	else
		$text .= "<tr><td colspan=" . $level_count . ">" . $text_rus['Aviable'] . " " . $ref_credit[$e] . " " . $text_rus['rCredits'] . "</td>";
	$text .= "</table>";

	$text = @iconv("UTF-8", "windows-1251", $text);

	$query[$e] .= ", ref_report='" . $text . "'";
}


//    @mysql_query("SET NAMES 'UTF8'");
//    @mysql_query("SET CHARACTER SET 'utf8'");

@mysql_query('SET NAMES cp1251');



foreach ($referral as $e => $v) {
	//if($e==5255)
	{
		echo    $myQueryText = "UPDATE birjadb.rep_contracts set " . $query[$e] . " where number=$e;";
		echo "<br>";
		$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
	}
}


$myQueryText = "UPDATE birjadb.rep_departments set rfidPass='" . $report_dateDB . "' where id=214;";
$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());




mysql_close($link);

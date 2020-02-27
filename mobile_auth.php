<?
session_start();

//if( $_POST['user_id']!='532248891' and $_POST['user_id']!='10637772' and $_POST['user_id']!='205800044'){ echo '{"msg":"4"}';exit;}

$validUser = 0;
$success = 0;

$apiVer = '5.21';
$appToken = 'apiTokenHere';
$appSecret = 'appKeyHere';

$vkApiRequest = 'https://api.vk.com/method/secure.checkToken?';
$vkApiRequest .= "v=$apiVer&";
$vkApiRequest .= "token=" . $_POST['access_token'] . "&";
$vkApiRequest .= "ip=" . $_SERVER['REMOTE_ADDR'] . "&";
$vkApiRequest .= "client_secret=$appSecret&";
$vkApiRequest .= "access_token=$appToken&";

///echo $vkApiRequest;

$json = file_get_contents($vkApiRequest);

$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST
);


//mobilepure lock

if ((($_POST['id'] != '' and $_GET['id'] != '' and $_GET['id'] == $_POST['id']) or (isset($_SESSION['my_valid_user']))) and $platform == 'mobile') {
    if (isset($_SESSION['my_valid_user'])) $_GET['id'] = $_POST['id'] = $_SESSION['my_valid_user'];
    $_POST['user_id'] = $_POST['id'];
    $validUser = $_POST['id'];
    $success = 1;
} else {
    foreach ($jsonIterator as $key => $val) {

        if ($key == 'success') $success = $val;
        if ($key == 'user_id') $validUser = $val;
        if ($key == 'error') {
            echo '{"msg":"3"}';
            exit;
        }
    }
}

//echo $_POST['user_id']!='';

$today_ts = time();
$today_formatted_date = date('d.m.Y');

if ($_POST['user_id'] != '' and $_POST['user_id'] == $validUser and $success == 1) {
    $_SESSION['my_valid_user'] = 'VK' . $_POST['user_id'];
    if ($platform == "mobile") $_SESSION['my_valid_user'] = $_POST['user_id'];

    //    if($_SESSION['my_valid_user']=='VK10637772' or $_SESSION['my_valid_user']=='VK6745730'){ echo '{"msg":"5", "sessid":"'.session_id().'"}';exit;}


    $user_id = $_POST['user_id'];
    include('srv/dbConnect.php');
    $link = mysql_connect($db_host, $db_user, $db_pass);

    $DB1 = "birjadb";
    $DB2 = "ns";

    if ($platform == '') {
        $social_platform = 'VK';
        $user_id = "VK" . $user_id;
        $query_table = 'terminals';
        $DB1 = "ns";
        $query_table = 'social_terminals';
    }
    if ($platform == 'mobile') {
        $query_table = 'terminals';
        $DB1 = "ns";
        $query_table = 'social_terminals';
    }

    $myQueryText = "SELECT * FROM $DB2.common where sessionId='" . $user_id . "'";
    $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
    $_Common = mysql_fetch_assoc($q);
    if (mysql_num_rows($q) == 0) {
        $name = $user_id;
        $clubId = 215;
        $wheelFullTime = 14400;
        $safeFullTime = 72000;

        $myQueryText = "INSERT INTO `$DB1`.`$query_table` 	(`club_id`, 	`hwid`, 	`id`, 	   `name`,      `attrib`,  `recycle`, `hwidhash`, `total_in`, `total_out`, `short_in`, `short_out`, `credit`, `status`, `gameset`,    `client_version`, `access_time`, `settings`, `lastClient`)
    VALUES 						('$clubId', 	'$user_id',	'$user_id','$name',	'0', 	   '0',       '',	  '0',	      '0',         '0',        '0',         '100.0',    '',	'ns',         '',		'-1',  	       '', 	   '');";
        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
        /*
    if($user_id=='VK10637772')
    echo "<br>".$myQueryText."<br>";
*/

        $myQueryText = "INSERT INTO `$DB2`.`common` 	(`sessionId`, 	`bet`, 	`lines`, `denom`, `referral`, `payRate`, `anBetVar`, `playerCurrencyIso`, `playerCurrency`, `jpCurrencyIso`, `jpCurrency`, `lang`,	`betted_full`,	`winned_full`, `payed_spins`,	`gameId`,	`termName`,	`clientId`, 	`ownerId`, `widgetOn`,	`platform`, pass, regDate)
    VALUES 					('$user_id', 	'1', 	'1', 	 '1', 	  '0', 	      '1',       '',	     'RUR',		  'U%2B20BD',	    'RUR',	     'U%2B20BD',   'ru',	'0',		'0',		'0',		'1',		'$name',   	'',		'',	   '1',	 	'$social_platform',	'',	'$today_formatted_date');";
        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
        //    echo "<br>".$myQueryText."<br>";

        $myQueryText = "INSERT INTO `$DB2`.`states` (`wilds`, `sessionId`, `answer`, `common`, `lastAction`, `lastRs`, `locked`, `resumeTxt`)
    VALUES 				      ('',      '$user_id',   '',       '',       'created',    '',       '',       '');";
        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
        //    echo $myQueryText."<br>";

        $taskState = "";
        //{"cards":[{"id":"0","gameSpins":0,"gameBSpins":0,"gameWinSpins":0,"gameBigwin":0,"gameFullwin":0,"gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":100,"status":2},"1":{"perc":100,"status":2},"2":{"perc":35.7,"status":1}}},{"id":"6","gameSpins":"0","gameBSpins":46,"gameWinSpins":46,"gameBigwin":"0","gameFullwin":"0","gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":"0","status":"0"},"1":{"perc":"0","status":"0"},"2":{"perc":"0","status":"0"}}},{"id":"7","gameSpins":"0","gameBSpins":46,"gameWinSpins":46,"gameBigwin":"0","gameFullwin":"0","gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":"0","status":"0"},"1":{"perc":"0","status":"0"},"2":{"perc":"0","status":"0"}}}]}

        //    $myQueryText="INSERT INTO `$DB2`.`social_feat` (`id`,	`wheelTime`, `wheelFullTime`, `safeTime`, `safeFullTime`, `dialyQuestReward`, `quest1Id`, `quest1Progress`, `quest2Id`, `quest2Progress`, `quest3Id`, `quest3Progress`, `tillFS`)
        //    VALUES 					   ('$user_id', '$today_ts', '$wheelFullTime','$today_ts','$safeFullTime','add_chips=500;',   '1',	  '0',		    '2',	'0',		  '3',	      '0',		'$today_ts');";
        $myQueryText = "INSERT INTO `$DB2`.`social_feat` (`id`,	`wheelTime`, `wheelFullTime`, `safeTime`, `safeFullTime`, `dialyQuestReward`, `quest1Id`, `quest1Progress`, `quest2Id`, `quest2Progress`, `quest3Id`, `quest3Progress`, `tillFS`,	tasksState)
    VALUES 					   ('$user_id', '$today_ts', '$wheelFullTime','$today_ts','$safeFullTime','add_chips=500;',   '1',	  '0',		    '2',	'0',		  '3',	      '0',		'$today_ts',	'$taskState');";

        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
        //    echo $myQueryText."<br>";

        $myQueryText = "INSERT INTO `$DB2`.`social_main` (`id`,	`level`, `exp`, `achievs`, `tutorStep`, `avaiableGames`,  `avGamesStatus`,	`denomLevel`, `inventory`, 				 `activeBuster`, `extra_wheel`, `extra_busterspin`, `free_rounds`, `lastLogin`, 		`daysLogin`,	`spins`, `credsWin`,	`credsLost`, 	`cashBack`, `bustersUse`, `wheelUse`)
    VALUES 					   ('$user_id', '1',	 '1',	'0',	   '1',		'1',		  '0:2,1:2',		'0',	       '0:0,6:0,7:0,8:0,9:0,10:0,11:0,12:0', 	 '',		 '1',		'1',		    '0',	   '$today_formatted_date',	'1',		'0',	 '0',		'0',		'0',	    '0',	  '0');";
        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
        //    echo $myQueryText."<br>";

        $file = '/var/www/birjauser/data/www/ermak.xyz/srv/oper/createDir.sh ' . $user_id;
        exec($file, $output, $return);

        echo '{"msg":"1"}';
    } else {
        $myQueryText = "SELECT * FROM $DB2.social_main where id='" . $user_id . "'";
        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
        $_Social = mysql_fetch_assoc($q);
        if ($_Social['tutorStep'] <= 5 and $_Social['tutorStep'] != 0)
            echo '{"msg":"1"}';
        else {
            echo '{"msg":"2"';
            $myQueryText = "SELECT * FROM $DB2.common where sessionid='" . $user_id . "'";
            $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
            $_Common = mysql_fetch_assoc($q);
            if ($_Social['lastLogin'] != $today_formatted_date) $_Common['activity'] = 1234567890;
            if ($_Common['activity']) echo ',"activity":"' . round(time() - $_Common['activity'], 2) . '"';
            if ($_Common['lang']) echo ',"lang":"' . $_Common['lang'] . '"';
            //	 echo '}';
            if ($_Common['gameId']) {
                if ($_Common['gameId'] == 999) $_Common['gameId'] = 0;
                $query = "SELECT * FROM " . $DB2 . ".social_games where id='" . $_Common['gameId'] . "';";
                $result = mysql_query($query);
                $_Game = mysql_fetch_assoc($result);
                echo ',"folder":"' . $_Game['folder'] . '"';
                echo ',"gameId":"' . $_Game['gameName'] . '"';
            }
            echo '}';
        }
    }

    mysql_close($link);
} else {
    session_destroy();
    exit;
}

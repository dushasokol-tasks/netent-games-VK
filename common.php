<?
# birjadomain.com
$db_user = "addMe";
$db_pass = "addMe";
$db_host = "localhost";
$db_name = "addMe";
$dir = '/var/www/birjauser/data/www/addMe.com/';


# User unique id's
$EADMIN   = 0;
$ESUBADMIN = 3;
$EOWNER   = 2;
$EMANAGER = 11;
$ETECH    = 14;
$ECASHIER = 16;

$ENOT_RECYCLED = 0;
$ERECYCLED = 1;

$ENOT_BANNED = 0;
$EBANNED = 1;

# Stock charts
$STOCK_POINTS = 20;

$COMPID_UNKNOWN = 0;
$COMPID_RASP = 1;
$COMPID_URKA = 2;
$COMPID_ROSN = 3;
$COMPID_MSTT = 4;
$COMPID_MGNT = 5;
$COMPID_MAGN = 6;
$COMPID_SBER = 7;
$COMPID_CHMF = 8;
$COMPID_NVTK = 9;
$COMPID_LKOH = 10;
$COMPID_RTSI = 11;


# Log viewer
$CLUBLOG_LINES_PER_PAGE     = 100;
$CLUBLOG_LINES_TOTAL_VIEW   = 50000;
$CLUBLOG_LINES_REMOVE_LIMIT = 55000; # if larger, then will DELETED TO  $CLUBLOG_LINES_TOTAL count

$TERMLOG_LINES_PER_PAGE     = 100;
$TERMLOG_LINES_TOTAL_VIEW   = 5000;
$TERMLOG_LINES_REMOVE_LIMIT = 6000;


# Log dirs
$logdir    = 'logs/';
$userlogs  = 'logs/user/';

$debugLogSize = 32 * 1024 * 1024; # 1M
$UserLogSize = 1000000;

$SV_ADD_CRED  = "svaddcred1";
$SV_ADD_CRED2 = "svaddcred2";

$SV_PAY_CRED  = "svpaycred1";
$SV_PAY_CRED2 = "svpaycred2";

$SV_INITMACHINE = "svinitmachine";
$SV_REBOOT      = "svreboot";

$SV_FORCEEXIT   = "svforceexit";


# Sql wrap
require_once "admin/sqlhlp.php";

# Terminal enums
require_once "admin/terminalhlp.php";



function debugLog($savestr)
{
  global $debugLogSize;
  global $dir;
  global $logdir;
  $file = $dir . $logdir . "debug.txt";
  logger($file, $savestr, $debugLogSize, 1);
}


function seterr()
{
  error_reporting(E_ALL);
  set_error_handler('err_handler');
  date_default_timezone_set("GMT"); // GMT +4 for Kazan
}


function err_handler($errno, $errmsg, $filename, $linenum)
{
  global $dir;
  global $logdir;
  $full_path = $dir . $logdir . "errors.log";

  $date = date('Y-m-d H:i:s (T)');
  $f = fopen($full_path, 'a');
  if (!empty($f)) {
    $err  = "<error>\r\n";
    $err .= "  <date>$date</date>\r\n";
    $err .= "  <errno>$errno</errno>\r\n";
    $err .= "  <errmsg>$errmsg</errmsg>\r\n";
    $err .= "  <filename>$filename</filename>\r\n";
    $err .= "  <linenum>$linenum</linenum>\r\n";
    $err .= "</error>\r\n";
    flock($f, LOCK_EX);
    fwrite($f, $err);
    flock($f, LOCK_UN);
    fclose($f);
  }
}


function GetFileSize($full_name)
{
  if (!file_exists($full_name)) {
    return 0;
  }
  $fp = @fopen($full_name, "r");
  if ($fp == 0) return 0;
  $res = @fseek($fp, 0, SEEK_END);
  $file_len = @ftell($fp);
  @fclose($fp);
  return $file_len;
}


function GetClientIp()
{
  $ClientIp = "";
  if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ClientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    if (!empty($_SERVER['REMOTE_ADDR'])) {
      $ClientIp = $_SERVER['REMOTE_ADDR'];
    }
  }
  return $ClientIp;
}


function logger($full_path, $savestr, $LogLen, $InsertTime)
{
  $ClientIp = GetClientIp();

  if ($InsertTime) {
    $s = date("d.m.Y/H:i:s/") . $ClientIp . "/" . $savestr . "\n";
  } else {
    $s = $savestr . "\n";
  }

  $FileLen = GetFileSize($full_path);
  if ($FileLen > 2 * $LogLen) {
    $fp = @fopen($full_path, "r");
    @fseek($fp, $FileLen - $LogLen, SEEK_SET);
    $str = @fgets($fp, 4096); //skip middle of line if exist        
    if ($str == FALSE) return; //error

    $Seek = @ftell($fp);
    $PieceSize = $FileLen - $Seek;
    $x = @fread($fp, $PieceSize);
    @fclose($fp);

    @clearstatcache();

    $fp = @fopen($full_path, "w");
    if ($fp == 0) return;

    @fwrite($fp, $x);
    @fwrite($fp, $s);
    #@fwrite( $fp, "log_moved\n" );//TODO: DELETE AFTER DEBUG
    @fclose($fp);
  } else {
    $h = @fopen($full_path, "a+");
    if ($h == 0) return;

    @flock($h, LOCK_EX);
    @fwrite($h, $s);
    @flock($h, LOCK_UN);
    @fclose($h);
  }
}


function disableCache()
{
  header("Expires: Mon, 29 Jule 2006 02:00:00 GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache");
  header("Last-Modified: Mon, 17 Jan 2006 00:00:00 GMT");
  header('Content-Type: text/html;windows-1251');
}


function KillSession()
{
  unset($_SESSION['admin']);
  unset($_SESSION['operator']);
  unset($_SESSION['owner']);
  unset($_SESSION['subadmin']);
  unset($_SESSION['manager']);
  unset($_SESSION['cashier']);
  unset($_SESSION['tech']);
  unset($_SESSION['user']);
  unset($_SESSION['club']);
  session_destroy();
}


function KillSess()
{
  KillSession();
  header("Location: /");
  exit;
}



###########################################
# Birja-Online
###########################################


function isTerminalOnline($curTime, $termData)
{
  global $ECLIENT_STATUS_LOGOFF;

  # If status!=logoff && lastAccessTime < 30sec -> online
  $res = 0;
  if (($termData["status"] != $ECLIENT_STATUS_LOGOFF) &&
    (abs($curTime - $termData["access_time"]) < 30)
  ) {
    $res = 1;
  }
  if ($termData["access_time"] == "-1") $res = 1;

  return $res;
}


function userlog($UserName, $savestr)
{
  global $dir;
  global $userlogs;
  global $UserLogSize;
  $full_path = $dir . $userlogs . "user_" . $UserName;
  logger($full_path, $savestr, $UserLogSize, 1);
}


function userlog2($userId, $savestr)
{
  # FIXME: get user login from db
  userlog("comlog", "$userId => " . $savestr);
  userlog($userId, $savestr);
}


function SafeStr($s)
{
  return preg_replace("/[^\w_\.\-]/", "", $s);
}

# 0 - admin
# 3 - subadmin
# 2 - owner
# 11- manager
# 14- tech
# 16 - cashier
function priv2str($priv)
{
  if ($priv == $GLOBALS["EADMIN"])   return "Администратор";
  if ($priv == $GLOBALS["EOWNER"])   return "Владелец";
  if ($priv == $GLOBALS["ESUBADMIN"]) return "Субадмин";
  if ($priv == $GLOBALS["EMANAGER"]) return "Менеджер";
  if ($priv == $GLOBALS["ETECH"])    return "Техник";
  if ($priv == $GLOBALS["ECASHIER"]) return "Кассир";
  return "Неизв.";
}

function Session2Id()
{
  if (isset($_SESSION['admin']))    return intval($_SESSION['admin']);
  if (isset($_SESSION['subadmin'])) return intval($_SESSION['subadmin']);
  if (isset($_SESSION['owner']))    return intval($_SESSION['owner']);
  if (isset($_SESSION['operator'])) return intval($_SESSION['operator']);
  if (isset($_SESSION['manager']))  return intval($_SESSION['manager']);
  if (isset($_SESSION['tech']))     return intval($_SESSION['tech']);
  if (isset($_SESSION['cashier']))  return intval($_SESSION['cashier']);
  return -1;
}


function Session2UserEnum()
{
  if (isset($_SESSION['admin']))    return $GLOBALS["EADMIN"];
  if (isset($_SESSION['owner']))    return $GLOBALS["EOWNER"];
  if (isset($_SESSION['subadmin'])) return $GLOBALS["ESUBADMIN"];
  if (isset($_SESSION['manager']))  return $GLOBALS["EMANAGER"];
  if (isset($_SESSION['tech']))     return $GLOBALS["ETECH"];
  if (isset($_SESSION['cashier']))  return $GLOBALS["ECASHIER"];
  return -1;
}


# param1=val1;param2=val2
function extractCsvParams($src, &$param_name, &$param_val)
{
  $params = explode(";", $src); //search XXX;YYY;ZZZ
  for ($i = 0; $i < count($params); $i++) {
    $str = explode("=", $params[$i]); # PARAM=VAL
    if (isset($str[0]) && isset($str[1])) {
      array_push($param_name, $str[0]);
      array_push($param_val,  $str[1]);
    }
  }
}


function extractCsvParam($src, $paramName)
{
  $params = explode(";", $src); # search XXX;YYY;ZZZ
  for ($i = 0; $i < count($params); $i++) {
    $str = explode("=", $params[$i]); # search a=1
    if (isset($str[0]) && isset($str[1])) {
      if ($str[0] == $paramName) {
        $paramVal = urldecode($str[1]);
        return $paramVal;
      }
    }
  }
  return ""; //Not found
}

# insertCsvParam($src, $param, $val)


function isTerminalHasQueuedServerCommands($termId)
{
  global $SV_ADD_CRED;
  global $SV_ADD_CRED2;
  global $SV_PAY_CRED;
  global $SV_PAY_CRED2;

  $srvCommands = array();
  getTerminalSrvCommands($termId, $srvCommands);

  $res = 0;
  for ($i = 0; $i < count($srvCommands); ++$i) {
    $cmd = $srvCommands[$i];
    if (($cmd["cmd"] == $SV_ADD_CRED) ||
      ($cmd["cmd"] == $SV_PAY_CRED) ||
      ($cmd["cmd"] == $SV_ADD_CRED2) ||
      ($cmd["cmd"] == $SV_PAY_CRED2)
    ) {
      $res++;
      break;
    }
  }
  return $res;
}


function getStatString($clubData, $terminalData)
{
  $clubId = $clubData["id"];
  $ctin = $clubData["total_in"];
  $ctout = $clubData["total_out"];
  $csin = $clubData["short_in"];
  $csout = $clubData["short_out"];
  $depos = $clubData["deposit"];

  $termId = $terminalData["id"];
  $ttin = $terminalData["total_in"];
  $ttout = $terminalData["total_out"];
  $tsin = $terminalData["short_in"];
  $tsout = $terminalData["short_out"];
  $tcred = $terminalData["credit"];

  $s = "club_id=$clubId;ctin=$ctin;ctout=$ctout;csin=$csin;csout=$csout;deposit=$depos;term_id=$termId;ttin=$ttin;ttout=$ttout;tsin=$tsin;tsout=$tsout;credit=$tcred";

  return $s;
}


function getStatString2($clubData)
{
  $clubId = $clubData["id"];
  $ctin = $clubData["total_in"];
  $ctout = $clubData["total_out"];
  $csin = $clubData["short_in"];
  $csout = $clubData["short_out"];
  $depos = $clubData["deposit"];
  $s = "club_id=$clubId;ctin=$ctin;ctout=$ctout;csin=$csin;csout=$csout;deposit=$depos";

  return $s;
}


function getClubsWithDeposit($src, &$arr)
{
  for ($i = 0; $i < count($src); ++$i) {
    $v = $src[$i];
    if (intval($v["use_deposit"]) != 0) {
      array_push($arr, $v);
    }
  }
}


function isValueInArray($val, $arr)
{
  $res = false;
  for ($i = 0; $i < count($arr); ++$i) {
    if ($arr[$i] == $val) {
      $res = true;
      break;
    }
  }
  return $res;
}


function getUserTimeZone($userId)
{
  $timeZone = "";
  if (getUserData($userId, $userData)) {
    $timezoneList = DateTimeZone::listIdentifiers();
    $timeZone = extractCsvParam($userData["settings"], "timezone");
    if (empty($timeZone) || !isValueInArray($timeZone, $timezoneList)) {
      $timeZone = "Europe/Moscow";
    }
  }
  return $timeZone;
}


function getHwidHash($hwid)
{
  return crc32($hwid);
}


function isIdValueInArray($val, $arr)
{
  $res = false;
  for ($i = 0; $i < count($arr); ++$i) {
    $v = $arr[$i];
    if ($v["id"] == $val) {
      $res = true;
      break;
    }
  }
  return $res;
}


function getDenom($terminalData)
{
  $settings = $terminalData["settings"];
  $denom = intval(extractCsvParam($settings, "denom"));
  if (!(($denom >= 1) && ($denom <= 10))) {
    $denom = 1;
  }
  return $denom;
}

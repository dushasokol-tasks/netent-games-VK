<?
require_once "../common.php";
#seterr();
dbinit();
libxml_use_internal_errors(true);

#global $dir;
#global $logdir;
#$filePath = $dir.$logdir."sber.xml";
#$filePath = "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/sber.xml";
#$xmlString = file_get_contents($filePath);

$urls = array(
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/rasp.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/urka.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/rosn.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/mstt.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/mgnt.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/magn.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/sber.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/chmf.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/nvtk.xml",
  "http://moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/lkoh.xml",
  "http://moex.com/iss/engines/stock/markets/index/securities/rtsi.xml"
);

date_default_timezone_set("Europe/Moscow"); # Moex timezone 
for ($i = 0; $i < count($urls); ++$i) {
  $xmlString = @file_get_contents($urls[$i]);
  if ($xmlString === false) {
    echo "get_content_error;";
  } else {
    if (parseMoexXml($xmlString)) {
      echo "ok;";
    } else {
      echo "parse_error;";
    }
  }
}
exit();



function parseMoexXml($str)
{
  global $COMPID_UNKNOWN;
  global $COMPID_RTSI;

  $res = false;
  $xml = @simplexml_load_string($str);
  if ($xml) {
    $idx = 0;
    while (!empty($xml->data[$idx])) {
      $v = $xml->data[$idx];
      if (!empty($v["id"])) {
        if ($v["id"] == "marketdata") {
          $secId     = $v->rows[0]->row["SECID"];
          $sysTime   = $v->rows[0]->row["SYSTIME"];

          $companyId = companyNameToId($secId);
          $sysTimestamp = strtotime($sysTime);

          if ($companyId != $COMPID_UNKNOWN) {
            if ($companyId == $COMPID_RTSI) {
              $currentValue      = $v->rows[0]->row["CURRENTVALUE"];
              $v1["companyId"]   = $companyId;
              $v1["currentValue"] = $currentValue;
              $v1["sysTimestamp"] = $sysTimestamp;
              saveStockRtsi($v1);
            } else {
              $tradingStatus = $v->rows[0]->row["TRADINGSTATUS"];
              $last          = $v->rows[0]->row["LAST"];
              $v1["companyId"] = $companyId;
              $v1["last"]     = $last;
              $v1["status"]   = $tradingStatus;
              $v1["sysTimestamp"] = $sysTimestamp;
              saveStock($v1);
            }
          }
          break;
        }
      }
      ++$idx;
    }
    $res = true;
  }
  return $res;
}


function companyNameToId($s)
{
  global $COMPID_RASP;
  global $COMPID_URKA;
  global $COMPID_ROSN;
  global $COMPID_MSTT;
  global $COMPID_MGNT;
  global $COMPID_MAGN;
  global $COMPID_SBER;
  global $COMPID_CHMF;
  global $COMPID_NVTK;
  global $COMPID_LKOH;
  global $COMPID_RTSI;
  global $COMPID_UNKNOWN;

  if ($s == "RASP") {
    return $COMPID_RASP;
  }
  if ($s == "URKA") {
    return $COMPID_URKA;
  }
  if ($s == "ROSN") {
    return $COMPID_ROSN;
  }
  if ($s == "MSTT") {
    return $COMPID_MSTT;
  }
  if ($s == "MGNT") {
    return $COMPID_MGNT;
  }
  if ($s == "MAGN") {
    return $COMPID_MAGN;
  }
  if ($s == "SBER") {
    return $COMPID_SBER;
  }
  if ($s == "CHMF") {
    return $COMPID_CHMF;
  }
  if ($s == "NVTK") {
    return $COMPID_NVTK;
  }
  if ($s == "LKOH") {
    return $COMPID_LKOH;
  }
  if ($s == "RTSI") {
    return $COMPID_RTSI;
  }
  return $COMPID_UNKNOWN; # Unknown
}

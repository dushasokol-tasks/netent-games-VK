<?
require_once "integr/common.php";

$db_pref = "birjadb.";

if ($cmd == "login") {
  cmd_login($xml);
} else if ($cmd == "logoff") {
  cmd_logoff($xml);
} else if ($cmd == "getstatistics") {
  cmd_getstatistics($xml);
} else if ($cmd == "getsettings") {
  cmd_getsettings($xml);
} else if ($cmd == "updategamedata") {
  cmd_updategamedata($xml);
} else if ($cmd == "svaddcred1ack") {
  //    echo $cmd. "[[[";
  cmd_svaddcred1ack($xml, $decoded);
  //echo "dsda";
} else if ($cmd == "svpaycred1ack") {
  cmd_svpaycred1ack($xml, $decoded);
} else if ($cmd == "svinitmachineack") {
  cmd_svinitmachineack($xml);
} else if ($cmd == "getstocks") {
  cmd_getstocks($xml);
} else if ($cmd == "legal") {
  cmd_legal($xml);
} else if ($cmd == "svforceexitack") {
  cmd_svforceexitack($xml);
}


function sendToClient($s)
{
  # TODO: Crypt data
  echo $s;
}


function getResultXmlString($res)
{
  return "<root><result res=\"$res\"/></root>";
}


function sendAccessDenied()
{
  sendToClient(getResultXmlString("access_denied"));
}


function sendOk()
{
  sendToClient(getResultXmlString("ok"));
}



function cmd_legal($xml)
{
  global $ECLIENT_STATUS_LOGIN;

  $hwid  = $xml->hwid["val"];
  $email = $xml->email["val"];
  $date  = $xml->date["val"];

  $terminalData;
  if (getTerminalData($hwid, $terminalData)) {
    if (isTerminalBanned($terminalData)) {
      sendAccessDenied();
    } else {
      #debugLog("HWID: $hwid EMAIL: $email DATE: $date");
      writeToLegalityLog($email, $date, $terminalData["id"]);
      sendOk();
    }
  } else {
    sendAccessDenied();
  }
  exit();
}


function cmd_login($xml)
{
  global $ECLIENT_STATUS_LOGIN;

  $hwid    = $xml->hwid["val"];
  $gameset = $xml->game["val"];
  $version = $xml->version["val"];

  $terminalData;
  if (getTerminalData($hwid, $terminalData)) {
    if (isTerminalBanned($terminalData)) {
      sendAccessDenied();
    } else {
      $prevStatus = $terminalData["status"];

      $id = $terminalData["id"];
      updateTerminalAccessTime($id);
      $terminalData["gameset"]        = $gameset;
      $terminalData["client_version"] = $version;
      $terminalData["status"]         = $ECLIENT_STATUS_LOGIN;
      setTerminalDataById($id, $terminalData);

      # Log
      $msg = "oper=login;client=$gameset;version=$version;term_id=$id";
      $tm = time();
      writeToTerminalLog($id, $msg, $tm);

      #sendOk();
      $resXml =
        "<root>
    <result res=\"ok\"/>
    <prev_status val=\"$prevStatus\" />
  </root>";
      sendToClient($resXml);
    }
  } else {
    sendAccessDenied();
  }
  exit();
}


function cmd_logoff($xml)
{
  global $ECLIENT_STATUS_LOGOFF;

  $hwid    = $xml->hwid["val"];
  $gameset = $xml->game["val"];
  $version = $xml->version["val"];

  $terminalData;
  if (getTerminalData($hwid, $terminalData)) {
    $id = $terminalData["id"];
    updateTerminalAccessTime($id);
    $terminalData["gameset"]        = $gameset;
    $terminalData["client_version"] = $version;
    $terminalData["status"]         = $ECLIENT_STATUS_LOGOFF;
    setTerminalDataById($id, $terminalData);

    # Log
    $msg = "oper=logoff;client=$gameset;version=$version;term_id=$id";
    $tm = time();
    writeToTerminalLog($id, $msg, $tm);

    sendOk();
  } else {
    sendAccessDenied();
  }
  exit();
}

function cmd_getstatistics($xml)
{
  $hwid = $xml->hwid["val"];
  $terminalData;
  if (getTerminalData($hwid, $terminalData)) {
    if (isTerminalBanned($terminalData)) {
      sendAccessDenied();
    } else {
      $id = $terminalData["id"];
      updateTerminalAccessTime($id);

      $credit   = $terminalData["credit"];
      $total_in = $terminalData["total_in"];
      $total_out = $terminalData["total_out"];
      $short_in = $terminalData["short_in"];
      $short_out = $terminalData["short_out"];
      $resXml =
        "<root>
    <result res=\"ok\"/>
    <credits val=\"$credit\" />
    <total_in val=\"$total_in\" />
    <total_out val=\"$total_out\" />
    <short_in val=\"$short_in\" />
    <short_out val=\"$short_out\" />
  </root>";
      sendToClient($resXml);
    }
  } else {
    sendAccessDenied();
  }
  exit();
}


function cmd_getsettings($xml)
{
  $hwid    = $xml->hwid["val"];
  $terminalData;
  if (getTerminalData($hwid, $terminalData)) {
    if (isTerminalBanned($terminalData)) {
      sendAccessDenied();
    } else {
      $id = $terminalData["id"];
      updateTerminalAccessTime($id);

      #$icredit_limit = "1"; # [0-5]
      #$irisk_limit   = "1"; # [0-5]
      #$ipercent      = "1"; # [0-3]
      #$ibonus_rate   = "1"; # [0-10]

      $settings = $terminalData["settings"];

      $icredit_limit = intval(extractCsvParam($settings, "icredit_limit"));
      if (!(($icredit_limit >= 0) && ($icredit_limit <= 5))) {
        $icredit_limit = 0;
      }

      $irisk_limit = intval(extractCsvParam($settings, "irisk_limit"));
      if (!(($irisk_limit >= 0) && ($irisk_limit <= 5))) {
        $irisk_limit = 0;
      }

      $ipercent = intval(extractCsvParam($settings, "ipercent"));
      if (!(($ipercent >= 0) && ($ipercent <= 3))) {
        $ipercent = 0;
      }

      $ibonus_rate = intval(extractCsvParam($settings, "ibonus_rate"));
      if (!(($ibonus_rate >= 0) && ($ibonus_rate <= 10))) {
        $ibonus_rate = 0;
      }


      # Gaminator cold-fire
      # gstrategy [0-2] NONE/SOFT/HARD
      # gcredit_limit  [10000-1000000]
      # gjackpot_limit [10000-1000000]
      # gdouble_limit  [10000-1000000]
      $gstrategy = intval(extractCsvParam($settings, "gstrategy"));
      if (!(($gstrategy >= 0) && ($gstrategy <= 2))) {
        $gstrategy = 0;
      }

      $gcredit_limit = intval(extractCsvParam($settings, "gcredit_limit"));
      if (!(($gcredit_limit >= 10000) && ($gcredit_limit <= 1000000))) {
        $gcredit_limit = 10000;
      }

      $gjackpot_limit = intval(extractCsvParam($settings, "gjackpot_limit"));
      if (!(($gjackpot_limit >= 10000) && ($gjackpot_limit <= 1000000))) {
        $gjackpot_limit = 10000;
      }

      $gdouble_limit = intval(extractCsvParam($settings, "gdouble_limit"));
      if (!(($gdouble_limit >= 10000) && ($gdouble_limit <= 1000000))) {
        $gdouble_limit = 10000;
      }

      $g1 = getGaminGame($settings, "g1", 1);
      $g2 = getGaminGame($settings, "g2", 2);
      $g3 = getGaminGame($settings, "g3", 3);
      $g4 = getGaminGame($settings, "g4", 4);
      $g5 = getGaminGame($settings, "g5", 5);
      $g6 = getGaminGame($settings, "g6", 6);
      $g7 = getGaminGame($settings, "g7", 7);
      $g8 = getGaminGame($settings, "g8", 8);
      $g9 = getGaminGame($settings, "g9", 9);
      $g10 = getGaminGame($settings, "g10", 10);

      $denom = getDenom($terminalData);


      # GBOX
      $gbox_risksteps = intval(extractCsvParam($settings, "gbox_risksteps"));
      if (!(($gbox_risksteps >= 0) && ($gbox_risksteps <= 30))) {
        $gbox_risksteps = 0;
      }

      $gbox_risklimit = intval(extractCsvParam($settings, "gbox_risklimit"));
      if (!(($gbox_risklimit >= 10000) && ($gbox_risklimit <= 1000000))) {
        $gbox_risklimit = 10000;
      }

      $gbox_workmode = intval(extractCsvParam($settings, "gbox_workmode"));
      if (!(($gbox_workmode >= 0) && ($gbox_workmode <= 3))) {
        $gbox_workmode = 0;
      }

      $gbox_gameset = intval(extractCsvParam($settings, "gbox_gameset"));
      if (!(($gbox_gameset >= 0) && ($gbox_gameset <= 18))) {
        $gbox_gameset = 0;
      }



      $resXml =
        "<root>
    <result res=\"ok\"/>
    <igrosoft>
      <credit_limit val=\"$icredit_limit\" />
      <risk_limit val=\"$irisk_limit\" />
      <percent val=\"$ipercent\" />
      <bonus_rate val=\"$ibonus_rate\" />
    </igrosoft>
    
    <gaminator>
      <gstrategy val=\"$gstrategy\" />
      <gcredit_limit val=\"$gcredit_limit\" />
      <gjackpot_limit val=\"$gjackpot_limit\" />
      <gdouble_limit val=\"$gdouble_limit\" />
      <g1 val=\"$g1\" />
      <g2 val=\"$g2\" />
      <g3 val=\"$g3\" />
      <g4 val=\"$g4\" />
      <g5 val=\"$g5\" />
      <g6 val=\"$g6\" />
      <g7 val=\"$g7\" />
      <g8 val=\"$g8\" />
      <g9 val=\"$g9\" />
      <g10 val=\"$g10\" />
    </gaminator>

    <common_settings>
      <denom val=\"$denom\" />
    </common_settings>

    <gbox>
      <gbox_risksteps val=\"$gbox_risksteps\" />
      <gbox_risklimit val=\"$gbox_risklimit\" />
      <gbox_workmode  val=\"$gbox_workmode\" />
      <gbox_gameset   val=\"$gbox_gameset\" />
    </gbox>

  </root>";
      sendToClient($resXml);
    }
  } else {
    sendAccessDenied();
  }
  exit();
}


function updateTerminalStatFromXml($id, $xml)
{
  $credits  = $xml->credits["val"];
  #$total_in = $xml->total_in["val"];
  #$total_out= $xml->total_out["val"];
  #$short_in = $xml->short_in["val"];
  #$short_out= $xml->short_out["val"];

  # Bet info from client
  $betlineinfo = "";
  if (!empty($xml->betlineinfo["val"])) {
    $betlineinfo = $xml->betlineinfo["val"];
  }

  $terminalData;
  if (getTerminalDataById($id, $terminalData)) {
    $tin = $terminalData["total_in"];
    $tout = $terminalData["total_out"];
    $sin = $terminalData["short_in"];
    $sout = $terminalData["short_out"];
    $oldCred = $terminalData["credit"];

    # If terminal state not changed -> NOT UPDATE!!!!
    # If betline send-> UPDATE!!!!!!1111
    if (($oldCred != $credits) || !empty($betlineinfo)) {
      $denom = getDenom($terminalData);
      $realCredits = intval($credits / $denom);  # REAL VAL

      $msg = "oper=stat_update;term_id=$id;credit=$credits;realcredit=$realCredits";

      if (!empty($betlineinfo)) {
        # Decode
        $betlineinfo = @base64_decode($betlineinfo);
        $msg = $msg . ";client_bets=1;$betlineinfo";
      }

      $tm = time();
      writeToTerminalLog($id, $msg, $tm);
    }

    // Update terminal data in sql
    updateTerminalStat($id, $credits);
  }
}


function getSrvCmdXml($id, &$outCmdId)
{
  $outCmdId = 0;
  $resXml = "";
  $q = @mysql_query("SELECT * FROM srvcmd WHERE term_id='$id' AND sended='0'");
  if (@mysql_num_rows($q) == 0) {
    # No srv commands
    $resXml = getResultXmlString("ok");
  } else {
    $f = @mysql_fetch_array($q);
    $cmdid = $f["id"];
    $termid = $f["term_id"];
    $cmd   = $f["cmd"]; # server command
    $outCmdId = $cmdid;

    $paramsStr = urldecode($f["params"]); # CSV params
    $params = array();
    $vals   = array();
    extractCsvParams($paramsStr, $params, $vals);

    # CSV extract params
    $resXml =
      "<root>
  <result val=\"ok\"/>
  <servercmd name=\"$cmd\" id=\"$cmdid\">";
    for ($i = 0; $i < count($params); ++$i) {
      $p = $params[$i];
      $v = $vals[$i];
      $resXml = $resXml . "<$p val=\"$v\"/>";
    }
    $resXml = $resXml . "
  </servercmd>
</root>";
  }
  return $resXml;
}


function cmd_updategamedata($xml)
{
  $hwid = $xml->hwid["val"];
  $terminalData;
  if (getTerminalData($hwid, $terminalData)) {
    if (isTerminalBanned($terminalData)) {
      sendAccessDenied();
    } else {
      $id = $terminalData["id"];
      updateTerminalAccessTime($id);

      #########################
      #########################
      # Check for existing srv commands before stat update
      updateTerminalStatFromXml($id, $xml);

      # Add server command (if present in srvcmd table)
      # Mark srv command in db
      $cmdId = 0;
      $resXml = getSrvCmdXml($id, $cmdId);
      if ($cmdId != 0) {
        markSrvCommand($cmdId);
      }
      sendToClient($resXml);
    }
  } else {
    sendAccessDenied();
  }
  exit();
}



function cmd_svaddcred1ack($xml, $xmlString)
{
  global $cmdId;
  global $bt;
  global $ECLIENT_OK;
  global $ECLIENT_STATUS_ADDED;
  global $ECLIENT_STATUS_ADD_ERROR;
  $db_pref = "birjadb.";

  $svCmdId = $cmdId;

  $status = $ECLIENT_OK;

  $beforeAddCredits = $xml->before_credits["val"]; # Credits before add
  $afterAddCredits  = $xml->after_credits["val"];  # Credits after add

  $terminalData = $bt;

  $id     = $terminalData["id"]; #terminal id
  $clubId = $terminalData["club_id"]; # Terminal club id

  getClubData($clubId, $clubData);

  $srvCmdData;
  if (getSrvCmd($svCmdId, $srvCmdData)) {
    # Get params from svaddcred
    $params = urldecode($srvCmdData["params"]);
    $addval = extractCsvParam($params, "addval");
    $denom  = extractCsvParam($params, "denom");
    $origval = extractCsvParam($params, "origval");
    $client_id = extractCsvParam($params, "client_id");
    $owner_id = extractCsvParam($params, "owner_id");
    $jp = extractCsvParam($params, "jp");
    $rfid = extractCsvParam($params, "rfid");
    $doc_id = $srvCmdData["id"];
    $statString = getStatString($clubData, $terminalData);

    # ADD CREDIT SUCCESS. SUB FROM DEPOSIT. UPDATE COUNTERS
    if ($clubData["use_deposit"]) {
      $deposit = $clubData["deposit"];
      if ($deposit < $origval) {
        debugLog("ADD_CREDIT_ERROR_DEPOSIT_NEGATIVE;club_id=$clubId;deposit=$deposit;sub=$origval");
      } else {
        if ($jp == '')
          $clubData["deposit"] -= $origval;
      }
    }


    ##############################################
    # Terminal total_in/short_in update
    # FIXME: use client short in. Don't add here?
    ##############################################
    $terminalData["total_in"] += $origval;
    $terminalData["short_in"] += $origval;
    $terminalData["status"] = "added";
    $terminalData["credit"] += $origval;

    setTerminalDataById($id, $terminalData);

    # Update club total_in/short_in
    if ($jp == '') {
      $clubData["total_in"]  += $origval;
      $clubData["short_in"]  += $origval;
      setClubData($clubId, $clubData);
    }

    # Write to log
    $tm = time();
    $msg = "oper=addcredit;client_status=$status;addval=$origval;denomaddval=$addval;owner_id=$owner_id;client_id=$client_id;jp=$jp;doc_id=$doc_id;rfid=$rfid;$statString"; ////////////////////
    writeToCashLog1($clubId, $msg, $tm);
    writeToTerminalLog($id, $msg, $tm);

    //////////////////////JP

    if ($jp == '') {
      $bonus = 'none';
      $myQueryText = "SELECT * FROM " . $db_pref . "rep_departments WHERE id=$clubId;";
      $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      $dept = @mysql_fetch_array($q);

      $myQueryText = "SELECT * FROM " . $db_pref . "rep_contracts WHERE number='$client_id';";
      $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      $cl = @mysql_fetch_array($q);

      $fll_in = $cl['full_in'] + $origval;
      $fll_dt = $cl['full_delta'] + $origval;
      $sh_dt = $cl['short_delta'] + $origval;
      ////////////
      //	    if($rfid!='' and $rfid!='nocard' and $rfid!='nouser')$bl_dt=$cl['balls_delta']+$origval;
      if ($cl['card_id'] != '') $bl_dt = $cl['balls_delta'] + $origval;
      ////////////
      else $bl_dt = $cl['balls_delta'];

      $myQueryText = "UPDATE " . $db_pref . "rep_contracts SET full_in='$fll_in', full_delta='$fll_dt', short_delta='$sh_dt', balls_delta='$bl_dt' WHERE number='$client_id';";
      $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      if ($dept['dialy'] > 0) {
        if ($dept['trans_num'] > 0 and $dept['djp_start_hour'] <= date("H") and $dept['djp_start_hour'] != 0)  $dept['trans_num']--;
        if ($dept['trans_num'] == 0 and $dept['dialy'] > 0) $bonus = 'dialy';

        if ($bonus == 'dialy') {
          $dept['steps']--;
          if ($dept['steps'] > 0) $dept['trans_num'] = $dept['trans_min_quant'];
          else $dept['dialy'] = 0;
        }
        $myQueryText = "UPDATE " . $db_pref . "rep_departments SET dialy='" . $dept['dialy'] . "', trans_num='" . $dept['trans_num'] . "', steps='" . $dept['steps'] . "' WHERE id='" . $clubId . "'";
        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      }
      if ($bonus == 'none')
        if ($dept['1st'] > $dept['1potThold'] or $dept['2nd'] > $dept['2potThold'] or $dept['3rd'] > $dept['3potThold'])
          if ($dept['JPdelay'] != 0 and $dept['JPdelay'] < time())
            if ($cl['full_delta'] > 5000 and $cl['short_delta'] > 300) {
              $cl_dice = round(rand(0, 100));
              if ($dept['1st'] > $dept['1potThold'] and $dept['1potChance'] > 0)  if ($cl_dice <= intval($dept['1potChance'])) {
                $bonus = '1st';
                $dept['JPdelay'] = 0;
              }
              if ($dept['2nd'] > $dept['2potThold'] and $dept['2potChance'] > 0)  if ($cl_dice <= intval($dept['2potChance'])) {
                $bonus = '2nd';
                $dept['JPdelay'] = 0;
              }
              if ($dept['3rd'] > $dept['3potThold'] and $dept['3potChance'] > 0)  if ($cl_dice <= intval($dept['3potChance'])) {
                $bonus = '3rd';
                $dept['JPdelay'] = 0;
              }
              userlog2("$owner_id", " Try to JP: %=" . $cl_dice . ";fd=" . $cl['full_delta'] . ";sd=" . $cl['short_delta']);
            }
      if ($bonus != 'none') {
        $bon_addval = $dept[$bonus] / 100;
        $bon_adv = $denom * $bon_addval;
        $bon_params = "addval=$bon_adv;denom=$denom;origval=$bon_addval;client_id=$client_id;owner_id=$owner_id";
        $prms = urlencode($bon_params);
        $ts = time();
        $query_str = "INSERT INTO " . $db_pref . "rep_queue (cmd, params, term_id, user_id, timestamp) VALUES ('$bonus', '$prms', '$id', '$owner_id', '$ts')";
        $q = @mysql_query($query_str) or die('mysql_query error: ' . mysql_error());
      }

      if ($bonus == '3rd' or $bonus == '2nd' or $bonus == '1st') {
        $dept[$bonus] = 0;
        $myQueryText = "UPDATE " . $db_pref . "rep_departments SET  1st='" . $dept['1st'] . "', 2nd='" . $dept['2nd'] . "', 3rd='" . $dept['3rd'] . "', JPdelay='" . $dept['JPdelay'] . "' WHERE id='" . $clubId . "'";
        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      }
    }
    delSrvCmd($svCmdId);
  } else {
    debugLog("ADD_CREDIT____ERROR_SVADDCRED1_NOTFOUND. ClubId: $clubId. TermId: $id. client_status=$status");
    debugLog("XML from client: " . $xmlString);
    sendToClient(getResultXmlString("error_svaddcred1_notfound"));
  }
}


# Payout
function cmd_svpaycred1ack($xml, $xmlString)
{
  global $old_credit;
  global $cmdId;
  global $bt;
  global $ECLIENT_OK;
  global $ECLIENT_STATUS_PAYED;
  global $ECLIENT_STATUS_PAY_ERROR;
  $db_pref = "birjadb.";

  $svCmdId = $cmdId;

  $terminalData = $bt;

  $id     = $terminalData["id"]; #terminal id
  $clubId = $terminalData["club_id"]; # Terminal club id

  updateTerminalAccessTime($id);

  getClubData($clubId, $clubData);

  $srvCmdData;

  if (getSrvCmd($svCmdId, $srvCmdData)) {
    $credit = abs(intval($beforeCredits) - intval($afterCredits)); # Credits with denomination
    $statString = getStatString($clubData, $terminalData);

    $params = urldecode($srvCmdData["params"]);
    $denom  = extractCsvParam($params, "denom");
    $client_id = extractCsvParam($params, "client_id");
    $owner_id = extractCsvParam($params, "owner_id");

    $origCredit = intval($credit / $denom);  # REAL VAL

    if ($client_id != $terminalData["lastClient"] and $terminalData["lastClient"] != 0) {
      $myQueryText = "UPDATE " . $db_pref . "rep_contracts SET balls_delta='0' WHERE number='" . $terminalData["lastClient"] . "';";
      $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      $myQueryText = date(h . ":" . i . " " . d . "." . m, time()) . ";reason=diffClts;userId=" . $owner_id . ";clubId=" . $clubId . ";client_id=" . $client_id . ";last_added_id=" . $terminalData['lastClient'] . ",";
      $myQueryText = "log=concat(log,'" . $myQueryText . "')";
      $myQueryText = "UPDATE " . $db_pref . "rep_departments SET $myQueryText WHERE id='$clubId';";
      $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      userlog2("$owner_id", " NULL balls_delta: client_id=" . $client_id . ";last_added_id=" . $terminalData["lastClient"]);
      $client_id = $terminalData["lastClient"];
    }


    $rfid = extractCsvParam($params, "rfid");
    $doc_id = $srvCmdData["id"];

    if (($status != $ECLIENT_OK) || (intval($afterCredits) != 0)) {
      # PAY ERROR
      debugLog("PAY_CREDIT_ERROR. ClubId:" . $clubId . " TermId:" . $id . " client_status=$status before=" . $beforeCredits . " after=" . $afterCredits);

      # Set terminal status
      $terminalData["status"] = $ECLIENT_STATUS_PAY_ERROR;
      setTerminalDataById($id, $terminalData);

      # Write to log
      #$msg = "oper=paycredit_error;client_status=$status;payval=$credit;denompayval=$credit;$statString";
      $msg = "oper=paycredit_error;client_status=$status;payval=$origCredit;denompayval=$credit;$statString";
      $tm = time();
      writeToCashLog1($clubId, $msg, $tm);
      writeToTerminalLog($id, $msg, $tm);
    } else {
      $origCredit = floor($old_credit / 100);

      # Update terminal total_out/short_out
      # FIXME: add here? Or use client data?
      $terminalData["total_out"] += $origCredit;
      $terminalData["short_out"] += $origCredit;
      $terminalData["credit"] = 0;
      $terminalData["status"] = $ECLIENT_STATUS_PAYED;
      setTerminalDataById($id, $terminalData);

      # Update club total_in/short_in/deposit
      $clubData["deposit"]   += $origCredit;
      $clubData["total_out"] += $origCredit;
      $clubData["short_out"] += $origCredit;
      setClubData($clubId, $clubData);

      # Write to log
      $msg = "oper=paycredit;client_status=$status;payval=$origCredit;denompayval=$old_credit;owner_id=$owner_id;client_id=$client_id;doc_id=$doc_id;rfid=$rfid;$statString";
      $tm = time();
      writeToCashLog1($clubId, $msg, $tm);
      writeToTerminalLog($id, $msg, $tm);

      //////////////JP

      $myQueryText = "SELECT * FROM " . $db_pref . "rep_departments WHERE id=$clubId;";
      $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      $dept = @mysql_fetch_array($q);


      $myQueryText = "SELECT * FROM " . $db_pref . "rep_contracts WHERE number='$client_id';";
      $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      $cl = @mysql_fetch_array($q);

      $fll_out = $cl['full_out'] + $origCredit;
      $fll_dt = $cl['full_delta'] - $origCredit;
      $sh_dt = $cl['short_delta'] - $origCredit;
      if ($cl['card_id'] != '' and $cl['card_id'] != 'nocard') $bl_dt = $cl['balls_delta'] - $origCredit;
      else $bl_dt = $cl['balls_delta'];
      //	    if($rfid!='' and $rfid!='nocard' and $rfid!='nouser')$bl_dt=$cl['balls_delta']-$origCredit;
      //	    else $bl_dt=$cl['balls_delta'];

      ////////////////

      if ($dept['1potPut'] > 0 or $dept['2potPut'] > 0 or $dept['3potPut'] > 0) {
        $oldPot1 = $dept['1st'];
        $oldPot2 = $dept['2nd'];
        $oldPot3 = $dept['3rd'];
        if (round(rand(0, 1)) == 1) $res = 1;
        else $res = -1;
        if ($sh_dt > 0) {
          $dept['3rd'] += ($sh_dt * 2 * $res + $sh_dt * $dept['3potPut']);
        }
        if ($sh_dt >= 500) {
          $dept['2nd'] += $sh_dt * $res + $sh_dt * $dept['2potPut'];
        }
        if ($sh_dt >= 1000) {
          $dept['1st'] += $sh_dt * $dept['1potPut'];
        }
        if ($sh_dt > 0) {
          if ($dept['JPdelay'] == 0) {
            if ($dept['1st'] > $dept['1potThold']) $dept['JPdelay'] = time() + round(rand(250000, 400000));
            if ($dept['2nd'] > $dept['2potThold']) $dept['JPdelay'] = time() + round(rand(200000, 300000));
            if ($dept['3rd'] > $dept['3potThold']) $dept['JPdelay'] = time() + round(rand(145000, 180000));
          }
          $oldPot1 = $dept['1st'] - $oldPot1;
          $oldPot2 = $dept['2nd'] - $oldPot2;
          $oldPot3 = $dept['3rd'] - $oldPot3;
          userlog2("$owner_id", "SYS put to pot " . $sh_dt . ", client " . $client_id . ", 1st=" . $dept['1st'] . "(" . $oldPot1 . "), 2nd=" . $dept['2nd'] . "(" . $oldPot2 . "), 3rd=" . $dept['3rd'] . "(" . $oldPot3 . ")");
          $sh_dt = 0;
          $myQueryText = "UPDATE " . $db_pref . "rep_departments SET 1st='" . $dept['1st'] . "', 2nd='" . $dept['2nd'] . "', 3rd='" . $dept['3rd'] . "', JPdelay='" . $dept['JPdelay'] . "' WHERE id='" . $clubId . "'";
          $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
        }
      }
    }

    $myQueryText = "UPDATE " . $db_pref . "rep_contracts SET full_out='$fll_out', full_delta='$fll_dt', short_delta='$sh_dt', balls_delta='$bl_dt' WHERE number='$client_id';";
    $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

    if ($dept['dialy'] > 0) {
      if ($dept['djp_start_hour'] <= date("H") and $dept['djp_start_hour'] != 0) {
        $dept['trans_num']++;
        $myQueryText = "UPDATE " . $db_pref . "rep_departments SET trans_num='" . $dept['trans_num'] . "' WHERE id='" . $clubId . "'";
        $q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
      }
    }
    delSrvCmd($svCmdId);
  }

  //      else
  //      {
  //        debugLog("PAY_CREDIT____ERROR_SVPAYCRED1_NOTFOUND. ClubId: $clubId. TermId: $id. client_status=$status");
  //        debugLog("XML from client: ".$xmlString);
  //        sendToClient(getResultXmlString("error_svpaycred1_notfound"));
  //      }

}


function cmd_svinitmachineack($xml)
{
  $hwid    = $xml->hwid["val"];
  $svCmdId = $xml->cmdid["val"];
  $terminalData;
  if (getTerminalData($hwid, $terminalData)) {
    if (isTerminalBanned($terminalData)) {
      sendAccessDenied();
    } else {
      $id     = $terminalData["id"]; #terminal id
      $clubId = $terminalData["club_id"]; # Terminal club id

      updateTerminalAccessTime($id);

      getClubData($clubId, $clubData);

      $srvCmdData;
      if (getSrvCmd($svCmdId, $srvCmdData)) {
        $terminalData["total_in"]  = 0;
        $terminalData["total_out"] = 0;
        $terminalData["short_in"]  = 0;
        $terminalData["short_out"] = 0;
        $terminalData["credit"]    = 0;
        setTerminalDataById($id, $terminalData);

        # Write club cash log.
        $statString = getStatString($clubData, $terminalData);

        # Write club cash log.
        $msg = "oper=initterminal;$statString";
        $tm = time();
        writeToCashLog1($clubId, $msg, $tm);
        writeToTerminalLog($id, $msg, $tm);

        # Delete svpaycred1 cmd
        delSrvCmd($svCmdId);
        sendOk();
      } else {
        sendToClient(getResultXmlString("error_svinitmachine_notfound"));
      }
    }
  } else {
    sendAccessDenied();
  }
}


# Stocks
function getCompanyStockXml($companyId, &$res)
{
  $stocks = array();
  getCompanyStocks($companyId, $stocks);

  $res = $res . "<stocks company_id=\"$companyId\">";
  for ($i = 0; $i < count($stocks); ++$i) {
    $v    = $stocks[$i];
    $last = $v["last_val"];
    $sysT = $v["system_time"];
    $res  = $res . "<stock last=\"$last\" time=\"$sysT\" />";
  }
  $res = $res . "</stocks>";
}


function cmd_getstocks($xml)
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

  # Output XML
  $res = "<root><result res=\"ok\"/>";

  # Server time add
  date_default_timezone_set("Europe/Moscow"); # Moex timezone
  $dt = date('Y-m-d H:i:s');
  $t = strtotime($dt);
  $res = $res . "<server_time val=\"$t\"/>";

  getCompanyStockXml($COMPID_RASP, $res);
  getCompanyStockXml($COMPID_URKA, $res);
  getCompanyStockXml($COMPID_ROSN, $res);
  getCompanyStockXml($COMPID_MSTT, $res);
  getCompanyStockXml($COMPID_MGNT, $res);
  getCompanyStockXml($COMPID_MAGN, $res);
  getCompanyStockXml($COMPID_SBER, $res);
  getCompanyStockXml($COMPID_CHMF, $res);
  getCompanyStockXml($COMPID_NVTK, $res);
  getCompanyStockXml($COMPID_LKOH, $res);
  getCompanyStockXml($COMPID_RTSI, $res);
  $res = $res . "</root>";
  sendToClient($res);
  exit();
}



function getGaminGame($settings, $paramName, $def)
{
  $res = intval(extractCsvParam($settings, $paramName));
  if (!(($res >= 1) && ($res <= 20))) {
    $res = $def;
  }
  return $res;
}



function cmd_svforceexitack($xml)
{
  $hwid    = $xml->hwid["val"];
  $svCmdId = $xml->cmdid["val"];
  $terminalData;
  if (getTerminalData($hwid, $terminalData)) {
    if (isTerminalBanned($terminalData)) {
      sendAccessDenied();
    } else {
      $id = $terminalData["id"]; #terminal id
      updateTerminalAccessTime($id);
      $srvCmdData;
      if (getSrvCmd($svCmdId, $srvCmdData)) {
        $msg = "oper=forceexit;term_id=$id";
        $tm = time();
        writeToTerminalLog($id, $msg, $tm);
        # Delete cmd
        delSrvCmd($svCmdId);
        sendOk();
      } else {
        sendToClient(getResultXmlString("error_svforceexitack_notfound"));
      }
    }
  } else {
    sendAccessDenied();
  }
}

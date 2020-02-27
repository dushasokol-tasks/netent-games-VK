<?
session_start();

if (!$_SESSION['user']) {
    header("Location: meow/login.php");
    exit();
} else {
    header('Content-type: text/html; charset=utf-8');
    //$_GET['id']='VK10637772';

    //make token verify

    $_POST = $_GET;
    function callback($buffer, $b)
    {
        $a = json_decode($buffer);

        $main_url = 'https://ermak.xyz/';
        $sessId = $_GET['id'];
        $lang = $a->lang;
        $staticServer = 'https%3A%2F%2Fermak.xyz%2F';
        $lobbyURL = 'https%3A%2F%2Fermak.xyz%2Fermak_mobile.php%3Fgohome%3D1';
        $server = 'https%3A%2F%2Fermak.xyz%2F';
        $pluginURL = 'https%3A%2F%2Fermak.xyz%2Fgames%2Flobby%2Fworlds2.php%3Fid%3D' . $sessId;
        $operatorId = 'wincastle';

        if ($a->msg == 2) {
            if ($a->activity > 21600 or $_GET['gohome'] == 1) {
                $folder = "lobby_html";
                $gameId = "lobby";
                $outer_url = $main_url . "games/" . $folder . "/game/" . $gameId . ".php?staticServer=" . $staticServer . "&lobbyURL=" . $lobbyURL . "&server=" . $server . "&lang=" . $lang . "&sessId=" . $sessId . "&gameId=" . $gameId . "&operatorId=" . $operatorId . "&pluginURL=" . $pluginURL;
            } else {
                $folder = $a->folder;
                $gameId = $a->gameId;
                $outer_url = $main_url . "games/" . $folder . "/game/" . $gameId . ".php?staticServer=" . $staticServer . "&lobbyURL=" . $lobbyURL . "&server=" . $server . "&lang=" . $lang . "&sessId=" . $sessId . "&gameId=" . $gameId . "&operatorId=" . $operatorId . "&pluginURL=" . $pluginURL;
            }
        } elseif ($a->msg == 1) {
            $folder = "FairyRed";
            $gameId = "fairyred";
            $outer_url = $main_url . "games/" . $folder . "/game/" . $gameId . ".php?staticServer=" . $staticServer . "&lobbyURL=" . $lobbyURL . "&server=" . $server . "&lang=" . $lang . "&sessId=" . $sessId . "&gameId=" . $gameId . "&operatorId=" . $operatorId . "&pluginURL=" . $pluginURL;
        } else $outer_url = $main_url . "meow/login.php";

        header("Location: $outer_url");

        return ($buffer);
    }

    ob_start("callback");
    $platform = "mobile";
    include("mobile_auth.php");
    ob_end_flush();
}

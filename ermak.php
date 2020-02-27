<?
if ($_GET['gohome'] == 1) header("Location: /");
else
	header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>

<head>
	<script src='/games/lobby/js/jquery-3.3.1.min.js'></script>
	<script src="https://vk.com/js/api/xd_connection.js?2" type="text/javascript"></script>
</head>

<body style='text-align:center;padding-top:50px;' id='body'>
	<script type="text/javascript">
		VK.init(function() {
			VK.api("users.get", "", function(data) {
				var e = {
					ajaxurl: "/mobile_auth.php"
				};
				jQuery.post(e.ajaxurl, {
						user_id: data.response[0].id,
						access_token: '<? echo $_GET['access_token']; ?>'
					}, function(e) {
						var o = {},
							w = '';
						o = JSON.parse(e);
						var i = data.response[0].id;
						i = 'VK' + i;
						var folder = o.folder,
							gameId = o.gameId,
							lang = o.lang,
							lobbyUrl = "worlds2.php";
						if (o.msg == '1') {
							folder = "FairyRed";
							gameId = "fairyred";
							lobbyUrl = "pi.php";
							lang = "ru";
						}
						if (o.msg == '2') {
							if (o.activity > 21600) {
								folder = "lobby_html", gameId = "lobby";
							}

						}
						if (o.msg == '3') {
							console.log('no access token, but session');
						}
						w = 'https://ermak.xyz/games/' + folder + '/game/' + gameId + '.php?social=vk&staticServer=https%3A%2F%2Fermak.xyz%2F&lobbyURL=https%3A%2F%2Fermak.xyz%2Fermak_mobile.php%3Fgohome%3D1&server=https%3A%2F%2Fermak.xyz%2F&lang=' + lang + '&sessId=' + i + '&gameId=' + gameId + '&pluginURL=https%3A%2F%2Fermak.xyz%2Fgames%2Flobby%2F' + lobbyUrl + '%3Fid%3D' + i;
						if (o.msg == '4') w = 'https://ermak.xyz/maintenance.php?w=0';

						if (o.msg == '1' || o.msg == '2' || o.msg == '5') {
							if (document.cookie == 'undefined' || document.cookie == '' || o.msg == '5') {
								VK.callMethod('resizeWindow', $(document).width(), $(document).height());
								$("body").append("<div style='position: absolute;left:0px;top:0px;'><table border=0 width=100% height=100%><tr><td align=center><img width=100% src='/games/lobby/images/Auth/Bear-speach.png'></td><tr><td align=center></table></div>");
								$("body").append("<div style='position: absolute;right:-30px;bottom:" + ($(document).height() / 3) + "px;z-index:9999;'><a href='trick.php' target='_top'><img  class='a' src='/games/lobby/images/Auth/Button_up.png'></a></div>");
								$('.a').on({
									'click': function() {
										$('.a').attr('src', '/games/lobby/images/Auth/Button_down.png');
									}
								});
								o.msg = 5;
							}
						}

						if (o.msg != '5') window.location = w + '&operatorId=wincastle';
					})
					.fail(function() {
						alert('cant auth');
					})

			})
		}, function() {
			// API initialization failed 
			// Can reload page here 

		}, '5.92');
	</script>
</body>

</html>
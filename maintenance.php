<?
session_start();
header('Content-type: text/html; charset=utf-8');
?>
<html>
<h1>
    ПРИЛОЖЕНИЕ НА ТЕХОБСЛУЖИВАНИИ
</h1>
<p>
    Ориентировочное время окончания: 17:30 МСК
</p>
<p>
    <? echo $_SESSION['my_valid_user']; ?>
</p>
<script>
    //alert(document.cookie);
</script>

</html>
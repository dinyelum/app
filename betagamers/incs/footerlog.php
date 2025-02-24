<footer>
<div class= "footer">
<div class= "footerlinks">
<ul>
<?php
if(isset($_SESSION['users']["logged_in"]) && $_SESSION['users']["logged_in"] === true){
	echo '<li><a href="/tips/profile.php">My Profile</a></li>
	<li><a href="/loginsystem/logout.php">Logout</a></li>';
} else {
echo '<li><a href="/loginsystem/mainregform.php">Register</a></li>
<li><a href="/loginsystem/mainlogin.php">Login</a></li>';
}
ob_end_flush();
?>
<li><a href= "/free_predictions/">Free Tips</a></li>
<li><a href= "/support">Contact Us</a></li> 
</ul>
</div>
<div class= "footercop">
<p><a href= "/">Copyright &copy; <?=date('Y')?> The BetaGamers Group</a></p>
</div>
</div>
</footer>
<!-- <script src="/js/basic2.js"></script> -->
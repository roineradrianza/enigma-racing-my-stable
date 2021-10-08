<?php 
if ($page == "login" OR $page == "register") {
	require_once "model/Member.php"; 
}
else{
	require_once "../model/Member.php"; 
}
$member = new Member();

$isLoggedIn = false;
if (!empty($_SESSION["userID"])) {
    $isLoggedIn = true;
}
else if (! empty($_COOKIE["u"]) && ! empty($_COOKIE["p"]) && $isLoggedIn == false){
	if ($_COOKIE["u"] != "" && $_COOKIE["p"] != "") {
		$verify = $member->verify($_COOKIE["u"], $_COOKIE["p"]);
		$fetch=$verify->fetch_object();
		if (isset($fetch) AND $fetch->memberID > 0) {

			$_SESSION['userID']=$fetch->memberID;
			$_SESSION['name']=$fetch->fullname;
			$_SESSION['status']=$fetch->status ? 'verified':'unverified';
			$_SESSION['email']=$fetch->email;
			$_SESSION['position']=$fetch->position;
			$isLoggedIn = true;

		}
		else{
			$isLoggedIn = false;
		}
	}
}
?>
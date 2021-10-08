<?php 
//database connection
require "connection.php";

Class Member
{
	public function __construct()
	{

	}
	public function list_member(){
		$sql = "SELECT * FROM members ORDER BY status ASC";
		return executeQuery($sql);
	}
	public function list_admin_emails(){
		$sql = "SELECT email FROM members WHERE position = 'admin' ";
		return executeQuery($sql);
	}
	//Method to register members
	public function register($fullname,$email,$password){
		$sql = "INSERT INTO members (fullname, email, emailRegistered, password) VALUES('$fullname','$email','$email','$password')";
		//return executeQuery($sql);
		$syndicateNewID=executeQueryReturnID($sql);

		return $syndicateNewID;
	}
	public function resetPasswordRequest($email,$token){
		$sql = "SELECT COUNT(email) as 'emailNumber' FROM members WHERE email = '$email' ";
		$verifyEmail = executeQueryReturnRow($sql);
		$fetch = (array) $verifyEmail;
		if ($fetch['emailNumber'] == 1) {
			$sql = "UPDATE members SET resetCode ='$token' WHERE email = '$email' ";
			$query = executeQuery($sql);
		}
		else{
			$query = false;
		}
		return $query;
	}	
	public function resetPassword($token,$password){
		$sql = "UPDATE members SET password ='$password', resetCode='' WHERE resetCode ='$token' ";
		$query = executeQuery($sql);
		return $query;
	}
	//Method to create members and assign their position being the administrator
	 public function create_member($fullname,$email,$password,$position){
		$sql = "INSERT INTO members (fullname,email,emailRegistered, password,position) VALUES('$fullname','$email','$email','$password','$position')";
		//return executeQuery($sql);
		$syndicateNewID=executeQueryReturnID($sql);

		return $syndicateNewID;
	}	
	//Method to show more specify information about an member
	public function show($memberID){
		$sql = "SELECT * FROM members WHERE memberID = '$memberID'";
		return executeQueryReturnRow($sql);
	}
	//Method to edit members
	public function edit($memberID,$fullname,$email,$position){
		$sql = "SELECT * members WHERE email = '$email'";
		if (executeQuery($sql) > 0) {
		$sql = "UPDATE members SET fullname='$fullname',position='$position' WHERE memberID = '$memberID'";
		executeQuery($sql);
		}
		else{
			$sql = "UPDATE members SET fullname='$fullname',email='$email',position='$position' WHERE memberID = '$memberID'";
			executeQuery($sql);
		}
		$sw=true;
		return $sw;

	}	
	public function edit_P($memberID,$fullname,$email,$password,$position){
		$sql = "SELECT * members WHERE email = '$email'";
		if (executeQuery($sql) > 0) {
			$sql = "UPDATE members SET fullname='$fullname',password='$password' WHERE memberID = '$memberID'";
			executeQuery($sql);
		}
		else{
			$sql = "UPDATE members SET fullname='$fullname',email='$email',password='$password' WHERE memberID = '$memberID'";
			executeQuery($sql);
		}

		$sw=true;

		return $sw;

	}	
	public function verify_user($memberID){
			$sql = "UPDATE members SET status=1 WHERE memberID = '$memberID'";
			return executeQuery($sql);
	}
	public function unverify_user($memberID){
			$sql = "UPDATE members SET status=0 WHERE memberID = '$memberID'";
			return executeQuery($sql);
	}
	public function delete ($memberID){
		$sql = "DELETE FROM members WHERE memberID=$memberID";
		return executeQuery($sql);
	}
	//Method to verify the member who is try to log in
	public function verify($login,$password){
  	$sql = "SELECT * FROM members WHERE email='$login' AND password='$password'"; 
  	return executeQuery($sql);  
  }
}

?>
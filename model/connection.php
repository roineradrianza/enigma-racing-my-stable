<?php 

$connection = new mysqli('localhost','root','','enigmaracing');

mysqli_query( $connection, 'SET NAMES "utf8"');

//It shows the error if there any
if (mysqli_connect_errno())
{
	printf("Failed to connect to the databse, for more information, you show the following error to the Developer taking a screenshot of the error or copying it: %s\n",mysqli_connect_error());
	exit();
}

if (!function_exists('executeQuery'))
{
	function executeQuery($sql)
	{
		global $connection;
		$query = $connection->query($sql);
		return $query;
	}

	function executeQueryReturnRow($sql)
	{
		global $connection;
		$query = $connection->query($sql);		
		$row = $query->fetch_assoc();
		return $row;
	}

	function executeQueryReturnID($sql)
	{
		global $connection;
		$query = $connection->query($sql);		
		return $connection->insert_id;			
	}

	function cleanString($str)
	{
		global $connection;
		$str = mysqli_real_escape_string($connection,trim($str));
		return htmlspecialchars($str);
	}
}
?>
<?php
class DBController
{
	private $host = "leeyunhong-database.ctkzjljmwfwu.us-east-1.rds.amazonaws.com";
	private $user = "admin";
	private $password = "Admin123";
	private $database = "leeyunhong_database";
	private $conn = "";

	/*# composer dependencies 
	require 'vendor/autoload.php';
	use Aws\S3\S3Client;  
	use Aws\Exception\AwsException;

	$config = [ 
	's3-access' => [ 
		'key' => 'ASIATJFO5JO5DOR66CNN', 
		'secret' => 'DRlxwL92aAF6rEZgs32o53b9N44pQpGcJttUdnmj', 
		'bucket' => 'leeyunhong-bucket', 
		'region' => 'us-east-1', 
		'version' => 'latest', 
		'acl' => 'public-read', 
		'private-acl' => 'private' 
	] 
	]; 

	# initializing s3 
	$s3 = Aws\S3\S3Client::factory([ 
	'credentials' => [ 
	'key' => $config['s3-access']['key'], 
	'secret' => $config['s3-access']['secret'] 
	], 
	'version' => $config['s3-access']['version'], 
	'region' => $config['s3-access']['region'] 
	]); 
*/
	function __construct()
	{
		$this->conn = $this->connectDB();
	}

	function connectDB()
	{
		$conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
		return $conn;
	}

	function runQuery($query)
	{
		$result =  mysqli_query($this->conn, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		if (!empty($resultset))
			return $resultset;
	}

	function numRows($query)
	{
		$result  = mysqli_query($this->conn, $query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;
	}

	function executeQuery($query)
	{
		$result  = mysqli_query($this->conn, $query);
		return $result;
	}
}

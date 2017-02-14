#!/usr/local/bin/php
<?php
date_default_timezone_set('America/Los_Angeles');
$database = "dbfight.db";
try
{
	$db = new SQLite3($database);
}
catch (Exception $exception)
{
	echo '<p>There was an error connecting to the database!</p>';

    if ($db)
    {
        echo $exception->getMessage();
    }
}
$table = "fightdata";
$field1 = "id";
$field2 = "vote";
$sql= "CREATE TABLE IF NOT EXISTS $table (
$field1 varchar(10),
$field2 varchar(10)
)";
$result = $db->query($sql);
$id = 0;
if (isset($_GET['id']))
{
	$id = $_GET['id'];
}
if (isset($_GET['vote']))
{
	$vote = $_GET['vote'];
	$sql="INSERT INTO $table ('$field1', '$field2')
	VALUES('$id', '$vote')";
	$result = $db->query($sql);
}
$question_arr[0] = 0;
$question_arr[1] = 0;
$question_arr[2] = 0;
$question_arr[3] = 0;
$sql = "SELECT * FROM $table";
$result = $db->query($sql);
//actually update the results, adds up votes from database
while($record = $result->fetchArray()){	

if ($record[$field1] == $id){
	if ($record[$field2] == "opp_1")
	{
		$question_arr[0]++;
	}	
	else if ($record[$field2] == "opp_2")
	{
		$question_arr[1]++;
	}
	else if ($record[$field2] == "opp_3"){
		$question_arr[2]++;
	}
	else if ($record[$field2] == "opp_4"){
		$question_arr[3]++;
	}
}
}
foreach($question_arr as $key=>$val)
	{
	print "$val". ";";
	}
?>
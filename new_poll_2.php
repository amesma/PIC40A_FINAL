#!/usr/local/bin/php
<?php
date_default_timezone_set('America/Los_Angeles');
$database = "dbquestion.db";
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

$answer3 = "not_set";//initially answer 3 and 4 are not set
$answer4 = "not_set";

$table = "questiondata";
$field1 = "poll_id";
$field2 = "question";
$field3 = "answer1";
$field4 = "answer2";
$field5 = "answer3";
$field6 = "answer4";

$sql= "CREATE TABLE IF NOT EXISTS $table (
$field1 varchar(10),
$field2 varchar(100),
$field3 varchar(100),
$field4 varchar(100),
$field5 varchar(100),
$field6 varchar(100))";

$result = $db->query($sql);
if (isset($_GET['poll_id']))
{
	$poll_id = $_GET['poll_id'];
}
if (isset($_GET['question']))
{
	$question = $_GET['question'];
}
if (isset($_GET['opp1']) && isset($_GET['opp2']))
{
	$answer1 = $_GET['opp1'];
	$answer2 = $_GET['opp2'];
}

if (isset($_GET['opp3']))
{
	$answer3 = $_GET['opp3'];
}
if (isset($_GET['opp4']))
{
	$answer4 = $_GET['opp4'];
}
$sql="INSERT INTO $table ('$field1', '$field2', '$field3', '$field4', '$field5', '$field6')
	VALUES('$poll_id', '$question', '$answer1', '$answer2', '$answer3', '$answer4')";
	$result = $db->query($sql);
	
$sql = "SELECT * FROM $table";
$result = $db->query($sql);

$question_arr;
//this loop will check which values are outputted
while($record = $result->fetchArray()){	
	if ($record[$field1] == $poll_id)//checks to make sure id's match
	{
		$question_arr[0] =$record[$field2];
		$question_arr[1] = $record[$field3];
		$question_arr[2] = $record[$field4];
		if ($record[$field4] != "not_set") //makes sure option 3 exists
		{
			$question_arr[3] = $record[$field5];
		}
		if ($record[$field4] != "not_set") //makes sure option 3 exists
		{
			$question_arr[4] = $record[$field6];
		}
	}
}
foreach($question_arr as $key=>$val)
	{
		print "$val" . ";";
	}
//print out array to give values to Ajax to use JAVASCRIPT to use DOM to write in pollform
?>
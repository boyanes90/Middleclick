<?php
ob_start();
include ('Include/common.php');
mydoctype();
myheader();
$html = "";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
		session_start();

		if ( (!empty($_POST['name'])) &&
		(!empty($_POST['password'])) ) {

		$username = $_POST['name'];
		$password = $_POST['password'];

		if ($dbc = @mysql_connect('buffalogrove.sat.iit.edu:3306','iituser','-8iituser!'))  {

		$dbName = 'middleclik';
		if (mysql_selectdb($dbName,$dbc)) {
		$query = "SELECT * FROM users WHERE username=\"$username\" AND password=\"$password\"";
		$result = mysql_query($query,$dbc);

		if ($result) {
		if (mysql_num_rows($result)==1) {

		$row= mysql_fetch_array($result, MYSQL_ASSOC);

		$_SESSION['username']=$row['username'];
		$_SESSION['password']=$row['password'];
		$_SESSION['company']=$row['company'];
		$_SESSION['logged']=TRUE;

		if (($_SESSION['company'])=='middleclik') {

		header('Location: ./Administration/admin.php');

		} else if (!file_exists("./Content/{$_SESSION['company']}/")) { //Check if the company uploaded anything

		print "Your company haven't uploaded any files";

		} else {

		$Dir = "./Content/{$_SESSION['company']}/";
		$images = glob($Dir . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
		$snippet = glob($Dir . '*.{html,HTML}', GLOB_BRACE);
		$csv = glob($Dir . '*.{csv,CSV}', GLOB_BRACE);
		$len1=count($images);
		$len2=count($snippet);

		for ($i = 0; $i < $len1; $i++) {
			$num1 = $images[$i];
			$html .= "<img src = \"$num1\"><br />";
		}

		for ($i = 0; $i < $len2; $i++) {
		$num2 = $snippet[$i];
		$html .= "<iframe src = \"$num2\">";
		}

		if (!empty($csv)) {
		$datum = getCsv($csv[0]);

		print "<table>";
		foreach($datum as $row => $dataInRow)
		{
			$columType = "td";
			if ($row == 0)
				$columType = "th";
			
			print "<tr>";
			foreach($dataInRow as $columnValue)
			{
				print "<$columType>".$columnValue."</$columType>";
			}
			print "</tr>";
		}
		print "</table>";

		}
		$html .= "</br ><a href=\"./Include/logout.php\">Log Out</a>"; //Log out 
		} 
		} else {
		print "Username/Password combination incorrect!";
		}
		}

		mysql_close($dbc);

		} 
		} else {

		print 'Could not connect to MySQL'.mysql_error();

		}
		}
		else {
		print "Please, write the fields!";
		}
		mybody($html);
		myfooter();
		ob_end_flush();
		exit();
		}

		$html .= "<b><h1>Welcome to Middleclik</h1></b>";
		$html .= "<form action=\"index.php\" method=\"post\">";
		$html .= "<p>User name: <input type=\"text\" name=\"name\" size=\"30\" /></p>";
		$html .= "<p>Password: <input type=\"password\" name=\"password\" size=\"30\" /></p>";
		$html .= "<input type=\"submit\" name=\"submit\" value=\"Submit\" /><br/ ><br /><br/ >";

mybody($html);
myfooter();
ob_end_flush();
?>
<?php
	ob_start();
	include ('../Include/common.php');
	mydoctype();
	myheader();
	$html = "";
	session_start();

	if (isset($_SESSION['logged']) && ($_SESSION['logged']=TRUE)) { //If the user has logged under middleclik user

	if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

	$directory = $_POST['cname'];
	$file_name = $_POST['mcname'];
	$html_text = $_POST['html'];
	$csvname = "marketing";

	if ((empty($directory)) || (empty($file_name))) { //Check comany and campaign name

	print "Please, enter your Company and your Marketing Campaign Name";

	}  else if (!(is_uploaded_file($_FILES['the_file'] ['tmp_name'])) && (empty($html_text )) && !(is_uploaded_file($_FILES['the_csv'] ['tmp_name']))) { //Check html, image or csv

	 print "Please, enter at least an IMAGE, CSV or HTML!";

	} 

	else {

	//Create the directory in Content folder if it doesn't exist yet
	if (!file_exists('../Content/'.$directory)) {
	mkdir('../Content/'.$directory); 
	}

	//Get file extension
	$ext_img = pathinfo($_FILES['the_file']['name'], PATHINFO_EXTENSION);
	$ext_csv = pathinfo($_FILES['the_csv']['name'], PATHINFO_EXTENSION);

	if ((!empty($html_text))) {	//Check if there is html text written
	if (!file_exists("../Content/$directory/$file_name.html")) {  // Check if the html doesn't exist
	//Write the html file
	$file = "../Content/".$directory."/".$file_name;
	file_put_contents($file.".html", $html_text);
	} else {
	print "You have already uploaded an html code related to this Marketing Campaign!";
	}
	}

		// Try to move the uploaded file:
		if (!file_exists("../Content/$directory/$file_name.$ext_img")) { //If  the image doesn't exist
		
		if (move_uploaded_file ($_FILES['the_file']['tmp_name'], "../Content/$directory/$file_name.$ext_img")) {
		
			print '<p>Your image has been uploaded.</p>';
		
		}
		} else {
		print "You have already uploaded an image related to this Marketing Campaign!";
		}
		
		if (!file_exists("../Content/$directory/$csvname.$ext_csv")) { //If the csv file doesn't exist
		
		if (move_uploaded_file ($_FILES['the_csv']['tmp_name'], "../Content/$directory/$csvname.$ext_csv")) {
		
			print '<p>Your CSV file has been uploaded.</p>';
		
		} 
		} else {
		print "You have already uploaded a CSV file";
		}	
	}
	}

	$html = "<form action=\"admin.php\" enctype=\"multipart/form-data\" method=\"post\">";
	$html .= "<p>Upload an IMAGE:</p>";
	$html .= "<p><input type=\"file\" name=\"the_file\" /></p>";
	$html .= "<p>HTML text:</p>";
	$html .= "<textarea name=\"html\" rows=\"5\" cols=\"30\" placeholder=\"Enter your HTML here.\">";
	$html .= "</textarea>";
	$html .= "<br />";
	$html .= "<p>Upload a CSV file:</p>";
	$html .= "<p><input type=\"file\" name=\"the_csv\" /></p>";
	$html .= "<p>Company Name: <input type=\"text\" name=\"cname\" size=\"30\" /></p>";
	$html .= "<p>Marketing Campaign Name: <input type=\"text\" name=\"mcname\" size=\"30\" /></p>";
	$html .= "<p><input type=\"submit\" name=\"submit\" value=\"Submit\" /></p>";
	$html .= "</form>";
	$html .= "</br ><a href=\"../Include/logout.php\">Log Out</a>"; //Log out 

	} else { //If you are not middleclik user

	print "You are not a middleclik user!!";

	}

	mybody($html);
	myfooter();
	ob_end_flush();

?>
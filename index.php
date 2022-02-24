<?php
require "classes/PageClass.php";

class Index extends Page{
	protected function GetContent(){
		$output = "<!-- First Parallax Image with Logo Text -->";

		$output .= "<div class='bgimg-1 w3-display-container w3-opacity-min' id='home'>";
			$output .= "<div class='w3-display-middle' style='white-space:nowrap;'>";
			if (isset($_SESSION["username"])) {
				$username = $_SESSION["username"];
				$output .= "<span class='w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity'>DOBRODOŠLI ".strtoupper($username)."</span>";
			}else{
				$output .= "<span class='w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity'>DOBRODOŠLI U ALGEBRA CONNECT</span>";
			}
			$output .= "</div>";
		$output .= "</div>";
		
		return $output;
	}
	
	protected function PageRequiresAuthenticUser(){
		return false;
	}
}

$site = new Index();
$site->Display('AlgebraConnect - Index');

?>

<!--https://www.w3schools.com/w3css/tryit.asp?filename=tryw3css_templates_parallax&stacked=h-->
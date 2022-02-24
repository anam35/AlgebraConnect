<?php
require "classes/PageClass.php";

class Registracija extends Page{
	protected function GetContent(){
		$this->HandleFormData();
		
		$output = "<!-- Third Parallax Image with Registration Form -->";

		$output .= "<div class='bgimg-3 w3-display-container w3-opacity-min' id='register'>";
			$output .= "<div class='w3-display-middle' style='white-space:nowrap;'>";
				$output .= "<form method='POST'>";
					$output .= "<div class='w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity'>";
						$output .= "<label>Korisničko ime:</label>";
						$output .= "<input type='text' name='un'/>";
						$output .= "<label>Zaporka:</label>";
						$output .= "<input type='password' name='p1'/>";
						$output .= "<label>Ponovljena zaporka:</label>";
						$output .= "<input type='password' name='p2'/>";
						$output .= "<input type='submit' name='btnSub' value='Registriraj se'/>";
					$output .= "</div>";
				$output .= "</form>";
			$output .= "</div>";
		$output .= "</div>";
		
		return $output;
	}
	
	private function HandleFormData(){
		if(!isset($_POST["btnSub"])){
			return;
		}
		
		if($_POST["p1"] !== $_POST["p2"]){
			echo "Zaporke se moraju poklapati!";
			return;
		}
		
		$username = $_POST["un"];
		$password = $_POST["p1"];
		$this->_authenticator->CreateUser($username, $password);
		
		$this->_authenticator->AuthenticateUser($username, $password);
		
		if($this->_authenticator->UserIsAuthentic())
			$this->BackToLanding();
	}
	
	protected function PageRequiresAuthenticUser(){
		return false;
	}
}

$site = new Registracija();
$site->Display('AlgebraConnect - Registracija');

?>
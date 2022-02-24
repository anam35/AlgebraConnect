<?php
require "classes/PageClass.php";

class Prijava extends Page{
	protected function GetContent(){
		$this->HandleFormData();
		
		$output = "<!-- Second Parallax Image with Login Form -->";

		$output .= "<div class='bgimg-2 w3-display-container w3-opacity-min' id='login'>";
			$output .= "<div class='w3-display-middle' style='white-space:nowrap;'>";
				$output .= "<form method='POST'>";
					$output .= "<div class='w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity'>";
						$output .= "<label>Korisničko ime:</label>";
						$output .= "<input type='text' name='un'/>";
						$output .= "<label>Zaporka:</label>";
						$output .= "<input type='password' name='pw'/>";
						$output .= "<input type='submit' name='btnSub' value='Prijavi se'/>";
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
		
		$username = $_POST["un"];
		$password = $_POST["pw"];
		
		$this->_authenticator->AuthenticateUser($username, $password);
		
		if($this->_authenticator->UserIsAuthentic()){
			$this->BackToLanding();
		}else{
			echo "Neuspjela prijava!";
		}
	}
	
	protected function PageRequiresAuthenticUser(){
		return false;
	}
}

$site = new Prijava();
$site->Display('AlgebraConnect - Prijava');

?>
<?php
require "classes/PageClass.php";

class Postavke extends Page{
	protected function GetContent(){
		$this->HandleFormData();
		
		$output = "<!-- Fourth Parallax Image with Login Form -->";

		$output .= "<div class='bgimg-4 w3-display-container w3-opacity-min' id='settings'>";
			$output .= "<div class='w3-display-middle' style='white-space:nowrap;'>";
				$output .= "<form method='POST'>";
					$output .= "<div class='w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity'>";
						$output .= "<label>Stara zaporka:</label>";
						$output .= "<input type='password' name='p0'/>";
						$output .= "<label>Nova zaporka:</label>";
						$output .= "<input type='password' name='p1'/>";
						$output .= "<label>Ponovljena nova zaporka:</label>";
						$output .= "<input type='password' name='p2'/>";
						$output .= "<input type='submit' name='btnSub' value='Promijeni zaporku'/>";
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
		
		if($_POST["p0"] == $_POST["p1"]){
			echo "<div class='w3-display-topmiddle' style='white-space:nowrap; color:red; padding-top:12rem; z-index: 1;'>";
				echo "<strong>Nova zaporka ne može biti jednaka trenutačnoj zaporci!</strong>";
			echo "</div>";
			return;
		}else if($_POST["p1"] !== $_POST["p2"]){
			echo "<div class='w3-display-topmiddle' style='white-space:nowrap; color:red; padding-top:15rem; z-index: 1;'>";
				echo "<strong>Zaporke se moraju poklapati!</strong>";
			echo "</div>";
			return;
		}
		
		$id = $this->_authenticator->GetCurrentUserId();
		$newPassword = $_POST["p1"];
		
		$this->_authenticator->ChangeUserPassword($id, $newPassword);
		
		echo "<div class='w3-display-topmiddle' style='white-space:nowrap; color:red; padding-top:15rem; z-index: 1;'>";
			echo "<strong>Zaporka promijenjena!</strong>";
		echo "</div>";
	}
	
	protected function PageRequiresAuthenticUser(){
		return true;
	}
}

$site = new Postavke();
$site->Display('AlgebraConnect - Moje postavke');

?>
<?php 
session_start();

require "AuthSystem.php";

abstract class Page{
	public $_authenticator;
	public $_database;

	public function __construct(){
		$dsn = "mysql:host=localhost;dbname=algebracontacts";
		$user = "root";
		$pass = "";

		$this->_authenticator = new AuthSystem($dsn, $user, $pass, null);

		$this->_database = new PDO($dsn, $user, $pass, null);
	}

	public function Display($title){
		if ($this->PageRequiresAuthenticUser() && !$this->UserIsAuthenticated()){
			$this->BackToLanding();
		}

		echo "<!DOCTYPE html>";
		echo "<html lang='hr'>";
			echo $this->GetHead($title);
			echo "<body>";
				echo $this->GetNavigation();
				echo $this->GetContent();
			echo "</body>";
		echo "</html>";
	}

	public function BackToLanding(){
		header("Location: index.php");
	}

	private function UserIsAuthenticated(){
		return $this->_authenticator->UserIsAuthentic();
	}

	private function GetHead($title){
		$output = "";
		$output .= "<head>";
		$output .= "<meta charset='utf-8'>";
		$output .= "<title>$title</title>";
		$output .= "<meta name='viewport' content='width=device-width, initial-scale=1'>";
		$output .= "<link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'>";
		$output .= "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato'>";
		$output .= "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>";
		$output .= "<link rel='stylesheet' href='./css/style.css'>";
		$output .= "</head>";

		return $output;
	}

	private function GetNavigation(){
		$output = "<!-- Navbar (sit on top) -->";

		$output .= "<div class='w3-top'>";
			$output .= "<div class='w3-bar' id='myNavbar'>";
				$output .= "<a class='w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right' href='javascript:void(0);' onclick='toggleFunction()' title='Toggle Navigation Menu'>";
					$output .= "<i class='fa fa-bars'></i>";
				$output .= "</a>";
				$output .= "<a href='index.php' class='w3-bar-item w3-button'><i class='fa fa-home'></i>  HOME</a>";
				if ($this->UserIsAuthenticated()) {
					$output .= "<a href='#contact' class='w3-bar-item w3-button w3-hide-small'><i class='fa fa-files-o'></i> MOJE DATOTEKE</a>";
					$output .= "<a href='#contact' class='w3-bar-item w3-button w3-hide-small'><i class='fa fa-cogs'></i> MOJE POSTAVKE</a>";
					$output .= "<a href='#contact' class='w3-bar-item w3-button w3-hide-small'><i class='fa fa-sign-out'></i> ODJAVA</a>";
				} else {
					$output .= "<a href='prijava.php' class='w3-bar-item w3-button w3-hide-small'><i class='fa fa-sign-in'></i> PRIJAVA</a>";
					$output .= "<a href='registracija.php' class='w3-bar-item w3-button w3-hide-small'><i class='fa fa-user-plus'></i> REGISTRACIJA</a>";
				}
			$output .= "</div>";
			
			$output .= "<!-- Navbar on small screens -->";
			$output .= "<div id='navDemo' class='w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium'>";
			if ($this->UserIsAuthenticated()) {
				$output .= "<a href='#contact' class='w3-bar-item w3-button' onclick='toggleFunction()><i class='fa fa-files-o'></i> MOJE DATOTEKE</a>";
				$output .= "<a href='#contact' class='w3-bar-item w3-button' onclick='toggleFunction()><i class='fa fa-cogs'></i> MOJE POSTAVKE</a>";
				$output .= "<a href='#contact' class='w3-bar-item w3-button' onclick='toggleFunction()><i class='fa fa-sign-out'></i> ODJAVA</a>";
			} else {
				$output .= "<a href='prijava.php' class='w3-bar-item w3-button' onclick='toggleFunction()><i class='fa fa-sign-in'></i> PRIJAVA</a>";
				$output .= "<a href='registracija.php' class='w3-bar-item w3-button' onclick='toggleFunction()><i class='fa fa-user-plus'></i> REGISTRACIJA</a>";
			}
			$output .= "</div>";
		$output .= "</div>";

		return $output;
	}

	abstract protected function PageRequiresAuthenticUser();

	abstract protected function GetContent();
}

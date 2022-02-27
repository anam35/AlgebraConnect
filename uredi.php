<?php
require "classes/PageClass.php";

class Uredi extends Page{
	protected function GetContent(){
		$this->HandleFormData();

		if(!isset($_GET["id"]) || $this->NotContactOwner($_GET["id"])){
			$this->BackToContacts();
		}
		
		$contactId = $_GET["id"];
		
		$q = "SELECT name, number FROM contacts WHERE id = $contactId ;";
		
		foreach($this->_database->query($q) as $row){
			$name = $row["name"];
			$number = $row["number"];
		}
		
		$output = "<!-- Seventh Parallax Image with Login Form -->";

		$output .= "<div class='bgimg-7 w3-display-container w3-opacity-min' id='settings'>";
			$output .= "<div class='w3-display-middle' style='white-space:nowrap;'>";
				$output .= "<form method='POST'>";
					$output .= "<div class='w3-center w3-padding-large w3-black w3-xlarge w3-animate-opacity'>";
						$output .= "<span class='w3-center w3-padding-large w3-black w3-xlarge w3-animate-opacity'>Uredi kontakt <b>$name</b>?</span><br/>";
						$output .= "<label>Ime kontakta:</label>";
						$output .= "<input type='text' name='name' value='$name'/>";
						$output .= "<label>Broj kontakta:</label>";
						$output .= "<input type='text' name='number' value='$number'/>";
						$output .= '<input type="hidden" name="contactId" value="'.$contactId.'"/>';
						$output .= '<input type="hidden"  name="oldName" value="'.$name.'"/>';
						$output .= '<input type="hidden"  name="oldNumber" value="'.$number.'"/>';
						$output .= "<input type='submit' name='btnSub' value='Promijeni kontakt'/>";
						$output .= "<span style='padding-left: 10px;'><input type='submit' name='btnNot' value='Odustani'/></span>";
					$output .= "</div>";
				$output .= "</form>";
			$output .= "</div>";
		$output .= "</div>";
		
		return $output;
	}
	
	private function HandleFormData(){
		if(isset($_POST["btnSub"])){
		
			$newName = $_POST["name"];
			$oldName = $_POST["oldName"];
			$newNumber = $_POST["number"];
			$oldNumber = $_POST["oldNumber"];
			$id = $_POST["contactId"];
			
			$q = "UPDATE contacts SET name=:name, number=:number WHERE id=:id ;";
			
			if($stmt = $this->_database->prepare($q)){
				$stmt->bindParam(":name", $newName, PDO::PARAM_STR, 255);
				$stmt->bindParam(":number", $newNumber, PDO::PARAM_STR, 20);
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
				
				if($stmt->execute()){
					$this->BackToContacts();
				}else{
					echo "<div class='w3-display-topmiddle' style='white-space:nowrap; color:red; padding-top:12rem; z-index: 1;'>";
						echo "<strong>Pogreška u izvršavanju upita!</strong>";
					echo "</div>";
				}
			}else{
				echo "<div class='w3-display-topmiddle' style='white-space:nowrap; color:red; padding-top:12rem; z-index: 1;'>";
					echo "<strong>Pogreška u pripremi upita!</strong>";
				echo "</div>";
			}
		}

		if(isset($_POST["btnNot"])){
			$this->BackToContacts();
		}
	}
	
	private function NotContactOwner($contactId){
		$ownerId = $this->_authenticator->GetCurrentUserId();
		
		$q = "SELECT 1 FROM contacts WHERE id = $contactId AND ownerId = $ownerId ;";
		
		$count = 0;
		
		foreach($this->_database->query($q) as $row){
			$count++;
		}
		
		return $count === 0;
	}
	
	protected function PageRequiresAuthenticUser(){
		return true;
	}
}

$site = new Uredi();
$site->Display("AlgebraConnect - Uredi kontakt");

?>
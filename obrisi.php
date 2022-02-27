<?php
require "classes/PageClass.php";

class Obrisi extends Page{
	protected function GetContent(){
		$this->HandleFormData();
		
		if(!isset($_GET["id"]) || $this->NotContactOwner($_GET["id"])){
			$this->BackToContacts();
		}
			
		$contactId = $_GET["id"];
		
		$q = "SELECT name FROM contacts WHERE id = $contactId ;";
		
		foreach($this->_database->query($q) as $row){
			$name = $row["name"];
		}
		
		$output = "<!-- Sixth Parallax Image with Login Form -->";

		$output .= "<div class='bgimg-6 w3-display-container w3-opacity-min' id='settings'>";
			$output .= "<div class='w3-display-middle' style='white-space:nowrap;'>";
				$output .= "<form method='POST'>";
					$output .= "<div class='w3-center w3-padding-large w3-black w3-xlarge w3-animate-opacity'>";
						$output .= "<span class='w3-center w3-padding-large w3-black w3-xlarge w3-animate-opacity'>Jeste li sigurni da želite izbrisati kontakt <b>$name</b>?</span><br/>";
						$output .= '<input type="hidden" name="contactId" value="'.$contactId.'"/>';
						$output .= "<span style='padding-right: 10px;'><input type='submit' name='btnSub' value='Da'/></span> ";
						$output .= "<span style='padding-left: 10px;'><input type='submit' name='btnNot' value='Ne'/></span>";
					$output .= "</div>";
				$output .= "</form>";
			$output .= "</div>";
		$output .= "</div>";
		
		return $output;
	}
	
	private function HandleFormData(){
		if(isset($_POST["btnSub"])){
			$contactId = $_POST["contactId"];
			
			$q = "DELETE FROM contacts WHERE id = $contactId";
			
			$this->_database->beginTransaction();
			
			if($this->_database->exec($q) !== 1){
				echo "<div class='w3-display-topmiddle' style='white-space:nowrap; color:red; padding-top:12rem; z-index: 1;'>";
					echo "<strong>Pogreška pri brisanju kontakta!</strong>";
				echo "</div>";
				$this->_database->rollBack();
				return;
			}
			
			$this->_database->commit();

			$this->BackToContacts();
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

$site = new Obrisi();
$site->Display("AlgebraConnect - Brisanje kontakta");

?>
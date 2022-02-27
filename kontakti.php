<?php
require "classes/PageClass.php";

class Moje extends Page{
	protected function GetContent(){
		$this->HandleFormData();

		$output = $this->GetContactsTable();
		
		return $output;
	}
	
	private function GetContactsTable(){
		$ownerId = $this->_authenticator->GetCurrentUserId();
		
		$q = "SELECT * FROM contacts WHERE ownerId = $ownerId";
		$count = 0;

		$output = "<!-- Fifth Parallax Image with Login Form -->";

		$output .= "<div class='bgimg-5 w3-display-container w3-opacity-min' id='settings'>";
			$output .= "<div class='w3-display-middle' style='white-space:nowrap;'>";
				$output .= "<form method='POST'>";
					$output .= "<div class='w3-center w3-padding-large w3-black w3-xlarge w3-animate-opacity'>";
						$output .= "<table class='w3-table-all'>";
							$output .= "<thead class='w3-wide'>";
								$output .= "<tr>";
									$output .= "<th>Ime</th>";
									$output .= "<th>Broj</th>";
									$output .= "<th></th>";
								$output .= "</tr>";
							$output .= "</thead>";
							$output .= "<tbody>";
							foreach($this->_database->query($q) as $row){
								$name = $row["name"];
								$number = $row["number"];
								$id = $row["id"];
								
								$ctrls = '<a href="uredi.php?id='.$id.'">Izmjeni</a> | <a href="obrisi.php?id='.$id.'">Obriši</a>';
								
								$output .= "<tr>";
									$output .= "<td>$name</td>";
									$output .= "<td>$number</td>";
									$output .= "<td>$ctrls</td>";
								$output .= "</tr>";
								
								$count++;
							}

							if($count === 0){
								$output .= "<tr>";
									$output .= "<td colspan='3'>Nemate pohranjenih kontakata.</td>";
								$output .= "</tr>";
							}
							$output .= "</tbody>";
							$output .= "<tfoot class='w3-wide'>";
								$output .= "<tr>";
									$output .= "<th colspan='4'>Novi kontakt</th>";
								$output .= "</tr>";
								$output .= "<tr>";
									$output .= "<th><input type='text' name='conName' placeholder='Novi kontakt ime'></th>";
									$output .= "<th><input type='text' name='conNumber' placeholder='Novi kontakt broj'></th>";
									$output .= "<th><input type='submit' value='Dodaj kontakt' name='btnSub' style='margin-top: 0.25rem;'/></th>";
								$output .= "</tr>";
							$output .= "</tfoot>";
						$output .= "</table>";
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

		$id = $this->_authenticator->GetCurrentUserId();
		$conName = $_POST["conName"];
		$conNumber = $_POST["conNumber"];
		
		$this->_authenticator->CreateNewContact($id, $conName, $conNumber);
		
		echo "<div class='w3-display-topmiddle' style='white-space:nowrap; color:red; padding-top:15rem; z-index: 1;'>";
			echo "<strong>Kreiran novi kontakt!</strong>";
			echo "<meta http-equiv='refresh' content='0'>";
		echo "</div>";
	}

	protected function PageRequiresAuthenticUser(){
		return true;
	}
}

$site = new Moje();
$site->Display("AlgebraConnect - Moji kontakti");

?>
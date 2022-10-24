<?php

if(isset($_GET['adresse']) && $_GET['adresse'] != '') {
	$apiUrl = "https://api-adresse.data.gouv.fr/search?q=".str_replace(" ", "+", $_GET['adresse'])."&limit=5";

	$response = file_get_contents($apiUrl, False);
	
	$data = json_decode($response);	

	if(count($data->features) != 0 ) {
		if(isset($_GET['format']) && $_GET['format'] == "json") {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data->features);
		}else {
			echo "[statut]=OK;[resultat]=";
			for($i=0;$i<count($data->features);$i++) {
				if(isset($data->features[$i]->properties->label)){ echo $data->features[$i]->properties->label; } else { echo "NULL"; };
				echo "_";
				if(isset($data->features[$i]->properties->housenumber)){ echo $data->features[$i]->properties->housenumber; } else { echo "NULL"; };
				echo "_";
				if(isset($data->features[$i]->properties->street)){ echo $data->features[$i]->properties->street; } else { echo "NULL"; };
				echo "_";
				if(isset($data->features[$i]->properties->postcode)){ echo $data->features[$i]->properties->postcode; } else { echo "NULL"; };
				echo "_";
				if(isset($data->features[$i]->properties->city)){ echo $data->features[$i]->properties->city; } else { echo "NULL"; };
				echo "/";
			};	
			echo ";";
		}
	}else {
		echo "[statut]=KO;[cause]=Aucunes adresses trouvé;";
	}
}else {
	echo "[statut]=KO;[cause]=Paramètre manquant;";
}


?>
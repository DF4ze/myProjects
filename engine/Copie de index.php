<?php

	require_once("c_bdd.php");
	require_once("c_note.php");
	

	// $_Params['bdd_user'] = "root";
	// $_Params['bdd_pwd'] = "";
	// $_Params['bdd_server'] = "127.0.0.1";
	// $_Params['bdd_base'] = "jdb_v1h";
	// $_Params['bdd_query'] = $bdd->create_query( $_Params );//"SELECT * FROM mp_projects WHERE proj = 'Web'";
	$_Params['debug'] = true;
	
	$bdd = new c_bdd( $_Params );
	
	$a_clause[0]['champ'] = 'proj';
	$a_clause[0]['valeur'] = 'Web';
	$a_clause[1]['champ'] = 'id_proj';
	$a_clause[1]['valeur'] = '2';
	// $a_clause[2]['champ'] = 'id_cat';
	// $a_clause[2]['valeur'] = '1';
	$_Params['clauses'] = $a_clause;
	$_Params['champ'] = '*';
	$_Params['table'] = 'mp_projects';
	// $_Params['order_by']['champ'] = 'proj';
	// $_Params['order_by']['sens'] = 'DESC';
	$_Params['limit']['pos'] = '0';
	$_Params['limit']['pas'] = '3';
	$bdd->query( $bdd->create_query( $_Params ));
	
	if( $bdd->is_connected() ){
		echo "Connecté<br/>";
		
		// 1ere méthode d'exploitation des résultats
		if( $result = $bdd->get_result() ){
			// Reception de la variable class 'mysqli_result' ... petit dump dessus
			var_dump( $result );
			echo "current_field : ".$result->current_field.'<br/>';
			echo "field_count : ".$result->field_count.'<br/>';
			echo "Lengths : ".var_dump($result->lengths).'<br/>';
			echo "Nb Ligne : ".$result->num_rows.'<br/>';
			//
			
			echo "<br/><br/><br/>";
			while( $data = $result->fetch_array() ){
				foreach( $data as $key => $value ){
					if( !is_numeric($key) )
						echo $key." : ".$value." --- ";
				}
				echo "<br/>";
			}
		}else
			echo "pas de résultat<br/>";
		echo '<br/><br/><br/><br/>';
		
		
		// 2eme méthode d'exploitation des résultats
		if( $result = $bdd->get_tabresult() ){
			for( $i=0; $i < count( $result ); $i++ ){
				foreach( $result[$i] as $key => $value ){
					echo $key." : ".$value." --- ";
				}		
				echo "<br/>";
			} 

		}else
			echo "pas de résultat<br/>";
	}else
		echo "Erreur de connexion";

		
		
		
		
	echo '<br/><br/><br/><br/>';
	$param['note_id'] = "1";
	$note = new c_note( $param );
		
	echo 'resultats : <br/>';
	echo $note->get_note_titre().'<br/>';
	echo $note->get_note_description().'<br/>';
	echo $note->get_note_pied().'<br/>';
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>
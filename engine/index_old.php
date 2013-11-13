<?php

	require_once("required_files.php");






	echo "<br/><br/><br/><br/><br/>";
	echo "<h1>Test c_control_arbo:</h1>";
	
	// User
	$_Params = array();
	$_Params['user'] = 'admin';
	$_Params['password'] = 'admin';
	$u_Admin = new c_access_user( $_Params );
	
	
	// Menu Gauche
	$_Params = array();
	$_Params['user'] = $u_Admin;
	$_cont_arbo = new c_control_arbo( $_Params );
	$_Params['auto_insert_left_menu'] = true;
	$_Params['menu_left_titre'] = 'Selectionnez un Projet';
	$_Params['menu_left'] = $_cont_arbo->get_tree_arbo();
	
	
	// HEAD
	$_Params['auto_insert_head'] = true;
	$_Params['titre'] = 'Titre de la page';
	$_Params['css'] = 'design.css';

	// Banniere
	$_Params['auto_insert_banniere'] = true;
	$_Params['appli_name'] = 'MyProjectv2';
	$_Params['logo_url'] = '';
	$_Params['login_action'] = 'index.php';
	$_Params['menu_banniere'][0]['texte'] = '1er';
	$_Params['menu_banniere'][0]['url'] = 'http://www.google.fr';

	// Corps
	//$_Params['auto_insert_corps_note'] = true;
	$_Params['auto_insert_corps_projet'] = true;
	// $_Params['auto_insert_corps_accueil'] = true;
	$test = new c_control_conteneur($_Params);
	
	
	echo '<h1> Type '.$test->get_type().'</h1>';
	
	
	$tab = $test->retrieve_id_up();
	foreach( $tab['projet'] as $key => $value  ){
		echo "<h1> Tab $key = ";
		foreach( $value as $key2 => $value2  ){
			echo $key.':'.$value2." ";
		} 
		echo "</h1>";
	} 
	foreach( $tab['note'] as $key => $value  ){
		echo "<h1> Tab $key : ";
		foreach( $value as $key2 => $value2  ){
			echo $value2." ";
		} 
		echo "</h1>";
	} 
	$tab = $test->retrieve_id_down();
	foreach( $tab['projet'] as $key => $value  ){
		echo "<h1> Tab $key : ";
		foreach( $value as $key2 => $value2  ){
			echo $value2." ";
		} 
		echo "</h1>";
	} 
	foreach( $tab['note'] as $key => $value  ){
		echo "<h1> Tab $key : ";
		foreach( $value as $key2 => $value2  ){
			echo $value2." ";
		} 
		echo "</h1>";
	} 	
	
	
	
	
	
	$_Params['proj_titre'] = 'Titre pour Le projet =)';
	$_Params['proj_description'] = 'proj_description proj_description proj_description proj_description proj_description proj_description <a href="dtc">sdfqwsdf sqsdfqsdf qsdfqsdf qsdf gsqgqsdfg sdfgdfgs fsdfg gsdfgsdf g</a>';
	$_Params['proj_pied'] = 'Pied du Projet';
	$_Params['onglets_haut'][0]['texte'] = 'texte1texte1texte1texte1txte1texte1tetexte1texte1texte1texte1texte1texte1t';
	$_Params['onglets_haut'][0]['lien'] = 'texte1';
	$_Params['onglets_haut'][1]['texte'] = 'texte2texte2texte2tex';
	$_Params['onglets_haut'][1]['lien'] = 'texte2';
	$_Params['onglets_haut'][2]['texte'] = 'texte3texte3texte3texte3text';
	$_Params['onglets_haut'][2]['lien'] = 'texte3';
	$_Params['onglets_haut'][3]['texte'] = 'texte4';
	$_Params['onglets_haut'][3]['lien'] = 'texte4';
	$_Params['onglets_bas'][0]['texte'] = 'texte1texte1texte1texte1texttee1texte1texte1texte1texte1t';
	$_Params['onglets_bas'][0]['lien'] = 'texte1';
	$_Params['onglets_bas'][1]['texte'] = 'texte2texte2texte2texte2texte2texte2texte2texte2texte2texte2texte2texte2';
	$_Params['onglets_bas'][1]['lien'] = 'texte2';
	$_Params['onglets_bas'][2]['texte'] = 'texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3';
	$_Params['onglets_bas'][2]['lien'] = 'texte3';
	$_Params['onglets_bas'][3]['texte'] = 'texte4texte4texte4texte4texte4texte4texte4texte4texte4texte4texte4texte4texte4';
	$_Params['onglets_bas'][3]['lien'] = 'texte4'; 


	$_Params['notes'][0]['note_titre'] = 'Titre pour La 1ere Note =)';
	$_Params['notes'][0]['note_description'] = 'La 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere Note <a href="dtc">sdfqwsdf sqsdfqsdf qsdfqsdf qsdf gsqgqsdfg sdfgdfgs fsdfg gsdfgsdf g</a>';
	$_Params['notes'][0]['note_pied'] = 'Pied de la 1ere note :)';

	$_Params['notes'][1]['note_titre'] = 'Titre pour La 2eme Note =)';
	$_Params['notes'][1]['note_description'] = 'La 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere NoteLa 1ere Note <a href="dtc">sdfqwsdf sqsdfqsdf qsdfqsdf qsdf gsqgqsdfg sdfgdfgs fsdfg gsdfgsdf g</a>';
	$_Params['notes'][1]['note_pied'] = 'Pied de la 2eme note :)';


$page = new c_page_maker( $_Params );
echo $page;
	
?>
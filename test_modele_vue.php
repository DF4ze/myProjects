<?php
session_start();

require_once( "engine/required_files.php" );


if( isset( $_GET['kill'] ) ){
	$_SESSION = array();
	session_destroy();
}
	







if( !isset( $_SESSION['init'] ) or $_SESSION['init'] == false){
	$_SESSION['init'] = false;
	// User
	$_Params_user['user'] = 'admin';
	$_Params_user['password'] = 'admin';
	$_SESSION['user'] = new c_access( $_Params_user );
	
	// Arbo
	$_Params_arbo['id'] = 1;
	$_Params_arbo['user_access'] = $_SESSION['user'];
	$_SESSION['arbo'] = new c_arbo( $_Params_arbo );
	
	//// Page
	// Head
	$_Params_page['auto_insert_head'] = true;
	$_Params_page['titre'] = 'Titre de la page';
	$_Params_page['css'] = 'design.css';
	// Banniere
	$_Params_page['auto_insert_banniere'] = true;
	$_Params_page['appli_name'] = 'MyProjectv2';
	$_Params_page['logo_url'] = '';
	$_Params_page['login_action'] = 'test_modele_vue.php';
	$_Params_page['menu_banniere'][0]['texte'] = '1er';
	$_Params_page['menu_banniere'][0]['url'] = 'http://www.google.fr';
	$_Params_page['menu_banniere'][1]['texte'] = '2eme';
	$_Params_page['menu_banniere'][1]['url'] = 'http://www.google.fr';
	$_Params_page['menu_banniere'][2]['texte'] = '3eme';
	$_Params_page['menu_banniere'][2]['url'] = 'http://www.google.fr';
	$_Params_page['menu_banniere'][3]['texte'] = '4eme';
	$_Params_page['menu_banniere'][3]['url'] = 'http://www.google.fr';
	
	////Menu gauche
	$_Params_page['auto_insert_left_menu'] = true;
	$_Params_page['menu_left_titre'] = 'Titre';

	// On récupère les ID_SONS et on boucle dessus
	$a_idsons = $_SESSION['arbo']->get_idsons();
	
	for( $i=0; $i<count( $a_idsons ); $i++ ){
		$_Params_conteneur['id'] = 	$a_idsons[$i];
		$cont = new c_conteneur( $_Params_conteneur );
		$_Params_page['menu_left'][$i]['texte'] = $cont->get_titre();
		$_Params_page['menu_left'][$i]['lien'] = 'test_modele_vue.php?conteneur='.$_Params_conteneur['id'];
		
		// On en profite pour ajouter ces liens aux onglets
		$_Params_page['onglets_haut'][$i]['texte'] = $cont->get_titre();
		$_Params_page['onglets_haut'][$i]['lien'] = 'test_modele_vue.php?conteneur='.$_Params_conteneur['id'];
	}
	// On récupère les ID_PARENTS et on boucle dessus
	$a_idparent = $_SESSION['arbo']->get_idparent();
	echo var_dump( $a_idparent );
	
	// Attention, si plusieurs résultat : Tableau, si qu'un resultat : Integer
	if( count( $a_idparent ) == 1 ){
		// Attention, s'il n'y a pas de parent : Get_parent retourne l'ID en cours.
		if( (string)$a_idparent != $_SESSION['arbo'] ){
			$_Params_conteneur['id'] = 	$a_idparent;
			$cont = new c_conteneur( $_Params_conteneur );
			$_Params_page['onglets_bas'][0]['texte'] = $cont->get_titre();
			$_Params_page['onglets_bas'][0]['lien'] = 'test_modele_vue.php?conteneur='.$_Params_conteneur['id'];	
		}
	}else
		for( $i=0; $i<count( $a_idparent ); $i++ ){
			$_Params_conteneur['id'] = 	$a_idparent[$i];
			$cont = new c_conteneur( $_Params_conteneur );
			$_Params_page['onglets_bas'][$i]['texte'] = $cont->get_titre();
			$_Params_page['onglets_bas'][$i]['lien'] = 'test_modele_vue.php?conteneur='.$_Params_conteneur['id'];		
		}
	
	//// Corps
	$_Params_conteneur = array();
	$_Params_page['auto_insert_corps_note'] = true;
	// $_Params['auto_insert_corps_accueil'] = true;

	$_Params_conteneur['id'] = 	$_SESSION['arbo'];
	$cont = new c_conteneur( $_Params_conteneur );
	$_Params_page['corps_titre'] = 'Titre du projet : '.$cont->get_titre();
	$_Params_page['corps_description'] = 'Description : '.$cont->get_description();
	$_Params_page['note_titre'] = 'Titre pour une note'.$cont->get_titre();
	$_Params_page['note_description'] = $cont->get_description();
	$_Params_page['note_pied'] = $cont->get_pied();
	
 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$_SESSION['page'] = new c_page( $_Params_page );
	
	$_SESSION['init'] = true;
	
}else
	$_SESSION['page'] = unserialize( $_SESSION['page'] );


	echo /* htmlspecialchars( */$_SESSION['page']/* ) */;



	$_SESSION['page'] = serialize( $_SESSION['page'] );


	echo '<a href="test_modele_vue.php?kill=bill">Kill</a>';
?>
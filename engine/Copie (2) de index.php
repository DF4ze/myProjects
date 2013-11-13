<?php

	require_once("required_files.php");
/* 	
	$param['id'] = "1";
	$note = new c_note( $param );
		
	if( $note->is_loaded() ){
		echo 'resultats : <br/>';
		echo 'titre : '.$note->get_titre().'<br/>';
		echo 'Decript : '.$note->get_description().'<br/>';
		echo 'Pied : '.$note->get_pied().'<br/>';
		echo 'get_pub_date : '.$note->get_pub_date().'<br/>';
		echo 'get_pub_autor : '.$note->get_pub_autor().'<br/>';
		echo 'get_edit_date : '.$note->get_edit_date().'<br/>';
		echo 'get_edit_autor : '.$note->get_edit_autor().'<br/>';
	}else
		echo 'Note non chargé<br/>';
		
		
		
		
	echo '<br/><br/><br/><br/><br/>';
	$param['id'] = "4";
	$projet = new c_projet( $param );
		
	if( $projet->is_loaded() ){
		echo 'resultats : <br/>';
		echo 'titre : '.$projet->get_titre().'<br/>';
		echo 'Decript : '.$projet->get_description().'<br/>';
		echo 'Pied : '.$projet->get_pied().'<br/>';
		echo 'get_pub_date : '.$projet->get_pub_date().'<br/>';
		echo 'get_pub_autor : '.$projet->get_pub_autor().'<br/>';
		echo 'get_edit_date : '.$projet->get_edit_date().'<br/>';
		echo 'get_edit_autor : '.$projet->get_edit_autor().'<br/>';
	}else
		echo 'Projet non chargé<br/>';
		
		
 */		






	echo "<br/><br/><br/><br/><br/>";
	echo "<strong>Test c_arbo get_roots sans aucun parametres:</strong>";
	$arbo = new c_arbo();
	$tab = $arbo->get_roots();
	foreach( $tab as $offset => $infos  ){
		echo $infos['id']." : ".$infos['niveau']."<br/>";
	}	



	echo "<br/><br/><br/><strong>liste des enfants : </strong><br/>";
	// $_Params['load_id_noeud'] = 'id_src';
	// $_Params['champ_id'] = 'id_src';
	// $_Params['table'] = 'mp_arbo';
	// $_Params['load_id_dest'] = 'id_dest';
	$_Params['id'] = 3;
	// $_Params['filter'] = 'projet';
	
	$arbo = new c_arbo($_Params);
	$sons = $arbo->get_idsons();
	foreach( $sons as $key => $value  ){
		echo " - $value<br/>";
	} 
		
	echo "<br/><br/><br/><br/><br/>";
	$result = $arbo->get_idparent();
	echo "<strong>liste des Parents pour l'id".$_Params['id']."</strong><br/>";
	// var_dump( $result );
	if( count( $result ) == 0 )
		echo " - ".$result."<br/>";
	else
		for( $i=0; $i<count( $result ); $i++ ){
			echo " - ".$result[$i]."<br/>";
		} 
		
	$result = $arbo->get_idparent( 5 );
	echo "<strong>liste des Parents pour l'id 5 </strong><br/>";
	// var_dump( $result );
	if( count( $result ) == 0 )
		echo " - ".$result."<br/>";
	else
		for( $i=0; $i<count( $result ); $i++ ){
			echo " - ".$result[$i]."<br/>";
		} 
		
/* 	$result = $arbo->get_classparent();
	
	if( count( $result ) != 0){
		echo "Il y a plusieurs résultats :<br/>";
		for( $i=0; $i < count( $result ); $i++ ){
			echo 'Id : '.$result[0]->get_id();
		} 
	}
 */		
		
		
		
		
		
		
	echo "<br/><br/><br/><br/><br/>";
	echo "<strong>Test Niveau :</strong><br/>";
	echo "Niveau dans l'ID ".$_Params['id'].' : '.$arbo->get_niveau().'<br/>';
		
		
		
		
		

	$_Params['id'] = 1;
	$arbo = new c_arbo($_Params);
	$id_a_chercher = 1;
	
	echo "<br/><br/><br/><br/><br/>";
	echo "<strong>Test Path :</strong><br/>";
	echo "depuis l'ID ".$arbo->get_id().' recherche de l\'ID '.$id_a_chercher.': <br/>';
	
	if( $arbo->get_path($id_a_chercher) ){
		echo "Trouvé : Var Path : <br/>";
		echo var_dump( $arbo->path );
	}else
		echo "pas trouvé";
	
		
		
	echo "<br/><br/><br/><br/><br/>";
	
		

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	echo "<br/><br/><br/><br/><br/>";
	echo "<strong>Test Access Groupe :</strong><br/>";
	$_Params['groupname'] = 'user_normal';
	$access = new c_access_group( $_Params );
	// $rights = $access->get_rights();
	// echo var_dump( $access->get_rights() );
	
	// foreach( $rights as $right => $value  ){
		// echo '$this->const[\'bdd_tables\'][\'group\'][\''.$right.'\'] = \'`\'.$this->const[\'bdd_tables\'][\'group\'][\'table\'].\'`.'.$right.'\';<br/>';

	// } 

	echo  "<br/>Je suis un user du groupe : ".$access->get_name()."<br/>";
	echo "Ai-je acces à la lecture des notes? ".(($access->get_right_section('access_note'))?"oui":"non")."<br/>";
	echo "Ai-je acces à l'arbo_logued? ".(($access->get_right_section('arbo_logued'))?"oui":"non")."<br/>";
	echo "Ai-je acces à l'arbo VIP? ".(($access->get_right_section('arbo_vip'))?"oui":"non")."<br/>";
	
	$_Params['groupname'] = 'admin';
	echo  "<br/><br/><br/>";
	$access = new c_access_group( $_Params );
	echo  "Je suis un user du groupe : ".$access->get_name()."<br/>";
	echo "Ai-je acces à la lecture des notes? ".(($access->get_right_section('access_note'))?"oui":"non")."<br/>";
	echo "Ai-je acces à l'arbo_logued? ".(($access->get_right_section('arbo_logued'))?"oui":"non")."<br/>";
	echo "Ai-je acces à l'arbo VIP? ".(($access->get_right_section('arbo_vip'))?"oui":"non")."<br/>";
	
	$_Params['groupid'] = '1';
	$_Params['groupname'] = '';
	echo  "<br/><br/><br/>";
	$access = new c_access_group( $_Params );
	echo  "Je suis un user du groupe : ".$access->get_name()."<br/>";
	echo "Ai-je acces à la lecture des notes? ".(($access->get_right_section('access_note'))?"oui":"non")."<br/>";
	echo "Ai-je acces à l'arbo_logued? ".(($access->get_right_section('arbo_logued'))?"oui":"non")."<br/>";
	echo "Ai-je acces à l'arbo VIP? ".(($access->get_right_section('arbo_vip'))?"oui":"non")."<br/>";
	
	echo  "<br/><br/><br/>";
	
	
	
	
	
	
	
	
	
	echo "<br/><br/><br/><br/><br/>";
	$_Params = array();
	$_Params['user'] = 'test';
	$_Params['password'] = 'test';
	echo "<strong>Test Access User: ".$_Params['user'].":".$_Params['password']."</strong><br/>";
	$user = new c_access_user( $_Params );
	
/* 	echo "Verify user = test, mdp = test : ".(($id = $user->init_user( 'test', 'test' ))? "ok ".$id : "user ou mdp incorrect").'<br/>';
	echo "Verify user = test, mdp = admin : ".(($id = $user->init_user( "test", 'admin' ))? "ok ".$id : "user ou mdp incorrect").'<br/>';
	echo "Verify user = admin, mdp = admin : ".(($id = $user->init_user( 'admin', 'admin' ))? "ok ".$id : "user ou mdp incorrect").'<br/>';
 */	
	echo "<strong>$user</strong><br/>";
	if( $user->is_logued() ){
		echo "Success log<br/>";
		echo var_dump( $user->get_profil() );
		echo var_dump( $user->get_rights() );
	}else
		echo "Faiiiiiil to log<br/>";
	
	
	
	echo "<br/><br/><br/><br/><br/>";
	$_Params = array();
	$_Params['user'] = 'test';
	$_Params['password'] = 'qsfdqsdf';
	$user = new c_access_user( $_Params );
	
	echo "<strong>".$_Params['user'].":".$_Params['password']." : $user Must be Faiiiiiil</strong><br/>";
	if( $user->is_logued() ){
		echo "Success log<br/>";
		echo var_dump( $user->get_profil() );
		echo var_dump( $user->get_rights() );
	}else{
		echo "Faiiiiiil to log Ah ah ahaaaaaaaa<br/>";
		echo var_dump( $user->get_profil() );
		echo var_dump( $user->get_rights() );
	}
	
	echo "<br/><br/><br/><br/><br/>";
	$_Params = array();
	$user = new c_access_user( $_Params );
	
	echo "<strong>Pas de parametres : $user Must be Faiiiiiil</strong><br/>";
	if( $user->is_logued() ){
		echo "Success log<br/>";
		echo var_dump( $user->get_profil() );
		echo var_dump( $user->get_rights() );
	}else{
		echo "Faiiiiiil to log $user<br/>";
		echo var_dump( $user->get_profil() );
		echo var_dump( $user->get_rights() );
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	echo "<br/><br/><br/><br/><br/>";
	echo "<h1>Test droit du user sur conteneurs:</h1>";
	$_Params = array();
	$u_Visitor = new c_access_user( $_Params );
	echo "<h2>Utilisateur Sans Parametres : '$u_Visitor'</h2>";
	if( $u_Visitor->is_logued() ){
		echo "<strong>Logued</strong><br/>";
	}else{
		echo "<strong>Faiiiil to Log</strong><br/>";
	}
	// echo "<strong>Profil</strong>";
	// echo var_dump( $u_Visitor->get_profil() );
	// echo "<strong>Droits</strong>";
	// echo var_dump( $u_Visitor->get_rights() );

/* 	$id = 4;
	echo "<h2>Arbo sur l'ID $id </h2>";
	$_Params['user'] = $u_Visitor;
	$_Params['id'] = 3;
	$arbo = new c_arbo($_Params);
 */	
	$id = 7;
 	$right = $u_Visitor->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";
	$id = 6;
 	$right = $u_Visitor->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";
	$id = 4;
 	$right = $u_Visitor->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";
	
	
	
	
	
	echo "<br/><br/><br/><br/><br/>";
	$_Params = array();
	$_Params['user'] = 'test';
	$_Params['password'] = 'test';
	
	$u_Test = new c_access_user( $_Params );
	echo "<h2>Utilisateur Avec Parametres : '$u_Test'</h2>";
	if( $u_Test->is_logued() ){
		echo "<strong>Logued</strong><br/>";
	}else{
		echo "<strong>Faiiiil to Log</strong><br/>";
	}
	$id = 7;
 	$right = $u_Test->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";
	$id = 6;
 	$right = $u_Test->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";
	$id = 4;
 	$right = $u_Test->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";

	
	
	
	echo "<br/><br/><br/><br/><br/>";
	$_Params = array();
	$_Params['user'] = 'admin';
	$_Params['password'] = 'admin';
	
	$u_Admin = new c_access_user( $_Params );
	echo "<h2>Utilisateur Avec Parametres : '$u_Admin'</h2>";
	if( $u_Admin->is_logued() ){
		echo "<strong>Logued</strong><br/>";
	}else{
		echo "<strong>Faiiiil to Log</strong><br/>";
	}
	$id = 7;
 	$right = $u_Admin->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";
	$id = 6;
 	$right = $u_Admin->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";
	$id = 4;
 	$right = $u_Admin->get_right_access_for_conteneur($id);
	echo "<h2>Acces à l'ID $id : ".(($right)?"oui":"non")."</h2>";

	






	echo "<br/><br/><br/><br/><br/>";
	echo "<h1>Test droit du user sur arbo:</h1>";
	$_Params = array();
	$_Params['id'] = 3;
	$_Params['user_access'] = $u_Visitor;
	$arbo = new c_arbo( $_Params );
	$niveau = $arbo->get_niveau();
	echo "<h2>User : ".$u_Visitor." arbo chargée à l'ID : ".$arbo->get_id()." contient $niveau niveaux</h2>";
	
	$_Params = array();
	$_Params['id'] = 3;
	$_Params['user_access'] = $u_Admin;
	$arbo = new c_arbo( $_Params );
	$niveau = $arbo->get_niveau();
	echo "<h2>User : ".$u_Admin." arbo chargée à l'ID : ".$arbo->get_id()." contient $niveau niveaux</h2>";
	
	echo "<br/><br/><br/><br/><br/>";
	echo "<strong>Test c_arbo get_roots sans aucun parametres:</strong>";
	$tab = $arbo->get_roots();
	foreach( $tab as $offset => $infos  ){
		echo $infos['id']." : ".$infos['niveau']."<br/>";
	}	
	
	
	echo "<br/><br/><br/><br/><br/>";
	echo "<h1>Test droit du user sur other user:</h1>";
	$id = 1;
	echo "<h2>User : ".$u_Visitor." droit sur User id $id (test): ".(($u_Visitor->get_right_access_for_user($id))?"oui":"non")." </h2>";
	$id = 2;
	echo "<h2>User : ".$u_Visitor." droit sur User id $id (Admin) : ".(($u_Visitor->get_right_access_for_user($id))?"oui":"non")." </h2>";
	$id = 3;
	echo "<h2>User : ".$u_Visitor." droit sur User id $id (Visitor) : ".(($u_Visitor->get_right_access_for_user($id))?"oui":"non")." </h2><br/>";
	
	$id = 1;
	echo "<h2>User : ".$u_Test." droit sur User id $id (test) : ".(($u_Test->get_right_access_for_user($id))?"oui":"non")." </h2>";
	$id = 2;
	echo "<h2>User : ".$u_Test." droit sur User id $id (Admin): ".(($u_Test->get_right_access_for_user($id))?"oui":"non")." </h2>";
	$id = 3;
	echo "<h2>User : ".$u_Test." droit sur User id $id (Visitor) : ".(($u_Test->get_right_access_for_user($id))?"oui":"non")." </h2><br/>";
	

	$id = 1;
	echo "<h2>User : ".$u_Admin." droit sur User id $id (test) : ".(($u_Admin->get_right_access_for_user($id))?"oui":"non")." </h2>";
	$id = 2;
	echo "<h2>User : ".$u_Admin." droit sur User id $id (Admin): ".(($u_Admin->get_right_access_for_user($id))?"oui":"non")." </h2>";
	$id = 3;
	echo "<h2>User : ".$u_Admin." droit sur User id $id (Visitor) : ".(($u_Admin->get_right_access_for_user($id))?"oui":"non")." </h2><br/>";
	

	
	
	
	
		echo "<br/><br/><br/><br/><br/>";
	echo "<h1>Test tools c_pile:</h1>";
	
	$pile = new c_pile( 4 );
	
	for( $i=0; $i < 5; $i++ ){
		$test = $pile[$i] = $i;
		// $pile->add( $i );
		for( $j=0; $j < $pile->count(); $j++ ){
			echo "$i : ".$pile[$j]."<br/>";
		} 
		echo "<br/>";
	} 

	unset( $pile[1] );
	for( $j=0; $j < $pile->count(); $j++ ){
		echo " $j : ".$pile[$j]."<br/>";
	} 	
	
	







	
	
	echo "<br/><br/><br/><br/><br/>";
	echo "<h1>Test c_control_arbo:</h1>";
	$_Params = array();
	$_Params['user'] = $u_Admin;
	$_cont_arbo = new c_control_arbo( $_Params );
	echo var_dump( $_cont_arbo->get_tree_arbo() );
	
	
?>
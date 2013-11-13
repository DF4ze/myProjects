<?php
/************************************************************************************************************************\
Fichier : c_access.php
Auteur : c.ortiz 
Date : 07/07/2013
Description : 
Class qui va gérer la connexion ainsi que les droits d'acces par user/groupe
\*************************************************************************************************************************/


class access_group_structure extends c_modele{
	protected $rights = array();
	
	protected function set_rights( $rights ){
		$this->rights = $rights;
	}
	public function get_rights( ){
		return $this->rights;
	}
	
	public function get_right_section( $section ){
		if( isset( $this->rights[$section] ) )
			return $this->rights[$section];
		else{
			if( $this->debug )
				echo "Droit demandé inconnu : $section<br/>";
			return false;
		}
	}
}

class access_group_frombdd extends access_group_structure{
	protected $bdd;
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		$this->bdd = new c_bdd( $_Params );
		if( $this->bdd->is_connected() ){
			if( $this->debug )
				echo "Init Group_Access : BDD Connectée<br/>";	
			
			if( isset( $_Params['groupname'] ) or isset( $_Params['groupid'] ) )
				if( isset( $_Params['groupname'] ) and $_Params['groupname'] != '' )
					$this->set_name( $_Params['groupname'] );
				else if( isset( $_Params['groupid'] ) and $_Params['groupid'] != '' )
					$this->set_id( $_Params['groupid'] );
				else
					if( $this->debug )
						echo "Warning : construct c_access parametre ['groupname'] et/ou ['groupid'] vide(s) : pas de chargement de droits<br/>";					
					
			else
				if( $this->debug )
					echo "Warning : construct c_access sans parametre ['groupname'] ou ['groupid'] : pas de chargement de droits<br/>";
		}

	}
	
	protected function load_byname( $groupname ){
		$result = $this->querying_forgroupname( $groupname );
		return $this->load_from_queryresult( $result );
	}
	protected function load_byid( $id ){
		$result = $this->querying_forid( $id );
		return $this->load_from_queryresult( $result );
	}
	
	protected function querying_forgroupname( $groupname ){
		//// Params pour la requete
		// Filtre sur le nom du groupe
		$_Params_query['clause']['champ'] = $this->const['bdd_tables']['group']['name'];
		$_Params_query['clause']['valeur'] = $groupname;
		// définition de la table a requeter.
		$_Params_query['table'] = $this->const['bdd_tables']['group']['table'];
			
		//// Création de la requete
		$query_string = $this->bdd->create_query( $_Params_query );

		//// Exécution de la requete -> retour sous format tableau.
		return $this->bdd->query_tabresult( $query_string );
	}
	protected function querying_forid( $id ){
		//// Params pour la requete
		// Filtre sur le nom du groupe
		$_Params_query['clause']['champ'] = $this->const['bdd_tables']['group']['id'];
		$_Params_query['clause']['valeur'] = $id;
		// définition de la table a requeter.
		$_Params_query['table'] = $this->const['bdd_tables']['group']['table'];
			
		//// Création de la requete
		$query_string = $this->bdd->create_query( $_Params_query );

		//// Exécution de la requete -> retour sous format tableau.
		return $this->bdd->query_tabresult( $query_string );
	}
	
	protected function load_from_queryresult( $result ){
		if( count( $result ) == 1 ){
			$this->set_rights( $result[0] );
			if( $this->debug )
				echo "GroupName Loaded<br/>";
			return true;
		}else{
			if( $this->debug )
				echo "Le nombre de Groupe retrouvé est incorrect : ".count( $result )."<br/>";
			return false;
		}
	}
	
	public function set_name( $name ){
		if( $this->bdd->is_connected() ){
			return $this->load_byname( $name );
		}else{
			if( $this->debug )
				echo "set_groupname : Non connecté BDD <br/>";
			return false;
		}
	}
	public function set_id( $id ){
		if( $this->bdd->is_connected() ){
			return $this->load_byid( $id );
		}else{
			if( $this->debug )
				echo "set_id : Non connecté BDD <br/>";
			return false;
		}
	}
	public function get_name(){
		if( isset( $this->rights['name'] ) )
			return $this->rights['name'];
		else{
			if( $this->debug )
				echo "get_groupname : Groupname non initialisé<br/>";
			return false;
		}
	}
}

class access_conteneur extends access_group_frombdd{

	public function get_right_access_for_conteneur( $id_conteneur ){
		//// Params pour la requete
		$query_string = "SELECT * FROM ".$this->const['bdd_tables']['conteneurs']['table'].", ".$this->const['bdd_tables']['group']['table']."
							WHERE ".$this->const['bdd_tables']['conteneurs']['id_right_level']." = ".$this->const['bdd_tables']['group']['id']." 
							AND ".$this->const['bdd_tables']['conteneurs']['id']." = '".$id_conteneur."'";
		
		//// Exécution de la requete -> retour sous format tableau.
		$result = $this->bdd->query_tabresult( $query_string );		

		$ok = false;
		//// Exploitation du résultat
		if( count( $result ) == 1 ){
			// nous avons trouvé une correspondance entre le group d'acces à la note et les droits d'acces 
			// Vérifion maintenant si nos droits sont >= aux droits de la note.
			if( $this->rights[$this->nom_champ($this->const['bdd_tables']['group']['right_level']) ] >= $result[0][ $this->nom_champ($this->const['bdd_tables']['group']['right_level']) ] )
				$ok = true;
		}else
			if( $this->debug )
				echo "Resultat get_right_access_for_conteneur incorrect : ".count( $result )."<br/>";
		
		return $ok;
	}

}

class c_access_group extends access_conteneur{
}






class profil_user extends c_access_group{
	protected $profil = array();
	
	protected function set_profil( $profil ){
		$this->profil = $profil;
	}
	public function get_profil(  ){
		return $this->profil;
	}
}


class login extends profil_user{
	protected $logued = false;
	
	public function __construct( $_Params = ''){
		parent::__construct( $_Params );
		
		if( isset( $_Params['user'], $_Params['password'] ) )
			$this->set_logued( $this->init_user( $_Params['user'], $_Params['password'] ));
		else{
			 $this->init_user( $this->const['rights']['defaut']['user'], $this->const['rights']['defaut']['password'] );
			 $this->set_logued( false);
		}
	}
	public function __toString(){
		if( isset( $this->profil['name'] ) )
			return $this->profil['name'];
		else
			return "Unknow";
	}
	
	/* public function only_verify_login( $user, $password ){
		if( $this->bdd->is_connected() ){
			//// Params pour la requete
			// Filtre sur le nom du groupe
			$_Params_query['clauses'][0]['champ'] = $this->const['bdd_tables']['logins']['user'];
			$_Params_query['clauses'][0]['valeur'] = $user;
			$_Params_query['clauses'][1]['champ'] = $this->const['bdd_tables']['logins']['password'];
			$_Params_query['clauses'][1]['valeur'] = $password;
			// définition de la table a requeter.
			$_Params_query['table'] = $this->const['bdd_tables']['logins']['table'];
				
			//// Création de la requete
			$query_string = $this->bdd->create_query( $_Params_query );

			//// Exécution de la requete -> retour sous format tableau.
			$result = $this->bdd->query_tabresult( $query_string );		

			//// Exploitation du résultat
			if( count( $result ) == 1 ){
				// if( $this->debug )
					// echo "User $user et son mot de passe son correct<br/>";
					
				$this->set_logued( true );
				return $result[0][$this->nom_champ($this->const['bdd_tables']['logins']['id'])];
			}else{
				// if( $this->debug )
					// echo "Le nombre de User retrouvé est incorrect : ".count( $result )."<br/>";
				return false;
			}

		}else
			if( $this->debug() )
				echo "Impossible de vérifier le compte : BDD non connectée<br/>";
	}	
	 */
	protected function verifylogin_and_loaduser( $user, $password ){
		if( $this->bdd->is_connected() ){
			//// Params pour la requete
			$query_string = "SELECT * FROM ".$this->const['bdd_tables']['logins']['table'].", ".$this->const['bdd_tables']['profils']['table']."
								WHERE ".$this->const['bdd_tables']['profils']['id_login']." = ".$this->const['bdd_tables']['logins']['id']." 
								AND ".$this->const['bdd_tables']['logins']['user']." = '".$this->bdd->escape_string($user)."'
								AND ".$this->const['bdd_tables']['logins']['password']." = '".$this->bdd->escape_string($password)."'";


			//// Exécution de la requete -> retour sous format tableau.
			$result = $this->bdd->query_tabresult( $query_string );		

			//// Exploitation du résultat
			if( count( $result ) == 1 ){
				// if( $this->debug )
					// echo "User $user et son mot de passe son correct<br/>";
					
				$this->set_logued( true );
				$this->set_profil( $result[0] );
				return $result[0][$this->nom_champ($this->const['bdd_tables']['profils']['id_group'])];
			}else{
				// if( $this->debug )
					// echo "Le nombre de User retrouvé est incorrect : ".count( $result )."<br/>";
				return false;
			}

		}else{
			if( $this->debug() )
				echo "Impossible de vérifier le compte : BDD non connectée<br/>";
				
			return false;
		}
	}
	public function init_user( $user, $password ){
		if( $id_group = $this->verifylogin_and_loaduser( $user, $password ))
			return $this->load_byid( $id_group );
		else{
			if( $id_group = $this->verifylogin_and_loaduser( $this->const['rights']['defaut']['user'], $this->const['rights']['defaut']['password'] ))
				$this->load_byid( $id_group );
			$this->set_logued( false );
			return false;
		}
			
	}
	
	protected function set_logued( $logued ){
		$this->logued = $logued;
	}
	public function is_logued(){
		return $this->logued;
	}
}

class check_right extends login{
	public function get_right_access_for_user( $id_user ){
		//// Params pour la requete
		$query_string = "SELECT * FROM ".$this->const['bdd_tables']['profils']['table'].", ".$this->const['bdd_tables']['group']['table']."
							WHERE ".$this->const['bdd_tables']['profils']['id_group']." = ".$this->const['bdd_tables']['group']['id']." 
							AND ".$this->const['bdd_tables']['profils']['id']." = '".$id_user."'";
		
		//// Exécution de la requete -> retour sous format tableau.
		$result = $this->bdd->query_tabresult( $query_string );		

		$ok = false;
		//// Exploitation du résultat
		if( count( $result ) == 1 ){
			// nous avons trouvé une correspondance entre le group d'acces à la note et les droits d'acces 
			// Vérifion maintenant si nos droits sont >= aux droits de la note.
			if( $this->rights[$this->nom_champ($this->const['bdd_tables']['group']['right_level']) ] >= $result[0][ $this->nom_champ($this->const['bdd_tables']['group']['right_level']) ] )
				$ok = true;
		}else
			if( $this->debug )
				echo "Resultat get_right_access_for_user incorrect : ".count( $result )."<br/>";
		
		return $ok;		
	}

}


class c_access_user extends check_right{
}
















class c_access extends c_access_user{
}










?>
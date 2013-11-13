<?php
/************************************************************************************************************************\
Fichier : c_arbo.php
Auteur : c.ortiz 
Date : 29/06/2013
Description : 
Class qui va gérer les strutures d'imbrication des notes/projets

Les parents sont des projets ou notes qui vont utiliser ce noeud
Les enfants s'ils sont notes : sont dans le projets
Les enfants s'ils sont projets : sont externe et necessaire a ce projet/note
\*************************************************************************************************************************/

class arbo_noeud_structure extends c_modele{
	protected $id = false;
	protected $id_noeud = false;
	protected $sons = array();
	protected $niveau = 0; // niveau d'arborescence (combien d'étage de noeud y a-t-il dans cette arbo?)
	protected $granpa; // pointeur vers le noeud racine
	
	public function get_id(){
		return $this->id;
	}
	protected function get_id_noeud(){
		return $this->id_noeud;
	}
	public function get_idsons(){
		return $this->sons;
	}
	public function get_niveau(){
		return $this->niveau;
	}
	
	protected function set_id( $id ){
		$this->id = $id;
	}
	protected function set_id_noeud( $id_noeud ){
		$this->id_noeud = $id_noeud;
	}
	protected function set_granpa( $granpa ){
		$this->granpa = $granpa;
	}
	protected function reset_niveau( ){
		$this->niveau = 0;
	}
}

class arbo_noeud_bdd extends arbo_noeud_structure{
	protected $bdd;
	protected $conteneur = false;
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		// if( isset( $_Params['granpa'] ) )
			// $this->set_granpa( $_Params['granpa'] );
		$this->set_granpa( (isset( $_Params['granpa'] ))?$_Params['granpa']:$this);
			
		$this->bdd = new c_bdd( $_Params );
		if( isset( $_Params['id'] ) )
			$this->init( $_Params['id'], $_Params );
		else
			if( $this->debug )
				echo "arbo_noeud_bdd : Pas d'ID donné à l'initialisation...<br/>";
	}
	
	protected function init( $id, $_Params = ''){
		if( $this->bdd->is_connected() ){
			// if( $this->debug )
				// echo "Init Conteneur : BDD Connectée<br/>";			
			
			// Récup du conteneur ayant l'ID $id
			$this->set_id( $id );
			$Temp_Params['id'] = $id;
			$this->conteneur = new c_conteneur( $Temp_Params );
			
			$this->sons = $this->loadby_id( $id, $_Params );
				
		}else
			if( $this->debug )
				echo "Erreur connexion bdd : pas d'initialisation de note.<br/>";
	}
	private function loadby_id( $id, $_Params ){
		$query_string = $this->loadby_id_querymaker( $id, $_Params );
		
		//// Exécution de la requete -> retour sous format tableau.
		$result = $this->bdd->query_tabresult( $query_string );
		
		if( $this->debug )
			 echo "<strong>Hello, I'm id : $id and I have ".count( $result )." sons :</strong><br/>";

		//// Exploitation des résultats. Sil y en a...
		$a_cont = array();
		if( count( $result ) != 0){
			$a_cont = $this->loadby_id_resultexploit( $result, $_Params );				
			
			// Il y a des résultats ... c'est a dire des liens ... mais peut-etre l'utilisateur actuel n'a pas acces a certain des items
			if( count( $a_cont ) )
				$this->granpa->niveau++;
		}else
			if( $this->debug ){
				echo "arbo : Il y a ".count($result)." noeud arbo avec l'ID : ".$id."<br/>";
				//echo var_dump( $result )."<br/>";
			}
			
		return $a_cont;
	}
	private function loadby_id_querymaker( $id, $_Params ){
		//// On prépare la requete
		$query_string = '';
		
		if( isset( $_Params['filter_arbo'] ) ){
			if( $this->debug )
				echo "Filtrage sur ".$_Params['filter_arbo']."<br/>";
				
			if( $_Params['filter_arbo'] == $this->const['bdd_tables']['conteneurs']['type_enum']['note']){
				$query_string = "SELECT * FROM ".$this->const['bdd_tables']['conteneurs']['table'].", ".$this->const['bdd_tables']['arbo']['table']."
								WHERE ".$this->const['bdd_tables']['arbo']['id_dest']." = ".$this->const['bdd_tables']['conteneurs']['id']." 
								AND ".$this->const['bdd_tables']['conteneurs']['type']." = '".$this->const['bdd_tables']['conteneurs']['type_enum']['note']."'
								AND ".$_Params['champ_id']." = '".$id."'";
								
			}else if( $_Params['filter_arbo'] == $this->const['bdd_tables']['conteneurs']['type_enum']['projet'] ){
				$query_string = "SELECT * FROM ".$this->const['bdd_tables']['conteneurs']['table'].", ".$this->const['bdd_tables']['arbo']['table']."
								WHERE ".$this->const['bdd_tables']['arbo']['id_dest']." = ".$this->const['bdd_tables']['conteneurs']['id']." 
								AND ".$this->const['bdd_tables']['conteneurs']['type']." = '".$this->const['bdd_tables']['conteneurs']['type_enum']['projet']."'
								AND ".$_Params['champ_id']." = '".$id."'";
			}else
				if( $this->debug )
					echo "['filter_arbo'] : Valeur non reconnue<br/>";
		}else{
			if( $this->debug )
				echo "PAS DE Filtrage <br/>";
				
			// Filtre sur l'ID
			$_Params_query['clause']['champ'] = $_Params['champ_id'];
			$_Params_query['clause']['valeur'] = $id;

			// définition de la table a requeter.
			$_Params_query['table'] = $_Params['table'];
			
			//// Création de la requete
			$query_string = $this->bdd->create_query( $_Params_query );
		}
		
		return $query_string;
	}
	protected function loadby_id_resultexploit( $result, $_Params ){ 
		// Mis en methode de facon a pouvoir la redef dans la partie gestion de droits.
		$a_cont = array();
		for( $i=0; $i < count( $result ) ; $i++ ){
			$Temp_Params = $_Params;
			$Temp_Params['id'] = $result[$i][$this->nom_champ($_Params['id_dest'])];
			$Temp_Params['granpa'] = $this->granpa;
			
			$a_cont[$i] = new c_arbo( $Temp_Params );
			$a_cont[$i]->set_id_noeud( $result[$i][$this->nom_champ($this->const['bdd_tables']['arbo']['id'])] );
			
			// $a_cont[$i] = $result[$i][$_Params['id_dest']];
		}
		return $a_cont;
	}
}

class arbo_by_const extends arbo_noeud_bdd{
	public function __construct( $_Params = '' ){
		$c = new constants();
		
		if( !isset( $_Params['table'] ) )
			$_Params['table'] = $c->const['bdd_tables']['arbo']['table'];
		if( !isset( $_Params['champ_id'] ) )
			$_Params['champ_id'] = $c->const['bdd_tables']['arbo']['id_src'];
		if( !isset( $_Params['id_node'] ) )
			$_Params['id_node'] = $c->const['bdd_tables']['arbo']['id'];
		if( !isset( $_Params['id_dest'] ) )
			$_Params['id_dest'] = $c->const['bdd_tables']['arbo']['id_dest'];

		// On force le filtrage de l'arbo avec des projets uniquement.
		if( !isset( $_Params['filter_arbo'] ) )
			$_Params['filter_arbo'] = $c->const['bdd_tables']['conteneurs']['type_enum']['projet'];
			
		parent::__construct( $_Params );
	}
}

class arbo_noeud_tools extends arbo_by_const{
	public $path = array();
	
	// Va retourner le 1er niveau de parent(s) : qui pointe vers cet item?
	public function get_idparent( $id = '' ){
		$parent = false;
		if($this->bdd->is_connected()){
			//// On prépare la requete
			// Filtre sur l'ID de l'instance actuelle sur le champ de destination.
			$_Params_query['clause']['champ'] = $this->const['bdd_tables']['arbo']['id_dest'];
			$_Params_query['clause']['valeur'] = ($id == '')?$this->get_id():$id;

			// définition de la table a requeter.
			$_Params_query['table'] = $this->const['bdd_tables']['arbo']['table'];
			
			//// Création et Exécution de la requete -> retour sous format tableau.
			$result = $this->bdd->query_tabresult( $this->bdd->create_query( $_Params_query ) );
			
			// s'il n'y a pas de parent
			if( count( $result ) == 0 and $result !== false )
				$parent = ($id == '')?$this->get_id():$id;
			// S'il y a UN parent
			else if( count( $result ) == 1 )
				$parent = $result[0][$this->nom_champ($this->const['bdd_tables']['arbo']['id_src'])];
			// S'il y a PLUSIEURS parents.
			else if( count( $result ) > 1 ){
				for( $i=0; $i < count( $result ); $i++ ){
					$parent[$i] = $result[$i][$this->nom_champ($this->const['bdd_tables']['arbo']['id_src'])];
				} 
			}
			
		}else
			if( $this->debug )
				echo "Arbo-Tools : bdd non connecté<br/>";
				
		return $parent;
	}
	protected function get_classparent(){
		$id = $this->get_idparent();
		$classparent = false;
		if( count( $id ) != 0 ){
			for( $i=0; $i < count($id); $i++ ){
				$classparent[$i] = new c_arbo( $id[$i] );
			} 
			return $classparent;
		}else if( $id != false ){
			return new c_arbo( $id );
		}
		
	}

	public function get_path( $id ){
		$path = array();
		$path[] = (String)$id;
		return $this->get_path_method( $id, $path );
	}
	protected function get_path_method( $id, $path ){
		// Si l'ID cherché est l'ID actuel ... il ne va pas trouver... donc on force a TRUE.
		if( (String)$id !=  (String)$this){
			$result = $this->get_idparent( $id );
			
			// si on a qu'un seul résultat (ou 0)
			if( count( $result ) == 1 ){
				//si l'ID donné a bien un parent
				// echo "resultat simple : Res : $result ID : $id<br/>";
				if( $result != $id ){
					if( $result != $this->get_id() ){
						$path[] = $result;
						return $this->get_path_method( $result, $path );
					}else{
						if( $this->debug )
							echo "ID $id count : ".count( $result )." path : ".var_dump( $path );

						return true;
					}
				}else{
					$path[] = false;
					return false;
				}
			}else{
				for( $i=0; $i < count( $result ) ; $i++ ){
					if( $result[$i] != $this->get_id() ){
						$ok = $this->get_path_method( $result[$i], $path );
						if( $ok ){
							$path[] = $result[$i];
							return true;
						}
					}else{
						$path[] = $result[$i];
						$this->path = $path;
						//echo "ID $id count : ".count( $result )." path : ".var_dump( $path );
						return true;
					}
				} 
			}
		}else
			return true;
		
	}
	public function am_i_on_the_path( $a_path ){
		$find = false;
		if( $a_path !== false )
		for( $i=0; $i < count( $a_path ); $i++ ){
			if( (String)$this == $a_path[$i] ){
				$find = true;
				$i = count( $a_path ); // on arrete la boucle.
			}
		}
		return $find;
	}
	
/* 	public function get_roots(){
		// va retourner un tableau avec tout les noeuds du niveau le plus elevé au niveau le plus bas.
		if( $this->bdd->is_connected() ){
			// Préparation de la query_string
			$query_string = " SELECT DISTINCT ".$this->nom_champ($this->const['bdd_tables']['arbo']['id_src'])
							." FROM ".$this->const['bdd_tables']['arbo']['table'].', '.$this->const['bdd_tables']['conteneurs']['table']
							." WHERE ".$this->const['bdd_tables']['arbo']['id_src']." = ".$this->const['bdd_tables']['conteneurs']['id']
							." AND ".$this->const['bdd_tables']['conteneurs']['type']." = '".$this->const['bdd_tables']['conteneurs']['type_enum']['projet']."'";
			//// Exécution de la requete -> retour sous format tableau.
			$result = $this->bdd->query_tabresult( $query_string );
			
			$a_niveaux = false;
			if( count( $result ) ){
				// Si nous avons des resultats, alors on va récup les Niveaux.
				$a_niveaux = array();
				for( $i=0; $i < count( $result ); $i++ ){
					$tmp_Params['id'] = $result[$i][$this->nom_champ($this->const['bdd_tables']['arbo']['id_src'])];
					$tmp_arbo = new c_arbo( $tmp_Params );
					
					$a_niveaux[$tmp_Params['id']] = $tmp_arbo->get_niveau();
				} 
				asort( $a_niveaux );
			}
			return $a_niveaux;
		}
	} */
}

class arbo_rights extends arbo_noeud_tools{
	private $user;
	
	public function __construct( $_Params = '' ){
		if( isset( $_Params['user_access'] ) )
			$this->set_user( $_Params['user_access'] );
		else{
			$this->set_user( ); // va générer le user par defaut (visitor)
			$_Params['user_access'] = $this->get_user();
		}

		
		parent::__construct( $_Params );
	}
	
	public function set_user( $user = '' ){
		if( $user != '' )
			$this->user = clone $user;
		else
			$this->user = new c_access();
	}
	public function get_user( ){
		return $this->user;
	}
	
  	protected function init( $id, $_Params = '' ){
		if( isset( $this->user ) ){
			parent::init( $id, $_Params );
		}else{
			// si pas de user : on créé un user standard 'Visitor'
			$this->user = new c_access();
			$this->init( $id, $_Params );
		}
	} 
	
	protected function loadby_id_resultexploit( $result, $_Params ){ 
		// redef d ecette méthode qui charge tout les items dans la partie ARBO_NOEUD_BDD 
		// Ici elle filtrera sur les droits de l'utilisateur courrant.
		$a_cont = array();
		for( $i=0; $i < count( $result ) ; $i++ ){
			$Temp_Params = $_Params;
			$Temp_Params['id'] = $result[$i][$this->nom_champ($_Params['id_dest'])];
			$Temp_Params['granpa'] = $this->granpa;
			
			// Vérif si on a les droits.
			if( $this->user->get_right_access_for_conteneur($Temp_Params['id'])){
				$a_cont[$i] = new c_arbo( $Temp_Params );
				$a_cont[$i]->set_id_noeud( $result[$i][$this->nom_champ($this->const['bdd_tables']['arbo']['id'])] );
			}
			// $a_cont[$i] = $result[$i][$_Params['id_dest']];
		}
		return $a_cont;
	}

	public function get_roots(){
		// va retourner un tableau avec tout les noeuds du niveau le plus elevé au niveau le plus bas.
		// MODIF 23/07 : NON, doit retourner uniquement les ROOTZ : Les noeuds n'ayant pas de parent!
		if( $this->bdd->is_connected() ){
			// Préparation de la query_string
			//$query_string = "SELECT DISTINCT ".$this->nom_champ($this->const['bdd_tables']['conteneurs']['id'])." FROM ".$this->const['bdd_tables']['conteneurs']['table'];
			$query_string = "SELECT DISTINCT ".$this->nom_champ($this->const['bdd_tables']['arbo']['id_src'])
							." FROM ".$this->const['bdd_tables']['arbo']['table'].', '.$this->const['bdd_tables']['conteneurs']['table']
							." WHERE ".$this->const['bdd_tables']['arbo']['id_src']." = ".$this->const['bdd_tables']['conteneurs']['id']
							." AND ".$this->const['bdd_tables']['conteneurs']['type']." = '".$this->const['bdd_tables']['conteneurs']['type_enum']['projet']."'";
			
			//// Exécution de la requete -> retour sous format tableau.
			$result = $this->bdd->query_tabresult( $query_string );
			
			$a_niveaux = false;
			/* echo '<h1> get_roots du arbo_rights : Nb Result SELECT DISTINCT '.count($result).'</h1>'; */
			if( count( $result ) ){
				// Si nous avons des resultats, alors on va récup les Niveaux.
				$a_niveaux = array();
				$tmp_niveaux = array();
				$j=0;
				for( $i=0; $i < count( $result ); $i++ ){
					// $tmp_Params['id'] = $result[$i][$this->nom_champ($this->const['bdd_tables']['conteneurs']['id'])];
					$tmp_Params['id'] = $result[$i][$this->nom_champ($this->const['bdd_tables']['arbo']['id_src'])];
					// Si le user a les droits sur cet ID.
					if( $this->user->get_right_access_for_conteneur($tmp_Params['id']) ){
						$tmp_Params['user_access'] = $this->user;
						$tmp_arbo = new c_arbo( $tmp_Params );
						
						// Si l'ID parent == l'ID actuel ==> pas de parent.
						if( $tmp_arbo->get_idparent() == (String)$tmp_arbo ){
							$a_niveaux[$j]['id'] = clone $tmp_arbo;
							$tmp_niveaux[$j] = $tmp_arbo->get_niveau();
							$a_niveaux[$j]['niveau'] = $tmp_niveaux[$j];
							$j++;
						}
					}
				}
				
				//// Réorganisation du tableau pour que le niveau le plus elevé soit en 1er.				
				array_multisort( $tmp_niveaux, SORT_DESC, $a_niveaux );
			}
			return $a_niveaux;
		}
	}
} 



class c_arbo extends arbo_rights{
	public function __toString(){
		return ($this->get_id())?(string)$this->get_id():'false';
	}
}
?>
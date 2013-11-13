<?php
/************************************************************************************************************************\
Fichier : c_conteneur.php
Auteur : c.ortiz 
Date : 26/06/2013
Description : 
Class qui lance les bases des notes et projets
\*************************************************************************************************************************/



class conteneur_liens extends c_modele{
	protected $id_parents = array();
	protected $id_sons = array();
	protected $t_liens_up = array();
	protected $t_liens_down = array();
	protected $s_type = '';
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
	
		if( isset( $_Params['liens_up'] ) )
			$this->t_liens_up = $_Params['liens_up'];
		if( isset( $_Params['liens_down'] ) )
			$this->t_liens_down = $_Params['liens_down'];
	}
	
	public function get_id_parents(){
		return $this->id_parents;
	}
	public function get_id_sons(){
		return $this->id_sons;
	}
	
	public function set_type( $type ){
		$this->type = $type;
	}
	public function get_type( ){
		return $this->type;
	}
	
	public function get_liens_up(){
		return $this->t_liens_up;
	}
	public function get_liens_down(){
		return $this->t_liens_down;
	}
	
	public function liens_up_add( $nom, $lien ){
		$this->t_liens_up[]['nom']= $nom;
		$this->t_liens_up[]['lien']= $lien;
	}
	public function liens_down_add( $nom, $lien ){
		$this->t_liens_down[]['nom']= $nom;
		$this->t_liens_down[]['lien']= $lien;
	}
	public function liens_up_reset(){
		$this->t_liens_up = array();
	}
	public function liens_down_reset(){
		$this->t_liens_down = array();
	}
	public function liens_reset_all(){
		$this->liens_up_reset();
		$this->liens_down_reset();
	}
}

class conteneur_corps extends conteneur_liens{
	protected $s_titre = 'init';
	protected $s_description = 'init';
	protected $s_pied = 'init';
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
	
		if( isset( $_Params['titre'] ) )
			$this->set_titre( $_Params['titre']);
		if( isset( $_Params['description'] ) )
			$this->set_description( $_Params['description']);
		if( isset( $_Params['pied'] ) )
			$this->set_pied( $_Params['pied']);
	}
	
	public function get_titre(){
		return $this->s_titre;
	}
	public function get_description(){
		return $this->s_description;
	}
	public function get_pied(){
		return $this->s_pied;
	}
	
	protected function set_titre( $titre ){
		$this->s_titre = $titre;
	}
	protected function set_description( $description ){
		$this->s_description = $description;
	}
	protected function set_pied( $pied ){
		$this->s_pied = $pied;
	}
}

class conteneur_publication extends conteneur_corps{
	protected $s_pub_date = '';
	protected $s_pub_autor = '';
	protected $s_edit_date = '';
	protected $s_edit_autor = '';
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
	
		if( isset( $_Params['pub_date'] ) )
			$this->set_pub_date( $_Params['pub_date']);
		if( isset( $_Params['pub_autor'] ) )
			$this->set_pub_autor( $_Params['pub_autor']);
		if( isset( $_Params['edit_date'] ) )
			$this->set_edit_date( $_Params['edit_date']);
		if( isset( $_Params['edit_autor'] ) )
			$this->set_edit_autor( $_Params['edit_autor']);
	}
	
	protected function set_pub_date( $pub_dat ){
		$this->s_pub_dat = $pub_dat;
	}
	protected function set_pub_autor( $pub_autor ){
		$this->s_pub_autor = $pub_autor;
	}
	protected function set_edit_date( $edit_date ){
		$this->s_edit_date = $edit_date;
	}
	protected function set_edit_autor( $edit_autor ){
		$this->s_edit_autor = $edit_autor;
	}
	
	public function get_pub_date(  ){
		return $this->s_pub_dat;
	}
	public function get_pub_autor(  ){
		return $this->s_pub_autor;
	}
	public function get_edit_date( ){
		return $this->s_edit_date;
	}
	public function get_edit_autor( ){
		return $this->s_edit_autor;
	}
}

class conteneur_from_bdd extends conteneur_publication{
	protected $bdd;
	protected $id;
	protected $loaded = false;
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		if( isset( $_Params['id'] ) )
			$this->init( $_Params['id'], $_Params );
		else
			if( $this->debug )
				echo "conteneur_from_bdd : Pas d'ID donné à l'initialisation...<br/>";
	}
	
	private function init( $id, $_Params = ''){
		$this->bdd = new c_bdd( $_Params );
		if( $this->bdd->is_connected() ){
			// if( $this->debug )
				// echo "Init Conteneur : BDD Connectée<br/>";			
			
			$this->loadby_id( $id, $_Params );
		}else
			if( $this->debug )
				echo "Erreur connexion bdd : pas d'initialisation de conteneur.<br/>";
	}
	private function loadby_id( $id, $_Params ){
		//// On prépare la requete
		// Filtre sur l'ID
		$_Params_query['clauses'][0]['champ'] = $_Params['champ_id'];
		$_Params_query['clauses'][0]['valeur'] = $id;
		// Filtre si note ou projet
		if( isset( $_Params['champ_type'], $_Params['type'] ) ){
			$_Params_query['clauses'][1]['champ'] = $_Params['champ_type'];
			$_Params_query['clauses'][1]['valeur'] = $_Params['type'];
		}// définition de la table a requeter.
		$_Params_query['table'] = $_Params['table'];
		
		//// Création de la requete
		$query_string = $this->bdd->create_query( $_Params_query );

		//// Exécution de la requete -> retour sous format tableau.
		$result = $this->bdd->query_tabresult( $query_string );
		
		//// Exploitation des résultats. Sil y en a...
		if( count( $result ) == 1){
			$this->id = $id;
			
			$this->set_type( $result[0][$this->nom_champ( $this->const['bdd_tables']['conteneurs']['type'] )] );
			
			// Chargement des datas
			if( isset( $_Params['load_titre'] ) )
				$this->set_titre( $result[0][$this->nom_champ($_Params['load_titre'])] );
			
			if( isset( $_Params['load_description'] ) )
				$this->set_description( $result[0][$this->nom_champ($_Params['load_description'])] );
			
			if( isset( $_Params['load_pub_date'] ) )
				$this->set_pub_date( $result[0][$this->nom_champ($_Params['load_pub_date'])] );
				
			if( isset( $_Params['load_pub_autor'] ) )
				$this->set_pub_autor( $result[0][$this->nom_champ($_Params['load_pub_autor'])] );
				
			if( isset( $_Params['load_edit_date'] ) )
				$this->set_edit_date( $result[0][$this->nom_champ($_Params['load_edit_date'])] );
				
			if( isset( $_Params['load_edit_autor'] ) )
				$this->set_edit_autor( $result[0][$this->nom_champ($_Params['load_edit_autor'])] );
				
						
			if( isset( $_Params['load_pied'] ) ){ // Pour le pied, ce n'est pas un simple champs qu'on insere, c'est une concaténation de plusieurs champs ...
				// $this->set_pied( $result[0][$this->nom_champ($_Params['load_pied'])] );
				$pied = "Publié le ".$this->get_pub_date()." par ".$this->get_pub_autor();
				if( $this->get_edit_autor() != '' )
					$pied .= " (réédité le ".$this->get_edit_date()." par ".$this->get_edit_autor().")";
				$this->set_pied( $pied );
			}	
			$this->loaded = true;
		}else
			if( $this->debug ){
				echo "Il y a ".count($result)." note(s)/projet(s) avec l'ID : ".$id."<br/>";
				//echo var_dump( $result )."<br/>";
			}
		
	}	
	public function is_loaded(){
		return $this->loaded;
	}
	
	public function get_id(){ 
		return $this->id;
	}
}

class conteneur_from_constants extends conteneur_from_bdd{
	public function __construct( $_Params = '' ){ 
/* 		// On force la table sur la table des "notes".
		$_Params['table'] = $this->const['bdd_tables']['notes'];
		echo "Params['table'] : ".$_Params['table'];
 */		// !!!! Impossible !!! $this->const n'est pas encore instancié! RRrrrr
		// On laisse l'oportunité de modifier les $_Params a la mano en mettant un if( !isset(...) )
		
		$c = new constants();
		if( !isset( $_Params['table'] ) )
			$_Params['table'] = $c->const['bdd_tables']['conteneurs']['table'];
		if( !isset( $_Params['champ_id'] ) )
			$_Params['champ_id'] = $c->const['bdd_tables']['conteneurs']['id'];
		if( !isset( $_Params['champ_type'] ) )
			$_Params['champ_type'] = $c->const['bdd_tables']['conteneurs']['type'];
		
		// Attribution des noms de colonnes à récupérer/charger
		if( !isset( $_Params['load_titre'] ) )
			$_Params['load_titre'] = $c->const['bdd_tables']['conteneurs']['titre'];
		if( !isset( $_Params['load_description'] ) )
			$_Params['load_description'] = $c->const['bdd_tables']['conteneurs']['description'];
		if( !isset( $_Params['load_pied'] ) )
			$_Params['load_pied'] = $c->const['bdd_tables']['conteneurs']['description'];
		if( !isset( $_Params['load_pub_date'] ) )
			$_Params['load_pub_date'] = $c->const['bdd_tables']['conteneurs']['pub_date'];
		if( !isset( $_Params['load_pub_autor'] ) )
			$_Params['load_pub_autor'] = $c->const['bdd_tables']['conteneurs']['pub_autor'];
		if( !isset( $_Params['load_edit_date'] ) )
			$_Params['load_edit_date'] = $c->const['bdd_tables']['conteneurs']['edit_date'];
		if( !isset( $_Params['load_edit_autor'] ) )
			$_Params['load_edit_autor'] = $c->const['bdd_tables']['conteneurs']['edit_autor'];
			
		parent::__construct( $_Params );	
	}
}

class conteneur_rights extends conteneur_from_constants{
	private $user;
	protected $right; // detient le fait qu'on ait les droits ou non... j'ai failli opter pour un "non construct" ... mais ca fou un peu la merde dans l'arbo par exemple... :)
	
	public function __construct( $_Params = '' ){
		// Init du User
		if( isset( $_Params['user_access'] ) )
			$this->set_user( $_Params['user_access'] );
		else{
			$this->set_user( ); // va générer le user par defaut (visitor)
			$_Params['user_access'] = $this->get_user();
		}
		
		// Vérif s'il y a un ID de posté
		if( isset( $_Params['id'] ) ){
			// On vérifie si on a les droits sur ce conteneur
			if( $this->user->get_right_access_for_conteneur( $_Params['id'] ))
				$this->right = true;
			else
				$this->right = false;
		}
		
		parent::__construct( $_Params );
	}
	
	public function get_right_access_for_conteneur(  ){
		return $this->right;
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

}



class c_conteneur extends conteneur_rights{
}





?>
<?php
/************************************************************************************************************************\
Fichier : c_control_conteneur.php
Auteur : c.ortiz 
Date : 09/09/2013
Description : 
c_control_conteneur va matcher le tableau de résultat du MOTEUR FONCTIONNEL au tableau d'affichage du MOTEUR GRAPHIQUE.
\*************************************************************************************************************************/
class c_controleur_bdd extends c_controler{
	protected $bdd;
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		$this->bdd = new c_bdd( $_Params );
	} 
}
class c_prepare_conteneur extends c_controleur_bdd{
	protected $conteneur; 				// detient le conteneur en question.
	protected $id_up = array(); 		// Contient les ID pour les "liens UP" (note ou projet)
	protected $id_down = array();		// Contient les ID pour les "liens DOWN"
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
 		// Y a-t-il un USER dans les Params?
		$tmp_Params['user_access'] = (isset( $_Params['user'] ))?$_Params['user']:'';

 
		// Y a-t-il un ID conteneur dans les Params?
		if( isset( $_Params['id'] ) )
			$tmp_Params['id'] = $_Params['id'];	
		// Y a-t-il un ID conteneur dans les variables postées?
		else if( isset($this->a_get[$this->const['POST']['conteneur']['id']]) ){
			$tmp_Params['id'] = $this->a_get[$this->const['POST']['conteneur']['id']];
			
			if( $this->debug )
				echo "<h1>Conteneurs : L'ID ".$this->a_get[$this->const['POST']['conteneur']['id']]." a été posté :)</h1>";
		}
		
		// Init du conteneur
		$this->conteneur = new c_conteneur( $tmp_Params );
		
		// Vérif si on a les droits
		if( !$this->conteneur->get_right_access_for_conteneur() )
			$this->conteneur = false;
	}
	
	public function get_type(){
		if( $this->conteneur != false )
			return $this->conteneur->get_type();
		else 
			return false;
	}
	
	public function retrieve_id_up(){
	// On va récup tout les items qui pointent vers notre conteneur.
	// On fera un légé tri en séparant les notes et projets
		$query = '';
		// if( $this->get_type() == 'note' ){
			// Les onglets du haut pour une note ne peuvent etre que d'autre notes.
						
			$query = "SELECT * FROM ".$this->const['bdd_tables']['conteneurs']['table'].', '.$this->const['bdd_tables']['arbo']['table'].
					" WHERE ".$this->const['bdd_tables']['conteneurs']['id']." = ".$this->const['bdd_tables']['arbo']['id_src'].
					" AND ".$this->const['bdd_tables']['arbo']['id_dest']." = '".$this->conteneur->get_id()."'";/* .
					" AND ".$this->const['bdd_tables']['conteneurs']['type']." = '".$this->const['bdd_tables']['conteneurs']['type_enum']['note']."'"; */
		// }else if( $this->get_type() == 'projet' ){
			// Onglets du haut pour un projet sont soit des notes soit des projets
			// $query = "SELECT * FROM ".$this->const['bdd_tables']['arbo']['table'].
					// " WHERE ".$this->const['bdd_tables']['arbo']['id_dest']." = '".$this->conteneur->get_id()."'";
		// }else
			// return false;
		
		$result = $this->bdd->query_tabresult( $query );
		
		$return = array();
		foreach( $result as $key => $conteneur  ){
			if( $conteneur['type'] == $this->const['bdd_tables']['conteneurs']['type_enum']['note'] )
				$return[$this->const['bdd_tables']['conteneurs']['type_enum']['note']][] = $conteneur;
			else
				$return[$this->const['bdd_tables']['conteneurs']['type_enum']['projet']][] = $conteneur;
		} 
		
		return $return;
	}
	public function retrieve_id_down(){
		$query = '';
		// if( $this->get_type() == 'note' ){
			// Note ou projet
			// $query = "SELECT * FROM ".$this->const['bdd_tables']['arbo']['table'].
					// " WHERE ".$this->const['bdd_tables']['arbo']['id_src']." = '".$this->conteneur->get_id()."'";
		// }else if( $this->get_type() == 'projet' ){
			// que projet
			$query = "SELECT * FROM ".$this->const['bdd_tables']['conteneurs']['table'].', '.$this->const['bdd_tables']['arbo']['table'].
					" WHERE ".$this->const['bdd_tables']['conteneurs']['id']." = ".$this->const['bdd_tables']['arbo']['id_dest'].
					" AND ".$this->const['bdd_tables']['arbo']['id_src']." = '".$this->conteneur->get_id()."'";/* .
					" AND ".$this->const['bdd_tables']['conteneurs']['type']." = '".$this->const['bdd_tables']['conteneurs']['type_enum']['projet']."'" */
			
		// }else
			// return false;
		
		
		$result = $this->bdd->query_tabresult( $query );
		
		$return = array();
		foreach( $result as $key => $conteneur  ){
			if( $conteneur['type'] == $this->const['bdd_tables']['conteneurs']['type_enum']['note'] )
				$return[$this->const['bdd_tables']['conteneurs']['type_enum']['note']][] = $conteneur;
			else
				$return[$this->const['bdd_tables']['conteneurs']['type_enum']['projet']][] = $conteneur;
		} 
		
		return $return;
	}
	private function retrieve_id_note(){

	}
	
	protected function get_notes_for_this_project(){
		
	}
	
	public function get_id_up(){
		return $this->id_up;
	}
	public function  get_id_down(){
		return $this->id_down;
	}
}


class c_show_conteneur extends c_prepare_conteneur{
}







class c_control_conteneur extends c_show_conteneur{
	public function __construct( $_Params = '' ){
		//!!!\\ Doit etre impérativement appelé dans la derniere classe qui hérite de c_get_manager ... avant l'appel du __construct parent de facon
		// a ce que les variables soient traitées avant l'initialisation de la classe ... et ainsi récupérer ces variables à jour.
		
		// Modularisation des variables en fonction  des parametres $_GET
		$this->auto_manage_get();

		parent::__construct( $_Params );
	}
}


?>
<?php
/************************************************************************************************************************\
Fichier : c_control_arbo.php
Auteur : c.ortiz 
Date : 16/07/2013
Description : 
c_control_arbo va matcher le tableau de résultat du MOTEUR FONCTIONNEL ARBO au tableau d'affichage du MOTEUR GRAPHIQUE MENU GAUCHE.
\*************************************************************************************************************************/

class c_control_arbo_get extends c_controler{
	// redef pour faire la gestion du GET
/* 	protected function manage_get( $get ){
		parent::manage_get( $get );
		// A-t-on envoyé un ID de conteneur?
		if( isset( $get[$this->const['POST']['conteneur']['id']] ) )
			echo "<h1>L'ID ".$get[$this->const['POST']['conteneur']['id']]." a été posté :)</h1>";
		
	}  */
/* 	protected function get_getline_forfind(){
		return $this->get_input_text_name().'='.$this->get_input_text_value().'&'.$this->get_input_submit_name().'='.$this->get_input_submit_value();
	} */

}

class c_control_arbo_tree extends c_control_arbo_get{
	protected $arbo;
	protected $a_path = array();
	
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
				echo "<h1>ARBO : L'ID ".$this->a_get[$this->const['POST']['conteneur']['id']]." a été posté :)</h1>";
		}

		// Init de l'abro
		$this->arbo = new c_arbo( $tmp_Params );
	}
	
	public function get_tree_arbo(){
		// On récupère les ID qui n'ont pas de parent. (en fonction du USER)
		$a_roots = $this->arbo->get_roots();

		$result = array();
		// S'il y a des noeuds sans parents
		if( count( $a_roots ) ){
			// Peut-etre a-t-on demandé l'affichage d'un CONTENEUR... dans quel cas il faut dérouler ce menu.
			$id= false;
			if( isset( $this->a_get[$this->const['POST']['conteneur']['id']] ) )
				$id = $this->a_get[$this->const['POST']['conteneur']['id']];
				
			if( $this->debug )
				echo "<h1>Un ID posté : $id</h1>";
				
			// On fait le tour de chacun de ces ID pour récup le tableau d'arbo.
			for( $i=0; $i < count( $a_roots ); $i++ ){
				$result[$i] = $this->get_tree_recur( $a_roots[$i]['id'], $id);
			}
		}
		return $result;
	}
	
	protected function get_tree_recur( $i_arbo, $id_search ){
		// Préparation des outils
		$tab = array();
		$_Params['id'] = $i_arbo;
		$i_contener = new c_conteneur( $_Params );
		
		// Inscription du texte
		$tab['texte'] = $i_contener->get_titre();
		// Inscription du lien
		$tab['lien'] = $this->const['pages']['index']."?".$this->const['POST']['conteneur']['id']."=".$i_arbo; 
		
		//// Recherche des enfants ... mais on n'affiche/déroule que ceux qui font parti du chemin qu'on a demandé.
		// On lance la récur QUE si on est sur le chemin.
		if( $id_search !== false )
		if( $i_arbo->get_path( $id_search ) ){
			// Récup ID
			$a_ids = $i_arbo->get_idsons();
				for( $i=0; $i < count( $a_ids ); $i++ ){
					$tmp_Params['id'] = $a_ids[$i];
					$tmp_Params['user_access'] = $i_arbo->get_user();
					
					$tmp_arbo = new c_arbo( $tmp_Params );
					
					// On lance la récur
					$tab['arbo'][$i] = $this->get_tree_recur( $tmp_arbo, $id_search);
				} 
		}
		return $tab;
	}
}



















class c_control_arbo extends c_control_arbo_tree{
	
	public function __construct( $_Params = '' ){
		//!!!\\ Doit etre impérativement appelé dans la derniere classe qui hérite de c_get_manager ... avant l'appel du __construct parent de facon
		// a ce que les variables soient traitées avant l'initialisation de la classe ... et ainsi récupérer ces variables à jour.
		
		// Modularisation des variables en fonction  des parametres $_GET
		$this->auto_manage_get();

		parent::__construct( $_Params );
	}
}


?>
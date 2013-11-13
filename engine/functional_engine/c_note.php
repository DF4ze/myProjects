<?php
/************************************************************************************************************************\
Fichier : c_note.php
Auteur : c.ortiz 
Date : 19/06/2013
Description : 
Class qui va gérer les fonctionnalités des notes
\*************************************************************************************************************************/

// require_once( 'c_conteneur.php' );



class note_from_bdd extends c_conteneur{
	public function __construct( $_Params = '' ){ 
/* 		// On force la table sur la table des "notes".
		$_Params['table'] = $this->const['bdd_tables']['notes'];
		echo "Params['table'] : ".$_Params['table'];
 */		// !!!! Impossible !!! $this->const n'est pas encore initialisé! RRrrrr
		
/* 		$c = new constants();
		$_Params['table'] = $c->const['bdd_tables']['notes']['table'];
		$_Params['champ_id'] = $c->const['bdd_tables']['notes']['id'];
		$_Params['champ_type'] = $c->const['bdd_tables']['notes']['type'];
		
		// Attribution des noms de colonnes à récupérer/charger
		$_Params['load_titre'] = $c->const['bdd_tables']['notes']['titre'];
		$_Params['load_description'] = $c->const['bdd_tables']['notes']['description'];
		$_Params['load_pied'] = $c->const['bdd_tables']['notes']['description'];
		$_Params['load_pub_date'] = $c->const['bdd_tables']['notes']['pub_date'];
		$_Params['load_pub_autor'] = $c->const['bdd_tables']['notes']['pub_autor'];
		$_Params['load_edit_date'] = $c->const['bdd_tables']['notes']['edit_date'];
		$_Params['load_edit_autor'] = $c->const['bdd_tables']['notes']['edit_autor'];
 */

		$c = new constants();
		$_Params['type'] = $c->const['bdd_tables']['conteneurs']['type_enum']['note'];
		parent::__construct( $_Params );	
	}
}















class c_note extends note_from_bdd{

}
<?php
/************************************************************************************************************************\
Fichier : c_projet.php
Auteur : c.ortiz 
Date : 27/06/2013
Description : 
Class qui va gérer les fonctionnalités des projets
\*************************************************************************************************************************/


// require_once( '../c_constants.php' );
// require_once( 'c_conteneur.php' );


class projet_from_bdd extends c_conteneur{
	public function __construct( $_Params = '' ){ 

/* 		$c = new constants();
		$_Params['table'] = $c->const['bdd_tables']['projets']['table'];
		$_Params['champ_id'] = $c->const['bdd_tables']['projets']['id'];
		$_Params['champ_type'] = $c->const['bdd_tables']['notes']['type'];

		$_Params['load_titre'] = $c->const['bdd_tables']['projets']['titre'];
		$_Params['load_description'] = $c->const['bdd_tables']['projets']['description'];
		$_Params['load_pied'] = $c->const['bdd_tables']['projets']['description'];
		$_Params['load_pub_date'] = $c->const['bdd_tables']['projets']['pub_date'];
		$_Params['load_pub_autor'] = $c->const['bdd_tables']['projets']['pub_autor'];
		$_Params['load_edit_date'] = $c->const['bdd_tables']['projets']['edit_date'];
		$_Params['load_edit_autor'] = $c->const['bdd_tables']['projets']['edit_autor'];
 */
		$c = new constants();
		$_Params['type'] = $c->const['bdd_tables']['conteneurs']['type_enum']['projet'];
		parent::__construct( $_Params );	
	}
}





class c_projet extends projet_from_bdd {

}
?>
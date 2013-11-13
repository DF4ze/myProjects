<?php
/************************************************************************************************************************\
Fichier : c_page.php
Auteur : c.ortiz 
Date : 07/06/2013
Description : 
Class qui va nous mettre à disposition les constantes du site.
Elles seront modifiable via un parametre 'const'
\*************************************************************************************************************************/

class constants extends virtual{
	protected $const;
	
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		$this->const = array();
		
		//!\\ s'il faut ajouter une constante, le faire ci-dessous mais également dans le IF/SWITCH plus bas
		
		//// Initialisation des constantes.
		// HTML CLASS : HC
		$this->const['hc_login'] = 'login';
		$this->const['hc_logo'] = 'logo';
		$this->const['hc_menu_banniere_item'] = 'menu_banniere_item';
		$this->const['hc_menu_banniere'] = 'menu_banniere';
		$this->const['hc_banniere'] = 'banniere';

		$this->const['hc_menu_left_item'] = 'menu_left_item';
		$this->const['hc_menu_left'] = 'menu_left';
		
		$this->const['hc_menu_right'] = 'menu_right';
		
		$this->const['hc_corps_titre'] = 'corps_titre';
		$this->const['hc_corps_description'] = 'corps_description';
		$this->const['hc_note_titre'] = 'note_titre';
		$this->const['hc_note_descript'] = 'note_descript';
		$this->const['hc_note_pied'] = 'note_pied';
		$this->const['hc_note_corps'] = 'note_corps';
		$this->const['hc_note_onglet'] = 'note_onglet';
		$this->const['hc_note_onglets'] = 'note_onglets';

		$this->const['hc_corps'] = 'corps';
		/* $this->const['hc_spacer'] = 'spacer'; */
		
		
		
		//// Connexion BDD
		$this->const['bdd_user'] = 'root';
		$this->const['bdd_pwd'] = '';
		$this->const['bdd_server'] = '127.0.0.1';
		$this->const['bdd_base'] = 'myprojects_v2';
		//// Tables et Champs	
		// Table CONTENEURS
		$this->const['bdd_tables']['conteneurs']['table'] = 		'mp_conteneurs';
		$this->const['bdd_tables']['conteneurs']['id'] = 			'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.id';
		$this->const['bdd_tables']['conteneurs']['titre'] = 		'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.titre';
		// $this->const['bdd_tables']['conteneurs']['titre'] = 		'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.description';
		$this->const['bdd_tables']['conteneurs']['description'] =	'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.description';
		$this->const['bdd_tables']['conteneurs']['pub_date'] = 		'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.pub_date';
		$this->const['bdd_tables']['conteneurs']['pub_autor'] = 	'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.pub_autor';
		$this->const['bdd_tables']['conteneurs']['edit_date'] = 	'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.edit_date';
		$this->const['bdd_tables']['conteneurs']['edit_autor'] = 	'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.edit_autor';
		$this->const['bdd_tables']['conteneurs']['id_right_level'] ='`'.$this->const['bdd_tables']['conteneurs']['table'].'`.id_right_level';
		$this->const['bdd_tables']['conteneurs']['type'] = 			'`'.$this->const['bdd_tables']['conteneurs']['table'].'`.type';
		$this->const['bdd_tables']['conteneurs']['type_enum']['note'] = 'note';
		$this->const['bdd_tables']['conteneurs']['type_enum']['projet'] = 'projet';
		// Table ARBO
		$this->const['bdd_tables']['arbo']['table'] = 	'mp_arbo';
		$this->const['bdd_tables']['arbo']['id'] = 		'`'.$this->const['bdd_tables']['arbo']['table'].'`.id';
		$this->const['bdd_tables']['arbo']['id_src'] = 	'`'.$this->const['bdd_tables']['arbo']['table'].'`.id_src';
		$this->const['bdd_tables']['arbo']['id_dest'] = '`'.$this->const['bdd_tables']['arbo']['table'].'`.id_dest';
		// Table GROUP_ACCESS
		$this->const['bdd_tables']['group']['table'] = 								'mp_group_access';
		$this->const['bdd_tables']['group']['id'] = 								'`'.$this->const['bdd_tables']['group']['table'].'`.id';
		$this->const['bdd_tables']['group']['right_level'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.right_level';
		$this->const['bdd_tables']['group']['name'] = 								'`'.$this->const['bdd_tables']['group']['table'].'`.name';
		// .... 44 champs dans cette table ... est-il vraiment necessaire de faire les constantes ....................? la réponse est OUI .... mais de facon automatisé qd meme! je vais pas saisir tt ca a la main :)
		$this->const['bdd_tables']['group']['access_note'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.access_note';
		$this->const['bdd_tables']['group']['note_add'] = 							'`'.$this->const['bdd_tables']['group']['table'].'`.note_add';
		$this->const['bdd_tables']['group']['note_edit_own'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.note_edit_own';
		$this->const['bdd_tables']['group']['note_edit_all'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.note_edit_all';
		$this->const['bdd_tables']['group']['note_suppr_own'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.note_suppr_own';
		$this->const['bdd_tables']['group']['note_suppr_all'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.note_suppr_all';
		$this->const['bdd_tables']['group']['com_add'] = 							'`'.$this->const['bdd_tables']['group']['table'].'`.com_add';
		$this->const['bdd_tables']['group']['com_edit_own'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.com_edit_own';
		$this->const['bdd_tables']['group']['com_edit_all'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.com_edit_all';
		$this->const['bdd_tables']['group']['com_suppr_own'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.com_suppr_own';
		$this->const['bdd_tables']['group']['com_suppr_all'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.com_suppr_all';
		$this->const['bdd_tables']['group']['com_suppr_all_own_note'] = 			'`'.$this->const['bdd_tables']['group']['table'].'`.com_suppr_all_own_note';
		$this->const['bdd_tables']['group']['upload_image'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.upload_image';
		$this->const['bdd_tables']['group']['upload_son'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.upload_son';
		$this->const['bdd_tables']['group']['upload_video'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.upload_video';
		$this->const['bdd_tables']['group']['upload_suppr_own'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.upload_suppr_own';
		$this->const['bdd_tables']['group']['upload_suppr_all'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.upload_suppr_all';
		$this->const['bdd_tables']['group']['compte_reset_pwd_own'] = 				'`'.$this->const['bdd_tables']['group']['table'].'`.compte_reset_pwd_own';
		$this->const['bdd_tables']['group']['compte_edit_own'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.compte_edit_own';
		$this->const['bdd_tables']['group']['compte_suppr_own'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.compte_suppr_own';
		$this->const['bdd_tables']['group']['access_admin'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.access_admin';
		$this->const['bdd_tables']['group']['compte_reset_pwd_all_less_admin'] = 	'`'.$this->const['bdd_tables']['group']['table'].'`.compte_reset_pwd_all_less_admin';
		$this->const['bdd_tables']['group']['compte_reset_pwd_all'] = 				'`'.$this->const['bdd_tables']['group']['table'].'`.compte_reset_pwd_all';
		$this->const['bdd_tables']['group']['compte_create_normal_user'] = 			'`'.$this->const['bdd_tables']['group']['table'].'`.compte_create_normal_user';
		$this->const['bdd_tables']['group']['compte_create_admin_user'] = 			'`'.$this->const['bdd_tables']['group']['table'].'`.compte_create_admin_user';
		$this->const['bdd_tables']['group']['compte_edit_all_less_admin'] = 		'`'.$this->const['bdd_tables']['group']['table'].'`.compte_edit_all_less_admin';
		$this->const['bdd_tables']['group']['compte_edit_all'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.compte_edit_all';
		$this->const['bdd_tables']['group']['compte_suppr_all_less_admin'] = 		'`'.$this->const['bdd_tables']['group']['table'].'`.compte_suppr_all_less_admin';
		$this->const['bdd_tables']['group']['compte_suppr_all'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.compte_suppr_all';
		$this->const['bdd_tables']['group']['arbo_create'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.arbo_create';
		$this->const['bdd_tables']['group']['arbo_edit'] = 							'`'.$this->const['bdd_tables']['group']['table'].'`.arbo_edit';
		$this->const['bdd_tables']['group']['arbo_suppr'] = 						'`'.$this->const['bdd_tables']['group']['table'].'`.arbo_suppr';
		$this->const['bdd_tables']['group']['access_sources'] = 					'`'.$this->const['bdd_tables']['group']['table'].'`.access_sources';
		// Table LOGINS
		$this->const['bdd_tables']['logins']['table'] = 	'mp_logins';
		$this->const['bdd_tables']['logins']['id'] = 		'`'.$this->const['bdd_tables']['logins']['table'].'`.id';
		$this->const['bdd_tables']['logins']['user'] = 		'`'.$this->const['bdd_tables']['logins']['table'].'`.user';
		$this->const['bdd_tables']['logins']['password'] = 	'`'.$this->const['bdd_tables']['logins']['table'].'`.password';
		// Table PROFILS
		$this->const['bdd_tables']['profils']['table'] = 			'mp_users_profile';
		$this->const['bdd_tables']['profils']['id'] = 				'`'.$this->const['bdd_tables']['profils']['table'].'`.id';
		$this->const['bdd_tables']['profils']['id_login'] = 		'`'.$this->const['bdd_tables']['profils']['table'].'`.id_login';
		$this->const['bdd_tables']['profils']['id_ban'] = 			'`'.$this->const['bdd_tables']['profils']['table'].'`.id_ban';
		$this->const['bdd_tables']['profils']['id_group'] = 		'`'.$this->const['bdd_tables']['profils']['table'].'`.id_group_access';
		$this->const['bdd_tables']['profils']['last_ip'] = 			'`'.$this->const['bdd_tables']['profils']['table'].'`.last_ip';
		$this->const['bdd_tables']['profils']['name'] = 			'`'.$this->const['bdd_tables']['profils']['table'].'`.name';
		$this->const['bdd_tables']['profils']['path_avatar'] = 		'`'.$this->const['bdd_tables']['profils']['table'].'`.path_avatar';
		$this->const['bdd_tables']['profils']['mail'] = 			'`'.$this->const['bdd_tables']['profils']['table'].'`.mail';
		$this->const['bdd_tables']['profils']['localisation'] = 	'`'.$this->const['bdd_tables']['profils']['table'].'`.localisation';
		$this->const['bdd_tables']['profils']['tel'] = 				'`'.$this->const['bdd_tables']['profils']['table'].'`.tel';
		$this->const['bdd_tables']['profils']['date_naissance'] = 	'`'.$this->const['bdd_tables']['profils']['table'].'`.date_naissance';


		// Droits par defaut
		$this->const['rights']['defaut']['user'] = 		'visitor';
		$this->const['rights']['defaut']['password'] = 	'visitor';

		//Noms des variables POST/GET
		$this->const['POST']['conteneur']['id'] = 	'id_cont';
		
		// Nom des pages
		$this->const['pages']['index'] = 'index_old.php';
		
		// a-t-on posté des parametres à modifier?
		// if( isset( $_Params['const'] ) )
			// $this->change_const( $_Params['const'] );
	}
	
	public function nom_champ( $champ ){
		$result = explode( '.', $champ );
		if(count($result) == 0) 
			return false;
		else if(count($result) == 1)
				return $result[0]; 
		else if( count($result) == 2)
			return $result[1];
		else 
			return false;
	}
	
	public function change_const( $_Params ){
		// Personnalisation des constantes.
		$ok = false;
 		foreach( $_Params as $key => $value ){
			switch( $key ){
				case 'hc_login' : 
				case 'hc_logo' : 
				case 'hc_menu_banniere_item' : 
				case 'hc_menu_banniere' : 
				case 'hc_banniere' : 
				case 'hc_menu_left_item' : 
				case 'hc_menu_left' : 
				case 'hc_corps_titre' : 
				case 'hc_corps_description' : 
				case 'hc_note_titre' : 
				case 'hc_note_descript' : 
				case 'hc_note_pied' : 
				case 'hc_note_corps' : 
				case 'hc_note_onglet' : 
				case 'hc_note_onglets' : 
				case 'hc_corps' : 
				case 'hc_spacer' : 
				
				case 'bdd_user' : 
				case 'bdd_pwd' : 
				case 'bdd_server' : 
				case 'bdd_base' : 
				case 'bdd_tables' : 
				
				case 'rights' : 

				case 'POST' : 
					$this->const[$key] = $value;
					$ok = true;
					break;
				default :
					break;
			}
		}
		return $ok;
	}
}

?>
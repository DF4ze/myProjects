<?php
/************************************************************************************************************************\
Fichier : c_page.php
Auteur : c.ortiz 
Date : 05/06/2013
Description : 
Class qui va créer les différents modules de la page.
et du coup définir le nom des class des différents div
\*************************************************************************************************************************/


// require_once( 'c_page.php' );




// Défini les différentes parties qui seront affichées dans la banniere
class page_structure_banniere_items extends cPage{
	protected function make_login( $action ){
		// Création des inputs
		$this->insert_inputs(	$this->make_input( 'text', 'login_user' ).
								$this->make_input( 'password', 'login_pwd' ).
								$this->make_input( 'submit', '', 'Log' ));
		return $this->make_div( $this->const['hc_login'], $this->make_form( $action, 'POST' ) );
	}
	
	protected function make_logo( $appli_name, $url_logo, $height = '', $width = '' ){
		return $this->make_div( $this->const['hc_logo'], 	$this->get_image( $url_logo, $appli_name, $height!='' AND $width!='' ? ' width="'.$width.'" height="'.$height.'"' : '' ).
											'<h1>'.$appli_name.'</h1>'
								);
	}
	protected function make_menu_banniere( $tab_menu ){
		$menus ='';
		foreach( $tab_menu as $key => $menu )
			$menus .= $this->make_div( $this->const['hc_menu_banniere_item'], '<a href="'.$menu['url'].'">'.$menu['texte'].'</a>' );
		
		return $this->make_div( $this->const['hc_menu_banniere'], $menus );
	}
	protected function make_banniere( $texte ){
		return $this->make_div( $this->const['hc_banniere'], $texte );
	}
}

// Modules pour le menu de gauche
class page_structure_menu_left_items extends page_structure_banniere_items{
	
	protected function make_left_menu_item_link( $texte, $cible ){
		return $this->make_div( $this->const['hc_menu_left_item'], '<a href="'.$cible.'">'.$texte.'</a>' );
	}
	protected function make_left_menu_item_nolink( $texte ){
		return $this->make_div( $this->const['hc_menu_left_item'], $texte );
	}
	protected function make_left_menu_recur( $tab_left_menu, $all_link ){
		$menu = '<ul>';
		foreach( $tab_left_menu as $key => $item ){
			// si on n'a pas d'arbo, alors on fait un lien
			if( !isset( $item['arbo'] ) )
				$menu .= '<li>'.$this->make_left_menu_item_link( $item['texte'], $item['lien'] ).'</li>';
			else{
				// sinon Fait-on un lien? et on lance la récursivité.
				if( $all_link )
					$menu .= '<li>'.$this->make_left_menu_item_link( $item['texte'], $item['lien'] ).'</li>';
				else
					$menu .= '<li>'.$this->make_left_menu_item_nolink( $item['texte'] ).'</li>';
				$menu .= $this->make_left_menu_recur( $item['arbo'], $all_link );
			}
		}
		$menu .= '</ul>';
		
		return $menu;
	}
	protected function make_left_menu( $tab, $titre = '', $all_link = true ){
		return $this->make_div( $this->const['hc_menu_left'], $titre == ''? $this->make_left_menu_recur( $tab, $all_link ) : '<h2>'.$titre.'</h2>'.$this->make_left_menu_recur( $tab, $all_link ) );
	}
}

// Modules pour le menu de droite
class page_structure_menu_right_items extends page_structure_menu_left_items{
	protected function make_right_menu( $texte ){
		return $this->make_div( $this->const['hc_menu_right'], $texte );
	}
}

// Modules pour le corps
class page_structure_corps extends page_structure_menu_right_items{
	protected function make_titre( $texte ){
		return $this->make_div( $this->const['hc_corps_titre'], '<h1>'.$texte.'</h1>' );
	}	
	protected function make_descript( $texte ){
		return $this->make_div( $this->const['hc_corps_description'], $texte );
	}	
	
	protected function make_note_titre( $texte ){
		return $this->make_div( $this->const['hc_note_titre'], '<h2>'.$texte.'</h2>' );
	}
	protected function make_note_descript( $texte ){
		return $this->make_div( $this->const['hc_note_descript'], $texte );
	}
	protected function make_note_pied( $texte ){
		return $this->make_div( $this->const['hc_note_pied'], $texte );
	}
	protected function make_note_corps( $texte ){
		return $this->make_div( $this->const['hc_note_corps'], $texte );
	}
	
	protected function make_note_onglets( $tab ){
		$onglets = '';
		foreach( $tab as $key => $onglet )
			$onglets .= $this->make_div( $this->const['hc_note_onglet'], '<a href="'.$onglet['lien'].'" >'.$onglet['texte'].'</a>');
		/* $onglets .= $this->make_div( $this->const['hc_spacer'], '' );  */

		return $this->make_div( $this->const['hc_note_onglets'], $onglets );
	}
	
	protected function make_corps( $texte ){
		return $this->make_div( $this->const['hc_corps'], $texte );
	}
}









class c_page_module extends page_structure_corps{
}

?>
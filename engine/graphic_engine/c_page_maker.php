<?php
/************************************************************************************************************************\
Fichier : c_page_maker.php
Auteur : c.ortiz 
Date : 05/06/2013
Description : 
Class qui va nous agglomerer les différent modules de facon a construire la page
\*************************************************************************************************************************/

// require_once( 'c_page_module.php' );

// Pose la structure complete de l'affichage du site
class page_generate_template extends c_page_module{
	protected $banniere = '';
	protected $left_menu = '';
	protected $right_menu = '';
	protected $corps = '';
	protected $pied = '';
	
	public function insert_banniere( $texte ){
		$this->banniere .= $texte;
	}
	public function insert_left_menu( $texte ){
		$this->left_menu .= $texte;
	}
	public function insert_right_menu( $texte ){
		$this->right_menu .= $texte;
	}
	public function insert_corps( $texte ){
		$this->corps .= $texte;
	}
	public function insert_pied( $texte ){
		$this->pied .= $texte;
	}
	
	public function reset_banniere(  ){
		$this->banniere = '';
	}
	public function reset_left_menu(  ){
		$this->left_menu = '';
	}
	public function reset_right_menu(  ){
		$this->right_menu = '';
	}
	public function reset_corps(  ){
		$this->corps = '';
	}
	public function reset_pied(  ){
		$this->pied = '';
	}
}

// Lance la structure de la page : HTML + HEAD
class page_generate_head extends page_generate_template{
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		if( isset( $_Params['auto_insert_head']) )
			$this->generate_head( $_Params );
	}
	
	protected function generate_head( $_Params ){
		$this->reset_head();
		$this->insert_head( $this->make_head( $_Params['titre'], 
												$_Params['css'], 
												isset($_Params['redir']['path'])?$_Params['redir']['path'] : '',
												isset($_Params['redir']['time'])?$_Params['redir']['time'] : '',
												isset($_Params['charset'])?$_Params['charset'] : "iso-8859-1"
											)
							);
		
	}
}

// Création de la Banniere (simple concaténation des différentes parties précédemment définies)
class page_generate_banniere extends page_generate_head{
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		if( isset( $_Params['auto_insert_banniere'] ) )
			$this->generate_banniere($_Params);
	}
	
	protected function generate_banniere( $_Params ){
		$banniere_content = $this->make_logo( 	isset( $_Params['appli_name'] )? $_Params['appli_name'] : '',
												isset( $_Params['logo_url'] )? $_Params['logo_url'] : '',
												isset( $_Params['logo_height'] )? $_Params['logo_height'] : '',
												isset( $_Params['logo_width'] )? $_Params['logo_width'] : ''
											);
		$banniere_content .= $this->make_login(	isset( $_Params['login_action'] )? $_Params['login_action'] : '' );
		
		// Insertion de la banniere (LOGO + Login)
		$this->reset_banniere( );
		$this->insert_banniere( $this->make_banniere( $banniere_content ) );
		// Insertion du menu horizontal
		$this->insert_banniere( $this->make_menu_banniere(	isset( $_Params['menu_banniere'] )? $_Params['menu_banniere'] : '' ) );			
	}
}

// Création du menu à gauche
class page_generate_left_menu extends page_generate_banniere{
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		if( isset( $_Params['auto_insert_left_menu'] ) )
			$this->generate_left_menu( $_Params );
	}
	
	protected function generate_left_menu( $_Params ){
		if( isset( $_Params['menu_left'] ) ){
			$this->reset_left_menu();
			$this->insert_left_menu( $this->make_left_menu($_Params['menu_left'], isset( $_Params['menu_left_titre'] )?$_Params['menu_left_titre']:'' ));
		} 
	}
}
// Création du menu à droite
class page_generate_right_menu extends page_generate_left_menu{
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		if( isset( $_Params['auto_insert_right_menu'] ) )
			$this->generate_right_menu( $_Params );
	}
	
	protected function generate_right_menu( $_Params ){
		if( isset( $_Params['menu_right'] ) ){
			$this->reset_right_menu();
			$this->insert_right_menu( $this->make_right_menu($_Params['menu_right'] ));
		}
	}
}



// Construction du corps
class page_generate_corps_items extends page_generate_right_menu{
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
		if( isset( $_Params['auto_insert_corps_note'] ) )
			$this->generate_corps_notes( $_Params );
		else if( isset( $_Params['auto_insert_corps_accueil'] ) )
			$this->generate_corps_accueil( $_Params );
		else if( isset( $_Params['auto_insert_corps_projet'] ) )
			$this->generate_corps_projets( $_Params );
	}
	
	public function generate_corps_projets( $_Params ){
		$corps = '';
		
		//// Partie Projet
		// La barre d'onglet 
		if( isset( $_Params['onglets_haut'] ) )
			$corps .= $this->make_note_onglets( $_Params['onglets_haut'] );			
			
		$note_corps = '';
		// titre
		if( isset( $_Params['proj_titre'] ) )
			$note_corps .= $this->make_note_titre( $_Params['proj_titre'] );
		// Description
		if( isset( $_Params['proj_description'] ) )
			$note_corps .= $this->make_note_descript( $_Params['proj_description'] );
		// Pied de note
		if( isset( $_Params['proj_pied'] ) )
			$note_corps .= $this->make_note_pied( $_Params['proj_pied'] );
		
		
		// On fait un div avec la partie NOTE que l'on met dans le CORPS
		if( $note_corps != '' )
			$corps .= $this->make_note_corps( $note_corps );
					
		// Barre d'onglet
		if( isset( $_Params['onglets_bas'] ) )
			$corps .= $this->make_note_onglets( $_Params['onglets_bas'] );
			
			
			
		//// Partie Notes
		if( isset( $_Params['notes'] ) ){
			$corps .= '<br/>Liste des Notes rattachées a ce projet :<br/>';
			for( $i=0; $i < count( $_Params['notes'] ); $i++ ){
				// La barre d'onglet 
				if( isset( $_Params['notes'][$i]['onglets_haut'] ) )
					$corps .= $this->make_note_onglets( $_Params['notes'][$i]['onglets_haut'] );			
					
				$note_corps = '';
				//// Partie 'note'
				// titre
				if( isset( $_Params['notes'][$i]['note_titre'] ) )
					$note_corps .= $this->make_note_titre( $_Params['notes'][$i]['note_titre'] );
				// Description
				if( isset( $_Params['notes'][$i]['note_description'] ) )
					$note_corps .= $this->make_note_descript( $_Params['notes'][$i]['note_description'] );
				// Pied de note
				if( isset( $_Params['notes'][$i]['note_pied'] ) )
					$note_corps .= $this->make_note_pied( $_Params['notes'][$i]['note_pied'] );
				
				//// On fait un div avec la partie NOTE que l'on met dans le CORPS
				if( $note_corps != '' )
					$corps .= $this->make_note_corps( $note_corps );
							
				// Barre d'onglet
				if( isset( $_Params['notes'][$i]['onglets_bas'] ) )
					$corps .= $this->make_note_onglets( $_Params['notes'][$i]['onglets_bas'] );
			} 		
		}
		
		$this->reset_corps();
		$this->insert_corps( $this->make_corps( $corps  ) );
	}
	public function generate_corps_notes( $_Params ){
		//// Partie CORPS
		$corps = '';
		
/* 		// La partie supérieure permettant de mettre un titre puis une breve description
		if( isset( $_Params['corps_titre'] ) )
			$corps .= $this->make_titre( $_Params['corps_titre'] );
		if( isset( $_Params['corps_description'] ) )
			$corps .= $this->make_descript( $_Params['corps_description'] );
		 */	
		// La barre d'onglet 
		if( isset( $_Params['onglets_haut'] ) )
			$corps .= $this->make_note_onglets( $_Params['onglets_haut'] );			
			
			
		$note_corps = '';
		//// Partie 'note'
		// titre
		if( isset( $_Params['note_titre'] ) )
			$note_corps .= $this->make_note_titre( $_Params['note_titre'] );
		// Description
		if( isset( $_Params['note_description'] ) )
			$note_corps .= $this->make_note_descript( $_Params['note_description'] );
		// Pied de note
		if( isset( $_Params['note_pied'] ) )
			$note_corps .= $this->make_note_pied( $_Params['note_pied'] );
		
		
		//// On fait un div avec la partie NOTE que l'on met dans le CORPS
		if( $note_corps != '' )
			$corps .= $this->make_note_corps( $note_corps );
					
		// Barre d'onglet
		if( isset( $_Params['onglets_bas'] ) )
			$corps .= $this->make_note_onglets( $_Params['onglets_bas'] );
			
		$this->reset_corps();
		$this->insert_corps( $this->make_corps( $corps  ) );
	}
	public function generate_corps_accueil( $_Params ){
		//// Partie CORPS
		$corps = '';
		
		// La partie supérieure permettant de mettre un titre puis une breve description
		if( isset( $_Params['corps_titre'] ) )
			$corps .= $this->make_titre( $_Params['corps_titre'] );
		if( isset( $_Params['corps_description'] ) )
			$corps .= $this->make_descript( $_Params['corps_description'] );
		
		$this->reset_corps();
		$this->insert_corps( $this->make_corps( $corps  ) );
	}
}









// Affiche le div du corps
class c_page_maker extends page_generate_corps_items{
	public function __construct( $_Params = '' ){
		parent::__construct( $_Params );
		
	}
	
	public function __toString(){
		$this->reset_body();
		$this->insert_body( $this->banniere );
		$this->insert_body( $this->left_menu );
		$this->insert_body( $this->right_menu );
		$this->insert_body( $this->corps );
		$this->insert_body( $this->pied );
		
		return parent::__toString();
	}
}

class c_page extends c_page_maker{
}


?>
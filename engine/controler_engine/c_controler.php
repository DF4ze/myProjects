<?php
/************************************************************************************************************************\
Fichier : c_controler.php
Auteur : c.ortiz 
Date : 16/07/2013
Description : 
1ere page de gestion du CONTROLER.
Va faire la "jointure" entre le moteur MODELE et le moteur GRAPHIQUE.
\*************************************************************************************************************************/
class c_get_manager extends constants{
	protected $a_get; // tab qui contiendra uniquement les GET qu'on a besoin.
		
	protected function auto_manage_get( ){
		// fonction qui a pour but d'automatiser la gestion des variables passées en GET.
		$this->manage_get( $this->get_param_from_string( $_SERVER['QUERY_STRING'] ) );
	} 
	protected function manage_get( $get ){
		// fonction qui a pour but d'etre redef.
		// ELle permettra, suite a la reception du GET de réaliser les actions necessaire a la classe en cours lorsqu'on receptionnera le GET approprié.
		
		// Il faudra donc :
		// - Lancer les actions necessaire
		// Plus d'actualité : - NE PAS OUBLIER d'enregistrer cette variable dans le a_get --> permet le GET_GETLINE()
		
		$this->a_get = array();
		foreach( $get as $key => $value  ){
			$this->a_get[ $key ] = $value;
		} 
	} 

	protected function get_param_from_string( $query_string ){
		$a_get = array();
		if( $query_string != '' ){
			// Dans un 1er temps, on récupère les groupements "Key = Value"
			// $count = 0;
			$pos1 = 0;
			$tab_keyvalue = array();
			// Faire ... Tant que ...
			do{
				// est-ce qu'on trouve un '&'?
				$pos2 = strpos( $query_string, '&', $pos1 );
				if( $pos2 !== false )
					// Oui, alors on extrait entre la position initiale et la position trouvée.
					$tab_keyvalue[] = substr( $query_string, $pos1, $pos2-$pos1 );
				else
					// Non, alors on récupère de la position initiale jusqu'a la fin.
					$tab_keyvalue[] = substr( $query_string, $pos1 );
					
				// Réinitialisation de la position initiale
				$pos1 = false;
				if( $pos2 !== false )
					$pos1 = $pos2+1;
			// ... Tant que ... Il n'y a plus de '&' donc on sort de la boucle.
			}while( $pos1 !== false );
	
		
			
			// Dans un 2nd temps, on sépare les 'Key' des 'Value'
			for( $i=0; $i < count( $tab_keyvalue ); $i++ ){
				$pos1 = 0;			
				// est-ce qu'on trouve un '='?
				$pos2 = strpos( $tab_keyvalue[$i], '=', $pos1 );
				if( $pos2 !== false ){
					// Oui, 
					// entre la position initiale et la position trouvée ==> OFFSET du $_GET
					// entre la position trouvé et la fin ==> Valeur du $_GET.
					$a_get[ substr( $tab_keyvalue[$i], $pos1, $pos2-$pos1 ) ] = substr( $tab_keyvalue[$i], $pos2+1 );
					
				}else
					// Non, alors on retourne une erreur...
					$a_get = false;
			
			}
		}
		return $a_get;
	}
	protected function get_getline(){
		$buff = '';
		$count = 0;
		if( count( $this->a_get ) )
		foreach( $this->a_get	as $key => $value  ){
			$buff .= $key.'='.$value;
			if( $count++ < count( $this->a_get )-1 )
				$buff .= '&';
		} 
		return $buff;
	}
	protected function get_page_html_get(){
		$buff = $this->get_page_html();
		//if( $this->get_getline() != '' ) // sans le IF, on est sur qu'on a toujours un ? a la fin ;) et pas de besoin de le calculer plus tard :):):)
		$buff .= '?'.$this->get_getline();
		return $buff;
	}
	protected function get_page_html_get_readytoadd(){
		$buff = $this->get_page_html();
		if( $this->get_getline() == '' )
			$buff .= '?';
		else
			$buff .= '?'.$this->get_getline().'&';
		return $buff;
	}
}

class c_controler extends c_get_manager{

}


?>
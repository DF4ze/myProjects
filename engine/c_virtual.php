<?php
/************************************************************************************************************************\
Fichier : c_virtual.php
Auteur : c.ortiz 
Date : 19/06/2013
Description : 
Class qui ... laisse un peu de place pour la gestion du debug
\*************************************************************************************************************************/


class virtual{
	protected $debug;
	
	public function __construct( $_Params = '' ){
		if( isset( $_Params['debug'] ) )
			$this->debug = $_Params['debug'];
		else
			$this->debug = true;
	}
}

?>
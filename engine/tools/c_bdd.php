<?php
/************************************************************************************************************************\
Fichier : c_bdd.php
Auteur : c.ortiz 
Date : 19/06/2013
Description : 
Class qui va gérer les interactions avec la bdd
\*************************************************************************************************************************/


class connect_bdd extends c_tools{
	// protected $mysqli;
	private $connected = false;
    private static $count_connect = 0; // On ne va lancer qu'une seule connexion a la BDD ... que l'on va réutiliser pour les autres classes.
    protected static $mysqli;
	
	public function __construct( $_Params = '' ){ 
		parent::__construct( $_Params );
		
		$_Custom_Params = array();
		
		if( isset( $_Params['bdd_user'] ) )
			$_Custom_Params['bdd_user'] = $_Params['bdd_user'] ;
		
		if( isset( $_Params['bdd_pwd'] ) )
			$_Custom_Params['bdd_pwd'] = $_Params['bdd_pwd'];
		
		if( isset( $_Params['bdd_base'] ) )
			$_Custom_Params['bdd_base'] = $_Params['bdd_base'];
			
		if( isset( $_Params['bdd_server'] ) )
			$_Custom_Params['bdd_server'] = $_Params['bdd_server'];

		
		$this->change_const( $_Custom_Params );
		$this->connect();
	}
	public function __destruct(){
		if( $this->is_connected() ) $this->disconnect();
		// echo "Destruct BDD!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!<br/>";
	}
	
	public function connect(){
		if( connect_bdd::$count_connect == 0 ){
			connect_bdd::$mysqli = new mysqli( $this->const['bdd_server'], $this->const['bdd_user'], $this->const['bdd_pwd'], $this->const['bdd_base']);
			
			if (connect_bdd::$mysqli->connect_errno) {
				if( $this->debug )
					echo "Echec lors de la connexion à MySQL : (" . connect_bdd::$mysqli->connect_errno . ") " . connect_bdd::$mysqli->connect_error.'<br/>';
				$this->connected = false;
				return false;
			}	
		}
		connect_bdd::$count_connect++;
		$this->connected = true;	
		return true;
	}
	
	public function disconnect(){
		if( $this->is_connected() ){
			if( connect_bdd::$count_connect < 2 ){
				connect_bdd::$mysqli->close();
			}
			connect_bdd::$count_connect--;	
			$this->connected = false;
		}
	}
	
	public function is_connected(){
		return $this->connected;
	}
}


class querying_bdd extends connect_bdd{
	private $result = array();
	
	public function __construct( $_Params = '' ){ 
		parent::__construct( $_Params );
		
		if( isset( $_Params['bdd_query'] ) and $this->is_connected() )
			$this->query( $_Params['bdd_query'] );
	}
	public function __destruct(){
		if( $this->is_connected() ) $this->free_result();

		parent::__destruct();
	}

	public function query( $query ){
		$ok = false;
		if( $this->is_connected() ){
			if( $this->debug )
				echo "Query : $query<br/>";
			
			$this->free_result();
			$this->result = connect_bdd::$mysqli->query( $query );
			
			if( $this->result !== false )
				$ok = $this->result;
			else 
				if( $this->debug )
					echo "La requete $query a retourné une erreur<br/>";
		}else
			if( $this->debug )
				echo "Pas connecté : Ne peut pas lancer la requete : $query<br/>";
		
		return $ok;
	}
	
	public function query_tabresult( $query, $numeric = false ){
		$result = array();
		$this->free_result();
		
		if( $this->query( $query ) )
			$result = $this->get_tabresult( $numeric );
		else
			$result = false;
			
		return $result;
	}
	
	public function get_result(){
		return $this->result;
	}
	public function get_tabresult( $numeric = false ){
		$result = array();
	
		if( is_a( $this->result, 'mysqli_result' ) ){
			$count = 0;
			$this->result->data_seek(0);
			while( $row = $this->result->fetch_array() ){
				foreach( $row as $key => $value )
					if( $numeric AND is_numeric($key) )
						$result[$count][$key] = $value;
					else if(!$numeric AND !is_numeric($key))
						$result[$count][$key] = $value;
				$count++;
			}
		}else
			$result = false;
					
		return $result;
	}
	protected function free_result(){
		if( is_a( $this->result, 'mysqli_result' ) )
				@$this->result->free();
	}
}

class secure_bdd extends querying_bdd{
	
	public function escape_string($query ){
		return connect_bdd::$mysqli->escape_string( $query  );
	}
}

class query_creator extends secure_bdd{

	private function select_from( $champ, $table ){
		return "SELECT ".$champ." FROM ".$table;
	}
	private function where( $where_clause ){
		return " WHERE ".$where_clause;
	}
	private function clause( $champ, $valeur ){
		return $champ." = '".$this->escape_string($valeur)."' ";
	}
	private function clauses( $a_clauses ){
		$query = '';
		// if( $this->debug )
			// echo 'nb clauses : '.count( $a_clauses) .'<br/>';
		if( count( $a_clauses ) ){
			for( $i=0; $i < count( $a_clauses ); $i++ ){
				$query .= $this->clause( $a_clauses[$i]['champ'], $a_clauses[$i]['valeur'] );
				if( $i < count( $a_clauses ) -1 )
					$query .= 'AND ';
			}
		}else
			if( $this->debug )
				echo "Nombre de clauses égal à 0<br/>";
		return $query;
		
	}
	private function where_clauses( $a_clauses ){
		return ' WHERE '.$this->clauses( $a_clauses );
	}
	private function limit( $pos, $pas ){
		return ' LIMIT '.$pos.', '.$pas;
	}
	private function order_by( $champ, $sens ){
		return ' ORDER BY '.$champ.' '.$sens;
	}
	
	// 	'champ' et 'table' sont obligatoires sinon return false, 
	//
	//	et/ou
	//
	//  'where_clause' (string qui contient le texte apres WHERE : plusieurs clauses voir meme un LIMIT et un ORDER BY)
    //	ou 'clause' ( comparaison, doit etre un tableau avec 'champ' et 'valeur' )
	//	ou 'clauses' ( tableau de clause indexé de 0 à X )
	//  sont optionnels 
	//  
	//  et/ou
	//  
	//	'limit' (tableau contenant 'pos' et 'pas')
	// 	et/ou 'order_by'(tableau contenant 'champ' et 'sens')
	//  sont optionnels 
	public function create_query( $_Params ){
		if( isset( $_Params['table'])){
			$query = $this->select_from( (isset( $_Params['champ'] ))?$_Params['champ']:'*', $_Params['table'] );
			
			if( isset( $_Params['where_clause'] ) )
				$query .= $this->where( $_Params['where_clause'] );
			else if( isset( $_Params['clause'] ) ){
				if( isset( $_Params['clause']['champ'], $_Params['clause']['valeur'] ) )
					$query .= $this->where( $this->clause( $_Params['clause']['champ'], $_Params['clause']['valeur'] ));
				else if( $this->debug )
					echo "['clause']['champ'] et ['clause']['valeur'] sont obligatoires <br/>";
			}else if( isset( $_Params['clauses'] ) ){
				$query .= $this->where_clauses( $_Params['clauses'] );
			}
				
			if( isset( $_Params['order_by'] ) )
				if( isset( $_Params['order_by']['champ'], $_Params['order_by']['sens'] ) )
					$query .= $this->order_by( $_Params['order_by']['champ'], $_Params['order_by']['sens'] );
				else if( $this->debug )
					echo "['order_by']['champ'] et ['order_by']['sens'] sont obligatoires <br/>";
				
			if( isset( $_Params['limit'] ) )
				if( isset( $_Params['limit']['pos'], $_Params['limit']['pas'] ) )
					$query .= $this->limit( $_Params['limit']['pos'], $_Params['limit']['pas'] );
				else if( $this->debug )
					echo "['limit']['pos'] et ['limit']['pas'] sont obligatoires <br/>";

			return $query;
		}else
			if( $this->debug )
				echo "['table'] est obligatoire.<br/>";
		return false;
	}	

}





class c_bdd extends query_creator{
	
}




?>
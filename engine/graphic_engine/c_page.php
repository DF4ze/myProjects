<?php
/************************************************************************************************************************\
Fichier : c_page.php
Auteur : c.ortiz 
Date : 05/06/2013
Description : 
Class qui va nous permettre de creer des pages HTML.
Les outils basiques sont présent telle que la création d'un 'head' avec le charset, title, icone, css redir et javascript.
Pour le 'body' il est possible de creer des formulaires avec des inputs basiques
également possible de creer un div.
\*************************************************************************************************************************/


// require_once( '../c_constants.php' );

class html_page_structure extends c_vue{
	private $inserted_head = '';
	private $inserted_body = '';
	
	protected function get_html_opening(){
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">';
	}
	protected function get_html_closing(){
		return '</html>';
	}
	
	protected function get_head_opening(){
		return '<head>';
	}
	protected function get_head_closing(){
		return '</head>';
	}
	protected function reset_head(){
		$this->inserted_head = '';
	}
	
	protected function get_body_opening(){
		return '<body>';
	}
	protected function get_body_closing(){
		return '</body>';
	}
	protected function reset_body(){
		$this->inserted_body = '';
	}
	
	public function insert_head( $inserted_head ){
		$this->inserted_head .= $inserted_head;
	}
	public function insert_body( $inserted_body ){
		$this->inserted_body .= $inserted_body;
	}
	
	public function clear_head(){
		$this->inserted_head = '';
	}
	public function clear_body(){
		$this->inserted_body = '';
	}
	public function clear_page(){
		$this->clear_body();
		$this->clear_head();
	}
	
	public function make_page(){
		$page = '';
		
		$page .= $this->get_html_opening();
		
		$page .= $this->get_head_opening();
		$page .= $this->inserted_head;
		$page .= $this->get_head_closing();
		
		$page .= $this->get_body_opening();
		$page .= $this->inserted_body;
		$page .= $this->get_body_closing();
		
		$page .= $this->get_html_closing();
	
		//$this->clear_page(); // Ne pas reset le corps apres un make : Souvent utilisé en direct sur l'affichage de la page : Du coup la classe est vide apres un affichage... et on ne peut plus la serialiser....!
		return $page;
	}
}

class html_items_head extends html_page_structure{
	private $inserted_javascript = '';
	private $inserted_meta = '';

	protected function get_meta_charset( $charset ){
		return '<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'" />';
	}
	protected function get_meta_title( $title ){
		return '<title>'.$title.'</title>';
	}
	protected function get_meta_ico( $path_ico ){
		return '<link rel="shortcut icon" type="image/x-icon" href="'.$path_ico.'" />';
	}
	protected function get_meta_css( $path_css ){
		return '<link rel="stylesheet" media="screen" type="text/css" title="Design" href="'.$path_css.'" />';
	}
	protected function get_meta_redir( $path_redir, $time = 0 ){
		return '<META HTTP-EQUIV="Refresh" CONTENT="'.$time.';URL='.$path_redir.'">';
	}
	protected function get_javascript_opening( ){
		return '<!-- <script type="text/javascript">';
	}
	protected function get_javascript_closing( ){
		return '</script > -->';
	}
	protected function insert_javascript( $inserted_javascript ){
		$this->inserted_javascript .= $inserted_javascript;
	}
	protected function insert_meta( $meta ){
		$this->inserted_meta .= $meta; 
	}
	protected function clear_javascript( ){
		$this->inserted_javascript = '';
	}
	protected function clear_meta( ){
		$this->inserted_meta = ''; 
	}
	
	protected function make_javascript(){
		$js = $this->get_javascript_opening();
		$js .= $this->inserted_javascript;
		$js .= $this->get_javascript_closing();
		
		$this->clear_javascript();
		return $js;
	}
	public function make_head( $title, $path_css, $path_ico = '', $path_redir = '', $time = 0, $charset = "iso-8859-1" ){
		$head = $this->get_meta_title( $title );
		$head .= $this->get_meta_css( $path_css );
		$head .= $this->get_meta_charset( $charset );
		
		if( $path_ico != '' )
			$head .= $this->get_meta_ico( $path_ico );
		if( $path_redir != '' )
			$head .= $this->get_meta_redir( $path_redir, $time );
		if( $this->inserted_javascript != '' )
			$head .= $this->make_javascript( );
		if( $this->inserted_meta != '' )
			$head .= $this->inserted_meta;
			
		$this->clear_head();
		return $head;
	}
}

class html_items_body_basic extends html_items_head{
	private $inserted_inputs = '';
	
	public function make_div( $class, $content, $id = '', $perso = '' ){
		$div = '<div class="'.$class.'"';
		if( $id != '' )
			$div .= ' id="'.$id.'"';
		if( $perso != '' )
			$div .= ' '.$perso;
		$div .= '>';
		
		$div .= $content;
		
		$div .= '</div>';
		
		return $div;
	}
	public function make_input( $type, $name = '', $value = '', $class = '', $id = '', $perso = '' ){
		$input = '<input type="'.$type.'" ';
		if( $name != '' )
			$input .= 'name="'.$name.'" ';
		if( $value != '' )
			$input .= 'value="'.$value.'" ';
		if( $class != '' )
			$input .= 'class="'.$class.'" ';
		if( $id != '' )
			$input .= 'id="'.$id.'" ';
		if( $perso != '' )
			$input .= $perso.' ';
			
		$input .= '/>';
		
		return $input;
	}
	public function make_form( $action, $method, $id = '' ){
		$form = $this->get_form_opening( $action, $method, $id );
		$form .= $this->inserted_inputs;
		$form .= $this->get_form_closing();
		
		$this->clear_form();
		
		return $form;
	}
	protected function get_form_opening( $action, $method, $id = ''){
		$form = '<form action="'.$action.'" method="'.$method;
		if( $id == '' )
			$form .= ' id="'.$id.'"';
		$form .= '">';
			
		return $form;
	}
	protected function get_form_closing( ){
		return '</form>';
	}
	public function get_image( $url, $title = '', $perso = '' ){
		$img = '<img src="'.$url.'" title="';
		if( $title == '' )
			$img .= $url.'" ';
		else
			$img .= $title.'" ';
		
		if( $perso != '' )
			$img .= $perso.' ';
		
		return $img.'/>';
	}
	public function insert_inputs( $inputs ){
		$this->inserted_inputs .= $inputs;
	}
	public function clear_form( ){
		$this->inserted_inputs = '';
	}
}

class cPage extends html_items_body_basic{
	public function __toString(){
		return $this->make_page();
	}
}
?>
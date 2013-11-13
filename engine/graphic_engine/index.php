<?php

require_once( "c_page_maker.php" );


$_Params['auto_insert_head'] = true;
$_Params['titre'] = 'Titre de la page';
$_Params['css'] = 'design.css';

$_Params['auto_insert_banniere'] = true;
$_Params['appli_name'] = 'MyProjectv2';
$_Params['logo_url'] = '';
$_Params['login_action'] = 'index.php';
$_Params['menu_banniere'][0]['texte'] = '1er';
$_Params['menu_banniere'][0]['url'] = 'http://www.google.fr';
$_Params['menu_banniere'][1]['texte'] = '2eme';
$_Params['menu_banniere'][1]['url'] = 'http://www.google.fr';
$_Params['menu_banniere'][2]['texte'] = '3eme';
$_Params['menu_banniere'][2]['url'] = 'http://www.google.fr';
$_Params['menu_banniere'][3]['texte'] = '4eme';
$_Params['menu_banniere'][3]['url'] = 'http://www.google.fr';

$_Params['auto_insert_left_menu'] = true;
$_Params['menu_left_titre'] = 'Titre';
$_Params['menu_left'][0]['texte'] = '1.texte';
$_Params['menu_left'][0]['lien'] = '1.texte';
$_Params['menu_left'][1]['texte'] = '2.texte';
$_Params['menu_left'][1]['lien'] = '2.texte';
$_Params['menu_left'][2]['texte'] = '3.texte';
$_Params['menu_left'][2]['lien'] = '3.texte';
$_Params['menu_left'][0]['arbo'][0]['texte'] = '1.1.texte';
$_Params['menu_left'][0]['arbo'][0]['lien'] = '1.1.texte';
$_Params['menu_left'][0]['arbo'][1]['texte'] = '1.2.texte';
$_Params['menu_left'][0]['arbo'][1]['lien'] = '1.2.texte';
$_Params['menu_left'][1]['arbo'][0]['texte'] = '2.1.texte';
$_Params['menu_left'][1]['arbo'][0]['lien'] = '2.1.texte';
$_Params['menu_left'][1]['arbo'][1]['texte'] = '2.2.texte';
$_Params['menu_left'][1]['arbo'][1]['lien'] = '2.2.texte';
$_Params['menu_left'][0]['arbo'][0]['arbo'][0]['texte'] = '1.1.1texte';
$_Params['menu_left'][0]['arbo'][0]['arbo'][0]['lien'] = 'http://www.google.fr'; 

$_Params['auto_insert_right_menu'] = true;
$_Params['menu_right']= '1.menu_right';
// $_Params['menu_right'][0]['texte'] = '1.menu_right';
// $_Params['menu_right'][0]['lien'] = '1.menu_right';
 


$_Params['auto_insert_corps_note'] = true;
// $_Params['auto_insert_corps_accueil'] = true;
$_Params['corps_titre'] = 'Titre pour le corps';
$_Params['corps_description'] = 'Description qui apparaitra juste en dessous du titre principal';
$_Params['note_titre'] = 'Titre pour une note';
$_Params['note_description'] = 'note_decriptionnote_decriptionnote_decriptionnote_decriptionnote_decriptionnote_decriptionnote_decriptionnote_decriptionnote_decription<a href="dtc">sdfqwsdfsqsdfqsdf qsdfqsdf qsdf gsqgqsdfg sdfgdfgs fsdfg gsdfgsdf g</a>';
$_Params['note_pied'] = 'note_pied';
$_Params['onglets_haut'][0]['texte'] = 'texte1texte1texte1texte1txte1texte1tetexte1texte1texte1texte1texte1texte1t';
$_Params['onglets_haut'][0]['lien'] = 'texte1';
$_Params['onglets_haut'][1]['texte'] = 'texte2texte2texte2tex';
$_Params['onglets_haut'][1]['lien'] = 'texte2';
$_Params['onglets_haut'][2]['texte'] = 'texte3texte3texte3texte3text';
$_Params['onglets_haut'][2]['lien'] = 'texte3';
$_Params['onglets_haut'][3]['texte'] = 'texte4';
$_Params['onglets_haut'][3]['lien'] = 'texte4';
/* $_Params['onglets_haut'][4]['texte'] = 'texte5texte1texte1texte1texte1ttexte1texte1texte1texte1texte1ttexte1texte1texte1texte1texte1ttexte1texte1texte1texte1texte1ttexte1texte1texte1texte1texte1ttexte1texte1texte1texte1texte1t';
$_Params['onglets_haut'][4]['lien'] = 'texte5';
$_Params['onglets_haut'][5]['texte'] = 'texte6texte6texte6texte6texte6texte6texte6texte6texte6texte6';
$_Params['onglets_haut'][5]['lien'] = 'texte2';
$_Params['onglets_haut'][6]['texte'] = 'texte7texte7texte7texte7texte7texte7texte7texte7texte7texte7texte7';
$_Params['onglets_haut'][6]['lien'] = 'texte3';
$_Params['onglets_haut'][7]['texte'] = 'texte8texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3';
$_Params['onglets_haut'][7]['lien'] = 'texte3';
$_Params['onglets_haut'][8]['texte'] = 'texte9texte9texte9texte9texte9texte9texte9texte9texte9texte9';
$_Params['onglets_haut'][8]['lien'] = 'texte3';
$_Params['onglets_haut'][9]['texte'] = 'texte10texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3';
$_Params['onglets_haut'][9]['lien'] = 'texte3';   */

$_Params['onglets_bas'][0]['texte'] = 'texte1texte1texte1texte1texttee1texte1texte1texte1texte1t';
$_Params['onglets_bas'][0]['lien'] = 'texte1';
$_Params['onglets_bas'][1]['texte'] = 'texte2texte2texte2texte2texte2texte2texte2texte2texte2texte2texte2texte2';
$_Params['onglets_bas'][1]['lien'] = 'texte2';
$_Params['onglets_bas'][2]['texte'] = 'texte3texte3texte3texte3texte3texte3texte3texte3texte3texte3';
$_Params['onglets_bas'][2]['lien'] = 'texte3';
$_Params['onglets_bas'][3]['texte'] = 'texte4texte4texte4texte4texte4texte4texte4texte4texte4texte4texte4texte4texte4';
$_Params['onglets_bas'][3]['lien'] = 'texte4'; 



$page = new c_page_maker( $_Params );

// echo /* htmlspecialchars( */$page/* ) */;

/* $page->reset_left_menu();
$page->insert_left_menu( $page->make_div('menu_left', "coucou"));
 */
echo $page;


?>
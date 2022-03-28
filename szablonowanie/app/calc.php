<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
//załaduj Smarty
require_once _ROOT_PATH.'/lib/smarty/libs/Smarty.class.php';

//pobranie parametrów
function getParams(&$form){
    $form['N']  = isset($_REQUEST['N']) ? $_REQUEST['N'] : null;
    $form['o']  = isset($_REQUEST['o']) ? $_REQUEST['o'] : null;
    $form['r']  = isset($_REQUEST['r']) ? $_REQUEST['r'] : null;
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$form,&$infos,&$msgs,&$hide_intro){

	//sprawdzenie, czy parametry zostały przekazane - jeśli nie to zakończ walidację
	if ( ! (isset($form['N']) && isset($form['o']) && isset($form['r']) ))	return false;
	
	//parametry przekazane zatem
	//nie pokazuj wstępu strony gdy tryb obliczeń (aby nie trzeba było przesuwać)
	// - ta zmienna zostanie użyta w widoku aby nie wyświetlać całego bloku itro z tłem 
	$hide_intro = true;

	$infos [] = 'Przekazano parametry.';

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $form['N'] == "") $msgs [] = 'Nie podano kwoty kredytu';
	if ( $form['o'] == "") $msgs [] = 'Nie podano okresu spłaty';
    if ( $form['r'] == "") $msgs [] = 'Nie podano oprocentowania';
	
	//nie ma sensu walidować dalej gdy brak parametrów
	if ( count($msgs)==0 ) {
		// sprawdzenie, czy $x i $y są liczbami całkowitymi
		if (! is_numeric( $form['N'] )) $msgs [] = 'Pierwsza wartość nie jest liczbą całkowitą';
		if (! is_numeric( $form['o'] )) $msgs [] = 'Druga wartość nie jest liczbą całkowitą';
        if (! is_numeric( $form['r'] )) $msgs [] = 'Trzecia wartość nie jest liczbą ';
	}
	
	if (count($msgs)>0) return false;
	else return true;
}
	
// wykonaj obliczenia
function process(&$form,&$infos,&$msgs,&$result){
	$infos [] = 'Parametry poprawne. Wykonuję obliczenia.';
	
	//konwersja parametrów na int
	$form['N'] = floatval($form['N']);
	$form['o'] = floatval($form['o']);
    $form['r'] = doubleval($form['r']);
	
	//wykonanie operacji
    $years = $form['o'] * 12;
    $percent = $form['r'] / 100;
    $k = 12 / (12 + $percent);

    $rata = ($form['N'] * $percent) / (12 * (1 - ($k ** $years)));
    $result = round($rata, 2);
}

//inicjacja zmiennych
$form = null;
$infos = array();
$messages = array();
$result = null;
	
getParams($form);
if ( validate($form,$infos,$messages,$hide_intro) ){
	process($form,$infos,$messages,$result);
}

// 4. Przygotowanie danych dla szablonu

$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Kalkulator kredytowy');
$smarty->assign('page_description','');
$smarty->assign('page_header','Szablony Smarty');

//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);

// 5. Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/calc.html');
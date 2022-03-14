<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

//pobranie parametrów
function getParams(&$N,&$o,&$r){
	$N = isset($_REQUEST['N']) ? $_REQUEST['N'] : null;
	$o = isset($_REQUEST['o']) ? $_REQUEST['o'] : null;
    $r = isset($_REQUEST['r']) ? $_REQUEST['r'] : null;

}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$N,&$o,&$r,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($N) && isset($o) && isset($r))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $N == "") {
		$messages [] = 'Nie podano kwoty kredytu';
	}
	if ( $o == "") {
		$messages [] = 'Nie podano okresu spłaty';
	}
    if ( $r == "") {
        $messages [] = 'Nie podano oprocentowania';
    }

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $N )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $o )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}

    if (! is_numeric( $r )) {
        $messages [] = 'Trzecia wartość nie jest liczbą ';
    }

    if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$N,&$o,&$r,&$messages,&$result)
{
    global $role;

    //konwersja parametrów
    $N = intval($N);
    $o = intval($o);
    $r = doubleval($r);

    //wykonanie operacji
    if ($role == 'admin') {
        $years = $o * 12;
        $percent = $r / 100;
        $k = 12 / (12 + $percent);

        $rata = ($N * $percent) / (12 * (1 - ($k ** $years)));
        $result = round($rata, 2);
    } else {
       $messages [] = 'Tylko administrator korzystać z kalkulatora !';
    }
}

//definicja zmiennych kontrolera
$N = null;
$o = null;
$r = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($N,$o,$r);
if ( validate($N,$o,$r,$messages) ) { // gdy brak błędów
	process($N,$o,$r,$messages,$result);
}

// Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';
<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$N = $_REQUEST ['N'];
$o = $_REQUEST ['o'];
$r = $_REQUEST ['r'];


// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($N) && isset($o) && isset($r) )) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $N == "") {
	$messages [] = 'Nie podano liczby 1';
}
if ( $o == "") {
	$messages [] = 'Nie podano liczby 2';
}
if ( $r == "") {
	$messages [] = 'Nie podano liczby 3';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $N )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $o )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}	

	if (! is_numeric( $r )) {
			$messages [] = 'Trzecia wartość nie jest liczbą';
		}	

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int i double
	$N = intval($N);
	$o = intval($o);
	$r = doubleval($r);
	
	
	//wykonanie operacji
	
	
	$years = $o * 12;
	$percent = $r/100;
	$k = 12/(12+$percent);
	
	
	
	$rata = ($N * $percent)/ (12*(1-($k**$years)));
	$result = round($rata,2);
	
}

// 4. Wywołanie widoku z przekazaniem zmiennych


include 'calc_view.php';
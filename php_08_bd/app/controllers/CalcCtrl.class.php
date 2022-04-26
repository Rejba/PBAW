<?php
// W skrypcie definicji kontrolera nie trzeba dołączać już niczego.
// Kontroler wskazuje tylko za pomocą 'use' te klasy z których jawnie korzysta
// (gdy korzysta niejawnie to nie musi - np używa obiektu zwracanego przez funkcję)

// Zarejestrowany autoloader klas załaduje odpowiedni plik automatycznie w momencie, gdy skrypt będzie go chciał użyć.
// Jeśli nie wskaże się klasy za pomocą 'use', to PHP będzie zakładać, iż klasa znajduje się w bieżącej
// przestrzeni nazw - tutaj jest to przestrzeń 'app\controllers'.

// Przypominam, że tu również są dostępne globalne funkcje pomocnicze - o to nam właściwie chodziło

namespace app\controllers;

//zamieniamy zatem 'require' na 'use' wskazując jedynie przestrzeń nazw, w której znajduje się klasa
use app\forms\CalcForm;
use app\transfer\CalcResult;

/** Kontroler kalkulatora
 *
 *
 */
class CalcCtrl {

	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
        $this->form->sum = getFromRequest('sum');
        $this->form->period = getFromRequest('period');
        $this->form->percent = getFromRequest('percent');
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
        if (! (isset ( $this->form->sum ) && isset ( $this->form->period ) && isset ( $this->form->percent ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false;
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
        if ($this->form->sum == "") {
            getMessages()->addError('Nie podano liczby 1');
        }
        if ($this->form->period == "") {
            getMessages()->addError('Nie podano liczby 2');
        }
        if ($this->form->percent == "") {
            getMessages()->addError('Nie podano liczby 3');
        }
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! getMessages()->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
            if (! is_numeric ( $this->form->sum )) {
                getMessages()->addError('Pierwsza wartość nie jest liczbą całkowitą');
            }

            if (! is_numeric ( $this->form->period )) {
                getMessages()->addError('Druga wartość nie jest liczbą całkowitą');
            }
            if (! is_numeric ( $this->form->percent )) {
                getMessages()->addError('Trzecia wartość nie jest poprawną liczbą ');
            }
		}
		
		return ! getMessages()->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function action_calcCompute(){

		$this->getParams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
            $this->form->sum = intval($this->form->sum);
            $this->form->period = intval($this->form->period);
            $this->form->percent = intval($this->form->percent);
            getMessages()->addInfo('Parametry poprawne.');

            //wykonanie operacji
            if (inRole('admin')) {
                $years = $this->form->period * 12;
                $percent_2 = $this->form->percent / 100;
                $k = 12 / (12 + $percent_2);

                $rata = ($this->form->sum * $percent_2) / (12 * (1 - ($k ** $years)));
                $this->result->result = round($rata, 2);
            }
            else{
                getMessages()->addError('Tylko admin może liczyć.');
            }
			getMessages()->addInfo('Wykonano obliczenia.');
		}
		
		$this->generateView();
	}
	
	public function action_calcShow(){
		getMessages()->addInfo('Kalkulator kredytowy, wprowadź dane ');
		$this->generateView();
	}
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){

		getSmarty()->assign('user',unserialize($_SESSION['user']));

		getSmarty()->assign('page_title','Super kalkulator - role');

		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('CalcView.tpl');
	}
}

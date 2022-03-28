<?php
// W skrypcie definicji kontrolera nie trzeba dołączać problematycznego skryptu config.php,
// ponieważ będzie on użyty w miejscach, gdzie config.php zostanie już wywołany.

require_once $conf->root_path.'/lib/smarty/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/calc/CalcForm.class.php';
require_once $conf->root_path.'/app/calc/CalcResult.class.php';

/** Kontroler kalkulatora
 *
 *
 */
class CalcCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
        $this->form->sum = isset($_REQUEST ['sum']) ? $_REQUEST ['sum'] : null;
        $this->form->period = isset($_REQUEST ['period']) ? $_REQUEST ['period'] : null;
        $this->form->percent = isset($_REQUEST ['percent']) ? $_REQUEST ['percent'] : null;
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
            $this->msgs->addError('Nie podano liczby 1');
        }
        if ($this->form->period == "") {
            $this->msgs->addError('Nie podano liczby 2');
        }

        if ($this->form->percent == "") {
            $this->msgs->addError('Nie podano liczby 3');
        }
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! $this->msgs->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
            if (! is_numeric ( $this->form->sum )) {
                $this->msgs->addError('Pierwsza wartość nie jest liczbą całkowitą');
            }

            if (! is_numeric ( $this->form->period )) {
                $this->msgs->addError('Druga wartość nie jest liczbą całkowitą');
            }

            if (! is_numeric ( $this->form->percent )) {
                $this->msgs->addError('Trzecia wartość nie jest poprawna wartością ');
            }
		}
		
		return ! $this->msgs->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getParams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
            $this->form->sum = intval($this->form->sum);
            $this->form->period = intval($this->form->period);
            $this->form->percent = doubleval($this->form->percent);
            $this->msgs->addInfo('Parametry poprawne.');
				
			//wykonanie operacji
            $years = $this->form->period * 12;
            $percent_2 = $this->form->percent / 100;
            $k = 12 / (12 + $percent_2);

            $rata = ($this->form->sum * $percent_2) / (12 * (1 - ($k ** $years)));
            $this->result->result = round($rata, 2);

            $this->msgs->addInfo('Wykonano obliczenia.');
			

		}
		
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		global $conf;
		
		$smarty = new Smarty();
		$smarty->assign('conf',$conf);
		
		$smarty->assign('page_title','Kalkulator kredytowy');
		$smarty->assign('page_description',' ');
		$smarty->assign('page_header',' ');
					
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);
		
		$smarty->display($conf->root_path.'/app/calc/CalcView.html');
	}
}

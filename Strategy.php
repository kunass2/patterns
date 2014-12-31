<?php


/* STRATEGY */

interface Latanie {  //interfejs
	function lec();
}

class mamskrzydla implements Latanie {
	function lec() { echo 'lece bo mam skrzydla'; }
}

class nielot implements Latanie {
	function lec() { echo 'ja nie latam, oleee'; }
}



interface Kwakanie { //interfejs
	function kwacz();
}

class piszcz implements Kwakanie {
	function kwacz() { echo 'piszcze, bo jestem sztuczna kaczka'; }
}

class niekwacz implements Kwakanie {
	function kwacz() { echo 'nie moge kwakac'; }
}


abstract class Kaczka {
	protected $latanie;  //podlaczenie interfejsow do klasy
	protected $kwakanie;

	function __construct($lot, $kwak) {
		$this->latanie = new $lot();
		$this->kwakanie = new $kwak();
	}
	abstract function wyglad();

	function setKwakanie(Kwakanie $kwak) { //typ obiektu mozna wymuszac takze nazwą INTERFEJSU
		$this->kwakanie = $kwak;
	}
	function setLatanie(Latenie $lot) {
		$this->latanie = $lot;
	}

	function lec() {
		$this->latanie->lec();
	}

	function kwacz() {
		$this->kwakanie->kwacz();
	}
}

class DzikaKaczka extends Kaczka { //klasa dzedziczaca
	function wyglad() {
		echo 'jestem dzika kaczka';
	}
}

$p = new DzikaKaczka('nielot', 'piszcz');
$p->lec();
$p->kwacz();
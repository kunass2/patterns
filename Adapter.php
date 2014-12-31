<?php

/* Adapter */

interface Duck {
	function quack();
	function fly();
}

class WildDuck implements Duck {
	function quack() {
		echo 'kwakanie dzikiej kaczki';
	}
	function fly() {
		echo 'latanie dzikiej kaczki';
	}
}

interface Turkey {
	function gobbling();
	function fly();
}

class WildTurkey implements Turkey {
	function gobbling() {
		echo 'gulhotanie indyka';
	}
	function fly() {
		echo 'latanie indyka';
	}
}


/* Adaptacja Indyka jako Kaczki */

class TurkeyAdapter implements Duck, Turkey {
	private $turkey;
	private $duck; //dodatkowa klasa dla adaptera dwustronnego

	function __construct(Turkey $turkey) {
		$this->turkey = $turkey;
	}
	function quack() {
		$this->turkey->gobbling();
	}
	function fly() {
		$this->turkey->fly();
	}

	function gobbling() {
		// adaptacja kaczki na indyka
	}
}

$duck = new WildDuck();
$turkey = new WildTurkey();
$turkeyadapter = new TurkeyAdapter($turkey);

$turkeyadapter->fly();
$turkeyadapter->quack();


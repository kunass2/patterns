<?php

/* State - obiekty przechdzi w rózne stany */

class GumMachine {

	private $stateNoGum;
	private $stateNoCoin;
	private $stateIsCoin;
	private $stateSoldGum;
	private $stateWinner;

	private $state;
	private $n = 0;

	function __construct($n) {
		$this->state = $this->stateNoGum;
		$this->stateNoGum = new StateNoGum($this);
		$this->stateNoCoin = new StateNoCoin($this);
		$this->stateIsCoin = new StateIsCoin($this);
		$this->stateSoldGum = new StateSoldGum($this);
		$this->stateWinner = new StateWinner($this);
		$this->n = $n;
		$this->n > 0 ? $this->state = $this->stateNoCoin : '';
	}

	function putCoin() {
		$this->state->putCoin();
	}

	function returnCoin() {
		$this->state->returnCoin();
	}

	function turnKnob() {
		$this->state->turnKnob();
		$this->state->getGum();
	}

	function setState(State $state) {
		$this->state = $state;
	}

	function releaseGum() {
		echo 'wypada guma';
		$this->n != 0 ? $this->n-- : '';
	}

	function getNumber() {
		return $this->n;
	}

	function getStateIsCoin() {
		return $this->stateIsCoin;
	}
	function getStateNoCoin() {
		return $this->stateNoCoin;
	}
	function getStateNoGum() {
		return $this->stateNoGum;
	}
	function getStateSoldGum() {
		return $this->stateSoldGum;
	}

	function getStateWinner() {
		return $this->stateWinner;
	}
}

interface State {
	function putCoin();
	function returnCoin();
	function turnKnob();
	function getGum();
}

class StateWinner implements State {
	private $gumMachine;

	function __construct(GumMachine $gumMachine) {
		$this->gumMachine = $gumMachine;
	}

	function putCoin() {
		echo 'nie wlozyles monety, wiec nie mozesz wygrac';
	}
	function returnCoin() {
		echo 'zwrot monety oznacza brak wygranej';
	}
	function turnKnob() {
		echo 'przekreciles galke, masz szanse wygrac';
	}
	function getGum() {
		echo 'Wygrałeś, dostajesz gumę!!';
		$this->gumMachine->releaseGum();
		if ($this->gumMachine->getNumber() > 0) :
			$this->gumMachine->setState($this->gumMachine->getStateNoCoin());
		else:
			echo 'nie ma już gum';
			$this->gumMachine->setState($this->gumMachine->getStateNoGum());
		endif;
	}
}

class StateNoCoin implements State {

	private $gumMachine;

	function __construct(GumMachine $gumMachine) {
		$this->gumMachine = $gumMachine;
	}

	function putCoin() {
		echo 'moneta przyjęta';
		$this->gumMachine->setState($this->gumMachine->getStateIsCoin());
	}
	function returnCoin() {
		echo 'nie wlozyles monety';
	}
	function turnKnob() {
		echo 'zanim przekrecisz galke, wrzuc monete';
	}
	function getGum() {
		echo 'najpierw zapłać';
	}
}

class StateNoGum implements State {
	private $gumMachine;

	function __construct(GumMachine $gumMachine) {
		$this->gumMachine = $gumMachine;
	}

	function putCoin() {
		echo 'nie mozna wrzucic monety, automat jest pusty';
	}
	function returnCoin() {
		echo 'zadna moneta nie zostala wrzucona';
	}
	function turnKnob() {
		echo 'obrociles gałkę, ale automat jest pusty';
	}
	function getGum() {
		echo 'nie wydano gumy';
	}
}
class StateIsCoin implements State {
	private $random;
	private $gumMachine;

	function __construct(GumMachine $gumMachine) {
		$this->gumMachine = $gumMachine;
		$this->random = rand(1, 10);
	}

	function putCoin() {
		echo 'nie mozesz wlozyc wiecej niz jednej monety';
	}
	function returnCoin() {
		echo 'moneta zwrócona';
		$this->gumMachine->setState($this->gumMachine->getStateNoCoin());
	}
	function turnKnob() {
		echo 'obrociles gałkę';
		if ($this->random == 1) :
			$this->gumMachine->setState($this->gumMachine->getStateWinner());
		else:
			$this->gumMachine->setState($this->gumMachine->getStateSoldGum());
		endif;
	}
	function getGum() {
		echo 'nie wydano gumy';
	}

}
class StateSoldGum implements State {

	private $gumMachine;

	function __construct(GumMachine $gumMachine) {
		$this->gumMachine = $gumMachine;
	}

	function putCoin() {
		echo 'prosze czekac na gume';
	}
	function returnCoin() {
		echo 'niestety nie mozna zwrocic monety po przeklreceniu galki';
	}
	function turnKnob() {
		echo 'nie dostaniesz gumy tylko dlatego ze przelreciles galke 2 razy';
	}
	function getGum() {
		$this->gumMachine->releaseGum();
		if ($this->gumMachine->getNumber() > 0) :
			$this->gumMachine->setState($this->gumMachine->getStateNoCoin());
		else:
			echo 'Ups, koniec gum:-)';
			$this->gumMachine->setState($this->gumMachine->getStateNoGum());
		endif;
	}
}

$a = new GumMachine(4);
$a->putCoin();
$a->turnKnob();











<?php

/*  Command - polecenie */

interface Command {
	function follow();
}


class Light {

	function turnOn() {
		echo 'swiatlo wlaczone';
	}

	function turnOff() {
		echo 'swiatklo wylaczone';
	}
}

class TurnOnLight implements Command {
	private $light;

	function __construct(Light $light) {
		$this->light = $light;
	}

	function follow() {
		$this->light->turnOn();
	}
}


class MiniPilot {
	private $slot;

	function __construct() {}

	function setCommand(Command $command) {
		$this->slot = $command;
	}

	function ButtonClicked() {
		$this->slot->follow();
	}
}



$pilot = new MiniPilot();
$turnOnLight = new TurnOnLight(new Light());

$pilot->setCommand($turnOnLight);
$pilot->buttonClicked();












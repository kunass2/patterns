<?php

/*  Command - polecenie */

interface Command {
	function follow();
	function back();
}

class NoCommand implements Command {
	function follow() {
		echo 'nie ma takiego polecenia';
	}
	function back() {
		echo 'wycofano brak polecenia';
	}
}

class SuperPilot {
	private $turnOn = array();
	private $turnOff = array();
	private $back;

	function __construct() {
		$noCommand = new NoCommand();
		for ($i = 0; $i < 7; $i++) {
			$this->turnOn[$i] = $noCommand;
			$this->turnOff[$i] = $noCommand;
		}
		$this->back = $noCommand;
	}

	function setCommand($slot, Command $turnOn, Command $turnOff) {
		$this->turnOn[$slot] = $turnOn;
		$this->turnOff[$slot] = $turnOff;
	}

	function TurnOnClicked($slot) {
		$this->turnOn[$slot]->follow();
		$this->back = $this->turnOn[$slot];
	}

	function TurnOffClicked($slot) {
		$this->turnOff[$slot]->follow();
		$this->back = $this->turnOff[$slot];
	}

	function backClicked() {
		$this->back->back();
	}
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

	function back() {
		$this->light->turnOff();
	}
}

class TurnOffLight implements Command {
	private $light;

	function __construct(Light $light) {
		$this->light = $light;
	}

	function follow() {
		$this->light->turnOff();
	}

	function back() {
		$this->light->turnOn();
	}
}

class HiFi {

	function turnOn() {
		echo 'wieza stereo wlaczona';
	}

	function turnOff() {
		echo 'wieza stereo wylaczona';
	}

	function setCD() {
		echo 'USTAWIONO cd';
	}
	function setVolume() {
		echo 'glosnosc ustawiona';
	}
}

class TurnOnHiFi implements Command {
	private $hifi;

	function __construct(HiFi $hifi) {
		$this->hifi = $hifi;
	}

	function follow() {
		$this->hifi->turnOn();
		$this->hifi->setVolume();
	}

	function back() {
		$this->hifi->turnOff();
	}
}

class TurnOffHiFi implements Command {
	private $hifi;

	function __construct(HiFi $hifi) {
		$this->hifi = $hifi;
	}

	function follow() {
		$this->hifi->turnOff();
		$this->hifi->setCD();
	}

	function back() {
		$this->hifi->turnOn();
	}
}

class Ventilator {
	const FAST = 3;
	const MIDDLE = 2;
	const SLOW = 1;
	const OFF = 0;
	private $location;
	private $speed;

	function __construct($location) {
		$this->location = $location;
		$this->speed = self::OFF;
	}

	function fastSpeed() {
		$this->speed = self::FAST;
		echo 'speed fast';
	}

	function middleSpeed() {
		$this->speed = self::MIDDLE;
	}

	function slowSpeed() {
		$this->speed = self::SLOW;
	}

	function offSpeed() {
		$this->speed = self::OFF;
		echo 'off speed';
	}

	function getSpeed() {
		return $this->speed;
	}
}

class VentilatorBack {

	protected $ventilator;
	protected $prevSpeed;

	function __construct(Ventilator $ventilator) {
		$this->ventilator = $ventilator;
	}

	function back() {
		switch ($this->prevSpeed) :
			case Ventilator::FAST : $this->ventilator->fastSpeed(); break;
			case Ventilator::MIDDLE : $this->ventilator->middleSpeed(); break;
			case Ventilator::SLOW : $this->ventilator->slowSpeed(); break;
			case Ventilator::OFF : $this->ventilator->offSpeed(); break;

		endswitch;
	}
}

class VentilatorFast extends VentilatorBack implements Command {

	function follow() {
		$this->prevSpeed = $this->ventilator->getSpeed();
		$this->ventilator->fastSpeed();
	}


}

class VentilatorOff extends VentilatorBack implements Command {

	function follow() {
		$this->prevSpeed = $this->ventilator->getSpeed();
		$this->ventilator->offSpeed();
	}
}

// klasa, ktora pozwoli na JEDNOCZESNE wlaczenie WIELU URZADZEN, a pozniej ich JEDNOCZESNE WYLACZENIE
// class multiPilot {}

$pilot = new SuperPilot();

$pilot->setCommand(3, new TurnOnLight(new Light()), new TurnOffLight(new Light()));
$pilot->setCommand(2, new TurnOnHiFi(new HiFi()), new TurnOffHiFi(new HiFi()));
$pilot->setCommand(1, new VentilatorFast(new Ventilator('kuchnia')), new VentilatorOff(new Ventilator('kuchnia')));
$pilot->turnOnClicked(3);
$pilot->turnOffClicked(2);
$pilot->turnOnClicked(2);
$pilot->turnOffClicked(3);
$pilot->turnOnClicked(1);

// $pilot->turnOnClicked(1);

$pilot->backClicked();












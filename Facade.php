<?php

/* Facade - upraszczanie, grupowe wywolywanie metod wielu metod z wielu klas*/

class FacadeTV {
	private $amplifier;
	private $dvdplayer;
	private $popcorn;

	function __construct(
		Amplifier $amplifier,
		DVDPlayer $dvdplayer,
		Popcorn $popcorn ) {

			$this->amplifier = $amplifier;
			$this->dvdplayer = $dvdplayer;
			$this->popcorn = $popcorn;
	}

	function moviePlayer() {
		$this->popcorn->turnOn();
		$this->amplifier->setVolume(5);
		$this->dvdplayer->play();
	}
}

class Amplifier {
	function setVolume($i) {
		echo 'glosnosc ustawiona na '.$i;
	}
}

class DVDPlayer {
	function play() {
		echo 'dvd wlaczone';
	}
}

class Popcorn {
	function turnOn() {
		echo 'popcorn wlaczony';
	}
}


$facade = new FacadeTV(new Amplifier, new DVDPlayer, new Popcorn);
$facade->moviePlayer();

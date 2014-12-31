<?php

/* DECORATOR */

abstract class Drink {
	private $about = 'Unknown drink';
	public function getAbout() {
		return $this->about;
	}
	public abstract function cost();
}

abstract class ComponentDekorator extends Drink { //zapewnienie ZGODNOŚCI TYPÓW, stąd dziedziczenie
	// public abstract function getAbout();
}

//drinks
class Espresso extends Drink {
	function __construct() {
		$this->about = 'Espresso Coffee';
	}
	function cost() {
		return 1.99;
	}
}

class StarCafeSpecial extends Drink {
	function __construct() {
		$this->about = 'Special Coffee of Star Cafe';
	}
	function cost() {
		return .89;
	}
}


class DarkCoffee extends Drink {
	function __construct() {
		$this->about = 'Dark Coffee';
	}
	function cost() {
		return 3.89;
	}
}

//Accesories to drinks

class Choco extends ComponentDekorator {
	private $drink;
	function __construct(Drink $drink) {
		$this->drink = $drink;
	}
	function cost() {
		return $this->drink->cost() + .89;
	}
	function getAbout() {
		return $this->drink->getAbout().', Czekolada';
	}
}

class Cream extends ComponentDekorator {
	private $drink;
	function __construct(Drink $drink) {
		$this->drink = $drink;
	}
	function cost() {
		return $this->drink->cost() + 2.00;
	}
	function getAbout() {
		return $this->drink->getAbout().', Cream';
	}
}

class SoyMilk extends ComponentDekorator {
	private $drink;
	function __construct(Drink $drink) {
		$this->drink = $drink;
	}
	function cost() {
		return $this->drink->cost() + 1.39;
	}
	function getAbout() {
		return $this->drink->getAbout().', SoyMilk';
	}
}

$drink = new Espresso();
// echo $drink->getAbout().' = '.$drink->cost().'<br />';
$drink = new Cream($drink);
$drink = new Cream($drink);
// echo $drink->getAbout().' = '.$drink->cost().'<br />';
$drink = new SoyMilk($drink);
echo $drink->getAbout().' = '.$drink->cost().'<br />';





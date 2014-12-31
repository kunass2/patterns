<?php

/* Multi Pattern */

//OBSERVER
interface DuckObserved {
	function registerObserver(Observer $observer);
	function callObservers();
}

interface Quacking extends DuckObserved {
	function quack();
}

class WildDuck implements Quacking {
	private $observed;

	function __construct() {
		$this->observed = new Observed($this);
	}

	function registerObserver(Observer $observer) {
		$this->observed->registerObserver($observer);
	}

	function callObservers() {
		$this->observed->callObservers();
	}
	function quack() {
		echo 'Kwa Kwa na dziko!<br />';
		$this->callObservers();
	}

	function getName() {
		return 'kwaknela dzika kaczka';
	}
}

class FlatnessDuck implements Quacking {
	private $observed;

	function __construct() {
		$this->observed = new Observed($this);
	}

	function registerObserver(Observer $observer) {
		$this->observed->registerObserver($observer);
	}

	function callObservers() {
		$this->observed->callObservers();
	}
	function quack() {
		echo 'Kwa Kwa płąskonos!<br />';
		$this->callObservers();
	}

	function getName() {
		return 'kwaknal plaskonos';
	}
}

class DecoyDuck implements Quacking {
	private $observed;

	function __construct() {
		$this->observed= new Observed($this);
	}

	function registerObserver(Observer $observer) {
		$this->observed->registerObserver($observer);
	}

	function callObservers() {
		$this->observed->callObservers();
	}
	function quack() {
		echo 'KwaK!';
		$this->callObservers();
	}

	function getName() {
		return 'kwaknela kaczka wabik';
	}
}

class RubberDuck implements Quacking {
	private $observed;

	function __construct() {
		$this->observed= new Observed($this);
	}

	function registerObserver(Observer $observer) {
		$this->observed->registerObserver($observer);
	}

	function callObservers() {
		$this->observed->callObservers();
	}
	function quack() {
		echo 'piszczę!!!<br />';
		$this->callObservers();
	}
	function getName() {
		return 'kwaknela gumowa kaczka';
	}
}

class Goose {

	function gaggle() {
		echo 'Ge! Ge!<br />';
		//$this->callObservers();
	}
}

//ADAPTER

class GooseAdapter implements Quacking {
	private $goose;
	private $observed;

	function __construct(Goose $goose) {
		$this->observed = new Observed($this);
		$this->goose = $goose;
	}

	function registerObserver(Observer $observer) {
		$this->observed->registerObserver($observer);
	}

	function callObservers() {
		$this->observed->callObservers();
	}

	function quack() {
		$this->goose->gaggle();
		$this->callObservers();
	}

	function getName() {
		return 'kwaknela ges';
	}
}

//DEKORATOR - zliczanie liczby kwaknięć

class QuackCounter implements Quacking {
	private $duck;
	private static $count = 0;

	function __construct(Quacking $duck) {
		$this->duck = $duck;
	}

	function quack() {
		$this->duck->quack();
		self::$count++;
	}

	static function getCounter() {
		return self::$count;
	}

	function registerObserver(Observer $observer) {
		$this->duck->registerObserver($observer);
	}

	function callObservers() {
		//none
	}
}

//ABSTRACT FACTORY

abstract class AbstractFactoryDuck {
	abstract function makeWildDuck();
	abstract function makeFlatnessDuck();
	abstract function makeDecoyDuck();
	abstract function makeRubberDuck();
}

// class FactoryDuck extends AbstractFactoryDuck {
// 	function makeWildDuck() {
// 		return new WildDuck();
// 	}
// 	function makeFlatnessDuck() {
// 		return new FlatnessDuck();
// 	}
// 	function makeDecoyDuck() {
// 		return new DecoyDuck();
// 	}
// 	function makeRubberDuck() {
// 		return new RubberDuck();
// 	}
// }

class CounterFactoryDuck extends AbstractFactoryDuck {
	function makeWildDuck() {
		return new QuackCounter(new WildDuck());
	}
	function makeFlatnessDuck() {
		return new QuackCounter(new FlatnessDuck());
	}
	function makeDecoyDuck() {
		return new QuackCounter(new DecoyDuck());
	}
	function makeRubberDuck() {
		return new QuackCounter(new RubberDuck());
	}

	function makeGoose() {
		return new QuackCounter(new GooseAdapter(new Goose));
	}
}

//COMPOSITE, zarządzanie całym stadem kaczek
class Herd implements Quacking {
	private $beards = array();
	private $observed;

	function __construct() {
		$this->observed = new Observed($this);
	}

	function add(Quacking $duck) {
		array_push($this->beards, $duck);
	}

	function registerObserver(Observer $observer) {
		$iterator = new DuckIterator($this->beards);
		while ($iterator->hasNext()) :
			$beard = $iterator->next();
			$beard->registerObserver($observer);
		endwhile;
	}

	function callObservers() {}

//ITERATOR
	function quack() {
		$iterator = new DuckIterator($this->beards);
		while ($iterator->hasNext()) :
			$beard = $iterator->next();
			$beard->quack();
		endwhile;
	}
}


interface MyIterator {
	function hasNext();
	function next();
}

class DuckIterator implements MyIterator {
	private $elems;
	private $pos = 0;

	function __construct($elems) {
		$this->elems = $elems;
	}

	function next() {
		$pos = $this->elems[$this->pos];
		$this->pos++;
		return $pos;
	}

	function hasNext() {
		if ($this->pos == count($this->elems) || $this->elems[$this->pos] == null ) :
			return false;
		else:
			return true;
		endif;
	}
}

class Observed implements DuckObserved {
	private $observers = array();
	private $duck;

	function __construct(DuckObserved $duck) {
		$this->duck = $duck;
	}

	function registerObserver(Observer $observer) {
		array_push($this->observers, $observer);
	}

	function callObservers() {
		$iterator = new DuckIterator($this->observers);
		while ($iterator->hasNext()) :
			$observer = $iterator->next();
			$observer->update($this->duck);
		endwhile;
	}
}

interface Observer {
	function update(DuckObserved $duck);
}

class Kwakolog implements Observer {
	function update(DuckObserved $duck) {
		echo '<b>Kwakolog</b>: '.$duck->getName().'<br />';
	}
}


class Run {
	private $factoryDuck;
	function __construct() {
		$this->factoryDuck = new CounterFactoryDuck();
		$herd = new Herd();

		$wildHerd = new Herd();

		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeWildDuck());
		$wildHerd->add($this->factoryDuck->makeGoose());


		$duck = $this->factoryDuck->makeWildDuck();
		$duck2 = $this->factoryDuck->makeFlatnessDuck();
		$duck3 = $this->factoryDuck->makeRubberDuck();

		$herd->add($duck);
		$herd->add($duck2);
		$herd->add($duck3);
		$herd->add($wildHerd);


		$kwakolog = new Kwakolog();
		$kwakolog2 = new Kwakolog();
		$herd->registerObserver($kwakolog);
		$herd->registerObserver($kwakolog2);

		$herd->quack();

		echo '<br />'.QuackCounter::getCounter();
	}
}

new Run();
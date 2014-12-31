<?php


/*  Iterator */

class menuElem {
	private $name;
	private $description;
	private $isVegetarian;
	private $price;

	function __construct($name, $description, $isVegetarian, $price) {
		$this->name = $name;
		$this->description = $description;
		$this->isVegetarian = $isVegetarian;
		$this->price = $price;
	}

	function getName() {
		return $this->name;
	}

	function getDescription() {
		return $this->description;
	}

	function getPrice() {
		return $this->price;
	}

	function isVegetarian() {
		return $this->isVegetarian;
	}
}

interface Menu {
	function createIterator();
}

class PancakeHouseMenu implements Menu {
	private $menuList = array();

	function __construct() {
		$this->addElem('Śniadanie naleśnikowe', 'naleniski z jajecznica i tostem', true, 2.99);
		$this->addElem('Śniadanie naleśnikowe zwykle', 'naleniski z jajkiem i kiełbasą', false, 3.99);
		$this->addElem('Naleśniki z jagodami', 'naleśniki ze świezymi jagodami', true, 3.50);
		$this->addElem('Wafle nadziewane', 'wafle z jagodami lub truskawkami', true, 3.59);
	}

	private function addElem($name, $description, $isVegetarian, $price) {
		array_push($this->menuList, new menuElem($name, $description, $isVegetarian, $price));
	}

	function getElems() {
		return $this->menuList();
	}

	function createIterator() {
		return new PancakeHouseMenuIterator($this->menuList);
	}
}

class DinerMenu implements Menu {
	CONST MAX = 6;
	private $count = 0;
	private $menuList = array();

	function __construct() {
		$this->addElem('wegetariańska kanapka', 'boczek z sałatą i pomidorem', true, 7.89);
		$this->addElem('zupa dnia', 'sałatka z pomidorem', true, 4.19);
		$this->addElem('hot dog', 'hot dog z kiszoną kapustą', false, 1.39);
	}

	private function addElem($name, $description, $isVegetarian, $price) {

		if ($this->count < self::MAX) :
			array_push($this->menuList, new menuElem($name, $description, $isVegetarian, $price));
			$this->count++;
		else:
			echo 'menu jest juz pelne';
		endif;
	}

	function createIterator() {
		return new DinerMenuIterator($this->menuList);
	}
}

class Waitress {
	private $pancakeHouseMenu;
	private $dinerMenu;

	function __construct(Menu $pancakeHouseMenu, Menu $dinerMenu) {
		$this->pancakeHouseMenu = $pancakeHouseMenu;
		$this->dinerMenu = $dinerMenu;
	}

	function printMenus() {
		$pancakeIterator = $this->pancakeHouseMenu->createIterator();
		$dinerIterator = $this->dinerMenu->createIterator();
		$this->printMenu($pancakeIterator);
		$this->printMenu($dinerIterator);
	}

	function printMenu(MyIterator $iterator) {
		while ($iterator->hasNext()) :
			$menuElem = $iterator->next();
			echo $menuElem->getName().' : '.$menuElem->getPrice().'<br />';
		endwhile;
	}
}


interface MyIterator {
	function hasNext();
	function next();
}

class DinerMenuIterator implements MyIterator {
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

class PancakeHouseMenuIterator implements MyIterator {
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

$pancakeMenu = new PancakeHouseMenu();
$dinerMenu = new DinerMenu();
$waitress = new Waitress($pancakeMenu, $dinerMenu);
$waitress->printMenus();






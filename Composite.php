<?php


/*  Composite - obiekty złożone, struktury drzewiaste */


abstract class Component {
	function add(Component $component) {
		throw new Exception('there is no such method');
	}
	function remove(Component $component) {}
	function getChild($i) {}
	function getName() {}
	function getDescription() {}
	function getPrice() {}
	function isVegetarian() {}
	function __print() {}
}


class MenuElem extends Component {

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

	function __print() {
		echo '<br />'.$this->getName();
		if ($this->isVegetarian()) :
			echo '(w)';
		endif;
		echo ': '.$this->getPrice().', '.$this->getDescription();
	}
}



class Menu extends Component {
	private $menuElems = array();
	private $name;
	private $description;

	function __construct($name, $description) {
		$this->name = $name;
		$this->description = $description;
	}

	function add(Component $component) {
		array_push($this->menuElems, $component);
	}

	function remove(Component $component) {
		if ( ($key = array_search($component, $this->menuElems)) !== false) :
    			unset($this->menuElems[$key]);
		endif;
	}

	function getChild($i) {
		return $this->menuElems[$i];
	}

	function getName() {
		return $this->name;
	}

	function getDescription() {
		return $this->description;
	}

	function __print() {
		echo '<br />'.$this->getName().'<br />'.$this->getDescription().'<br />------------';

		$iterator = new MenuIterator($this->menuElems);
		while ($iterator->hasNext()) :
			$menuElem = $iterator->next();
		$menuElem->__print();
		endwhile;
		echo '<br />';
	}
}

class Waitress {
	private $allMenus;

	function __construct(Component $allMenus) {
		$this->allMenus = $allMenus;
	}

	function __print() {
		$this->allMenus->__print();
	}
}

interface MyIterator {
	function hasNext();
	function next();
}

class MenuIterator implements MyIterator {
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


$pancakeHouseMenu = new Menu('PANCAKE HOUE MENU', "Śniadania");
$dinerMenu = new Menu('MENU RESTAURACJI DINER', "Lunch");
$uJackaMenu = new Menu('MENU U JACKA', "Obiady");
$deseryMenu = new Menu('MENU DESERÓW', "Desery, oczywiście!");

$wszystkieMenu = new Menu('WSZYSTKIE MENU', 'połączone menu');

$wszystkieMenu->add($pancakeHouseMenu);
$wszystkieMenu->add($dinerMenu);
$wszystkieMenu->add($uJackaMenu);


$pancakeHouseMenu->add( new MenuElem('Śniadanie naleśnikowe', 'naleniski z jajecznica i tostem', true, 2.99));
$pancakeHouseMenu->add( new MenuElem('Śniadanie naleśnikowe zwykle', 'naleniski z jajkiem i kiełbasą', false, 3.99));
$pancakeHouseMenu->add( new MenuElem('Naleśniki z jagodami', 'naleśniki ze świezymi jagodami', true, 3.50));
$pancakeHouseMenu->add( new MenuElem('Wafle nadziewane', 'wafle z jagodami lub truskawkami', true, 3.59));

$dinerMenu->add( new MenuElem('wegetariańska kanapka', 'boczek z sałatą i pomidorem', true, 7.89));
$dinerMenu->add( new MenuElem('zupa dnia', 'sałatka z pomidorem', true, 4.19));
$dinerMenu->add( new MenuElem('hot dog', 'hot dog z kiszoną kapustą', false, 1.39));

$dinerMenu->add($deseryMenu);

$deseryMenu->add( new MenuElem('Szarlotka', 'Szarlotka z lodami waniliowymi', true, 1.59));

$waitress = new Waitress($wszystkieMenu);

$waitress->__print();





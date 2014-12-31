<?php

/* FACTORY */

abstract class Pizzeria {  //Factory --> fabryka rzeczywista, nie musi być abstract

	function orderPizza ($type) {
		$pizza = $this->createPizza($type);
		$pizza->preparation();
		$pizza->cooking();
		$pizza->cutting();
		$pizza->packing();

		return $pizza;
	}

	protected abstract function createPizza($type); //Factory Method --> metoda fabrykująca, nie musi być abstract
}

class ItalianFactoryPizza extends Pizzeria {

	function createPizza($type) {
		$pizza = null;
		if ($type == 'cheese') :
			$pizza = new ItalianCheesePizza();
		elseif ($type == 'pepperoni') :
			$pizza = new ItalianPepperoniPizza();
		elseif ($type == 'vegetarian') :
			$pizza = new ItalianVegetarianPizza();
		endif;
		return $pizza;
	}
}

class AmericanFactoryPizza extends Pizzeria {

	function createPizza($type) {
		$pizza = null;
		if ($type == 'cheese') :
			$pizza = new AmericanCheesePizza();
		elseif ($type == 'pepperoni') :
			$pizza = new AmericanPepperoniPizza();
		elseif ($type == 'vegetarian') :
			$pizza = new AmericanVegetarianPizza();
		endif;
		return $pizza;
	}
}

/* FABRYKA SKŁADNIKÓW - INTERFACE, KTÓRY MOŻNA ZAIMPLEMENTOWAĆ*/

interface FactoryIngredients {

	function makeCake();
	function makeSauce();
	function makeCheese();
	function makeVegetables();
	function makePepperoni();
	function makeOctopussy();
}

class ItalianFactoryIngredients implements FactoryIngredients {

	function makeCake() {
		return new TinyCrispCake();
	}

	function makeSauce() {
		return new SauceMarinara();
	}

	function makeCheese() {
		return new CheeseReggiano();
	}

	function makeVegetables() {
		$vegetables = array(new Onion(), new Mushrooms(), new Potatoes());
		return $vegetables;
	}

	function makePepperoni() {
		return new PepperoniChips();
	}

	function makeOctopussy() {
		return new FreshOctopussy();
	}
}

/* KONIEC FABRYKI SKŁĄDNIKÓW, KTÓRĄ MOŻNA ZAIMPLEMENTOWAĆ*/


abstract class Pizza {
	protected $name;
	protected $under;
	protected $sauce;
	protected $add = array();

	function preparation(){
		echo 'Przygotowanie: '.$this->name.'<br />';
	}

	function cooking(){
		echo 'Pieczenie: 25\' w temp 25s stopni<br />';
	}

	function cutting(){
		echo 'Krojenie pizzy na 8 kawałków <br />';
	}

	function packing(){
		echo 'Pakowanie pizzy do oryginalnego pudełka <br />';
	}

	function getName() {
		return $this->name;
	}
}

class ItalianCheesePizza extends Pizza {

	function __construct() {
		$this->name = 'włoska pizza serowa z sosem marinata';
		$this->under = 'cienkie kruche ciasto';
		$this->sauce = 'Sos Marinata';
	}
}

class AmericanCheesePizza extends Pizza {

	function __construct() {
		$this->name = 'amerykanska pizza serowa z sosem marinata';
		$this->under = 'grube twarde ciasto';
		$this->sauce = 'Sos z pomidorów śliwkowych';
	}

	function cutting(){
		echo 'Krojenie pizzyna kwadratowe kawałki <br />';
	}
}


$eryk = new ItalianFactoryPizza();
$eryk->orderPizza('cheese');

$wladim = new AmericanFactoryPizza();
$wladim->orderPizza('cheese');







<?php

/*  Template Method - wycoagniecie ws[polnych czesci klas do metody w klasie abstrakcyjnej */


abstract class Drink {

	function preparation() { //template method
		$this->boilingWater();
		$this->brew();
		$this->intoacup();
		if ($this->wantAccessories()) {
			$this->addAccessories();
		}
	}

	abstract function brew();

	abstract function addAccessories();

	function boilingWater() {
		echo 'gotowanie wody';
	}

	function intoacup() {
		echo 'zalewanie filizanki';
	}

	function wantAccessories() {   //haczyk, klasa podrzedna moze przeslonic te metode, ale nie musi.
		return true;
	}
}

class Tea extends Drink {
	function brew() {
		echo 'zaparzanie herbaty';
	}

	function addAccessories() {
		echo 'dodawanie cytryny';
	}
}

class Coffee extends Drink {
	function brew() {
		echo 'zaparzanie kawy';
	}

	function addAccessories() {
		echo 'dodawanie mleka i cukru';
	}
}

$drink = new Coffee();
$drink->preparation();








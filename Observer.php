<?php

/* OBSERVER

I -> obiekt obserwowany wysyła informacje...
II -> obiekt obserwujący sam pobiera sobie informacje, poprzez ogólnie dostepne metody w obiekcie obserwowanym

*/

// przykład I

interface Subject {
	public function registerObserver(Observer $o);
	public function removeObserver(Observer $o);
	public function callObservers(); //powiadom obserwatorow
}

interface Observer {
	public function update($temp, $wetness, $pressure);
}

interface DisplayElement {
	public function display();
}

class WeatherData implements Subject {
	private $observers = array();
	private $temp;
	private $wet;
	private $pres;

	function registerObserver(Observer $o) {
		array_push($this->observers, $o);
	}


	function removeObserver(Observer $o) {
		$key = array_search($this->observers, $o);
		unset($this->observers[$key]);
	}

	function callObservers() {
		foreach ($this->observers as $o) :
			$o->update($this->temp, $this->wet, $this->pres);
		endforeach;
	}

	function changeData() {
		$this->callObservers();
	}

	function setData($temp, $wetness, $pressure) {
		$this->temp = $temp;
		$this->wet = $wetness;
		$this->pres = $pressure;
		$this->changeData();

	}
}

class RunningCondition implements Observer, DisplayElement {
	private $temp;
	private $wetness;

	function update($temp, $wetness, $pressure) {
		$this->temp = $temp;
		$this->wetness = $wetness;
		$this->display();
	}

	function display() {
		echo 'RunningCodition to'.$this->temp.' | '.$this->wetness.'<br />';
	}
}

class Statistics implements Observer, DisplayElement {

	private $temp;
	private $pressure;

	function update($temp, $wetness, $pressure) {
		$this->temp = $temp;
		$this->pressure = $pressure;
		$this->display();
	}

	function display() {
		echo 'Statistics to'.$this->temp.' | '.$this->pressure.' | koniec statystyk!<br />';
	}
}


$data = new WeatherData();
$data->registerObserver(new Statistics());
$data->registerObserver(new RunningCondition());
$data->setData('23C', '75%', 235);
$data->registerObserver(new RunningCondition());
$data->setData('23 new C', 'new 75%', 23545);


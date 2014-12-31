<?php
/* SINGLETON */
class Singleton {
	private static $instance;

	private function __construct() { }
	private function __clone() { }

	public static function getInstance() {
		self::$instance == null ? self::$instance = new Singleton() : '';
		return self::$instance;
	}
}

$s = Singleton::getInstance();
$w = Singleton::getInstance();

var_dump($s);
var_dump($w);
$n = new Singleton(); //makes an ERROR

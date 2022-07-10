<?php

/**
 * Event Class
 *
 * Handles Events, which can be hooked into to trigger custom functions
 * @author Robin Moser <mail@robinmoser.de>
 *
 */

class Event {

	public static $events = array();

	/**
	 * triggers the event and calls all bound functions, if any
	 */
	public static function trigger($event, $args = array()) {

		if(isset(self::$events[$event])) {

			foreach(self::$events[$event] as $func) {

				call_user_func($func, $args);

			}
		}

	}

	/**
	 * binds to the event and registers a custom function
	 */
	public static function bind($event, Closure $func) {

		self::$events[$event][] = $func;

	}

}

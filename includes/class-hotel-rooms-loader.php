<?php
/**
 * Description document
 *
 * @file
 * @package package
 */

/**
 * Class Hotel_Rooms_Loader
 */
class Hotel_Rooms_Loader {

	/**
	 * Description
	 *
	 * @var array
	 */
	protected $actions;

	/**
	 * Description
	 *
	 * @var array
	 */
	protected $filters;

	/**
	 * Description
	 *
	 * @var array
	 */
	protected $shortcodes;

	/**
	 * Hotel_Rooms_Loader constructor.
	 */
	public function __construct() {

		$this->actions    = array();
		$this->filters    = array();
		$this->shortcodes = array();

	}

	/**
	 * Description
	 *
	 * @param string $hook description.
	 * @param string $component description.
	 * @param string $callback description.
	 * @param int    $priority description.
	 * @param int    $accepted_args description.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Description
	 *
	 * @param string $hook description.
	 * @param string $component description.
	 * @param string $callback description.
	 * @param int    $priority description.
	 * @param int    $accepted_args description.
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Description
	 *
	 * @param string $hook description.
	 * @param string $component description.
	 * @param string $callback description.
	 */
	public function add_shortcode( $hook, $component, $callback ) {
		$this->shortcodes = $this->add( $this->filters, $hook, $component, $callback );
	}

	/**
	 * Description
	 *
	 * @param array  $hooks description.
	 * @param string $hook description.
	 * @param string $component description.
	 * @param string $callback description.
	 * @param int    $priority description.
	 * @param int    $accepted_args description.
	 *
	 * @return array
	 */
	private function add( $hooks, $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Description
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array(
				$hook['component'],
				$hook['callback']
			), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array(
				$hook['component'],
				$hook['callback']
			), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->shortcodes as $hook ) {
			add_shortcode( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}

	}

}

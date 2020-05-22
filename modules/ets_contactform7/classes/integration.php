<?php
/**
 * 2007-2018 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2018 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
 
class WPCF7_Integration {
	private static $instance;
	private $services = array();
	private $categories = array();
	private function __construct() {}
	public static function get_instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	public function add_service( $name, WPCF7_Service $service ) {
		$name = ets_sanitize_key( $name );
		if ( empty( $name ) || isset( $this->services[$name] ) ) {
			return false;
		}
		$this->services[$name] = $service;
	}
	public function add_category( $name, $title ) {
		$name = ets_sanitize_key( $name );
		if ( empty( $name ) || isset( $this->categories[$name] ) ) {
			return false;
		}
		$this->categories[$name] = $title;
	}
	public function service_exists( $name = '' ) {
		if ( '' == $name ) {
			return (bool) count( $this->services );
		} else {
			return isset( $this->services[$name] );
		}
	}
	public function get_service( $name ) {
		if ( $this->service_exists( $name ) ) {
			return $this->services[$name];
		} else {
			return false;
		}
	}
}
abstract class WPCF7_Service {
	abstract public function get_title();
	abstract public function is_active();
	public function get_categories() {
		return array();
	}
	public function icon() {
		return '';
	}
	public function link() {
		return '';
	}
	public function load( $action = '' ) {
	   unset($action);
	}
	public function display( $action = '' ) {
	   unset($action);
	}
	public function admin_notice( $message = '' ) {
        unset($message);
	}
}
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
 
class WPCF7_RECAPTCHA extends WPCF7_Service {
	const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
	private static $instance;
	private $sitekeys=array();
	public static function get_instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	private function __construct() {
	    $site_key = Configuration::get('ETS_CFT7_SITE_KEY');
        $secret_key = Configuration::get('ETS_CFT7_SECRET_KEY');   
		$this->sitekeys[$site_key]=$secret_key;
	}
	public function is_active() {
		$sitekey = $this->get_sitekey();
		$secret = $this->get_secret( $sitekey );
		return $sitekey && $secret;
	}
	public function get_categories() {
		return array( 'captcha' );
	}
	public function icon() {
	}
	public function link() {
		echo sprintf( '<a href="%1$s">%2$s</a>',
			'https://www.google.com/recaptcha/intro/index.html',
			'google.com/recaptcha' );
	}
	public function get_sitekey() {
		if ( empty( $this->sitekeys ) || ! is_array( $this->sitekeys ) ) {
			return false;
		}
		$sitekeys = array_keys( $this->sitekeys );
		return $sitekeys[0];
	}
	public function get_secret( $sitekey ) {
		$sitekeys = (array) $this->sitekeys;

		if ( isset( $sitekeys[$sitekey] ) ) {
			return $sitekeys[$sitekey];
		} else {
			return false;
		}
	}
	public function verify( $response_token ) {
		if ( empty( $response_token ) ) {
			return false;
		}
		$sitekey = $this->get_sitekey();
		$secret = $this->get_secret( $sitekey );
        $link_capcha="https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $response_token . "&remoteip=" . Tools::getRemoteAddr();
		$response = json_decode(Tools::file_get_contents($link_capcha), true);
        if ($response['success'] == false) {
            return false;
        }
        else
            return true;
	}
    public function get_title() {
		return 'reCAPTCHA';
	}
}
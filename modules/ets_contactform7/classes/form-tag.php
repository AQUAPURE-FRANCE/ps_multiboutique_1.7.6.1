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
 
class WPCF7_FormTag implements ArrayAccess {
	public $type;
	public $basetype;
	public $name = '';
	public $options = array();
	public $raw_values = array();
	public $values = array();
	public $pipes;
	public $labels = array();
	public $attr = '';
	public $content = '';
	public function __construct( $tag = array() ) {
		if ( is_array( $tag ) || $tag instanceof self ) {
			foreach ( $tag as $key => $value ) {
				if ( property_exists( __CLASS__, $key ) ) {
					$this->{$key} = $value;
				}
			}
		}
	}
	public function is_required() {
		return ( '*' == Tools::substr( $this->type, -1 ) );
	}
	public function has_option( $opt ) {
		$pattern = sprintf( '/^%s(:.+)?$/i', preg_quote( $opt, '/' ) );
		return (bool) preg_grep( $pattern, $this->options );
	}
	public function get_option( $opt, $pattern = '', $single = false ) {
		$preset_patterns = array(
			'date' => '([0-9]{4}-[0-9]{2}-[0-9]{2}|today(.*))',
			'int' => '[0-9]+',
			'signed_int' => '-?[0-9]+',
			'class' => '[-0-9a-zA-Z_]+',
			'id' => '[-0-9a-zA-Z_]+',
		);
		if ( isset( $preset_patterns[$pattern] ) ) {
			$pattern = $preset_patterns[$pattern];
		}
		if ( '' == $pattern ) {
			$pattern = '.+';
		}
		$pattern = sprintf( '/^%s:%s$/i', preg_quote( $opt, '/' ), $pattern );
		if ( $single ) {
			$matches = $this->get_first_match_option( $pattern );

			if ( ! $matches ) {
				return false;
			}
			return Tools::substr( $matches[0], Tools::strlen( $opt ) + 1 );
		} else {
			$matches_a = $this->get_all_match_options( $pattern );
            
			if ( ! $matches_a ) {
				return false;
			}

			$results = array();

			foreach ( $matches_a as $matches ) {
				$results[] = Tools::substr( $matches[0], Tools::strlen( $opt ) + 1 );
			}
			return $results;
		}
	}
	public function get_id_option() {
		return $this->get_option( 'id', 'id', true );
	}
	public function get_class_option( $default = '' ) {
		if ( is_string( $default ) ) {
			$default = explode( ' ', $default );
		}

		$options = array_merge(
			(array) $default,
			(array) $this->get_option( 'class', 'class' ) );

		$options = array_filter( array_unique( $options ) );

		return implode( ' ', $options );
	}
	public function get_size_option( $default = '' ) {
		$option = $this->get_option( 'size', 'int', true );

		if ( $option ) {
			return $option;
		}
		$matches_a = $this->get_all_match_options( '%^([0-9]*)/[0-9]*$%' );

		foreach ( (array) $matches_a as $matches ) {
			if ( isset( $matches[1] ) && '' !== $matches[1] ) {
				return $matches[1];
			}
		}
		return $default;
	}
	public function get_maxlength_option( $default = '' ) {
		$option = $this->get_option( 'maxlength', 'int', true );
		if ( $option ) {
			return $option;
		}
		$matches_a = $this->get_all_match_options(
			'%^(?:[0-9]*x?[0-9]*)?/([0-9]+)$%' );
		foreach ( (array) $matches_a as $matches ) {
			if ( isset( $matches[1] ) && '' !== $matches[1] ) {
				return $matches[1];
			}
		}
		return $default;
	}
	public function get_minlength_option( $default = '' ) {
		$option = $this->get_option( 'minlength', 'int', true );
		if ( $option ) {
			return $option;
		} else {
			return $default;
		}
	}
	public function get_cols_option( $default = '' ) {
		$option = $this->get_option( 'cols', 'int', true );
		if ( $option ) {
			return $option;
		}
		$matches_a = $this->get_all_match_options(
			'%^([0-9]*)x([0-9]*)(?:/[0-9]+)?$%' );
		foreach ( (array) $matches_a as $matches ) {
			if ( isset( $matches[1] ) && '' !== $matches[1] ) {
				return $matches[1];
			}
		}
		return $default;
	}
	public function get_rows_option( $default = '' ) {
		$option = $this->get_option( 'rows', 'int', true );
		if ( $option ) {
			return $option;
		}
		$matches_a = $this->get_all_match_options(
			'%^([0-9]*)x([0-9]*)(?:/[0-9]+)?$%' );
		foreach ( (array) $matches_a as $matches ) {
			if ( isset( $matches[2] ) && '' !== $matches[2] ) {
				return $matches[2];
			}
		}
		return $default;
	}
	public function get_date_option( $opt ) {
		$option = $this->get_option( $opt, 'date', true );
		if ( preg_match( '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $option ) ) {
			return $option;
		}
		if ( preg_match( '/^today(?:([+-][0-9]+)([a-z]*))?/', $option, $matches ) ) {
			$number = isset( $matches[1] ) ? (int) $matches[1] : 0;
			$unit = isset( $matches[2] ) ? $matches[2] : '';
			if ( ! preg_match( '/^(day|month|year|week)s?$/', $unit ) ) {
				$unit = 'days';
			}
			$date = gmdate( 'Y-m-d',
				strtotime( sprintf( 'today %1$s %2$s', $number, $unit ) ) );
			return $date;
		}
		return false;
	}
	public function get_default_option( $default = '', $args = '' ) {
		$args = ets_parse_args( $args, array(
			'multiple' => false ) );
		$values = array();
        $context=Context::getContext();
        if(isset($context->customer))
        {
            if($this->type=='email')
                $default = str_replace('default:user_email',Context::getContext()->customer->email,$default);
            else
                $default = str_replace(array('default:user_email','default:user_first_name','default:user_last_name','default:user_full_name'),array(Context::getContext()->customer->email,Context::getContext()->customer->firstname,Context::getContext()->customer->lastname,Context::getContext()->customer->firstname.' '.Context::getContext()->customer->lastname),$default);
        }
        $values[]=$default;
        if($args['multiple'])
            return $values;
        else
            return $default;
        //if ( empty( $options ) ) {
//			return $args['multiple'] ? $values : $default;
//		}
//		foreach ( $options as $opt ) {
//			$opt = ets_sanitize_key( $opt );
//			if ( 'get' == $opt && Tools::isSubmit($this->name) ) {
//				$vals = (array) Tools::getValue($this->name);
//				$vals = array_map( 'etscf7_sanitize_query_var', $vals );
//
//				if ( $args['multiple'] ) {
//					$values = array_merge( $values, $vals );
//				} else {
//					$val = isset( $vals[0] ) ? (string) $vals[0] : '';
//
//					if (Tools::strlen( $val ) ) {
//						return $val;
//					}
//				}
//			} elseif ( 'post' == $opt && Tools::isSubmit($this->name) ) {
//				$vals = (array) Tools::getValue($this->name);
//				$vals = array_map( 'etscf7_sanitize_query_var', $vals );
//				if ( $args['multiple'] ) {
//					$values = array_merge( $values, $vals );
//				} else {
//					$val = isset( $vals[0] ) ? (string) $vals[0] : '';
//
//					if (Tools::strlen( $val ) ) {
//						return $val;
//					}
//				}
//			} elseif ( 'shortcode_attr' == $opt ) {
//				if ( $contact_form = WPCF7_ContactForm::get_current() ) {
//					$val = $contact_form->shortcode_attr( $this->name );
//
//					if ( Tools::strlen( $val ) ) {
//						if ( $args['multiple'] ) {
//							$values[] = $val;
//						} else {
//							return $val;
//						}
//					}
//				}
//			}
//		}
//		if ( $args['multiple'] ) {
//			$values = array_unique( $values );
//			return $values;
//		} else {
//			return $default;
//		}
	}
	public function get_data_option( $args = '' ) {
		$options = (array) $this->get_option( 'data' );
        unset($args);
		return $options;
	}
	public function get_first_match_option( $pattern ) {
		foreach( (array) $this->options as $option ) {
			if ( preg_match( $pattern, $option, $matches ) ) {
				return $matches;
			}
		}
		return false;
	}
	public function get_all_match_options( $pattern ) {
		$result = array();
		foreach( (array) $this->options as $option ) {
			if ( preg_match( $pattern, $option, $matches ) ) {
				$result[] = $matches;
			}
		}
		return $result;
	}
	public function offsetSet( $offset, $value ) {
		if ( property_exists( __CLASS__, $offset ) ) {
			$this->{$offset} = $value;
		}
	}
	public function offsetGet( $offset ) {
		if ( property_exists( __CLASS__, $offset ) ) {
			return $this->{$offset};
		}
		return null;
	}
	public function offsetExists( $offset ) {
		return property_exists( __CLASS__, $offset );
	}
	public function offsetUnset( $offset ) {
	   unset($offset);
    }
}

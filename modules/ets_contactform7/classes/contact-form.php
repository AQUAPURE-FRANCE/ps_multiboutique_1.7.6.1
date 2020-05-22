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
 
class WPCF7_ContactForm {
	const post_type = 'etscf7_contact_form';
	public static $found_items = 0;
	public static $current = null;
	public $id;
	public $name;
	public $title;
	public $locale;
	public $properties = array();
	public $unit_tag;
	public $responses_count = 0;
	public $scanned_form_tags;
	public $shortcode_atts = array();
    public $save_message;
    public $open_form_by_button;
	public static function count() {
		return self::$found_items;
	}
	public static function get_current() {
		return self::$current;
	}
	public static function get_instance( $id_contact ) {
		$contact= new Ets_contact_class($id_contact,Context::getContext()->language->id);
		if ( !$contact->id ) {
			return false;
		}
		return self::$current = new self( $contact );
	}
	public static function get_unit_tag( $id = 0 ) {
		static $global_count = 0;
		$global_count += 1;
        $unit_tag = sprintf( 'wpcf7-f%1$d-o%2$d',
        ets_absint( $id ), $global_count );
		return $unit_tag;
	}
	private function __construct( $contact = null ) {
        if(is_numeric($contact))
            $contact =new Ets_contact_class($contact,Context::getContext()->language->id);
		if ( $contact->id) {
			$this->id = $contact->id;
			$this->name = $contact->title;
			$this->title = $contact->title;
			$this->locale = '';
            $this->save_message = $contact->save_message;
            $this->open_form_by_button = $contact->open_form_by_button;
            $this->button_label = $contact->button_label ? $contact->button_label :'Contact form 7';
            $this->title_alias= $contact->title_alias;
            $this->meta_title= $contact->meta_title;
            $this->meta_keyword= $contact->meta_keyword;
            $this->meta_description= $contact->meta_description;
            $this->save_attachments=$contact->save_attachments;
            $this->star_message= $contact->star_message;
			$properties=array(
                'form'=> $contact->short_code,
                'mail'=>array(
                    'active'=>1,
                    'subject'=> $contact->subject,
                    'sender'=>$contact->email_from,
                    'bcc' => $contact->bcc,
                    'recipient'=>$contact->email_to,
                    'body'=>$contact->message_body,
                    'additional_headers'=> $contact->additional_headers,
                    'attachments'=>$contact->file_attachments,
                    'use_html'=>true,
                    'exclude_blank'=>true,
                ),
                'mail_2'=>array(
                    'active'=>$contact->use_email2,
                    'subject'=> $contact->subject2,
                    'sender'=>$contact->email_from2,
                    'bcc' => $contact->bcc2,
                    'recipient'=>$contact->email_to2,
                    'body'=>$contact->message_body2,
                    'additional_headers'=> $contact->additional_headers2,
                    'attachments'=>$contact->file_attachments2,
                    'use_html'=>true,
                    'exclude_blank'=>true,
                ),
                'messages'=>array(
                    'mail_sent_ok'=>$contact->message_mail_sent_ok,
                    'mail_sent_ng'=>$contact->message_mail_sent_ng,
                    'validation_error'=> $contact->message_validation_error,
                    'spam'=> $contact->message_spam,
                    'accept_terms'=> $contact->message_accept_terms,
                    'invalid_required'=> $contact->message_invalid_required,
                    'invalid_too_long'=> $contact->message_invalid_too_long,
                    'invalid_too_short'=> $contact->message_invalid_too_short,
                    'invalid_date'=> $contact->message_invalid_date,
                    'date_too_early'=> $contact->message_date_too_early,
                    'date_too_late'=> $contact->message_date_too_late,
                    'upload_failed'=> $contact->message_upload_failed,
                    'upload_file_type_invalid'=>$contact->message_upload_file_type_invalid,
                    'upload_file_too_large'=>$contact->message_upload_file_too_large,
                    'upload_failed_php_error' => $contact->message_upload_failed_php_error,
                    'invalid_number'=> $contact->message_invalid_number,
                    'number_too_small'=> $contact->message_number_too_small,
                    'number_too_large'=> $contact-> message_number_too_large,
                    'quiz_answer_not_correct'=>$contact->message_quiz_answer_not_correct,
                    'captcha_not_match'=> $contact->message_captcha_not_match,
                    'ip_black_list' => $contact->message_ip_black_list,
                    'invalid_email'=> $contact->message_invalid_email,
                    'invalid_url'=> $contact->message_invalid_url,
                    'invalid_tel'=> $contact->message_invalid_tel,
                ),
                'additional_settings'=>$contact->additional_settings,
            );
			$this->properties = $properties;
		}
	}
	public function initial() {
		return empty( $this->id );
	}

	public function prop( $name ) {
		$props = $this->get_properties();
		return isset( $props[$name] ) ? $props[$name] : null;
	}
	public function get_properties() {
		$properties = (array) $this->properties;
		return $properties;
	}
	public function id() {
		return $this->id;
	}
	public function name() {
		return $this->name;
	}
	public function title() {
		return $this->title;
	}
	public function locale() {
		if ( etscf7_is_valid_locale( $this->locale ) ) {
			return $this->locale;
		} else {
			return '';
		}
	}
	public function set_locale( $locale ) {
		$locale = trim( $locale );

		if ( etscf7_is_valid_locale( $locale ) ) {
			$this->locale = $locale;
		} else {
			$this->locale = 'en_US';
		}
	}

	public function shortcode_attr( $name ) {
		if ( isset( $this->shortcode_atts[$name] ) ) {
			return (string) $this->shortcode_atts[$name];
		}
	}
	// Return true if this form is the same one as currently POSTed.
	public function is_posted() {
		return true;
	}
	/* Form Elements */
	public function replace_all_form_tags() {
		$manager = WPCF7_FormTagsManager::get_instance();
        $manager->set_instance();    
		$form = $this->prop('form');
		if ( etscf7_autop_or_not() ) {
			$form = $manager->normalize( $form );
			$form = etscf7_autop( $form );
		}
		$form = $manager->replace_all( $form );
		$this->scanned_form_tags = $manager->get_scanned_tags();
		return $form;
	}
	public function scan_form_tags( $cond = null ) {
		$manager = WPCF7_FormTagsManager::get_instance();
        $manager->set_instance(); 
		if ( empty( $this->scanned_form_tags ) ) {
			$this->scanned_form_tags = $manager->scan( $this->prop( 'form' ) );
		}

		$tags = $this->scanned_form_tags;

		return $manager->filter( $tags, $cond );
	}
	public function form_elements() {
		return $this->replace_all_form_tags();
	}
	public function submit( $args = '' ) {
		$args = ets_parse_args( $args, array(
			'skip_mail' =>false,
		));
		$submission = WPCF7_Submission::get_instance( $this, array(
			'skip_mail' => $args['skip_mail'],
		) );
		$result = array(
			'contact_form_id' => $this->id(),
			'status' => $submission->get_status(),
			'message' => $submission->get_response(),
			'demo_mode' => false,
		);
		if ( $submission->is( 'validation_failed' ) ) {
			$result['invalid_fields'] = $submission->get_invalid_fields();
		}
		return $result;
	}

	/* Message */

	public function message( $status, $filter = true ) {
		$messages = $this->prop( 'messages' );
		$message = isset( $messages[$status] ) ? $messages[$status] : '';
		if ( $filter ) {
			$message = $this->filter_message( $message, $status );
		}
		return $message;
	}
	public function filter_message( $message, $status = '' ) {
		$message = ets_strip_all_tags( $message );
		$message = etscf7_mail_replace_tags( $message, array( 'html' => true ) );
		$message = $message;
        unset($status);
		return $message;
	}
}

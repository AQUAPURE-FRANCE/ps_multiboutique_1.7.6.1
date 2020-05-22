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
 
class WPCF7_Mail {
	private static $current = null;
	private $name = '';
	private $locale = '';
	private $template = array();
	private $use_html = false;
	private $exclude_blank = false;
    public $contact_form;
	public static function get_current() {
		return self::$current;
	}
	public static function send( $template, $name = '',$save=false ) {
		self::$current = new self( $name, $template );
		return self::$current->compose(true,$save);
	}
    public static function deleteFileNotUse( $template, $name = '') {
		self::$current = new self( $name, $template );
		return self::$current->deleteFile();
	}
	private function __construct( $name, $template ) {
		$this->name = trim( $name );
		$this->use_html = ! empty( $template['use_html'] );
		$this->exclude_blank = ! empty( $template['exclude_blank'] );
        $this->template = ets_parse_args( $template, array(
			'subject' => '',
			'sender' => '',
            'bcc' => '',
			'body' => '',
			'recipient' => '',
			'additional_headers' => '',
			'attachments' => '',
		));
		if ( $submission = WPCF7_Submission::get_instance() ) {
			$contact_form = $submission->get_contact_form();
            $this->contact_form = $contact_form;
			$this->locale = $contact_form->locale();
            $this->save_message = $contact_form->save_message; 
		}
	}
	public function name() {
		return $this->name;
	}
	public function get( $component, $replace_tags = false ) {
		$use_html = ( $this->use_html && 'body' == $component );
		$exclude_blank = ( $this->exclude_blank && 'body' == $component );

		$template = $this->template;
        $body=false;
        if($component=='body')
            $body=true;
		$component = isset( $template[$component] ) ? $template[$component] : '';
        
		if ( $replace_tags ) {
			$component = $this->replace_tags( $component, array(
				'html' => $use_html,
				'exclude_blank' => $exclude_blank,
			),$body );
		}
        if($use_html)
            $component=ets_wpautop($component);
		return $component;
	}
	private function compose( $send = true,$save=false) {
		$components = array(
			'subject' => $this->get( 'subject', true ),
			'sender' => $this->get( 'sender', true ),
            'bcc' => $this->get( 'bcc', true ),
			'body' => $this->get( 'body', true ),
			'recipient' => $this->get( 'recipient', true ),
			'additional_headers' => $this->get( 'additional_headers', true ),
			'attachments' => $this->attachments(),
		);
		if ( ! $send ) {
			return $components;
		}
        $subject = etscf7_strip_newline( $components['subject'] );
        $from = Ets_contactform7::getEmailToString($components['sender']);
        $nameFrom =trim(str_replace(array('<','>',$from),'',$components['sender'])); 
        $body = $components['body'];
		$additional_headers = trim( $components['additional_headers']);
        $replyTo = Ets_contactform7::getEmailToString($additional_headers);
        $replyToName = trim(str_replace(array('<','>',$replyTo),'',$additional_headers));
		$attachments = $components['attachments'];
        if($this->name=='mail')
        {
            $template_email = Configuration::get('ETS_CTF_TEMPLATE_1',Context::getContext()->language->id);
        } 
        else
            $template_email = Configuration::get('ETS_CTF_TEMPLATE_2',Context::getContext()->language->id);
        $id_shop= Context::getContext()->shop->id;
        $link_basic =(Configuration::get('PS_SSL_ENABLED_EVERYWHERE')?'https://':'http://').Context::getContext()->shop->domain.Context::getContext()->shop->getBaseURI();
        if (Configuration::get('PS_LOGO_MAIL') !== false && file_exists(_PS_IMG_DIR_.Configuration::get('PS_LOGO_MAIL', null, null,$id_shop))) {
            $logo = Configuration::get('PS_LOGO_MAIL', null, null,$id_shop);
            $shop_logo ='<img src="'.$link_basic.'/img/'.$logo.'" alt="'.Configuration::get('PS_SHOP_NAME').'" >';
        } else {
            if (file_exists(_PS_IMG_DIR_.Configuration::get('PS_LOGO', null, null,$id_shop))) {
                $logo = Configuration::get('PS_LOGO', null, null,$id_shop);
                $shop_logo ='<img src="'.$link_basic.'/img/'.$logo.'" alt="'.Configuration::get('PS_SHOP_NAME').'" >';
            } else {
                $shop_logo='';
            }
        }
        //die($shop_logo);
        $shop_url=Context::getContext()->link->getPageLink('index', true,Context::getContext()->language->id,null,false,$id_shop);
        $template_vars=array(
            '{message_content}' => Configuration::get('ETS_CTF7_ENABLE_TEAMPLATE') ? str_replace(array('{message_content}','{shop_name}','{shop_url}','{shop_logo}','%7Bshop_url%7D','%7Bshop_logo%7D'),array($body,Configuration::get('PS_SHOP_NAME'),$shop_url,$shop_logo,$shop_url,$shop_logo),$template_email):$body,
        );
        //die(str_replace(array('{message_content}','{shop_name}','{shop_url}','{shop_logo}','%7Bshop_url%7D','%7Bshop_logo%7D'),array($body,Configuration::get('PS_SHOP_NAME'),$shop_url,$shop_logo,$shop_url,$shop_logo),$template_email));
        $recipients = explode(',',$components['recipient']);
        $ok=false;
        if($recipients)
        {
            $mails_to=array();
            $names_to =array();
            foreach($recipients as $recipient)
            {
                $to = Ets_contactform7::getEmailToString($recipient);
                $nameTo =trim(str_replace(array('<','>',$to),'',$recipient));
                if(Validate::isEmail($to))
                {
                    $mails_to[]=$to;
                    $names_to[] = $nameTo ? $nameTo : '';
                }
                else
                    return -1;
            }
            if(!$subject || !Validate::isMailSubject($subject))
                return -2;
            elseif($mails_to)
            {
                $mails_bcc = array();
                $bcc = explode(',',$components['bcc']);
                if($bcc)
                {
                   foreach($bcc as $bc)
                   {
                        $email = Ets_contactform7::getEmailToString($bc);
                        if(Validate::isEmail($email))
                            $mails_bcc[] = $email;
                   } 
                }
                if(Mail::Send(
        			Context::getContext()->language->id,
        			Configuration::get('ETS_CTF7_ENABLE_TEAMPLATE') ? 'contact_form7' : 'contact_form_7_plain',
        			$subject,
        			$template_vars,
			        $mails_to,
        			$names_to? $names_to : null,
        			($from? $from: null),
        			$nameFrom ? $nameFrom :Configuration::get('PS_SHOP_NAME'),
        			$attachments,
        			null,
        			dirname(__FILE__).'/../mails/',
        			false,
        			Context::getContext()->shop->id,
                    $mails_bcc,
                    $replyTo? $replyTo :null,
                    $replyToName ? $replyToName :null
                ))
                $ok=true;
            }
        }
		if($ok==true)
        {
            if($this->contact_form->save_message && $save)
            {
                $file_uploads= $this->file_uploads();
                $files_list='';
                foreach($file_uploads as $file)
                    $files_list .=','.basename($file);
                $contact_message= new Ets_contact_message_class();
                $contact_message->id_contact=Tools::getValue('_wpcf7');
                if(Context::getContext()->customer->logged)
                    $contact_message->id_customer= (int)Context::getContext()->customer->id;
                else
                    $contact_message->id_customer=0;
                $contact_message->subject= $subject;
                $contact_message->recipient=$components['recipient'];
                $contact_message->sender = $components['sender']? $components['sender']: (Configuration::get('PS_MAIL_METHOD')==2? Configuration::get('PS_MAIL_USER'):Configuration::get('PS_SHOP_MAIL'));
                $contact_message->reply_to = $components['additional_headers'];
                $contact_message->body= $body;
                $contact_message->attachments =trim($files_list,',');
                if($this->contact_form->star_message)
                    $contact_message->special=1;
                $contact_message->add();
                if(!$this->contact_form->save_attachments)
                {
                    $this->delete_file_uploads();
                }
            }elseif(!$this->contact_form->save_message && !$this->contact_form->save_attachments)
                $this->delete_file_uploads();
            return true;
        }
        return false;
	}
	public function replace_tags( $content, $args = '',$body=false ) {
		return etscf7_mail_replace_tags( $content, $args,$body );
	}
    private function file_uploads($template = null)
    {
        if ( ! $template ) {
			$template = $this->get( 'attachments' );
		}
		$attachments = array();
		if ( $submission = WPCF7_Submission::get_instance() ) {
			$uploaded_files = $submission->uploaded_files();
			foreach ( (array) $uploaded_files as $name => $path ) {
				if ( false !== strpos( $template, "[${name}]" )
				&& ! empty( $path ) ) {
					$attachments[] = $path;
				}
			}
		}
		return $attachments;
    }
    private function deleteFile($template = null)
    {
        if ( ! $template ) {
			$template = $this->get( 'attachments' );
		}
		if ( $submission = WPCF7_Submission::get_instance() ) {
			$uploaded_files = $submission->uploaded_files();
			foreach ( (array) $uploaded_files as $name => $path ) {
				if( false === strpos( $template, "[${name}]" )) {
					@unlink($path);
				}
			}
		}
    }
    private function delete_file_uploads($template = null)
    {
        if ( ! $template ) {
			$template = $this->get( 'attachments' );
		}
        
		if ( $submission = WPCF7_Submission::get_instance() ) {
			$uploaded_files = $submission->uploaded_files();
			foreach ( (array) $uploaded_files as $name => $path ) {
				if ( false !== strpos( $template, "[${name}]" )
				&& ! empty( $path ) ) {
					@unlink($path);
				}
			}
		}
    }
	private function attachments( $template = null ) {
		if ( ! $template ) {
			$template = $this->get( 'attachments' );
		}
		$attachments = array();
		if ( $submission = WPCF7_Submission::get_instance() ) {
			$uploaded_files = $submission->attachments();
			foreach ( (array) $uploaded_files as $name => $path ) {
				if ( false !== strpos( $template, "[${name}]" )
				&& ! empty( $path ) ) {
					$attachments[] = $path;
				}
			}
		}
		return $attachments;
	}
}
function etscf7_phpmailer_init( $phpmailer ) {
	$custom_headers = $phpmailer->getCustomHeaders();
	$phpmailer->clearCustomHeaders();
	$etscf7_content_type = false;

	foreach ( (array) $custom_headers as $custom_header ) {
		$name = $custom_header[0];
		$value = $custom_header[1];

		if ( 'X-WPCF7-Content-Type' === $name ) {
			$etscf7_content_type = trim( $value );
		} else {
			$phpmailer->addCustomHeader( $name, $value );
		}
	}
	if ( 'text/html' === $etscf7_content_type ) {
		$phpmailer->msgHTML( $phpmailer->Body );
	} elseif ( 'text/plain' === $etscf7_content_type ) {
		$phpmailer->AltBody = '';
	}
}
class WPCF7_MailTaggedText {
	private $html = false;
	private $callback = null;
	private $content = '';
	private $replaced_tags = array();
	public function __construct( $content, $args = '' ) {
		$args = ets_parse_args( $args, array(
			'html' => false,
			'callback' => null,
		) );
		$this->html = (bool) $args['html'];
		if ( null !== $args['callback'] && is_callable( $args['callback'] ) ) {
			$this->callback = $args['callback'];
		} elseif ( $this->html ) {
			$this->callback = array( $this, 'replace_tags_callback_html' );
		} else {
			$this->callback = array( $this, 'replace_tags_callback' );
		}
		$this->content = $content;
	}
	public function get_replaced_tags() {
		return $this->replaced_tags;
	}
	public function replace_tags() {
		$regex = '/(\[?)\[[\t ]*'
			. '([a-zA-Z_][0-9a-zA-Z:._-]*)' // [2] = name
			. '((?:[\t ]+"[^"]*"|[\t ]+\'[^\']*\')*)' // [3] = values
			. '[\t ]*\](\]?)/';
		return preg_replace_callback( $regex, $this->callback, $this->content );
	}
	private function replace_tags_callback_html( $matches ) {
		return $this->replace_tags_callback( $matches, true );
	}
	private function replace_tags_callback( $matches, $html = false ) {
		// allow [[foo]] syntax for escaping a tag
        if ( $matches[1] == '[' && $matches[4] == ']' ) {
			return Tools::substr( $matches[0], 1, -1 );
		}
		$tag = $matches[0];
		$tagname = $matches[2];
		$values = $matches[3];
		$mail_tag = new WPCF7_MailTag( $tag, $tagname, $values );
        
		$field_name = $mail_tag->field_name();
		$submission = WPCF7_Submission::get_instance();
		$submitted = $submission
			? $submission->get_posted_data( $field_name )
			: null;
		if ( null !== $submitted ) {

			if ( $mail_tag->get_option( 'do_not_heat' ) ) {
				$submitted = Tools::isSubmit($field_name) ? Tools::getValue($field_name) : '';
			}
			$replaced = $submitted;
			if ( $format = $mail_tag->get_option( 'format' ) ) {
				$replaced = $this->format( $replaced, $format );
			}
			$replaced = etscf7_flat_join( $replaced );
			if ( $html ) {
				$replaced = ets_esc_html( $replaced );
				//$replaced = wptexturize( $replaced );
			}
			if ( $form_tag = $mail_tag->corresponding_form_tag() ) {
				$type = $form_tag->type;
                if($type=='acceptance'|| $type=='acceptance*')
                    $replaced =etscf7_acceptance_mail_tag($replaced,$submitted,$html,$mail_tag);
			}
			$replaced = ets_unslash( trim( $replaced ) );
			$this->replaced_tags[$tag] = $replaced;
			return $replaced;
		}
		$special = null;
		if ( null !== $special ) {
			$this->replaced_tags[$tag] = $special;
			return $special;
		}
		return $tag;
	}
	public function format( $original, $format ) {
		$original = (array) $original;
		foreach ( $original as $key => $value ) {
			if ( preg_match( '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $value ) ) {
				$original[$key] = ets_mysql2date( $format, $value );
			}
		}
		return $original;
	}
}
class WPCF7_MailTag {
	private $tag;
	private $tagname = '';
	private $name = '';
	private $options = array();
	private $values = array();
	private $form_tag = null;
	public function __construct( $tag, $tagname, $values ) {
		$this->tag = $tag;
		$this->name = $this->tagname = $tagname;
		$this->options = array(
			'do_not_heat' => false,
			'format' => '',
		);
		if ( ! empty( $values ) ) {
			preg_match_all( '/"[^"]*"|\'[^\']*\'/', $values, $matches );
			$this->values = etscf7_strip_quote_deep( $matches[0] );
		}
		if ( preg_match( '/^_raw_(.+)$/', $tagname, $matches ) ) {
			$this->name = trim( $matches[1] );
			$this->options['do_not_heat'] = true;
		}
		if ( preg_match( '/^_format_(.+)$/', $tagname, $matches ) ) {
			$this->name = trim( $matches[1] );
			$this->options['format'] = $this->values[0];
		}
	}
	public function tag_name() {
		return $this->tagname;
	}
	public function field_name() {
		return $this->name;
	}
	public function get_option( $option ) {
		return $this->options[$option];
	}
	public function values() {
		return $this->values;
	}
	public function corresponding_form_tag() {
		if ( $this->form_tag instanceof WPCF7_FormTag ) {
			return $this->form_tag;
		}
		if ( $submission = WPCF7_Submission::get_instance() ) {
			$contact_form = $submission->get_contact_form();
			$tags = $contact_form->scan_form_tags( array(
				'name' => $this->name,
				'feature' => '! zero-controls-container',
			) );
			if ( $tags ) {
				$this->form_tag = $tags[0];
			}
		}
		return $this->form_tag;
	}
    public function getEmailToString($string)
    {
        $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
        preg_match_all($pattern, $string, $matches);
        var_dump($matches[0]);
    }
}

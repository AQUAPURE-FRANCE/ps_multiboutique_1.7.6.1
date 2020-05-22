<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  @version  Release: $Revision$
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;
    
class Ets_contactform7CaptchaModuleFrontController extends ModuleFrontController
{
    public function init()
	{
		$this->create_image();
        die;
	}
    public function create_image()
    {
        $security_code = Tools::substr(sha1(mt_rand()), 17, 6);
        $context = Context::getContext();
        $captcha_name =Tools::getValue('captcha_name');
        if (Tools::getValue('page') == 'contact')
            $context->cookie->$captcha_name = $security_code;
        else
            $context->cookie->$captcha_name = $security_code;
        $context->cookie->write();
        if (Tools::getValue('theme') == 'colorful')
        {
            
            $image = imagecreatetruecolor(150, 35);

    		$width = imagesx($image);
    		$height = imagesy($image);
    
    		$black = imagecolorallocate($image, 0, 0, 0);
    		$white = imagecolorallocate($image, 255, 255, 255);
    		$red = imagecolorallocatealpha($image, 255, 0, 0, 75);
    		$green = imagecolorallocatealpha($image, 0, 255, 0, 75);
    		$blue = imagecolorallocatealpha($image, 0, 0, 255, 75);
    
    		imagefilledrectangle($image, 0, 0, $width, $height, $white);
    		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $red);
    		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $green);
    		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $blue);
    		imagefilledrectangle($image, 0, 0, $width, 0, $black);
    		imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $black);
    		imagefilledrectangle($image, 0, 0, 0, $height - 1, $black);
    		imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $black);
    
    		imagestring($image, 10, (int)(($width - (Tools::strlen($security_code) * 9)) / 2), (int)(($height - 15) / 2), $security_code, $black);
        }     
        else
        {
            $width = 100;  
            $height = 30;  
            $image = ImageCreate($width, $height);  
            $white = ImageColorAllocate($image, 255, 255, 255); 
            $black = ImageColorAllocate($image, 27, 79, 166); 
            $noise_color = imagecolorallocate($image, 172,211,255);
            $background_color = imagecolorallocate($image, 255, 255, 255);
            //$text_color = imagecolorallocate($image, 20, 40, 100);
            ImageFill($image,0, 0, $background_color); 
            for( $i=0; $i<($width*$height)/3; $i++ ) {
                imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
            }
            for( $i=0; $i<($width*$height)/150; $i++ ) {
                imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
            }
            imagestring($image, 10, 30, 6, $security_code, $black);
        } 
        header("Content-Type: image/jpeg"); 
        ImageJpeg($image); 
        ImageDestroy($image); 
        exit();
    }
	/*function to convert hex value to rgb array*/
	protected function hexToRGB($colour)
	{
        if ( $colour[0] == '#' ) {
			$colour = Tools::substr( $colour, 1 );
        }
        if ( Tools::strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( Tools::strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
			return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( 'r' => $r, 'g' => $g, 'b' => $b );
	}
		
		
	/*function to get center position on image*/
	protected function ImageTTFCenter($image, $text, $font, $size, $angle = 8) 
	{
		$xi = imagesx($image);
		$yi = imagesy($image);
		$box = imagettfbbox($size, $angle, $font, $text);
		$xr = abs(max($box[2], $box[4]))+5;
		$yr = abs(max($box[5], $box[7]));
		$x = (int)(($xi - $xr) / 2);
		$y = (int)(($yi + $yr) / 2);
		return array($x, $y);	
	} 
}
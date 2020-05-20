{**
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<div class="container"></div>
<header id="header">
	{**Mobile-Nav*}
	<div class="mobile hidden-lg-up">
	     <div id="nav-mobile">
	        <div class="nav-button col-xs-4 text-center" data-wrapper="menu">
	            <i class="fa fa-bars"></i>
	        </div>
	        <div class="nav-button col-xs-4 text-center" data-wrapper="cart">
	            <div id="_mobile_cart">
	                <span class="fa fa-shopping-basket"></span>
	                <span id="count_cart_mobile"></span>
	            </div>
	        </div>
	        <div class="nav-button col-xs-4 text-center" data-wrapper="myaccount">
	            <div id="_mobile_acount">
	                <span class="fa fa-user"></span>
	            </div>
	        </div>
		 </div>
	     <div id="wrapper-mobile">
	     	<div class="wrapper-tab menu">
	            <div id="_mobile_language"></div>
	            <div id="_mobile_currency"></div>
	            <div id="header_mobile_menu" class="navbar-inactive">
	                <nav id="nrtmegamenu-mobile" class="nrtmegamenu">
	                    <ul id="_mobile_megamenu"></ul>
	                </nav>
	            </div>
	            <ul id="_mobile_vmegamenu"></ul>
	        </div>
	     	<div class="wrapper-tab cart">
				<div id='_mobile_cart_tab'></div>
	        </div>
	     	<div class="wrapper-tab myaccount">
				{include file="_partials/quick-login.tpl"}
	        </div>
	     </div>
		 <div id="_mobile_logo" class="text-center"></div>
	     <div class="container">
	     	<div id="_mobile_search"></div>
	     </div>
	</div>
{**End-Mobile-Nav*}

<div class="desktop hidden-md-down">
{*
{block name='header_banner'}
  <div class="header-banner">
    {widget name="ps_banner"}
  </div>
{/block}
*}
<div id="block-nav-center">
    <div class="container">
    	<div class="wraper_nav">
            <div class="nav_right">
            	{hook h='displayNav2'}
            </div>
            <div class="nav_left">
            	{hook h='displayNav1'}
            </div>
        </div>
    </div>
</div>
<div id="block-header-center" class="sticky_top">
    <div class="container">
    	<div id="_desktop_logo" class="header-logo">
            <a href="{$urls.base_url}"> 
				<img class="logo_home img-responsive" src="{$link->getMediaLink($shop.logo)}" alt="{$shop.name}"/>
            </a>
        </div>
    	<div class="header-left">
            {hook h='displayMobileTopSiteMap'}
        </div>
        <div class="header-right">
        	{hook h='displayTop'}
        	
        <div class="contact-iconmenu sticky_top">
	        <div class="af af-hotline"></div>	        
	    </div>	    
{*         	{hook h='linkwishlist'} *}
        </div>
    </div>
</div>
</div>
</header>
<div id="wrapper_menu" class="hidden-md-down">
    <div class="container">
    	{hook h='vmegamenu'}
        <div id="header_menu">
            <div class="container">
                <div class="row">
                    <nav id="nrtmegamenu-main" class="nrtmegamenu inactive">
                        {hook h='megamenu'}
                    </nav>
                </div>
            </div>
        </div>
        <div class="contactform_menu">
	        {hook h="displayContactForm7" id="3"}
	    </div>
    </div>
</div>

/**
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/


$(document).ready(function(){


//save on frontoffice editor update button
$('.update-fronteditor-action').on("click",function() {
  $('#preloader').fadeIn('fast'); 
  $('#status').delay(20).fadeIn('fast'); 
  $('body').delay(20).css({'overflow':'hidden'});
  saveEditorAjax();
});

$('.switch-guides-btn').on("click",function() {
  $("#ffpreview").contents().find('body').toggleClass('force-guides');
});




//set preview typ
$( '#fronteditor-toolbar' ).on( 'click', '.switch-front-view-btn', function() 
{

	switch ($(this).data('preview-type')) {
    case 'preview-d':
        $('#ffpreview').width('100%');
        break;
      case 'preview-t':
        $('#ffpreview').width('990px');
        break;
     case 'preview-p':
        $('#ffpreview').width('480px');
        break;
	}
});

});


function saveEditorAjax()
{ 

  if(document.getElementById('ffpreview').contentWindow.getSubmenuContentWindow() != '')
    var submenu_elements = encodeURIComponent(JSON.stringify(document.getElementById('ffpreview').contentWindow.getSubmenuContentWindow()));
      

  $.ajax({
    type: 'POST',
    url: admin_fronteditor_ajax_url,
    data: {
      controller : 'NrtFronteditor',
      action : 'saveEditor',
      submenu_elements : submenu_elements,
      ajax : true
    },
    success: function(jsonData)
    { 
      location.reload(true);
    }
  });
}



$(window).load(function() { 
			$('#status').fadeOut(); 
			$('#preloader').delay(350).fadeOut('slow'); 
			$('body').delay(350).css({'overflow':'visible'});
});

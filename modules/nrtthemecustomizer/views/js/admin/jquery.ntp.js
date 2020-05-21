$(document).ready(function(){

    // Make the first tab active
    var $_firstTab = $('#nrtthemecustomizer-tabs .tab').first();
    $_firstTab.addClass('active');

    var firstTabContentID = '#' + $_firstTab.attr('data-tab');
    $('#configuration_form .panel').not(firstTabContentID).hide();

    // On tab click
    $('#nrtthemecustomizer-tabs .tab').on('click', function()
    {
        var tabContentID = '#' + $(this).attr('data-tab');
        $('#configuration_form .panel').hide();
        $('#configuration_form .panel' + tabContentID).show();

        $('#nrtthemecustomizer-tabs .tab').removeClass('active');
        $(this).addClass('active');
    });

});

<div id="moda_popupnewsletter" class="modal fade nrtpopup" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="{if $nrt_ppp.NRT_WIDTH}max-width:{$nrt_ppp.NRT_WIDTH}px;{/if}">
    <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<div class="nrtpopupnewsletter" style="{if $nrt_ppp.NRT_WIDTH}width:{$nrt_ppp.NRT_WIDTH}px;{/if}{if $nrt_ppp.NRT_HEIGHT}height:{$nrt_ppp.NRT_HEIGHT}px;">
	{if $nrt_ppp.NRT_NEWSLETTER == 1}
	<div id="newsletter_block_popup">
    	<img class="img-responsive" src="{/if}{if $nrt_ppp.NRT_BG == 1 && !empty($nrt_ppp.NRT_BG_IMAGE)}{$nrt_ppp.NRT_BG_IMAGE}{/if}" alt=""/>
		<div class="block_content">
		{if isset($msg) && $msg}
			<p class="{if $nw_error}warning_inline{else}success_inline{/if}">{$msg}</p>
		{/if}
			<form action="{$link->getPageLink('index')|escape:'html'}" method="post">
                            {if $nrt_ppp.NRT_TITLE}{$nrt_ppp.NRT_TITLE|stripslashes nofilter}{/if}
                            {if isset($nrt_ppp.NRT_COUNTDOWN_POPUP) && !empty($nrt_ppp.NRT_COUNTDOWN_POPUP) && $nrt_ppp.NRT_COUNTDOWN_POPUP != '0000-00-00 00:00:00'}
                                <span class="item-countdown">
                                    <span class="bg_tranp"></span>
                                    <span class="item-countdown-time" data-time="{$nrt_ppp.NRT_COUNTDOWN_POPUP}"></span>
                                </span>
                            {/if}
                            <div class="send-response"></div>
                            <input class="inputNew form-control" id="newsletter-input-popup" type="text" name="email" value="{l s='Enter Email Address Here' mod='fieldpopupnewsletter'}"/>
                            <div class="send-reqest button_unique main_color_hover title_font">{l s='Subscribe' mod='nrtpopupnewsletter'}</div>
                 {if $nrt_ppp.NRT_TEXT}<div class="popup_text_bottom">{$nrt_ppp.NRT_TEXT|stripslashes nofilter}</div>{/if}
			</form>
        
		</div>
                <div class="newsletter_block_popup-bottom">
                    <input id="newsletter_popup_dont_show_again" type="checkbox">
                    <label for="newsletter_popup_dont_show_again">{l s='Don\'t show this popup again' mod='nrtpopupnewsletter'}</label>
                </div>
	</div>
	{/if}
</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{if $nrt_ppp.NRT_NEWSLETTER == 1}
<script type="text/javascript">
    var placeholder2 = "{l s='Enter Email Address Here' mod='nrtpopupnewsletter' js=1}";
    {literal}
        $(document).ready(function() {
            $('#newsletter-input-popup').on({
                focus: function() {
                    if ($(this).val() == placeholder2) {
                        $(this).val('');
                    }
                },
                blur: function() {
                    if ($(this).val() == '') {
                        $(this).val(placeholder2);
                    }
                }
            });
        });
    {/literal}
</script>
{/if}
<script type="text/javascript">
	var nrt_width={$nrt_ppp.NRT_WIDTH};
	var nrt_height={$nrt_ppp.NRT_HEIGHT};
	var nrt_newsletter={$nrt_ppp.NRT_NEWSLETTER};
	var nrt_path='{$nrt_ppp.NRT_PATH}';
</script>

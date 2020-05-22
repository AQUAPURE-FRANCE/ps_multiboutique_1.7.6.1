<div class="title-home-blog">
{if isset($nodecontent.title) && $nodecontent.title != ''}
    {if isset($nodecontent.href) && $nodecontent.href != ''}
        {if isset($nodecontent.legend) && $nodecontent.legend != ''}<div class="content_title clearfix">{/if}
        <h4 class="title_block title_font">
            <a class="title_text" href="{$nodecontent.href}">
                {$nodecontent.title nofilter} 
            </a>
        </h4>
        {if isset($nodecontent.legend) && $nodecontent.legend != ''}
            <p class="mb-10">{$nodecontent.legend}</p>
        {/if}
        {if isset($nodecontent.legend) && $nodecontent.legend != ''}</div>{/if}
    {else}
        {if isset($nodecontent.legend) && $nodecontent.legend != ''}<div class="content_title">{/if}
        <h4 class="title_block title_font">
            <span class="title_text">
                {$nodecontent.title nofilter} 
            </span>
        </h4>
        {if isset($nodecontent.legend) && $nodecontent.legend != ''}
            <p class="mb-10">{$nodecontent.legend}</p>
        {/if}
        {if isset($nodecontent.legend) && $nodecontent.legend != ''}</div>{/if}
    {/if}
{/if}
</div> 

<div class="smart-blog-home-post col-md-5">
    <div class="row">
        <div id="smart-blog-custom">                
            {if isset($view_data) AND !empty($view_data)}
            {assign var="i" value="0"}
            {if isset($nodecontent.colnb) && $nodecontent.colnb}{assign var="y" value=$nodecontent.colnb}{else}{assign var="y" value=1}{/if}
            {foreach from=$view_data item=post}
            {assign var="options" value=null}
            {$options.id_post = $post.id}
            {$options.slug = $post.link_rewrite}
            <div class="blog-item small">
            	<!-- Blog Image-->
                <div class="blog-media">
                  <div class="pic"><img src="{$link->getMediaLink($smarty.const._MODULE_DIR_)}smartblog/images/{$post.post_img}-home-default.jpg" alt="">
                    <div class="hover-effect"></div>
                    <div class="links"><a href="{$link->getMediaLink($smarty.const._MODULE_DIR_)}smartblog/images/{$post.post_img}-home-default.jpg" class="link-icon fa fa-image fancy" alt="{l s='See Image'}"></a><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" target="_blank" class="link-icon fa fa-glasses" alt="{l s='Read Post'}"></a></div>
{*
                    <div class="audio-wrapper">
                      <audio controls="">
                        <source src="audio/audio.mp3" type="audio/mpeg">
                      </audio>
                    </div>
*}
                  </div>
                </div>
                <!-- title, author...-->
                <div class="blog-item-data clearfix">
                  <div class="blog-date">
                    <div class="date">
                      <div class="date-cont"><span class="day">{$post.date_added|date_format:d}</span><span class="month"><span>{$post.date_added|date_format:"%b"}</span></span><span class="year">{$post.date_added|date_format:Y}</span><i class="springs"></i></div>
                    </div>
                  </div>
                  <h2 class="blog-title"><a target="_blank" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></h2>
                  <div class="divider gray"></div>
                  <p class="post-info">{l s='By'} <span class="posr-author">{$post.firstname}{$post.lastname}</span><i>|</i>in <a href="#" class="post-category"> <span>news</span></a>, <a href="#" class="post-category"><span>business </span></a><i>|</i><i class="fa fa-eye"></i> ({$post.totalcomment})</p>
                </div>
                <!-- Text Intro-->
                <div class="blog-item-body">
                  <p>{$post.short_description}</p>
                </div>
                <!-- Read More and social links-->
                <div class="blog-item-foot clearfix">
{* 	                <a href="#" class="cws-social fab fa-facebook"></a><a href="#" class="cws-social fab fa-twitter"></a><a href="#" class="cws-social fab fa-google-plus"></a><a href="#" class="cws-social fab fa-linkedin"></a><a href="#" class="cws-social fab fa-pinterest"></a> *}<a target="_blank" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="cws-button pull-right">{l s='Read more'}</a>
	            </div>
          	</div>
            {/foreach}
            {/if}
        </div>
    </div>
</div>
<div id="js-blog-section" class="row col-md-7"></div>
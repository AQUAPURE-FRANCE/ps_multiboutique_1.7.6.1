<div class="smart-blog-home-post">
    <div class="column-inner {if isset($nodecontent.ar) && $nodecontent.ar ==0}arrows_center{elseif isset($nodecontent.ar) && $nodecontent.ar ==1}arrows_oncolum{/if}">
    {if isset($nodecontent.title) && $nodecontent.title != ''}
        {if isset($nodecontent.href) && $nodecontent.href != ''}
            {if isset($nodecontent.legend) && $nodecontent.legend != ''}<div class="content_title">{/if}
            <h4 class="title_block title_font">
                <a class="title_text" href="{$nodecontent.href}">
                    {$nodecontent.title} 
                </a>
            </h4>
            {if isset($nodecontent.legend) && $nodecontent.legend != ''}
                <p>{$nodecontent.legend}</p>
            {/if}
            {if isset($nodecontent.legend) && $nodecontent.legend != ''}</div>{/if}
        {else}
            {if isset($nodecontent.legend) && $nodecontent.legend != ''}<div class="content_title">{/if}
            <h4 class="title_block title_font">
                <span class="title_text">
                    {$nodecontent.title} 
                </span>
            </h4>
            {if isset($nodecontent.legend) && $nodecontent.legend != ''}
                <p>{$nodecontent.legend}</p>
            {/if}
            {if isset($nodecontent.legend) && $nodecontent.legend != ''}</div>{/if}
        {/if}
    {/if}  
    <div class="slider_carousel horizontal_mode block lady_load_img" data-filter-carousel="{$nodecontent.line_md},{$nodecontent.line_sm},{$nodecontent.line_xs},{$nodecontent.ap},1,{$nodecontent.dt},{$nodecontent.ar},5000,{$nodecontent.line_ms}">
        <div class="row">
            <div id="smart-blog-custom" class="owl-carousel owl-theme">
                {if isset($view_data) AND !empty($view_data)}
                {assign var="i" value="0"}
                {if isset($nodecontent.colnb) && $nodecontent.colnb}{assign var="y" value=$nodecontent.colnb}{else}{assign var="y" value=1}{/if}
                {foreach from=$view_data item=post}
                {assign var="options" value=null}
                {$options.id_post = $post.id}
                {$options.slug = $post.link_rewrite}
                {if $i mod $y eq 0}
                <div class="item sds_blog_post">
                {/if}
                <div class="item-inner">
                
                <div class="news_module_image_holder">
                <div class="inline-block_relative">
                    <div class="image_holder_wrap">
                        <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">
                        <img class="{if $nodecontent.line_lg}owl-lazy{/if} img-responsive" 
                        {if $nodecontent.line_lg}data{/if}-src="{$link->getMediaLink($smarty.const._MODULE_DIR_)}smartblog/images/{$post.post_img}-home-default.jpg" 
                        {if $nodecontent.line_lg}src="#"{/if}
                        alt=""
                        {if isset($size_home_default_post.width)}width="{$size_home_default_post.width}"{/if}
                        {if isset($size_home_default_post.height)}height="{$size_home_default_post.height}"{/if} 
                        >
                        <i class="fa fa-link"></i></a>
                    </div> 
                    <div class="right_blog_home">                    
                    <div class="content">
                    <h3 class="sds_post_title title_font"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></h3>
                    <p>
                    {$post.short_description}
                    </p>
                    <div class="bottom_blog">
                    <a class="read-more-blog title_font" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">
                        {l s='Read more' }
                        <i class="fa fa-angle-right"></i>
                    </a>
                    </div>                 
                    </div>
                    
                    </div>
                </div>
                </div>
                </div>
                {assign var="i" value="`$i+1`"}
                {if $i mod $y eq 0 || $i eq count($view_data)}
                </div>
                {/if}
                {/foreach}
                {/if}
            </div>
        </div>
    </div>
    </div>
</div>
 <div class="smart-blog-home-post slider_carousel horizontal_mode {if isset($nodecontent.ar) && $nodecontent.ar ==0}arrows_center{elseif isset($nodecontent.ar) && $nodecontent.ar ==1}arrows_oncolum{/if}" data-filter-carousel="{$nodecontent.line_md},{$nodecontent.line_sm},{$nodecontent.line_xs},{$nodecontent.ap},1,{$nodecontent.dt},{$nodecontent.ar},5000,{$nodecontent.line_ms}">
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
				    <div class="inline-block_relative {if ($i+1) mod 2 eq 0}img_bottom{/if}">
					<div class="image_holder_wrap">
					    <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">
                        <img class="{if $nodecontent.line_lg}owl-lazy{/if} img-responsive" {if $nodecontent.line_lg}data{/if}-src="{$link->getMediaLink($smarty.const._MODULE_DIR_)}smartblog/images/{$post.post_img}-home-default.jpg" alt=""
                        {if isset($size_home_default_post.width)}width="{$size_home_default_post.width}"{/if}
                         {if isset($size_home_default_post.height)}height="{$size_home_default_post.height}"{/if} 
                         style="width:{$size_home_default_post.width}px;height:{$size_home_default_post.height}px;background-color:rgba(0,0,0,0.25)"
                        >
                        <i class="fa fa-link"></i></a>
					</div> 
					<div class="right_blog_home">
                     <span class="block_post_date"></span>

                    <span class="smart-auth"><i class="fa fa-user"></i>{l s='By: ' } <span>{$post.firstname}{$post.lastname}</span></span>
                 <div class="date_added">
                 <i class="fa fa-clock-o"></i>
                 <span>
                {$post.date_added|date_format:M}
                {$post.date_added|date_format:d},
                {$post.date_added|date_format:Y}
                </span>
                </div>
                <p class="viewed"><i class="fa fa-eye"></i>{$post.viewed} {if $post.viewed > 1 }{l s='Views' }{else}{l s='View' }{/if}</p>
					    <div class="content">
						<h3 class="sds_post_title"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></h3>
                        
					 
                         <p>
						    {$post.short_description|truncate:148:'...'|escape:'htmlall':'UTF-8'}
						</p>
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
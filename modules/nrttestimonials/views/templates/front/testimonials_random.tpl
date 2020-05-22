<div class="block_testimonials" {if $conf_testimonials.show_background && $background != ""}style="background: url({$link->getMediaLink("`$module_dir`$background")}) center center no-repeat; background-attachment: fixed; background-blend-mode: screen; background-clip: border-box; background-color: rgba(0, 0, 0, 0); background-size:cover; background-origin: padding-box; background-repeat: no-repeat;"{/if}>
    <div class="overlay_testimonials">
        <div class="container">
            <div class="content_title">  
                <p>{l s='What people say about them'}</p>
                <h4 class="title_block title_font">
                    <span class="title_text">
                    {l s='Testimonials'}
                    </span>
                </h4>
            </div>
            <div class="row">
<div id="testimonials_block_right">
  <div id="wrapper_testimonials" class="block_content horizontal_mode">
    {if $testimonials}
      <div id="slide-panel">
        <div id="slide" class="owl-carousel owl-theme">
          {foreach from=$testimonials key=test item=testimonial}
          	<div class="item">
            {if $testimonial.active == 1}
              <div class="main-block">
                {if $conf_testimonials.show_info}
                    <div class="media">
                    <div class="media-content">
                        {if $testimonial.media}
                            {if in_array($testimonial.media_type,$conf_testimonials.arr_img_type)}
                              <a href="javascript:void(0)">
                            <img class="img-responsive" src="{$conf_testimonials.mediaUrl}{$testimonial.media}" alt="Image Testimonial"/>
                              </a>
                            {/if}
                        {/if}
                        {if in_array($testimonial.media_type,$conf_testimonials.video_types)}
                        <video width="260" height="240" controls>
                            <source src="{$conf_testimonials.mediaUrl}{$testimonial.media}" type="video/mp4" />
                        </video>
                        {/if}
                        {if $testimonial.media_type == 'youtube'}
                          <a href="{$testimonial.media_link}"><img class="img-responsive" src="{$conf_testimonials.video_youtube}" alt="Youtube Video"/></a>
                        {elseif $testimonial.media_type == 'vimeo'}
                          <a href="{$testimonial.media_link}"><img class="img-responsive" src="{$conf_testimonials.video_vimeo}" alt="Vimeo Video"/></a>
                        {/if}
                    </div>
        
                    </div>
                {/if}
                <div class="content_test_top">
                  {if $conf_testimonials.show_info}
                    <div class="content_test_box">
                      <p class="des_namepost">{$testimonial.name_post}</p>
                      <p class="des_company">{$testimonial.company}</p>
                    </div>
                  {/if}
                  <p class="des_testimonial"><span>"</span>{$testimonial.content|truncate:203:'...'|escape:'htmlall':'UTF-8'}<span>"</span></p>
                </div>
              </div>
            {/if}
            </div>
          {/foreach}
        </div>
        
      </div>
    {/if}

                    </div>
</div>
            </div>
        </div>
    </div>
</div>

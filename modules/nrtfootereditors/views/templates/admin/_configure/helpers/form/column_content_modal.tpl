		<div class="modal fade column-content-modal" tabindex="-1" role="dialog" aria-labelledby="columnContent" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
                    <div class="modal-header">
        				<h4 class="modal-title">{l s='Column Setting' mod='nrtfootereditors'}</h4>
      				</div>
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Title' mod='nrtfootereditors'}
							</label>
				
							
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.title[$language.id_lang])}{$node.content_s.title[$language.id_lang]}{/if}" type="text" class="column-title-{$language.id_lang}">
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Title link' mod='nrtfootereditors'}
							</label>
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.href[$language.id_lang])}{$node.content_s.href[$language.id_lang]}{/if}" type="text" class="column-href-{$language.id_lang}">
							<p class="help-block">
								{l s='Example : http://google.com' mod='nrtfootereditors'}
							</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Title small' mod='nrtfootereditors'}
							</label>
				
							
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.legend[$language.id_lang])}{$node.content_s.legend[$language.id_lang]}{/if}" type="text" class="column-legend-{$language.id_lang}">
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3">{l s='Content type' mod='nrtfootereditors'}</label>
							<select class="select-column-content col-lg-9">
								<option value="9" {if isset($node.contentType) && $node.contentType==9}selected{/if}>{l s='Module include' mod='nrtfootereditors'}</option>
								<option value="7" {if isset($node.contentType) && $node.contentType==7}selected{/if}>{l s='Manufacturers logos' mod='nrtfootereditors'}</option>
								<option value="6" {if isset($node.contentType) && $node.contentType==6}selected{/if}>{l s='Banner image' mod='nrtfootereditors'}</option>
								<option value="4" {if isset($node.contentType) && $node.contentType==4}selected{/if}>{l s='Selected Products' mod='nrtfootereditors'}</option>
								<option value="2" {if isset($node.contentType) && $node.contentType==2}selected{/if}>{l s='Products Properties' mod='nrtfootereditors'}</option>
								<option value="1" {if isset($node.contentType) && $node.contentType==1}selected{/if}>{l s='Html Custom' mod='nrtfootereditors'}</option>
							<option value="8" {if isset($node.contentType) && $node.contentType==8}selected{/if}>{l s='Custom hook' mod='iqitcontentcreator'}</option>
								<option value="0" {if isset($node.contentType)}{if $node.contentType==0}selected{/if}{else}selected{/if} >{l s='Empty' mod='nrtfootereditors'}</option>

							</select></div>
						
					<div class="htmlcontent-wrapper content-options-wrapper">
							<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Custom Html content' mod='nrtfootereditors'}
							</label>
								<select class="select-customhtml col-lg-9">
							<option value="0">{l s='No content' mod='nrtfootereditors'}</option>
							{foreach from=$custom_html_select item=customhtml}
							<option value="{$customhtml.id_html}" {if isset($node.content.ids) && $node.content.ids == $customhtml.id_html}selected{/if} >{$customhtml.title}</option>
							{/foreach}
							</select>
			
									
								
								
						</div>
					</div>	
					
					<div class="categorytree-wrapper content-options-wrapper">
						
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Source of products' mod='nrtfootereditors'}</label>
								<select class="select-categories-ids col-lg-9">
									<option value="n" {if isset($node.content.ids) && $node.content.ids == 'n'}selected{/if}>{l s='New products' mod='nrtfootereditors'}</option>
									<option value="s" {if isset($node.content.ids) && $node.content.ids == 's'}selected{/if}>{l s='Price drops' mod='nrtfootereditors'}</option>
									<option value="b" {if isset($node.content.ids) && $node.content.ids == 'b'}selected{/if}>{l s='Best sellers' mod='nrtfootereditors'}</option>
									<option value="null" disabled>--- {l s='Categories' mod='nrtfootereditors'} ---</option>
									{foreach from=$categories_select item=category}
										<option value="{$category.id}" {if isset($node.content.ids) && $node.content.ids == '2'}selected{/if}>{$category.name}</option>

										{if isset($category.children)}
											{if isset($node.content.ids) && $node.contentType == 2}
												{include file="./subcategory.tpl" categories=$category.children ids=$node.content.ids type=$node.contentType}
											{else}
												{include file="./subcategory.tpl" categories=$category.children}
											{/if}     
										{/if}  
									{/foreach}
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='View type' mod='nrtfootereditors'}</label>
								<div class="col-lg-9"><select class="select-categories-view">
									<option value="1" {if isset($node.content.view) && $node.content.view == 1}selected{/if} >{l s='Slider - info below big image ' mod='nrtfootereditors'}</option>
									<option value="disabled" disabled>{l s='------------------'}</option>
									<option value="3" {if isset($node.content.view) && $node.content.view == 3}selected{/if} >{l s='Slider - info next to small image ' mod='nrtfootereditors'}</option>
									<option value="disabled" disabled>{l s='------------------'}</option>
                                    <option value="4"  {if isset($node.content.view) && $node.content.view == 4}selected{/if}>{l s='Slider - Full ' mod='nrtfootereditors'}</option>
									
								</select>
							</div>
							</div>
								<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Image size' mod='nrtfootereditors'}</label>
								<div class="col-lg-9"><select class="select-image-type">
								<option value="0" {if isset($node.content.itype) && $node.content.itype == 0}selected{/if}>{l s='Default - Recommanded' mod='nrtfootereditors'}</option>
								{foreach from=$images_formats item=format}
										<option value="{$format.name}" {if isset($node.content.itype) && $node.content.itype == $format.name}selected{/if}>{$format.name}</option>
										{/foreach}
								</select>
								<p class="help-block">
										{l s='For big image sliders home_default should be fine. For small images sliders small_default but everthing depends of your configuration. If you not shure keep default option' mod='nrtfootereditors'}
									</p>
							</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products limit' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
									<input value="{if isset($node.content.limit)}{$node.content.limit}{else}10{/if}" type="text" class="categories-products-limit" >
									<p class="help-block">
										{l s='Maxiumum number of products to show' mod='nrtfootereditors'}
									</p>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Order products by' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-categories-o">
									<option value="position"  {if isset($node.content.o) && $node.content.o == 'position'}selected{/if} > {l s='Position' mod='nrtfootereditors'}</option>
									<option value="name"  {if isset($node.content.o) && $node.content.o == 'name'}selected{/if} > {l s='Name' mod='nrtfootereditors'}</option>
									<option value="date_add"  {if isset($node.content.o) && $node.content.o == 'date_add'}selected{/if} >{l s='Date add' mod='nrtfootereditors'}</option>
									<option value="price"  {if isset($node.content.o) && $node.content.o == 'price'}selected{/if} > {l s='Price' mod='nrtfootereditors'}</option>
									<option value="1"  {if isset($node.content.o) && $node.content.o == 1}selected{/if} > {l s='Random(works only with categories)' mod='nrtfootereditors'}</option> 
								</select>
								<p class="help-block">
										{l s='This settings do not affects bestsellers' mod='nrtfootereditors'}
								</p>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Order way' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-categories-ob">
									<option value="ASC"  {if isset($node.content.ob) && $node.content.ob == 'ASC'}selected{/if} >Ascending</option>
									<option value="DESC"  {if isset($node.content.ob) && $node.content.ob == 'DESC'}selected{/if} >Descending</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per column' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-categories-per-column">
									<option value="1"  {if isset($node.content.colnb) && $node.content.colnb == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.colnb) && $node.content.colnb == 2}selected{/if} >2</option>
									<option value="3"  {if isset($node.content.colnb) && $node.content.colnb == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.colnb) && $node.content.colnb == 4}selected{/if} >4</option>
									<option value="5"  {if isset($node.content.colnb) && $node.content.colnb == 5}selected{/if} >5</option>
									<option value="6"  {if isset($node.content.colnb) && $node.content.colnb == 6}selected{/if} >6</option>
									<option value="7"  {if isset($node.content.colnb) && $node.content.colnb == 7}selected{/if} >7</option>
									<option value="8"  {if isset($node.content.colnb) && $node.content.colnb == 8}selected{/if} >8</option>
									<option value="9"  {if isset($node.content.colnb) && $node.content.colnb == 9}selected{/if} >9</option>
									<option value="10" {if isset($node.content.colnb) && $node.content.colnb == 10}selected{/if} >10</option>
								</select>
								<p class="help-block">
										{l s='Affects sliders only' mod='nrtfootereditors'}
									</p>
									</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider autoplay' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-categories-ap">
									<option value="0"  {if isset($node.content.ap) && $node.content.ap == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.ap) && $node.content.ap == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider arrows' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-categories-ar">
									<option value="0"  {if isset($node.content.ar) && $node.content.ar == 0}selected{/if} >In middle of slider</option>
									<option value="1"  {if isset($node.content.ar) && $node.content.ar == 1}selected{/if} >Above slider(on column title)</option>
									<option value="2"  {if isset($node.content.ar) && $node.content.ar == 2}selected{/if} >Hide</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider dots' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-categories-dt">
									<option value="0"  {if isset($node.content.dt) && $node.content.dt == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.dt) && $node.content.dt == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Lazy load' mod='nrtfootereditors'}</label>
								<select class="select-categories-line-lg col-lg-9">
									<option value="1"  {if isset($node.content.line_lg) && $node.content.line_lg == 1}selected{/if} >Yes</option>
									<option value="0"  {if isset($node.content.line_lg) && $node.content.line_lg == 0}selected{/if}>No</option>
								</select>
							</div>
                            <div class="form-group">
								<label  class="control-label col-lg-3">{l s='Loop' mod='nrtfootereditors'}</label>
								<select class="select-categories-line-ms col-lg-9">
									<option value="1"  {if isset($node.content.line_ms) && $node.content.line_ms == 1}selected{/if} >Yes</option>
									<option value="0"  {if isset($node.content.line_ms) && $node.content.line_ms == 0}selected{/if}>No</option>									
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - desktop' mod='nrtfootereditors'}</label>
								<select class="select-categories-line-md col-lg-9">
									<option value="1"  {if isset($node.content.line_md) && $node.content.line_md == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_md) && $node.content.line_md == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_md) && $node.content.line_md == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.line_md) && $node.content.line_md == 4}selected{/if}>4</option>
									<option value="5"  {if isset($node.content.line_md) && $node.content.line_md == 5}selected{/if}>5</option>
									<option value="6"  {if isset($node.content.line_md) && $node.content.line_md == 6}selected{/if}>6</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - tablet' mod='nrtfootereditors'}</label>
								<select class="select-categories-line-sm col-lg-9">
									<option value="1"  {if isset($node.content.line_sm) && $node.content.line_sm == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_sm) && $node.content.line_sm == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_sm) && $node.content.line_sm == 3}selected{/if}>3</option>
									<option value="4"  {if isset($node.content.line_sm) && $node.content.line_sm == 4}selected{/if}>4</option>
								</select>
							</div>
							
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - phone portrait' mod='nrtfootereditors'}</label>
								<select class="select-categories-line-xs col-lg-9">
									<option value="1"  {if isset($node.content.line_xs) && $node.content.line_xs == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_xs) && $node.content.line_xs == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_xs) && $node.content.line_xs == 3}selected{/if}>3</option>                    
								</select>
							</div>
					</div>

					<div class="column-image-wrapper content-options-wrapper">
						
						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Image source' mod='nrtfootereditors'}
							</label>	
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content.source[$language.id_lang])}{$node.content.source[$language.id_lang]}{/if}" type="text" class="i-upload-input image-source image-source-{$language.id_lang}" name="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}"  id="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" data-lang-id="{$language.id_lang}" >
									<a href="{if isset($admin_link)}{$admin_link}{/if}filemanager/dialog.php?type=1&field_id={if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" class="btn i-upload-input btn-default iframe-column-upload"  data-input-name="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" type="button">{l s='Select image' mod='nrtfootereditors'} <i class="icon-angle-right"></i></a>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Image link' mod='nrtfootereditors'}
							</label>	
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content.href[$language.id_lang])}{$node.content.href[$language.id_lang]}{/if}" type="text" class="image-href-{$language.id_lang}">
									<p class="help-block">
								{l s='Optional link. Use entire url with http:// prefix' mod='nrtfootereditors'}
							</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='New window' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-image-window">
									<option value="0"  {if isset($node.content.window) && $node.content.window== 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.window) && $node.content.window == 1}selected{/if} >Yes</option>
								</select>
								<p class="help-block">
										{l s='Open link in new window' mod='nrtfootereditors'}
									</p>
									</div>
							</div>
					</div>


					<div class="products-wrapper content-options-wrapper">
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Search product' mod='nrtfootereditors'}</label>
								<div class="col-lg-9"><input type="text" class="product-autocomplete form-control" ></div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3">{l s='Selected products' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-products-ids" multiple="multiple" style="height: 160px;">
								{if isset($node.content.ids) && $node.contentType == 4}
								{foreach from=$node.content.ids item=product}
									<option value="{$product.id_product}" >(ID: {$product.id_product}) {$product.name}</option>
								{/foreach}
								{/if}
								</select>
								<br />
								<button type="button" class="btn btn-danger remove-products-ids"><i class="icon-trash"></i> {l s='Remove selected' mod='nrtfootereditors'}</button>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='View type' mod='nrtfootereditors'}</label>
								<div class="col-lg-9"><select class="select-products-view">
									<option value="1" {if isset($node.content.view) && $node.content.view == 1}selected{/if} >{l s='Slider - info below big image ' mod='nrtfootereditors'}</option>
									<option value="disabled" disabled>{l s='------------------'}</option>
									<option value="3" {if isset($node.content.view) && $node.content.view == 3}selected{/if} >{l s='Slider - info next to small image ' mod='nrtfootereditors'}</option>
                                    <option value="disabled" disabled>{l s='------------------'}</option>
									<option value="4"  {if isset($node.content.view) && $node.content.view == 4}selected{/if}>{l s='Slider - Full ( Products per line is 1 in every screen )' mod='nrtfootereditors'}</option>								
								</select>
							</div>
							</div>
								<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Image size' mod='nrtfootereditors'}</label>
								<div class="col-lg-9"><select class="select-pimage-type">
								<option value="0" {if isset($node.content.itype) && $node.content.itype == 0}selected{/if}>{l s='Default - Recommanded' mod='nrtfootereditors'}</option>
								{foreach from=$images_formats item=format}
										<option value="{$format.name}" {if isset($node.content.itype) && $node.content.itype == $format.name}selected{/if}>{$format.name}</option>
										{/foreach}
								</select>
								<p class="help-block">
										{l s='You can adjust your image sizes to your slider. If you not shure just keep Default recommanded option' mod='nrtfootereditors'}
									</p>
							</div>
							</div>

							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per column' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-products-per-column">
									<option value="1"  {if isset($node.content.colnb) && $node.content.colnb == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.colnb) && $node.content.colnb == 2}selected{/if} >2</option>
									<option value="3"  {if isset($node.content.colnb) && $node.content.colnb == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.colnb) && $node.content.colnb == 4}selected{/if} >4</option>
									<option value="5"  {if isset($node.content.colnb) && $node.content.colnb == 5}selected{/if} >5</option>
									<option value="6"  {if isset($node.content.colnb) && $node.content.colnb == 6}selected{/if} >6</option>
									<option value="7"  {if isset($node.content.colnb) && $node.content.colnb == 7}selected{/if} >7</option>
									<option value="8"  {if isset($node.content.colnb) && $node.content.colnb == 8}selected{/if} >8</option>
									<option value="9"  {if isset($node.content.colnb) && $node.content.colnb == 9}selected{/if} >9</option>
									<option value="10" {if isset($node.content.colnb) && $node.content.colnb == 10}selected{/if} >10</option>
								</select>
								<p class="help-block">
										{l s='Affects sliders only' mod='nrtfootereditors'}
									</p>
									</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider autoplay' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-products-ap">
									<option value="0"  {if isset($node.content.ap) && $node.content.ap == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.ap) && $node.content.ap == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider arrows' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-products-ar">
									<option value="0"  {if isset($node.content.ar) && $node.content.ar == 0}selected{/if} >In middle of slider</option>
									<option value="1"  {if isset($node.content.ar) && $node.content.ar == 1}selected{/if} >Above slider(on column title)</option>
									<option value="2"  {if isset($node.content.ar) && $node.content.ar == 2}selected{/if} >Hide</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider dots' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-products-dt">
									<option value="0"  {if isset($node.content.dt) && $node.content.dt == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.dt) && $node.content.dt == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Lazy load' mod='nrtfootereditors'}</label>
								<select class="select-products-line-lg col-lg-9">
									<option value="1"  {if isset($node.content.line_lg) && $node.content.line_lg == 1}selected{/if} >Yes</option>
									<option value="0"  {if isset($node.content.line_lg) && $node.content.line_lg == 0}selected{/if}>No</option>

								</select>
							</div>
                            <div class="form-group">
								<label  class="control-label col-lg-3">{l s='Loop' mod='nrtfootereditors'}</label>
								<select class="select-products-line-ms col-lg-9">
									<option value="1"  {if isset($node.content.line_ms) && $node.content.line_ms == 1}selected{/if} >Yes</option>
									<option value="0"  {if isset($node.content.line_ms) && $node.content.line_ms == 0}selected{/if}>No</option>	
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - desktop' mod='nrtfootereditors'}</label>
								<select class="select-products-line-md col-lg-9">
									<option value="1"  {if isset($node.content.line_md) && $node.content.line_md == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_md) && $node.content.line_md == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_md) && $node.content.line_md == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.line_md) && $node.content.line_md == 4}selected{/if}>4</option>
									<option value="5"  {if isset($node.content.line_md) && $node.content.line_md == 5}selected{/if}>5</option>
									<option value="6"  {if isset($node.content.line_md) && $node.content.line_md == 6}selected{/if}>6</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - tablet' mod='nrtfootereditors'}</label>
								<select class="select-products-line-sm col-lg-9">
									<option value="1"  {if isset($node.content.line_sm) && $node.content.line_sm == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_sm) && $node.content.line_sm == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_sm) && $node.content.line_sm == 3}selected{/if}>3</option>
									<option value="4"  {if isset($node.content.line_sm) && $node.content.line_sm == 4}selected{/if}>4</option>
								</select>
							</div>
							
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - phone portrait' mod='nrtfootereditors'}</label>
								<select class="select-products-line-xs col-lg-9">
									<option value="1"  {if isset($node.content.line_xs) && $node.content.line_xs == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_xs) && $node.content.line_xs == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_xs) && $node.content.line_xs == 3}selected{/if}>3</option>          
								</select>
							</div>

							

						
					</div>

					<div class="manufacturers-wrapper content-options-wrapper">
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Select manufacturers' mod='nrtfootereditors'}</label>
                                <div class="col-lg-9">
								<select class="select-manufacturers-ids" multiple="multiple" style="height: 160px;">
								 <optgroup label="____All_____">
								<option value="0" {if isset($node.content.ids) && $node.contentType == 7 && in_array(0, $node.content.ids)}selected{/if} >{l s='Show all' mod='nrtfootereditors'}</option>
								 </optgroup>
								  <optgroup label="____Manual select_____">
									{foreach from=$manufacturers_select item=manufacturer}
										<option value="{$manufacturer.id}" {if isset($node.content.ids) && $node.contentType == 7 && in_array($manufacturer.id, $node.content.ids)}selected{/if} >{$manufacturer.name}</option>
									{/foreach}
								</optgroup>
                                </select>
								<p class="help-block">
								{l s='Do not selecta Show all manufacturers if you have large amount of' mod='nrtfootereditors'}
								</p>
                                </div>
								
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='View type' mod='nrtfootereditors'}</label>
								<div class="col-lg-9"><select class="select-manufacturers-view">
									<option value="1" {if isset($node.content.view) && $node.content.view == 1}selected{/if} >{l s='Slider' mod='nrtfootereditors'}</option>
									<option value="0"  {if isset($node.content.view) && $node.content.view == 0}selected{/if}>{l s='Grid' mod='nrtfootereditors'}</option>
								</select>
							<p class="help-block">
								{l s='You can show manufacuters in slider or in a grid view' mod='nrtfootereditors'}
							</p></div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Manufacturers per column' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-manufacturers-per-column">
									<option value="1"  {if isset($node.content.colnb) && $node.content.colnb == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.colnb) && $node.content.colnb == 2}selected{/if} >2</option>
									<option value="3"  {if isset($node.content.colnb) && $node.content.colnb == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.colnb) && $node.content.colnb == 4}selected{/if} >4</option>
									<option value="5"  {if isset($node.content.colnb) && $node.content.colnb == 5}selected{/if} >5</option>
								</select>
								<p class="help-block">
										{l s='Affects sliders only' mod='nrtfootereditors'}
									</p>
									</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider autoplay' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-manufacturers-ap">
									<option value="0"  {if isset($node.content.ap) && $node.content.ap == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.ap) && $node.content.ap == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider arrows' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-manufacturers-ar">
									<option value="0"  {if isset($node.content.ar) && $node.content.ar == 0}selected{/if} >In middle of slider</option>
									<option value="1"  {if isset($node.content.ar) && $node.content.ar == 1}selected{/if} >Above slider(on column title)</option>
									<option value="2"  {if isset($node.content.ar) && $node.content.ar == 2}selected{/if} >Hide</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider dots' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-manufacturers-dt">
									<option value="0"  {if isset($node.content.dt) && $node.content.dt == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.dt) && $node.content.dt == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Lazy load' mod='nrtfootereditors'}</label>
								<select class="select-manufacturers-line-lg col-lg-9">
									<option value="1"  {if isset($node.content.line_lg) && $node.content.line_lg == 1}selected{/if} >Yes</option>
									<option value="0"  {if isset($node.content.line_lg) && $node.content.line_lg == 0}selected{/if}>No</option>
								</select>
							</div>
                            <div class="form-group">
								<label  class="control-label col-lg-3">{l s='Loop' mod='nrtfootereditors'}</label>
								<select class="select-manufacturers-line-ms col-lg-9">
									<option value="1"  {if isset($node.content.line_ms) && $node.content.line_ms == 1}selected{/if} >Yes</option>
									<option value="0"  {if isset($node.content.line_ms) && $node.content.line_ms == 0}selected{/if}>No</option>									
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Brands per line - desktop' mod='nrtfootereditors'}</label>
								<select class="select-manufacturers-line-md col-lg-9">
									<option value="1"  {if isset($node.content.line_md) && $node.content.line_md == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_md) && $node.content.line_md == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_md) && $node.content.line_md == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.line_md) && $node.content.line_md == 4}selected{/if}>4</option>
									<option value="5"  {if isset($node.content.line_md) && $node.content.line_md == 5}selected{/if}>5</option>
									<option value="6"  {if isset($node.content.line_md) && $node.content.line_md == 6}selected{/if}>6</option>

								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Brands per line - tablet' mod='nrtfootereditors'}</label>
								<select class="select-manufacturers-line-sm col-lg-9">
									<option value="1"  {if isset($node.content.line_sm) && $node.content.line_sm == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_sm) && $node.content.line_sm == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_sm) && $node.content.line_sm == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.line_sm) && $node.content.line_sm == 4}selected{/if}>4</option>
									<option value="5"  {if isset($node.content.line_sm) && $node.content.line_sm == 5}selected{/if}>5</option>
									<option value="6"  {if isset($node.content.line_sm) && $node.content.line_sm == 6}selected{/if}>6</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Brands per line - phone portrait' mod='nrtfootereditors'}</label>
								<select class="select-manufacturers-line-xs col-lg-9">
									<option value="1"  {if isset($node.content.line_xs) && $node.content.line_xs == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.line_xs) && $node.content.line_xs == 2}selected{/if}>2</option>
									<option value="3"  {if isset($node.content.line_xs) && $node.content.line_xs == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.line_xs) && $node.content.line_xs == 4}selected{/if}>4</option>
								</select>
							</div>
					</div>
<div class="customhook-wrapper content-options-wrapper">
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Custom hook name' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<input value="{if isset($node.content.hook)}{$node.content.hook}{else}customhook{/if}" type="text" class="custom-hook-name">
								<p class="help-block">
								{l s='You can use this custom hook later in modules, for example in Megamenu.' mod='nrtfootereditors'}
								</p>
								</div>
						</div>
						</div>	
					<div class="moduleinclude-wrapper content-options-wrapper">
						<div class="alert alert-info col-lg-9 col-lg-offset-3">{l s='This function is only for advanced users, and issues related to this will be not supported. It maybe needed to clear Prestashop Cache if you do some changes in included module if they will be not visible.' mod='nrtfootereditors'}</div>
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Module to show' mod='nrtfootereditors'}</label>
								<select class="select-module col-lg-9">
										<option value="" >{l s='- Select module -' mod='nrtfootereditors'}</option>
									{foreach from=$available_modules item=module}
										<option value="{$module.name}" data-hooks="{$module.hooks}"{if isset($node.content.id_module) && $node.contentType == 9 && $node.content.id_module == $module.name}selected{/if} >{$module.name}</option>
									{/foreach}
								</select>
						</div>

						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Show module using hook' mod='nrtfootereditors'}</label>
								<div class="col-lg-9">
								<select class="select-module-hook ">
								{if isset($node.content.id_module) && $node.contentType == 9}
								{assign var="hooks" value=","|explode:$available_modules[$node.content.id_module].hooks}
								{foreach from=$hooks item=hook}
								<option value="{$hook}" {if isset($node.content.id_module) && $node.contentType == 9 && $node.content.hook == $hook}selected{/if} >{$hook}</option>
								{/foreach}
								{/if}
								</select>
								</div>
						</div>
					</div>	
					</div>
					<div class="modal-footer">
                        <button type="reset" class="btn btn-primary">{l s='reset' mod='nrtfootereditors'}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{l s='Save' mod='nrtfootereditors'}</button>
					</div>
				</div>
			</div>
		</div>
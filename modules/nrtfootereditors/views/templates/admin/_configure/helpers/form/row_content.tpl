	<div class="menu-row-content">
		<div class="modal fade row-settings-modal" tabindex="-1" role="dialog" aria-labelledby="rowSettings" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
                    <div class="modal-header">
        				<h4 class="modal-title">{l s='Row Setting' mod='nrtfootereditors'}</h4>
      				</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-lg-3">{l s='Row in' mod='nrtfootereditors'}</label>
							<div class="col-lg-9">
                                <select class="select-row-bgw">    
                                    <option value="0" {if isset($node.row_s.bgw) && $node.row_s.bgw==0}selected{/if}>{l s='Full width' mod='nrtfootereditors'}</option>                  
                                    <option value="1" {if isset($node.row_s.bgw) && $node.row_s.bgw==1}selected{/if}>{l s='Container' mod='nrtfootereditors'}</option>
                                </select>
                        	</div>
                        </div>
					<div class="form-group">
							<label class="control-label col-lg-3">{l s='Content row in' mod='nrtfootereditors'}</label>
							<div class="col-lg-9">
							<select class="select-row-bgh">
								<option value="0" {if isset($node.row_s.bgh) && $node.row_s.bgh==0}selected{/if}>{l s='Full width' mod='nrtfootereditors'}</option>
								<option value="1" {if isset($node.row_s.bgh) && $node.row_s.bgh==1}selected{/if}>{l s='Container' mod='nrtfootereditors'}</option>
							</select>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">{l s='Custom Class' mod='nrtfootereditors'}</label>
                        <div class="col-lg-9">
                        <input class="select-row-prlx" {if isset($node.row_s.prlx) && $node.row_s.prlx} value="{$node.row_s.prlx}"{/if} type="text" />
                    </div>
                    </div>	

                    <div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Background color' mod='nrtfootereditors'}
							</label>
							<div class="col-lg-9">
								<div class="row">
									<div class="input-group">
										<input type="text"  class="spectrumcolor  row-bgc {if isset($node.elementId)}row-bgc-{$node.elementId}{/if}"  name="row-bgc" value="{if isset($node.row_s.bgc)}{$node.row_s.bgc}{/if}" />
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Background image' mod='nrtfootereditors'}
							</label>
							<div class="col-lg-9">
									<input value="{if isset($node.row_s.bgi)}{$node.row_s.bgi}{/if}" type="text" class="row-bgi i-upload-input" name="{if isset($node.elementId)}{$node.elementId}-{/if}row-bgi"  id="{if isset($node.elementId)}{$node.elementId}-{/if}row-bgi" >
									<a href="{if isset($admin_link)}{$admin_link}{/if}filemanager/dialog.php?type=1&field_id={if isset($node.elementId)}{$node.elementId}-{/if}row-bgi" class="btn btn-default iframe-column-upload i-upload-input"  data-input-name="{if isset($node.elementId)}{$node.elementId}-{/if}row-bgi" type="button">{l s='Select image' mod='nrtfootereditors'} <i class="icon-angle-right"></i></a>
						</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">{l s='Background image repeat' mod='nrtfootereditors'}</label>
							<select class="select-row-bgr col-lg-9">
								<option value="3" {if isset($node.row_s.bgr) && $node.row_s.bgr==3}selected{/if}>{l s='Repeat XY' mod='nrtfootereditors'}</option>
								<option value="2" {if isset($node.row_s.bgr) && $node.row_s.bgr==2}selected{/if}>{l s='Repeat X' mod='nrtfootereditors'}</option>
								<option value="1" {if isset($node.row_s.bgr) && $node.row_s.bgr==1}selected{/if}>{l s='Repeat Y' mod='nrtfootereditors'}</option>
								<option value="0" {if isset($node.row_s.bgr) && $node.row_s.bgr==0}selected{/if} >{l s='No repeat' mod='nrtfootereditors'}</option>

							</select></div>
					</div>
					<div class="modal-footer">
                    	<button type="reset" class="btn btn-primary">{l s='reset' mod='nrtfootereditors'}</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal">{l s='Save' mod='nrtfootereditors'}</button>
					</div>
				</div>	
			</div>
		</div>
	</div>	
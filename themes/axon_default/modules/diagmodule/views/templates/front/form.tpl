{extends file=$layout}
{block name='content'}
<section id="content" class="page-content page-cms">
	<form action="" method="post" enctype="multipart/form-data">
		{if isset($errors)}
            {include file='_partials/form-errors.tpl' errors=$errors}
        {/if}
		<div class="block_form" id="customer">
			<div class="col-md-12">
				<label class="title" for="lastname">Bénéficiaire</label>
			</div>
			<div class="col-md-12">
				<div class="col-md-6" style="padding: 0 10px 0 0;">
					<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Nom" type="text" name="last-name" />
				</div>
				<div class="col-md-6" style="padding: 0;">
					<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Prénom" type="text" name="firstname" />
				</div>
			</div>
			<div class="col-md-12">
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Téléphone" type="tel" name="phone-number" />
				</div>
				<div class="col-md-9" style="padding: 0;">
					<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="votre@email.com" type="email" name="email" />
				</div>
			</div>
			<div class="col-md-12">
				<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="N° rue" type="text" name="address" />
			</div>
			<div class="col-md-12">
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<input name="zip" type="text" class="form-control" placeholder="Code Postal" />
				</div>
				<div class="col-md-9" style="padding: 0;">
					<input name="city" type="text" class="form-control" placeholder="Commune" />
				</div>
			</div>
		</div>
		<div class="block_form" id="installation">
			<div class="col-md-12">
				<label class="title">Installation</label>
			</div>
			<div class="col-md-12" id="whole_house">
				<h2>Après Compteur</h2>
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<label for="Tubing" class="subtitle">Matériau</label>
					<span class="wpcf7-form-control-wrap">
						<select class="wpcf7-form-control wpcf7-select form-control" id="tubing_mat" name="Tubing" onchange="Choix(this.form)">
							<option>--- Matériau de la canalisation (après-compteur) ---</option>
							<option value="Cuivre">Cuivre</option>
							<option value="Galva">Galva</option>
							<option value="MultiCouche">MultiCouche</option>
							<option value="PE">PolyEthylène</option>
							<option value="PER">PolyEthylène Réticulé</option>
							<option value="PVCu">PVC pression</option>
						</select>
						<span class="select_arrow"></span>
					</span>
				</div>
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<label for="Diameter" class="subtitle">Diamètre</label>
					<span class="wpcf7-form-control-wrap">
						<select class="wpcf7-form-control wpcf7-select form-control" id="tubing_diam" name="Diameter">
							<option></option>
						</select>
						<span class="select_arrow"></span>
					</span>
				</div>
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<label for="Thread_gender" class="subtitle">Pas de vis</label>
					<span class="wpcf7-form-control-wrap">
						<select class="wpcf7-form-control wpcf7-select form-control" name="Thread_gender" id="thread_gender">
							<option></option>
							<option value="M">Mâle</option>
							<option value="F">Femelle</option>
						</select>
						<span class="select_arrow"></span>
					</span>
				</div>
				<div class="col-md-3" style="padding: 0;">
					<label for="Thread_size" class="subtitle">Filetage</label>
					<span class="wpcf7-form-control-wrap">
						<select class="wpcf7-form-control wpcf7-select form-control" name="Thread_size" id="thread_size">
							<option></option>
							<option value="1/2&quot;">1/2"</option>
							<option value="3/4&quot;">3/4"</option>
							<option value="1/&quot;">1"</option>
							<option value="1&quot;1/4">1"1/4</option>
							<option value="1&quot;1/2">1"1/2</option>
						</select>
						<span class="select_arrow"></span>
					</span>
				</div>
				<div class="col-md-6" style="padding: 0 10px 0 0; margin-top:10px">
					<textarea type="text" style="height: 54px" class="wpcf7-form-control wpcf7-validates-as-required form-control" id="details_house" name="DetailsHouse" placeholder="Précisions"></textarea>
				</div>
				<div class="col-md-6" style="padding: 0; margin-top:10px">
					<label for="House-Upload" class="subtitle">Photo après compteur</label>
					<div class="bootstrap-filestyle input-group">
						<span class="wpcf7-form-control-wrap text-upload">
							<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" id="house-upload" name="House-Upload" />
						</span> 
						<span class="group-span-filestyle input-group-btn"> 
							<label for="file-sink" class="btn btn-default btn_upload"> 
								<span class="icon-span-filestyle fa fa-camera"></span>
								<span class="buttonText">Pièce Jointe</span>
							</label> 
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-12" id="sink">
				<h2>Sous Evier</h2>
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<label for="Tubing" class="subtitle">Matériau</label> 
					<span class="wpcf7-form-control-wrap">
						<select class="wpcf7-form-control wpcf7-select form-control" id="tubing_mat_sink" name="Tubing_sink" onchange="Change(this.form)">
							<option>--- Matériau de la canalisation ---</option>
							<option value="Cuivre">Cuivre</option>
							<option value="Galva">Galva</option>
							<option value="MultiCouche">MultiCouche</option>
							<option value="PER">PolyEthylène Réticulé</option>
						</select>
						<span class="select_arrow"></span>
					</span>
				</div>
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<label for="Diameter" class="subtitle">Diamètre</label> 
					<span class="wpcf7-form-control-wrap">
						<select class="wpcf7-form-control wpcf7-select form-control" id="tubing_diam_sink" name="Diameter_sink">
							<option></option>
						</select>
						<span class="select_arrow"></span> 
					</span>
				</div>
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<label for="Thread_gender" class="subtitle">Pas de vis</label>
					<span class="wpcf7-form-control-wrap">
						<select class="wpcf7-form-control wpcf7-select form-control" name="Thread_gender_sink" id="thread_gender_sink">
							<option></option>
							<option value="M">Mâle</option>
							<option value="F">Femelle</option>
						</select>
						<span class="select_arrow"></span>
					</span>
				</div>
				<div class="col-md-3" style="padding: 0;">
					<label for="Thread_size" class="subtitle">Filetage</label>
					<span class="wpcf7-form-control-wrap">
						<select class="wpcf7-form-control wpcf7-select form-control" name="Thread_size_sink" id="thread_size_sink">
							<option></option>
							<option value="3/8&quot;">3/8"</option>
							<option value="1/2&quot;">1/2"</option>
						</select>
						<span class="select_arrow"></span> 
					</span>
				</div>
				<div class="col-md-6" style="padding: 0 10px 0 0; margin-top:10px">
					<textarea style="height: 54px" type="text" class="wpcf7-form-control wpcf7-validates-as-required form-control" id="details_sink" name="DetailsSink" placeholder="Précisions"></textarea>
				</div>
				<div class="col-md-6" style="padding: 0; margin-top:10px">
					<label for="Sink-Upload" class="subtitle">Photo sous l'évier</label>
					<div class="bootstrap-filestyle input-group">
						<span class="wpcf7-form-control-wrap text-upload">
							<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" id="sink-upload" name="Sink-Upload" />
						</span> 
						<span class="group-span-filestyle input-group-btn"> 
							<label for="file-sink" class="btn btn-default btn_upload"> 
								<span class="icon-span-filestyle fa fa-camera"></span>
								<span class="buttonText">Pièce Jointe</span>
							</label> 
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-12" id="POU">
				<h2>Points d'Eau</h2>
				<div class="col-md-3" style="padding: 0;">
					<label class="subtitle">WC</label>
					<div class="col-md-12 WC_Form formList">
						<div class="col-xs-3" style="padding: 0;">
							<input style="width: 100%;" class="form-control" name="Qty_WC_" id="qty_wc_" type="number" />
						</div>
						<div class="col-md-9 next-label">
							<span class="wpcf7-form-control-wrap list-small">
								<select class="wpcf7-form-control form-control wpcf7-select" name="WC" id="wc">
									<option>-- type de WC --</option>
									<option value="WC_pose">WC posé</option>
									<option value="WC_suspendu">Wc suspendu</option>
								</select>
								<span class="select_arrow"></span> 
							</span>
						</div>
						<div class="col-md-12" style="padding: 0; margin: 10px 0 0 0;">
							<div class="bootstrap-filestyle input-group">
								<span class="wpcf7-form-control-wrap text-upload">
									<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" id="wc-upload" name="WC-Upload" />
								</span> 
								<span class="group-span-filestyle input-group-btn"> 
									<label for="file-wc" class="btn btn-default btn_upload"> 
										<span class="icon-span-filestyle fa fa-upload"></span>
										<span class="buttonText">Pièce Jointe</span>
									</label> 
								</span>
							</div>
							<span class="wpcf7-form-control-wrap fileUpload">
								<span class="custom_choosefile"> 
									<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" id="file-wc" name="File-WC" />
									<span class="button_choosefile">Pièce Jointe</span>
								</span>
							</span>
						</div>
					</div>
					<div class="col-md-6" style="padding-left: 0; margin-bottom: 0;">
						<input type="button" id="Add_WC" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="WC_Form" data-alert="Il n'y a que 2 options de WC possible !" data-limit="2" />
					</div>
				</div>
				<div class="col-md-3" style="padding: 0;">
					<label class="subtitle">Douche</label>
					<div class="col-md-12 Shower_Form formList">
						<div class="col-xs-3" style="padding: 0;">
							<input style="width: 100%;" class="form-control" name="Qty_Shower_" id="qty_shower_" type="number" />
						</div>
						<div class="col-md-9 next-label">
							<span class="wpcf7-form-control-wrap list-small">
								<select class="wpcf7-form-control form-control wpcf7-select" name="Shower" id="shower">
									<option>-- type de douche --</option>
									<option value="Shower_1">Douche à pommeau (mobile)</option>
									<option value="Shower_2">Douche encastrée</option>
								</select>
								<span class="select_arrow"></span> 
							</span>
						</div>
						<div class="col-md-12" style="padding: 0; margin: 10px 0 0 0;">
							<div class="bootstrap-filestyle input-group">
								<span class="wpcf7-form-control-wrap text-upload"> 
									<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" id="shower-upload" name="Shower-Upload" /> 
								</span> 
								<span class="group-span-filestyle input-group-btn"> 
									<label for="file-shower" class="btn btn-default btn_upload"> 
										<span class="icon-span-filestyle fa fa-upload"></span> 
										<span class="buttonText">Pièce Jointe</span> 
									</label> 
								</span>
							</div>
							<span class="wpcf7-form-control-wrap fileUpload"> 
								<span class="custom_choosefile"> 
									<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" id="file-shower" name="File-Shower" /> 
									<span class="button_choosefile">Pièce Jointe</span> 
								</span> 
							</span>
						</div>
					</div>
					<div class="col-md-6" style="padding-left: 0; margin-bottom: 0;">
						<input type="button" id="Add_Shower" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Shower_Form" data-alert="Il n'y a que 2 options de douche possible" data-limit="2" />
					</div>
				</div>
				<div class="col-md-3" style="padding: 0;">
					<label class="subtitle">Baignoire</label>
					<div class="col-md-12 Bath_Form formList">
						<div class="col-xs-3" style="padding: 0;">
							<input style="width: 100%;" class="form-control" name="Qty_Bath_" id="qty_bath_" type="number" />
						</div>
						<div class="col-md-9 next-label">Baignoire(s)</div>
						<div class="col-md-12" style="padding: 0; margin: 10px 0 0 0;">
							<div class="bootstrap-filestyle input-group">
								<span class="wpcf7-form-control-wrap text-upload">
									<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" id="bath-upload" name="Bath-Upload" /> 
								</span> 
								<span class="group-span-filestyle input-group-btn"> 
									<label for="file-bath" class="btn btn-default btn_upload"> 
										<span class="icon-span-filestyle fa fa-upload"></span> 
										<span class="buttonText">Pièce Jointe</span> 
									</label> 
								</span>
							</div>
							<span class="wpcf7-form-control-wrap fileUpload"> 
								<span class="custom_choosefile"> 
									<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" id="file-bath" name="File-Bath" /> 
									<span class="button_choosefile">Pièce Jointe</span> 
								</span> 
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-3" style="padding: 0;"><label class="subtitle">Lavabos</label>
					<div class="col-md-12 Sink_Form formList">
						<div class="col-xs-3" style="padding: 0;">
							<input style="width: 100%;" class="form-control" name="Qty_Sink_" id="qty_sink_" type="number" />
						</div>
						<div class="col-md-9 next-label">
							<span class="wpcf7-form-control-wrap list-small">
								<select class="wpcf7-form-control form-control wpcf7-select" name="Sink" id="sink">
									<option>-- type de poste --</option>
									<option value="Mixing_Tap">Mitigeur(s)</option>
									<option value="Single_Tap">Robinet(s) F + C</option>
								</select>
								<span class="select_arrow"></span> 
							</span>
						</div>
						<div class="col-md-12" style="padding: 0; margin: 10px 0 0 0;">
							<div class="bootstrap-filestyle input-group">
								<span class="wpcf7-form-control-wrap text-upload">
									<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" id="sink-upload" name="Sink-Upload" />
								</span> 
								<span class="group-span-filestyle input-group-btn"> 
									<label for="file-sink" class="btn btn-default btn_upload"> 
										<span class="icon-span-filestyle fa fa-upload"></span>
										<span class="buttonText">Pièce Jointe</span>
									</label>
								</span>
							</div>
							<span class="wpcf7-form-control-wrap fileUpload"> 
								<span class="custom_choosefile">
									<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" id="sink-bath" name="Sink-Bath" />
									<span class="button_choosefile">Pièce Jointe</span>
								</span>
							</span>
						</div>
					</div>
						<div class="col-md-6" style="padding-left: 0; margin-bottom: 0;">
							<input type="button" id="Add_Sink" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Sink_Form" data-alert="Il n'y a que 2 type de poste disponible" data-limit="2" />
						</div>
					</div>
				</div>
			<div class="col-md-12" id="Alternatives">
				<h2>Ressources Alternatives</h2>
					<div class="col-xs-4" style="padding-left: 0;">
						<label class="on_off-label">Puits </label>
						<input class="on_off-checkox" type="checkbox" id="check_puits" name="Puits" onclick="LockUnlockElements('about-puits', 'check_puits')" /> 
						<label for="check_puits"> 
							<span class="ui"></span> 
						</label>
						<div class="col-xs-12" id="about-puits" style="display: none; padding: 10px 0 0 0;">
							<div class="col-xs-6" style="padding: 0;">
								<input type="text" name="Text-Puits" class="form-control" placeholder="Précisons sur le puits" id="text-puits" />
							</div>
							<div class="col-xs-6" style="padding-right: 0;">
								<div class="bootstrap-filestyle input-group">
									<span class="wpcf7-form-control-wrap text-upload"> 
										<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" id="puits-upload" name="Puits-Upload" /> 
									</span> 
									<span class="group-span-filestyle input-group-btn"> 
										<label for="file-puits" class="btn btn-default btn_upload"> 
											<span class="icon-span-filestyle fa fa-upload"></span> 
											<span class="buttonText">Pièce Jointe</span> 
										</label> 
									</span>
								</div>
								<span class="wpcf7-form-control-wrap fileUpload"> 
									<span class="custom_choosefile"> 
										<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" id="file-puits" name="File-Puits" /> 
										<span class="button_choosefile">Pièce Jointe</span> 
									</span> 
								</span>
							</div>
						</div>
					</div>
					<div class="col-xs-4" style="padding-left: 0;">
						<label class="on_off-label">Forage </label>
						<input class="on_off-checkox" type="checkbox" id="check_forage" name="Forage" onclick="LockUnlockElements('about-forage', 'check_forage')" /> 
						<label for="check_forage"> 
							<span class="ui"></span> 
						</label>
						<div class="col-xs-12" id="about-forage" style="display: none; padding: 10px 0 0 0;">
							<div class="col-xs-6" style="padding: 0;">
								<input type="text" name="Text-Forage" class="form-control" placeholder="Précisons sur le forage" id="text-forage" />
							</div>
							<div class="col-xs-6" style="padding-right: 0;">
								<div class="bootstrap-filestyle input-group">
									<span class="wpcf7-form-control-wrap text-upload"> 
										<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" name="Forage-Upload" id="forage-upload" /> 
									</span> 
									<span class="group-span-filestyle input-group-btn"> 
										<label for="file-forage" class="btn btn-default btn_upload"> 
											<span class="icon-span-filestyle fa fa-upload"></span> 
											<span class="buttonText">Pièce Jointe</span> 
										</label> 
									</span>
								</div>
								<span class="wpcf7-form-control-wrap fileUpload"> 
									<span class="custom_choosefile"> 
										<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" id="file-forage" name="File-Forage" /> 
										<span class="button_choosefile">Pièce Jointe</span> 
									</span> 
								</span>
							</div>
						</div>
					</div>
					<div class="col-xs-4" style="padding: 0;">
						<label class="on_off-label">Resurgences </label> 
						<input class="on_off-checkox" type="checkbox" id="check_resurg" name="Resurgences" onclick="LockUnlockElements('about-resurg', 'check_resurg')" /> 
						<label for="check_resurg"> 
							<span class="ui"></span> 
						</label>
						<div class="col-xs-12" id="about-resurg" style="display: none; padding: 10px 0 0 0;">
							<div class="col-xs-6" style="padding: 0;">
								<input type="text" name="Text-Resurg" class="form-control" placeholder="Précisons sur la source resurgente" id="text-resurg" />
							</div>
							<div class="col-xs-6" style="padding-right: 0;">
								<div class="bootstrap-filestyle input-group">
									<span class="wpcf7-form-control-wrap text-upload"> 
										<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" name="Resurg-Upload" id="resurg-upload" /> 
									</span> 
									<span class="group-span-filestyle input-group-btn"> 
										<label for="file-resurg" class="btn btn-default btn_upload"> 
											<span class="icon-span-filestyle fa fa-upload"></span> 
											<span class="buttonText">Pièce Jointe</span> 
										</label> 
									</span>
								</div>
								<span class="wpcf7-form-control-wrap fileUpload"> 
									<span class="custom_choosefile"> 
										<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" id="file-resurg" name="File-Resurg" /> 
										<span class="button_choosefile">Pièce Jointe</span> 
									</span> 
								</span>
							</div>
						</div>
					</div>
				</div>
		</div>
		<div class="block_form" id="consomation">
			<div class="col-md-12">
				<label class="title">Consommation</label>
			</div>
			<div class="col-md-12" id="Volume">
				<h2>Eau Potable</h2>
				<div class="col-md-3" style="padding: 0 10px 0 0;">
					<div class="col-xs-3" style="padding: 0;">
						<input class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="L./an" type="number" name="Volume_an" />
					</div>
					<div class="col-xs-9 next-label">L./an</div>
				</div>
				<div class="col-md-9" id="upload_water_volume" style="padding: 0;">
					<div class="bootstrap-filestyle input-group">
						<span class="wpcf7-form-control-wrap text-upload"> 
							<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" id="volume-upload" name="Volume-Upload" /> 
						</span> 
						<span class="group-span-filestyle input-group-btn"> 
							<label for="file-volume" class="btn btn-default btn_upload"> 
								<span class="icon-span-filestyle fa fa-upload"></span> 
								<span class="buttonText">Joindre le relevé</span> 
							</label> 
						</span>
					</div>
					<span class="wpcf7-form-control-wrap fileUpload"> 
						<span class="custom_choosefile"> 
							<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" name="File-Volume" id="file-volume" /> 
							<span class="button_choosefile">Joindre le relevé</span> 
						</span> 
					</span>
				</div>
			</div>
			<div class="col-md-12" id="Family">
				<h2>Composition du Foyer</h2>
				<div class="col-md-3">
					<div class="col-xs-3" style="padding: 0;">
						<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Nb" type="number" name="Adultes" />	
					</div>
					<div class="col-xs-9 next-label">Adulte(s)</div>
				</div>
				<div class="col-md-3">
					<div class="col-xs-3" style="padding: 0;">
						<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Nb" type="number" name="Teenagers" />	
					</div>
					<div class="col-xs-9 next-label">Adolescent(s) (12-18ans)</div>
				</div>
				<div class="col-md-3">
				<div class="col-xs-3" style="padding: 0;">
					<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Nb" type="number" name="Children" />
				</div>
				<div class="col-xs-9 next-label">Enfant(s) (5-12ans)</div>
			</div>
			<div class="col-md-3">
				<div class="col-xs-3" style="padding: 0;">
					<input class="wpcf7-form-control wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Nb" type="number" name="Babys" />
				</div>
				<div class="col-xs-9 next-label">Enfant(s) (0-5ans)</div>
			</div>
		</div>
			<div class="col-md-12 desk_resp" style="margin-bottom: 0;">
				<h2>Eaux en bouteilles</h2>
				<div class="col-md-6" style="padding: 0;">
					<label class="on_off-label">Eau Plate </label> 
					<input class="on_off-checkox" type="checkbox" id="check_bottle_water" name="Bottle_Water" onclick="LockUnlockElements('bottle_water', 'check_bottle_water')" /> 
					<label for="check_bottle_water"> 
						<span class="ui"></span> 
					</label>
				</div>
				<div class="col-md-6" style="padding: 0;">
					<label class="on_off-label">Eau Pétillante</label> 
					<input class="on_off-checkox" type="checkbox" id="check_sparkling_water" name="Sparkling_Water" onclick="LockUnlockElements('sparkling_water', 'check_sparkling_water')" /> 
					<label for="check_sparkling_water"> 
						<span class="ui"></span> 
					</label>
				</div>
			</div>
			<div class="col-md-12 desk_resp" id="Bottles">
				<div class="col-md-6" style="padding: 0;">
					<div class="appear-box" id="bottle_water">
						<label>Bouteille d'Eau Plate</label> 
						<!-- Original 1 -->
						<div class="col-md-12 formList Water_Form" id="Water_Form">
							<div class="col-md-6" style="padding: 0 10px 0 0;">
								<div class="col-md-3" style="padding: 0;">
									<input style="width: 100%;" class="form-control" name="Qty_Bottle_" type="text" id="qty_bottle_" />	
								</div>
								<div class="col-md-9 next-label">L/semaine de</div>
							</div>
							<div class="col-md-6" style="padding: 0;">
								<span class="wpcf7-form-control-wrap list-small brand_bottle">
									<select class="wpcf7-form-control form-control wpcf7-select" name="Brand_Bottle_" id="brand_bottle_">
										<option value="Evian">Evian</option>
										<option value="Cristalline">Cristalline</option>
										<option value="Volvic">Volvic</option>
										<option value="Vittel">Vittel</option>
										<option value="Hepard">Hepard</option>
										<option value="Contrex">Contrex</option>
										<option value="Montroucoult">Montroucoult</option>
									</select>
									<span class="select_arrow"></span> 
								</span>
							</div>
						</div>
						<!-- END : Original 1 -->
						<div class="col-md-6" style="padding-left: 0; margin-bottom: 0;">
							<input type="button" id="Add_Water" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Water_Form" data-alert="Le nombre de Bouteilles est limité à 5" data-limit="5" />
						</div>
					</div>
				</div>
				<div class="col-md-6" style="padding: 0;">
					<div class="appear-box" id="sparkling_water">
						<label>Bouteille d'Eau Pétillante</label> 
						<!-- Original 2 -->
						<div class="col-md-12 formList Sparkling_Form" id="Sparkling_Form">
							<div class="col-md-6" style="padding: 0 10px 0 0;">
								<div class="col-md-3" style="padding: 0;">
									<input style="width: 100%;" class="form-control" name="Qty_Sparkling_" id="qty_sparkling_" type="text" />
								</div>
								<div class="col-md-9 next-label">L/semaine de</div>
							</div>
							<div class="col-md-6" style="padding: 0;">
								<span class="wpcf7-form-control-wrap list-small brand_bottle">
									<select class="wpcf7-form-control form-control wpcf7-select" name="Brand_Sparkling_" id="brand_sparkling_">
										<option value="Evian">Evian</option>
										<option value="Cristalline">Cristalline</option>
										<option value="Volvic">Volvic</option>
										<option value="Vittel">VittelHepard</option>
										<option value="Contrex">Contrex</option>
										<option value="Montroucoult">Montroucoult</option>
									</select>
									<span class="select_arrow"></span> 
								</span>
							</div>
						</div>
						<!-- END : Original 2 -->
						<div class="col-md-6" style="padding-left: 0;">
							<input type="button" id="Add_Sparkling" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Sparkling_Form" data-alert="Le nombre de Bouteilles est limité à 5" data-limit="5" />
						</div>
					</div>
				</div>
			</div>						
			<div class="col-md-12 mobile_resp" style="margin-bottom: 0;">
				<h2>Eaux en bouteilles</h2>
				<div class="col-md-12" style="padding: 0;">
					<label class="on_off-label">Eau Plate </label> 
					<input class="on_off-checkox" type="checkbox" id="check_bottle_water_mobile" name="Bottle_Water_mobile" onclick="LockUnlockElements('bottle_water_mobile', 'check_bottle_water_mobile')" /> 
					<label for="check_bottle_water_mobile"> 
						<span class="ui"></span> 
					</label>
				</div>
				<div class="col-md-6" style="padding: 0;">
					<div class="appear-box" id="bottle_water_mobile">
						<label>Bouteille d'Eau Plate</label> 
						<!-- Original 1 -->
						<div class="col-md-12 formList Water_Form_mobile" id="Water_Form_mobile">
							<div class="col-md-6" style="padding: 0 10px 0 0;">
								<div class="col-md-3" style="padding: 0;">
									<input style="width: 100%;" class="form-control" name="Qty_Bottle_mobile_" type="text" id="qty_bottle_mobile_" />
								</div>
								<div class="col-md-9 next-label">L/semaine de</div>
							</div>
							<div class="col-md-6" style="padding: 0;">
								<span class="wpcf7-form-control-wrap list-small brand_bottle_mobile">
									<select class="wpcf7-form-control form-control wpcf7-select" name="Brand_Bottle_mobile_" id="Brand_Bottle_mobile_">
										<option value="Evian">Evian</option>
										<option value="Cristalline">Cristalline</option>
										<option value="Volvic">Volvic</option>
										<option value="Vittel">Vittel</option>
										<option value="Hepard">Hepard</option>
										<option value="Contrex">Contrex</option>
										<option value="Montroucoult">Montroucoult</option>
									</select>
									<span class="select_arrow"></span> 
								</span>
							</div>
						</div>
						<!-- END : Original 1 -->
						<div class="col-md-6" style="padding-left: 0; margin-bottom: 0;"><input type="button" id="Add_Water_mobile" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Water_Form_mobile" data-alert="Le nombre de Bouteilles est limité à 5" data-limit="5" /></div>
					</div>
				</div>
			</div>
			<div class="col-md-12 mobile_resp" id="Bottles_mobile">
				<div class="col-md-12" style="padding: 0;">
					<label class="on_off-label">Eau Pétillante</label> 
					<input class="on_off-checkox" type="checkbox" id="check_sparkling_water_mobile" name="Sparkling_Water" onclick="LockUnlockElements('sparkling_water_mobile', 'check_sparkling_water_mobile')" /> <label for="check_sparkling_water_mobile"> 
						<span class="ui"></span> 
					</label>
				</div>
				<div class="col-md-6" style="padding: 0;">
					<div class="appear-box" id="sparkling_water_mobile">
						<label>Bouteille d'Eau Pétillante</label> 
						<!-- Original 2 -->
						<div class="col-md-12 formList Sparkling_Form_mobile" id="Sparkling_Form_mobile">
							<div class="col-md-6" style="padding: 0 10px 0 0;">
								<div class="col-md-3" style="padding: 0;">
									<input style="width: 100%;" class="form-control" name="Qty_Sparkling_mobile_" id="qty_sparkling_mobile_" type="text" />
								</div>
								<div class="col-md-9 next-label">L/semaine de</div>
							</div>
						<div class="col-md-6" style="padding: 0;">
							<span class="wpcf7-form-control-wrap list-small brand_bottle_mobile">
								<select class="wpcf7-form-control form-control wpcf7-select" name="Brand_Sparkling_mobile_" id="Brand_Sparkling_mobile_">
									<option value="Evian">Evian</option>
									<option value="Cristalline">Cristalline</option>
									<option value="Volvic">Volvic</option>
									<option value="Vittel">VittelHepard</option>
									<option value="Contrex">Contrex</option>
									<option value="Montroucoult">Montroucoult</option>
								</select>
								<span class="select_arrow"></span> 
							</span>
						</div>
					</div>
					<!-- END : Original 2 -->
					<div class="col-md-6" style="padding-left: 0;">
						<input type="button" id="Add_Sparkling_mobile" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Sparkling_Form_mobile" data-alert="Le nombre de Bouteilles est limité à 5" data-limit="5" />
					</div>
				</div>
			</div>
		</div>
			<div class="col-md-12" id="Energy">
				<h2>Besoin Energétique</h2>
				<div class="col-md-12" style="padding: 0;">
					<label class="subtitle">Chauffe-eau</label>
				</div>
				<div class="col-md-12 Boiler_Form" style="padding: 0;">
					<div class="col-md-6" style="padding: 0 10px 0 0;">
						<div class="col-xs-1" style="padding: 0;">
							<input style="width: 100%;" placeholder="Nb" class="form-control" name="Qty_Boiler_" id="qty_boiler_" type="number" />
						</div>
						<div class="col-xs-11 next-label">
							<span class="wpcf7-form-control-wrap list-small">
								<select class="wpcf7-form-control form-control wpcf7-select" name="Boiler" id="boiler">
									<option>-- type de chauffe-eau --</option>
									<option value="Boiler_pose">Electrique</option>
									<option value="Boiler_pose">Thermo-dynamique</option>
									<option value="Boiler_suspendu">Integré</option>
								</select>
								<span class="select_arrow"></span>
							</span>
						</div>
					</div>
					<div class="col-md-6" style="padding: 0;">
						<div class="bootstrap-filestyle input-group">
							<span class="wpcf7-form-control-wrap text-upload"> 
								<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" name="Boiler-Upload" id="boiler-upload" /> 
							</span> 
							<span class="group-span-filestyle input-group-btn"> 
								<label for="file-volume" class="btn btn-default"> 
									<span class="icon-span-filestyle fa fa-upload"></span> 
									<span class="buttonText">Pièce Jointe</span> 
								</label> 
							</span>
						</div>
						<span class="wpcf7-form-control-wrap fileUpload"> 
							<span class="custom_choosefile"> 
								<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" name="File-Boiler" id="file-boiler" /> 
								<span class="button_choosefile">Pièce Jointe</span> 
							</span> 
						</span>
					</div>
				</div>
				<div class="col-md-6" style="padding-left: 0; margin-bottom: 0;">
					<input type="button" id="Add_Boiler" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Boiler_Form" data-alert="Il n'y a que 3 types de chauffe-eau disponible !" data-limit="3" />
				</div>
				<div class="col-md-12" style="padding: 0; margin: 0;"><hr /></div>
				<div class="col-md-12" style="padding: 0;">
					<label class="subtitle">Chauffage</label>
				</div>
				<div class="col-md-12 Warming_Form" style="padding: 0;">
					<div class="col-md-6" style="padding: 0 10px 0 0;">
						<div class="col-xs-1" style="padding: 0;">
							<input style="width: 100%;" placeholder="Nb" class="form-control" name="Qty_Warming_" id="qty_warming_" type="number" />
						</div>
						<div class="col-xs-11 next-label">
							<span class="wpcf7-form-control-wrap list-small">
								<select class="wpcf7-form-control form-control wpcf7-select" name="Warming" id="warming">
									<option>-- type de chauffage --</option>
									<option value="Warming_elec">Electrique</option>
									<option value="Warming_fuel">Chaudière Fuel</option>
									<option value="Warming_gaz">Chaudière Gaz</option>
									<option value="Warming_PAC">Pompe a Chaleur</option>
								</select>
								<span class="select_arrow"></span> 
							</span>
						</div>
					</div>
					<div class="col-md-6" style="padding: 0;">
						<div class="bootstrap-filestyle input-group">
							<span class="wpcf7-form-control-wrap text-upload"> 
								<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" name="Warming-Upload" id="warming-upload" /> 
							</span> 
							<span class="group-span-filestyle input-group-btn"> 
								<label for="file-volume" class="btn btn-default"> 
									<span class="icon-span-filestyle fa fa-upload"></span> 
									<span class="buttonText">Pièce Jointe</span> 
								</label> 
							</span>
						</div>
						<span class="wpcf7-form-control-wrap fileUpload"> 
							<span class="custom_choosefile"> 
								<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" name="File-Warming" id="file-warming" /> 
								<span class="button_choosefile">Pièce Jointe</span> 
							</span> 
						</span>
					</div>
				</div>
				<div class="col-md-6" style="padding-left: 0; margin-bottom: 0;">
					<input type="button" id="Add_Warming" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Warming_Form" data-alert="Il n'y a que 4 types de chauffage possible !" data-limit="4" />
				</div>
				<div class="col-md-12" style="padding: 0; margin: 0;"><hr /></div>
					<div class="col-md-12" style="padding: 0;">
						<label class="subtitle">Electroménager</label>
					</div>
					<div class="col-md-12 Machine_Form" style="padding: 0;">
					<div class="col-md-6" style="padding: 0 10px 0 0;">
						<div class="col-xs-1" style="padding: 0;">
							<input style="width: 100%;" placeholder="Nb" class="form-control" name="Qty_Warming_" id="qty_warming_" type="number" />
						</div>
					<div class="col-xs-11 next-label">
						<span class="wpcf7-form-control-wrap list-small">
							<select class="wpcf7-form-control form-control wpcf7-select" name="Machine" id="machine">
								<option>-- type d'Electroménager --</option>
								<option value="Washing_Machine">Lave-Linge</option>
								<option value="Dish_Wacher">Lave-Vaisselle</option>
								<option value="Hoven">Four(s) à vapeur</option>
								<option value="Coffee_Machine">Cafetière(s)</option>
								<option value="Cooker">Cuit-Vapeur</option>
								<option value="Baby_Cook">Chauffe-Biberon</option>
							</select>
							<span class="select_arrow"></span> 
						</span>
					</div>
				</div>
				<div class="col-md-6" style="padding: 0;">
					<div class="bootstrap-filestyle input-group">
						<span class="wpcf7-form-control-wrap text-upload"> 
							<input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" type="text" name="Machine-Upload" id="machine-upload" /> 
						</span> 
						<span class="group-span-filestyle input-group-btn"> 
							<label for="file-volume" class="btn btn-default"> 
								<span class="icon-span-filestyle fa fa-upload"></span> 
								<span class="buttonText">Pièce Jointe</span> 
							</label> 
						</span>
					</div>
					<span class="wpcf7-form-control-wrap fileUpload"> 
						<span class="custom_choosefile"> 
							<input size="40" class="wpcf7-form-control wpcf7-file form-control input-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.odt,.avi,.ogg,.m4a,.mov,.mp3,.mp4,.mpg,.wav,.wmv" aria-invalid="false" type="file" name="File-Machine" id="file-machine" /> 
							<span class="button_choosefile">Pièce Jointe</span> 
						</span> 
					</span>
				</div>
			</div>
		<div class="col-md-6" style="padding-left: 0; margin-bottom: 0;">
			<input type="button" id="Add_Machine" value="Ajouter" class="button button-submit-alt clonning-button" data-clone="Machine_Form" data-alert="Il n'y a que 6 types d'electroménager disponibles !" data-limit="6" />
		</div>
	</div>
		</div>
		<div class="block_form" id="Pollution">
			<div class="col-md-12">
				<label class="title">Pollution</label>
			</div>
			<div class="col-md-12" id="Scale">
				<h2>Evaluation Calcaire</h2>
				<div class="col-md-6" style="padding: 0 0 10px 0;">
					<div class="col-xs-1" style="padding: 0;">
						<input style="width: 100%;" placeholder="PPM" class="form-control" name="TDS" id="tds" type="number">
					</div>
					<div class="col-xs-11 next-label">TDS relevé</div>
				</div>
				<div class="col-md-6" style="padding-left: 0;">
					<label class="subtitle">Retour de l'Usager</label>
					<select id="rating_taste" class="star-rating" name="Rating_taste" data-options='{literal}{"initialText":"Dureté ressentie"}{/literal}'>
						<option value="">Ressenti du calcaire</option>
						<option value="5">Très dure</option>
						<option value="4">Dure</option>
						<option value="3">Moyennement dure</option>
						<option value="2">Douce</option>
						<option value="1">Très douce</option>
					</select>
				</div>
			</div>
			<div class="col-md-12" id="FeedBack">
				<h2>Retour de l'Usager</h2>
				<div class="col-md-4" style="padding-left: 0;">
					<div class="col-xs-12" style="padding: 0;">
						<label class="subtitle">Goût de l'eau au robinet</label>
					</div>
					<select id="rating_taste" class="star-rating" name="Rating_taste" data-options='{literal}{"initialText":"Avis sur le goût"}{/literal}'>
						<option value="">Avis sur le goût</option>
						<option value="5">Excellent</option>
						<option value="4">Bon</option>
						<option value="3">Moyen</option>
						<option value="2">Mauvais</option>
						<option value="1">Irratrapable</option>
					</select>
				</div>
				<div class="col-md-4" style="padding-left: 0;">
					<div class="col-xs-12" style="padding: 0;">
						<label class="subtitle">Odeur de l'eau au robinet</label>					
					</div>
					<select id="rating_olor" class="star-rating" name="Rating_olor" data-options='{literal}{"initialText":"Avis sur l&apos;odeur"}{/literal}'>
						<option value="">Avis sur l'odeur</option>
						<option value="5">Excellente</option>
						<option value="4">Bonne</option>
						<option value="3">Passable</option>
						<option value="2">Mauvaise</option>
						<option value="1">Insupportable</option>
					</select>
				</div>
				<div class="col-md-4" style="padding-left: 0;">
					<div class="col-xs-12" style="padding: 0;">
						<label class="subtitle">Qualité de l'eau au robinet</label>
					</div>
					<select id="rating_confidence" class="star-rating" name="Rating_confidence" data-options='{literal}{"initialText":"Avis général"}{/literal}'>
						<option value="">Avis sur la qualité générale</option>
						<option value="5">Irréprochable</option>
						<option value="4">Satisfaisante</option>
						<option value="3">Moyenne</option>
						<option value="2">Douteuse</option>
						<option value="1">Terrible</option>
					</select>
				</div>
			</div>
			<div class="col-md-12" id="SpecAna">
				<h2>Analyses Particulières</h2>
			</div>
		</div>
		<div class="col-md-12" style="padding-left: 0px; float:none">
			<input class="wpcf7-form-control button button-submit" type="submit" name="submitDiag" value="Envoyer" />
		</div>
	</form>
<script type="text/javascript">
;(function( window, document, undefined ) {

	"use strict";

	/** @return object */
	var Plugin = function( selector, options ) { // string|object, object
		this.selects = {}.toString.call( selector ) === '[object String]' ? document.querySelectorAll( selector ) : [selector];
		this.destroy = function() {
			this.widgets.forEach( function( widget ) {
				widget.destroy_();
			});
		};
		this.rebuild = function() {
			this.widgets.forEach( function( widget ) {
				widget.rebuild_();
			});
		};
		this.widgets = [];
		for( var i = 0; i < this.selects.length; i++ ) {
			if( this.selects[i].tagName !== 'SELECT' )continue;
			var widget = new Widget( this.selects[i], options );
			if( widget.direction === undefined )continue;
			this.widgets.push( widget );
		}
	};

	/** @return void */
	var Widget = function( el, options ) { // HTMLElement, object|null
		this.el = el;
		this.options_ = this.extend_( {}, this.defaults_, options || {}, JSON.parse( el.getAttribute( 'data-options' )));
		this.setStarCount_();
		if( this.stars < 1 || this.stars > this.options_.maxStars )return;
		this.init_();
	};

	Widget.prototype = {

		defaults_: {
			classname: 'gl-star-rating',
			clearable: true,
			initialText: 'Select a Rating',
			maxStars: 10,
			showText: true,
		},

		/** @return void */
		init_: function() {
			this.initEvents_();
			this.current = this.selected = this.getSelectedValue_();
			this.wrapEl_();
			this.buildWidgetEl_();
			this.setDirection_();
			this.setValue_( this.current );
			this.handleEvents_( 'add' );
		},

		/** @return void */
		buildLabelEl_: function() {
			if( !this.options_.showText )return;
			this.textEl = this.insertSpanEl_( this.widgetEl, {
				class: this.options_.classname + '-text',
			}, true );
		},

		/** @return void */
		buildWidgetEl_: function() {
			var values = this.getOptionValues_();
			var widgetEl = this.insertSpanEl_( this.el, {
				class: this.options_.classname + '-stars',
			}, true );
			for( var key in values ) {
				var newEl = this.createSpanEl_({
					'data-value': key,
					'data-text': values[key],
				});
				widgetEl.innerHTML += newEl.outerHTML;
			}
			this.widgetEl = widgetEl;
			this.buildLabelEl_();
		},

		/** @return void */
		changeTo_: function( index ) { // int
			if( index < 0 || isNaN( index )) {
				index = 0;
			}
			if( index > this.stars ) {
				index = this.stars;
			}
			this.widgetEl.classList.remove( 's' + ( 10 * this.current ));
			this.widgetEl.classList.add( 's' + ( 10 * index ));
			if( this.options_.showText ) {
				this.textEl.textContent = index < 1 ? this.options_.initialText : this.widgetEl.childNodes[index - 1].dataset.text;
			}
			this.current = index;
		},

		/** @return HTMLElement */
		createSpanEl_: function( attributes ) { // object
			var el = document.createElement( 'span' );
			attributes = attributes || {};
			for( var key in attributes ) {
				el.setAttribute( key, attributes[key] );
			}
			return el;
		},

		/** @return void */
		destroy_: function() {
			this.handleEvents_( 'remove' );
			var wrapEl = this.el.parentNode;
			wrapEl.parentNode.replaceChild( this.el, wrapEl );
		},

		/** @return void */
		eventListener_: function( el, action, events ) { // HTMLElement, string, array
			events.forEach( function( event ) {
				el[action + 'EventListener']( event, this.events[event] );
			}.bind( this ));
		},

		/** @return object */
		extend_: function() { // ...object
			var args = [].slice.call( arguments );
			var result = args[0];
			var extenders = args.slice(1);
			Object.keys( extenders ).forEach( function( i ) {
				for( var key in extenders[i] ) {
					if( !extenders[i].hasOwnProperty( key ))continue;
					result[key] = extenders[i][key];
				}
			});
			return result;
		},

		/** @return int */
		getIndexFromEvent_: function( ev ) { // MouseEvent|TouchEvent
			var direction = {};
			var pageX = ev.pageX || ev.changedTouches[0].pageX;
			var widgetWidth = this.widgetEl.offsetWidth;
			direction.ltr = Math.max( pageX - this.offsetLeft, 1 );
			direction.rtl = widgetWidth - direction.ltr;
			return Math.min(
				Math.ceil( direction[this.direction] / Math.round( widgetWidth / this.stars )),
				this.stars
			);
		},

		/** @return object */
		getOptionValues_: function() {
			var el = this.el;
			var unorderedValues = {};
			var orderedValues = {};
			for( var i = 0; i < el.length; i++ ) {
				if( this.isValueEmpty_( el[i] ))continue;
				unorderedValues[el[i].value] = el[i].text;
			}
			Object.keys( unorderedValues ).sort().forEach( function( key ) {
				orderedValues[key] = unorderedValues[key];
			});
			return orderedValues;
		},

		/** @return int */
		getSelectedValue_: function() {
			return parseInt( this.el.options[Math.max( this.el.selectedIndex, 0 )].value ) || 0;
		},

		/** @return void */
		handleEvents_: function( action ) { // string
			var formEl = this.el.closest( 'form' );
			if( formEl.tagName === 'FORM' ) {
				this.eventListener_( formEl, action, ['reset'] );
			}
			this.eventListener_( this.el, action, ['change', 'keydown'] );
			this.eventListener_( this.widgetEl, action, [
				'mousedown', 'mouseleave', 'mousemove', 'mouseover',
				'touchend', 'touchmove', 'touchstart',
			]);
		},

		/** @return void */
		initEvents_: function() {
			this.events = {
				change: this.onChange_.bind( this ),
				keydown: this.onKeydown_.bind( this ),
				mousedown: this.onPointerdown_.bind( this ),
				mouseleave: this.onPointerleave_.bind( this ),
				mousemove: this.onPointermove_.bind( this ),
				mouseover: this.onPointerover_.bind( this ),
				reset: this.onReset_.bind( this ),
				touchend: this.onPointerdown_.bind( this ),
				touchmove: this.onPointermove_.bind( this ),
				touchstart: this.onPointerover_.bind( this ),
			};
		},

		/** @return void */
		insertSpanEl_: function( el, attributes, after ) { // HTMLElement, object, bool
			var newEl = this.createSpanEl_( attributes );
			el.parentNode.insertBefore( newEl, after === true ? el.nextSibling : el );
			return newEl;
		},

		/** @return bool */
		isValueEmpty_: function( el ) { // HTMLElement
			return el.getAttribute( 'value' ) === null || el.value === '';
		},

		/** @return void */
		onChange_: function() {
			this.changeTo_( this.getSelectedValue_() );
		},

		/** @return void */
		onKeydown_: function( ev ) { // KeyboardEvent
			if( !~['ArrowLeft', 'ArrowRight'].indexOf( ev.key ))return;
			var increment = ev.key === 'ArrowLeft' ? -1 : 1;
			if( this.direction === 'rtl' ) {
				increment *= -1;
			}
			this.setValue_( Math.min( Math.max( this.getSelectedValue_() + increment, 0 ), this.stars ));
			this.triggerChangeEvent_();
		},

		/** @return void */
		onPointerdown_: function( ev ) { // MouseEvent|TouchEvent
			ev.preventDefault();
			var index = this.getIndexFromEvent_( ev );
			if( this.current !== 0 && parseFloat( this.selected ) === index && this.options_.clearable ) {
				this.onReset_();
				this.triggerChangeEvent_();
				return;
			}
			this.setValue_( index );
			this.triggerChangeEvent_();
		},

		/** @return void */
		onPointerleave_: function( ev ) { // MouseEvent
			ev.preventDefault();
			this.changeTo_( this.selected );
		},

		/** @return void */
		onPointermove_: function( ev ) { // MouseEvent|TouchEvent
			ev.preventDefault();
			this.changeTo_( this.getIndexFromEvent_( ev ));
		},

		/** @return void */
		onPointerover_: function( ev ) { // MouseEvent|TouchEvent
			ev.preventDefault();
			var rect = this.widgetEl.getBoundingClientRect();
			this.offsetLeft = rect.left + document.body.scrollLeft;
		},

		/** @return void */
		onReset_: function() {
			var originallySelected = this.el.querySelector( '[selected]' );
			var value = originallySelected ? originallySelected.value : '';
			this.el.value = value;
			this.selected = parseInt( value ) || 0;
			this.changeTo_( value );
		},

		/** @return void */
		rebuild_: function() {
			if( this.el.parentNode.classList.contains( this.options_.classname )) {
				this.destroy_();
			}
			this.init_();
		},

		/** @return void */
		setDirection_: function() {
			var wrapEl = this.el.parentNode;
			this.direction = window.getComputedStyle( wrapEl, null ).getPropertyValue( 'direction' );
			wrapEl.classList.add( this.options_.classname + '-' + this.direction );
		},

		/** @return void */
		setValue_: function( index ) {
			this.el.value = this.selected = index;
			this.changeTo_( index );
		},

		/** @return void */
		setStarCount_: function() {
			var el = this.el;
			this.stars = 0;
			for( var i = 0; i < el.length; i++ ) {
				if( this.isValueEmpty_( el[i] ))continue;
				if( isNaN( parseFloat( el[i].value )) || !isFinite( el[i].value )) {
					this.stars = 0;
					return;
				}
				this.stars++;
			}
		},

		/** @return void */
		triggerChangeEvent_: function() {
			this.el.dispatchEvent( new Event( 'change' ));
		},

		/** @return void */
		wrapEl_: function() {
			var wrapEl = this.insertSpanEl_( this.el, {
				class: this.options_.classname,
				'data-star-rating': '',
			});
			wrapEl.appendChild( this.el );
		},
	};

	if( typeof define === 'function' && define.amd ) {
		define( [], function() { return Plugin; });
	}
	else if( typeof module === 'object' && module.exports ) {
		module.exports = Plugin;
	}
	else {
		window.StarRating = Plugin;
	}

})( window, document );
</script>
</section>
{/block}
<?php 
use Etn\Utils\Helper;
    $settings 					 	= \Etn\Core\Settings\Settings::instance()->get_settings_option();
    $attendee_verification_style 	= isset( $settings['attendee_verification_style'] ) ? $settings['attendee_verification_style'] : 'on';
    $certificate_preference      	= isset( $settings['certificate_preference'] ) ? $settings['certificate_preference'] : 'on';
	$enable_attendee_bulk        	= isset( $settings['enable_attendee_bulk'] ) ? 'checked' : '';
?> 

<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label>
            <?php esc_html_e('Attendee\'s Verification Process', 'eventin'); ?>
        </label>
        <div class="etn-desc"> <?php esc_html_e('Determine attendees\' check-in process.', 'eventin'); ?> </div>
    </div>
	<?php 
		if(!class_exists( 'Wpeventin_Pro' )){ 
			echo Helper::get_pro();
		} else {
	?>
    <div class="etn-meta">
        <select value='on' id="attendee_verification_style" name='attendee_verification_style' class="etn-setting-input attr-form-control etn-settings-select">
            <option value='on' <?php echo esc_html( selected( $attendee_verification_style, 'on', false ) ); ?>> <?php echo esc_html__( 'Single Step for Auto Check-in', 'eventin' ); ?> </option>
            <option value='off' <?php echo esc_html( selected( $attendee_verification_style, 'off', false ) ); ?>> <?php echo esc_html( 'Two Step for Manual Check-in', 'eventin' ); ?> </option>
        </select>
    </div>
	<?php } ?>
</div>
<div class="attr-form-group etn-label-item certificate-label-item">
    <div class="etn-label">
        <label>
            <?php esc_html_e('Certification Preference', 'eventin'); ?>
        </label>
        <div class="etn-desc" style="max-width: 670px"> <?php esc_html_e('“Send to “Checked-in Attendees” option will allow you to send certificates to the attendees who checked in through QR Code scanning, whereas, Send to “All Attendees” option will send certificates to all the attendees.', 'eventin'); ?> </div>
    </div>
	<?php 
		if(!class_exists( 'Wpeventin_Pro' )){ 
			echo Helper::get_pro();
		} else {
	?>
    <div class="etn-meta">
        <select value='on' id="certificate_preference" name='certificate_preference' class="etn-setting-input attr-form-control etn-settings-select">
             <option value='on' <?php echo esc_html( selected( $certificate_preference, 'on', false ) ); ?>> <?php echo esc_html__( 'Send to "Checked-in Attendees"', 'eventin' ); ?> </option>
            <option value='off' <?php echo esc_html( selected( $certificate_preference, 'off', false ) ); ?>> <?php echo esc_html( 'Send to "All Attendees"', 'eventin' ); ?> </option>
        </select>
    </div>
	<?php } ?>
</div>

<div class="attr-form-group etn-label-item">
	<div class="etn-label">
		<label for="enable_attendee_bulk"><?php esc_html_e('Enable Bulk Attendee', 'eventin'); ?></label>
		<div class="etn-desc"> <?php esc_html_e("Enabling the bulk attendee option to show in the front-end.", 'eventin'); ?> </div>
	</div>
	<?php 
		if(!class_exists( 'Wpeventin_Pro' )){ 
			echo Helper::get_pro();
		} else {
	?>
	<div class="etn-meta">
		<input id="enable_attendee_bulk" type="checkbox" <?php echo esc_html($enable_attendee_bulk); ?> class="etn-admin-control-input" name="enable_attendee_bulk" />
		<label for="enable_attendee_bulk" class="etn_switch_button_label"></label>
	</div>
	<?php } ?>
</div>

<div class="etn-label-item etn-label-extra-field etn-label-top">
    <div class="etn-label">
        <label for="attendee_extra_field"
               class="etn-settings-label"><?php echo esc_html__('Extra Field', "eventin"); ?></label>
        <p class="etn-desc"> <?php echo esc_html__("Extra field will be added in attendee form", "eventin"); ?> </p>
    </div>
	<?php 
		if(!class_exists( 'Wpeventin_Pro' )){ 
			echo Helper::get_pro();
		} else {
	?>
    <div class="etn-meta">
        <div class="attendee_extra_main_block">
			<?php
			$input_type_array = [
				'text'     => esc_html__('Text', 'eventin'),
				'number'   => esc_html__('Number', 'eventin'),
				'date'     => esc_html__('Date', 'eventin'),
				'radio'    => esc_html__('Radio', 'eventin'),
				'checkbox' => esc_html__('Checkbox', 'eventin'),
			];

			$special_types = [
				'date',
				'radio',
				'checkbox',
			];

			$attendee_extra_fields = isset($settings['attendee_extra_fields']) ? $settings['attendee_extra_fields'] : [];

			$next_add_time_index = 1;
			if(is_array($attendee_extra_fields) && !empty($attendee_extra_fields)) {
				$next_add_time_index = count($attendee_extra_fields);

				foreach($attendee_extra_fields as $index => $attendee_extra_field) {
					$selection = !empty($attendee_extra_field['required']) ? $attendee_extra_field['required'] : "";
					?>
                    <div class="etn-attendee-field attendee_block">
                        <select name='attendee_extra_fields[<?php echo esc_attr($index); ?>][etn_field_type]'>
                            <option value="optional" <?php echo esc_attr($selection == 'optional' ? 'selected' : ''); ?> > <?php echo esc_html__("Optional", "eventin") ?></option>
                            <option value="required" <?php echo $selection ? 'selected' : ''; ?>><?php echo esc_html__("Required", "eventin") ?></option>
                        </select>
                        <div class="attendee_extra_field_wrapper">
                            <input type="text" name="attendee_extra_fields[<?php echo esc_attr($index); ?>][label]"
								value="<?php echo esc_attr($attendee_extra_field['label']); ?>"
								id="attendee_extra_label_<?php echo esc_attr($index); ?>"
								class="attendee_extra_label mr-1 etn-settings-input etn-form-control"
								placeholder="<?php esc_html_e('Input Label', 'eventin'); ?>" <?php echo ($index != 0) ? 'required' : '' ?> />
                        </div>
						<select name="attendee_extra_fields[<?php echo esc_attr($index); ?>][type]"
							id="attendee_extra_type_<?php echo esc_attr($index); ?>"
							class="attendee_extra_type mr-1 etn-settings-input etn-form-control"
							data-current_extra_block_index="<?php echo esc_attr($index); ?>" <?php echo ($index != 0) ? 'required' : '' ?>>
							<option value="" selected><?php echo esc_html__('Select Input Type', 'eventin'); ?></option>
							<?php foreach($input_type_array as $key => $value) { ?>
										<option value="<?php echo esc_attr($key); ?>" <?php selected($attendee_extra_field['field_type'], $key, true) ?>>
										<?php echo esc_html($value); ?></option>
							<?php } ?>
						</select>
                        <div class="attendee_extra_field_wrapper">
                        <input type="text" name="attendee_extra_fields[<?php echo esc_attr($index); ?>][placeholder_text]"
                               value="<?php echo esc_attr($attendee_extra_field['placeholder_text']); ?>"
                               id="attendee_extra_placeholder_<?php echo esc_attr($index); ?>"
                               class="attendee_extra_placeholder mr-1 etn-settings-input etn-form-control"
                               style="display: <?php echo in_array($attendee_extra_field['field_type'], $special_types) ? 'none' : 'block'; ?>;"
                               placeholder="<?php esc_html_e('Input Placeholder', 'eventin'); ?>"/>
                        </div>

                        <!-- attendee extra type radio section -->
						<?php
							if($attendee_extra_field['field_type'] == 'radio' && isset($attendee_extra_field['field_options'])) {
								if(is_array($attendee_extra_field['field_options']) && count($attendee_extra_field['field_options']) >= 2) {

									$next_add_time_radio_index = count($attendee_extra_field['field_options']);
									?>

									<div class="attendee_extra_type_radio_main_block">
											<div class="attendee_extra_type_radio_note"
													style="display: none;"><?php echo esc_html__('Note: At least 2 radio label are required for working. 1st two are mandatory.', "eventin"); ?></div>

										<?php
										// generating each radio field.
										foreach($attendee_extra_field['field_options'] as $radio_index => $radio_val) {
											?>
											<div class="etn-attendee-field attendee_extra_type_radio_block mb-2">
												<input type="text"
															name="attendee_extra_fields[<?php echo esc_attr($index); ?>][field_options][<?php echo esc_attr($radio_index); ?>]"
															value="<?php esc_html_e($radio_val['value'], 'eventin') ?>"
															id="attendee_extra_type_<?php echo esc_attr($index); ?>_radio_<?php echo esc_attr($radio_index); ?>"
															class="attendee_extra_type_radio mr-1 etn-settings-input etn-form-control <?php echo ($radio_index <= 1) ? 'attendee_extra_type_radio_' . esc_attr($radio_index) : ''; ?>"
															placeholder="<?php esc_html_e('Radio text', 'eventin'); ?>" />

												<?php
												if($radio_index > 1) {
													?>
														<span class="dashicons etn-btn dashicons dashicons-no-alt remove_attendee_extra_type_radio_field pl-1"></span>
													<?php
												}
												?>
											</div>
											<?php
										}
										?>

										<!-- add more radio portion -->
										<div class="etn_flex_reverse attendee_extra_type_radio_section">
											<span class="add_attendee_extra_type_radio_block etn-btn-text"
													data-radio_placeholder_text="<?php echo esc_html__("Radio text", "eventin"); ?>"
													data-next_add_time_radio_parent_index="<?php echo esc_attr($index); ?>"
													data-next_add_time_radio_index="<?php echo esc_attr($next_add_time_radio_index); ?>">
													<?php echo esc_html__('Add Radio', 'eventin'); ?>
											</span>
										</div>
								</div>
									<?php

								}
							}
						?>

                        <!-- attendee extra type checkbox section -->
						<?php

						if($attendee_extra_field['field_type'] == 'checkbox' && isset($attendee_extra_field['field_options'])) {
							if(is_array($attendee_extra_field['field_options']) && count($attendee_extra_field['field_options']) >= 1) {

								$next_add_time_checkbox_index = count($attendee_extra_field['field_options']);
								?>
								<div class="attendee_extra_type_checkbox_main_block">
										<?php
										// generating each checkbox field.
										foreach($attendee_extra_field['field_options'] as $checkbox_index => $checkbox_val) {
											?>
											<div class="etn-attendee-field attendee_extra_type_checkbox_block mb-2">
												<input type="text"
													name="attendee_extra_fields[<?php echo esc_attr($index); ?>][field_options][<?php echo esc_attr($checkbox_index); ?>]"
													value="<?php esc_html_e($checkbox_val['value'], 'eventin') ?>"
													id="attendee_extra_type_<?php echo esc_attr($index); ?>_checkbox_<?php echo esc_attr($checkbox_index); ?>"
													class="attendee_extra_type_checkbox mr-1 etn-settings-input etn-form-control"
													placeholder="<?php esc_html_e('Checkbox text', 'eventin'); ?>" <?php echo ($index != 0) ? 'required1' : '' ?> />

												<?php
												if($checkbox_index > 0) {
													?>
													<span class="dashicons etn-btn dashicons dashicons-no-alt remove_attendee_extra_type_checkbox_field pl-1"></span>
													<?php
												}
												?>
											</div>
											<?php
										}
										?>

										<!-- add more checkbox portion -->
										<div class="etn_flex_reverse attendee_extra_type_checkbox_section">
												<span class="add_attendee_extra_type_checkbox_block etn-btn-text"
													data-checkbox_placeholder_text="<?php echo esc_html__("Checkbox text", "eventin"); ?>"
													data-next_add_time_checkbox_parent_index="<?php echo esc_attr($index); ?>"
													data-next_add_time_checkbox_index="<?php echo esc_attr($next_add_time_checkbox_index); ?>">
													<?php echo esc_html__('Add Checkbox', 'eventin'); ?>
												</span>
										</div>
								</div>
								<?php
							}
						}
						?>
                        <div class="attendee_extra_show_in_dashboard_wrapper etn-checkbox-field">
                            <input type="checkbox"
                                   name="attendee_extra_fields[<?php echo esc_attr($index); ?>][show_in_dashboard]"
                                   value=""
                                   id="attendee_extra_show_in_dashboard_<?php echo esc_attr($index); ?>"
                                   class="attendee_extra_show_in_dashboard mr-1 etn-settings-input etn-form-checkbox"
								<?php echo isset($attendee_extra_field['show_in_dashboard']) ? 'checked' : '' ?> />

                            <label for="attendee_extra_show_in_dashboard_<?php echo esc_attr($index); ?>">
								<?php esc_html_e('Show in Attendee Dashboard', 'eventin'); ?>
                            </label>
                        </div>
						<?php
						if($index != 0) {
							?>
                            <span class="dashicons etn-btn dashicons dashicons-no-alt remove_attendee_extra_field pl-1"></span>
							<?php
						}
						?>
                    </div>
					<?php
				}
			} else {
				?>
                <div class="etn-attendee-field attendee_block mb-2">
                    <select name='attendee_extra_fields[0][etn_field_type]'>
                        <option value="optional"> <?php echo esc_html__("Optional", "eventin") ?></option>
                        <option value="required"><?php echo esc_html__("Required", "eventin") ?></option>
                    </select>
					<div class="attendee_extra_field_wrapper">
						<input type="text" name="attendee_extra_fields[0][label]" value=""
                           class="attendee_extra_label mr-1 etn-settings-input etn-form-control"
                           placeholder="<?php esc_html_e('Input Label', 'eventin'); ?>"/>
					</div>
                    <select name="attendee_extra_fields[0][type]"
                            class="attendee_extra_type mr-1 etn-settings-input etn-form-control"
                            data-current_extra_block_index="0">
                        <option value="" selected><?php echo esc_html__('Select Input Type', 'eventin'); ?></option>
						<?php
						foreach($input_type_array as $key => $value) {
							?>
							<option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
							<?php
						}
						?>
                    </select>
                    <input type="text" name="attendee_extra_fields[0][place_holder]" value=""
                           class="attendee_extra_placeholder mr-1 etn-settings-input etn-form-control"
                           placeholder="<?php esc_html_e('Input Placeholder', 'eventin'); ?>"/>
					<div class="attendee_extra_show_in_dashboard_wrapper etn-checkbox-field">
						<input 
							type="checkbox" 
							name="attendee_extra_fields[0][show_in_dashboard]" value=""
							class="attendee_extra_show_in_dashboard mr-1 etn-settings-input etn-form-checkbox"
						 	id="attendee_extra_show_in_dashboard[0]"
						   />
						<label for="attendee_extra_show_in_dashboard[0]">
							<?php esc_html_e('Show in Attendee Dashboard', 'eventin'); ?>
						</label>
					</div>
                    
                </div>
				<?php
			}
			?>
        </div>

        <div class="etn_flex_reverse attendee_extra_section">
            <span class="add_attendee_extra_block etn-btn-text"
                  data-label_text="<?php echo esc_html__("Label text", "eventin"); ?>"
                  data-placeholder_text="<?php echo esc_html__("Placeholder text", "eventin"); ?>"
                  data-select_input_type_text="<?php echo esc_html__("Select Input Type", "eventin"); ?>"
                  data-input_type_text="<?php echo esc_html__("Text", "eventin"); ?>"
                  data-input_type_number="<?php echo esc_html__('Number', "eventin"); ?>"
                  data-input_type_date="<?php echo esc_html__('Date', "eventin"); ?>"
                  data-input_type_radio="<?php echo esc_html__('Radio', "eventin"); ?>"
                  data-input_type_checkbox="<?php echo esc_html__('Checkbox', "eventin"); ?>"
                  data-radio_placeholder_text="<?php echo esc_html__('Radio text', "eventin"); ?>"
                  data-radio_add_btn_text="<?php echo esc_html__('Add Radio', "eventin"); ?>"
                  data-radio_note="<?php echo esc_html__('Note: At least 2 radio label are required for working. 1st two are mandatory.', "eventin"); ?>"
                  data-checkbox_placeholder_text="<?php echo esc_html__('Checkbox text', "eventin"); ?>"
                  data-checkbox_add_btn_text="<?php echo esc_html__(' Add Checkbox', "eventin"); ?>"
                  data-show_in_dashboard_text="<?php echo esc_html__('Show in Attendee Dashboard', "eventin"); ?>"
                  data-attendee-extra-scope="etn-extra-field-global"
                  data-next_add_time_index="<?php echo esc_attr($next_add_time_index); ?>">
                <?php echo esc_html__('Add Field', 'eventin'); ?>
            </span>
        </div>
    </div>
	<?php } ?>
</div>

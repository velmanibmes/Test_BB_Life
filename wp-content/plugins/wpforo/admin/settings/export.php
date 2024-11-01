<form method="post" onsubmit="return !!document.querySelector('.wpf-opt-row-imp-exp .wpf-opt-checkbox-wrap input:checked')">
    <input type="hidden" name="wpfaction" value="settings_export">
	<?php wp_nonce_field( "wpforo_settings_export" ); ?>

    <div class="wpf-opt-row">
        <div class="wpf-opt-intro">
            <svg height="50" width="50" viewBox="0 0 384 512">
                <path fill="currentColor"
                      d="m149.9 349.1l-.2-.2l-32.8-28.9l32.8-28.9c3.6-3.2 4-8.8.8-12.4l-.2-.2l-17.4-18.6c-3.4-3.6-9-3.7-12.4-.4l-57.7 54.1c-3.7 3.5-3.7 9.4 0 12.8l57.7 54.1c1.6 1.5 3.8 2.4 6 2.4c2.4 0 4.8-1 6.4-2.8l17.4-18.6c3.3-3.5 3.1-9.1-.4-12.4m220-251.2L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M256 51.9l76.1 76.1H256zM336 464H48V48h160v104c0 13.3 10.7 24 24 24h104zM209.6 214c-4.7-1.4-9.5 1.3-10.9 6L144 408.1c-1.4 4.7 1.3 9.6 6 10.9l24.4 7.1c4.7 1.4 9.6-1.4 10.9-6L240 231.9c1.4-4.7-1.3-9.6-6-10.9zm24.5 76.9l.2.2l32.8 28.9l-32.8 28.9c-3.6 3.2-4 8.8-.8 12.4l.2.2l17.4 18.6c3.3 3.5 8.9 3.7 12.4.4l57.7-54.1c3.7-3.5 3.7-9.4 0-12.8l-57.7-54.1c-3.5-3.3-9.1-3.2-12.4.4l-17.4 18.6c-3.3 3.5-3.1 9.1.4 12.4"></path>
            </svg>
			<?php _e( 'It allows users to export the configuration and settings data of the wpForo into a downloadable JSON file.', 'wpforo' ) ?>
        </div>
    </div>

    <div class="wpf-opt-row wpf-opt-row-imp-exp">
        <div class="wpf-opt-input">
            <div class="wpf-opt-checkbox-wrap">
                <input id="all" type="checkbox" checked>
                <label for="all" class="wpf-label"><?php _e( 'All', 'wpforo' ) ?></label>
            </div>
        </div>
    </div>

    <div class="wpf-subtitle">
        <span class="dashicons dashicons-admin-links"></span> <?php _e( 'Base Settings', 'wpforo' ) ?>
    </div>

    <div class="wpf-opt-row wpf-opt-row-imp-exp">
        <div class="wpf-opt-input">
			
			<?php
			foreach( WPF()->settings->info->core as $group => $info ) {
				if( wpfval( $info, 'base' ) ) {
					printf(
						'<div class="wpf-opt-checkbox-wrap">
									<input id="%1$s" type="checkbox" name="groups[]" value="%3$s" checked/>
									<label for="%1$s" class="wpf-label">%2$s</label>
								</div>',
						"wpf-chk-group-$group",
						$info['title'],
						$group
					);
				}
			}
			?>

        </div>
    </div>

    <div class="wpf-subtitle">
        <span class="dashicons dashicons-admin-links"></span> <?php _e( 'Board Settings', 'wpforo' ) ?>
    </div>

    <div class="wpf-opt-row wpf-opt-row-imp-exp">
        <div class="wpf-opt-input">
			
			<?php
			foreach( WPF()->settings->info->core as $group => $info ) {
				if( ! wpfval( $info, 'base' ) ) {
					printf(
						'<div class="wpf-opt-checkbox-wrap">
									<input id="%1$s" type="checkbox" name="groups[]" value="%3$s" checked/>
									<label for="%1$s" class="wpf-label">%2$s</label>
								</div>',
						"wpf-chk-group-$group",
						$info['title'],
						$group
					);
				}
			}
			?>

        </div>
    </div>

    <div class="wpf-opt-row" style="display: flex; justify-content: space-between; align-items: center;">
        <span style="color: darkorange; font-style: italic;"><?php _e( 'One or more checkboxes must be selected.', 'wpforo' ) ?></span>
        <input type="submit" value="<?php _e( 'Export to JSON File', 'wpforo' ) ?>" class="button-primary" title="<?php _e( 'One or more checkboxes must be selected.', 'wpforo' ) ?>">
    </div>
</form>

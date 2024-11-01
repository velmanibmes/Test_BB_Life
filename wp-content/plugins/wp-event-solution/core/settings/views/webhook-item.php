<?php
use Etn\Utils\Helper;
use Etn_Pro\Core\Webhook\Webhook;

$webhook_id = ! empty( $webhook_id ) ? $webhook_id : 0;

if ( ! class_exists( 'Wpeventin_Pro' ) ) {
    $webhook = '';
    $webhook_name = esc_html__('Webhook Name','eventin');
    $webhook_description = esc_html__('Webhook Description','eventin');
    $webhook_delivery_url = esc_html__('Webhook delivery url','eventin');
    $webhook_get_secrete = '';
    $webhook_get_id = '';
    $webhook_get_status = '';
    $webhook_get_topic = '';
    
} else {
    $webhook    = new Webhook( $webhook_id );

    $webhook_name = $webhook->get_name();
    $webhook_description = $webhook->get_description();
    $webhook_delivery_url = $webhook->get_delivery_url();
    $webhook_get_secrete = $webhook->get_secrete();
    $webhook_get_id = $webhook->get_id();
    $webhook_get_status = $webhook->get_status();
    $webhook_get_topic = $webhook->get_topic();
}

    // $webhook    = new Webhook( $webhook_id );
    
    $is_edit    = $webhook_get_id > 0 ? true: false;
    $class      = $is_edit ? 'etn-webhook-item' : 'etn-add-new-webhook';
    $form_class = $is_edit ? 'edit' : 'etn-add-webhook';
    
    $topics = [
        'event.created'     => __( 'Event Create', 'eventin' ),
        'event.updated'     => __( 'Event Update', 'eventin' ),
        'event.deleted'     => __( 'Event Delete', 'eventin' ),
        'event.restored'    => __( 'Event Restore', 'eventin' ),
        'speaker.created'   => __( 'Speaker Create', 'eventin' ),
        'speaker.updated'   => __( 'Speaker Update', 'eventin' ),
        'speaker.deleted'   => __( 'Speaker Delete', 'eventin' ),
        'speaker.restored'  => __( 'Speaker Restore', 'eventin' ),
        'attendee.created'  => __( 'Attendee Create', 'eventin' ),
        'attendee.updated'  => __( 'Attendee Update', 'eventin' ),
        'attendee.deleted'  => __( 'Attendee Delete', 'eventin' ),
        'attendee.restored' => __( 'Attendee Restore', 'eventin' ),
        'schedule.created'  => __( 'Schedule Create', 'eventin' ),
        'schedule.updated'  => __( 'Schedule Update', 'eventin' ),
        'schedule.deleted'  => __( 'Schedule Delete', 'eventin' ),
        'schedule.restored' => __( 'Schedule Restore', 'eventin' ),
        'order.created'     => __( 'Order Create', 'eventin' ),
        'order.updated'     => __( 'Order Update', 'eventin' ),
        'order.deleted'     => __( 'Order Delete', 'eventin' ),
        'order.restored'    => __( 'Order Restore', 'eventin' ),
    ];
    
    $statuses = [
        'active'    =>  __( 'Active', 'eventin' ),
        'pending'   =>  __( 'Pending', 'eventin' ),
        'disable'   =>  __( 'Disable', 'eventin' ),
    ];


?>

<div class="attr-form-group etn-label-item etn-label-top <?php echo $class; ?>">
    <?php if ( $is_edit ): ?>
        <div class="etn-label etn-webhook-title">
            <label><?php echo esc_html( $webhook_name ); ?></label>
            <div class="etn-desc mb-2"><?php echo esc_html( $webhook_description ); ?></div>
        </div>
        <div class="etn-meta">
            <button class="etn-btn-close webhook-close-btn">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </div>
    <?php else: ?>
        <div class="new-item-head">
            <div class="attr-form-group">
                <p class="etn-desc etn-mb-2">
                    <?php echo esc_html__('Specify the domain where you want to use the webhook.','eventin'); ?>
                </p>
                <button class="etn-btn-text" id="add-new-webhook"><?php esc_html_e( 'Add New', 'eventin' ); ?></button>
            </div>
        </div>
    <?php endif; ?>
    <div class="etn-webhook-item-content <?php echo esc_attr( $form_class ); ?>">
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e( 'Name', 'eventin' );?></label>
                <div class="etn-desc"><?php esc_html_e( 'User friendly name for webhook', 'eventin' ); ?></div>

            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
            <div class="etn-meta">
                <input 
                    type="text" 
                    name="webhook_name" 
                    value="<?php echo esc_attr( $webhook_name ); ?>" 
                    class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_attr_e( 'Webhook Name', 'eventin' ); ?>"
                >
            </div>
            <?php } ?>
        </div>
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e( 'Status', 'eventin' ); ?></label>
                <div class="etn-desc"><?php esc_html_e( 'Webhook Status', 'eventin' ); ?></div>

            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
            <div class="etn-meta">
                <select name="webhook_status" class="etn-setting-input attr-form-control etn-settings-select">
                    <option value=""><?php esc_html_e( 'Seelect', 'eventin' ); ?></option>
                    <?php foreach( $statuses as $stat_key => $status): ?>
                        <option 
                            value="<?php echo esc_attr( $stat_key ); ?>"
                            <?php echo $stat_key == $webhook_get_status ? 'selected' : ''; ?>
                        ><?php echo esc_html( $status ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php } ?>
        </div>
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e( 'Topic', 'eventin' ); ?></label>
                <div class="etn-desc"><?php esc_html_e( 'Webhook Topic', 'eventin' ); ?></div>

            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
            <div class="etn-meta">
                <select name="webhook_topic" class="etn-setting-input attr-form-control etn-settings-select">
                    <option value=""><?php esc_html_e( 'Select Topic', 'eventin' ); ?></option>
                    <?php foreach( $topics as $topic_key => $topic ): ?>
                        <option 
                            value="<?php echo esc_attr( $topic_key ); ?>"
                            <?php echo $topic_key == $webhook_get_topic ? 'selected' : '' ?> 
                        ><?php echo esc_html( $topic ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php } ?>
        </div> 
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e( 'Delivary URL', 'eventin' ); ?></label>
                <div class="etn-desc"><?php esc_html_e( 'User friendly name for webhook', 'eventin' ); ?></div>

            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
            <div class="etn-meta">
                <input 
                    type="text" 
                    name="webhook_delivery_url" 
                    value="<?php echo esc_attr( $webhook_delivery_url ); ?>" 
                    class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_attr_e( 'Webhook Delivery URL', 'eventin' ); ?>"
                >
            </div>
            <?php } ?>
        </div>
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e( 'Secrete', 'eventin' ); ?></label>
                <div class="etn-desc"><?php esc_html_e( 'Webhook Secrete', 'eventin' ); ?></div>

            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
            <div class="etn-meta">
                <input 
                    type="text" 
                    name="webhook_secrete" 
                    value="<?php echo esc_attr( $webhook_get_secrete ); ?>" 
                    class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_attr_e( 'Webhook Secrete', 'eventin' ); ?>"
                >
            </div>
            <?php } ?>
        </div> 
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e( 'Description', 'eventin' ); ?></label>
                <div class="etn-desc"><?php esc_html_e( 'Webhook Description', 'eventin' ); ?></div>

            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
            <div class="etn-meta">
                <textarea 
                    name="webhook_description"
                    placeholder="<?php esc_attr_e( 'Webhook description', 'eventin' ); ?>"
                    class="etn-setting-input attr-form-control" 
                ><?php echo esc_html( $webhook_description ); ?></textarea>
            </div>
            <?php } ?>
        </div>  
        <?php 
            if(class_exists( 'Wpeventin_Pro' )){ 
        ?>
        <div class="attr-form-group etn-text-right etn-mt-3">
            <input type="hidden" name="webhook_id" value="<?php echo esc_attr( $webhook_get_id ); ?>">
            <button class="etn-btn-text save-webhook-btn"><?php esc_html_e( 'Save Changes', 'eventin' ); ?></button>
            <button class="etn-btn-text cancel-webhook-btn"><?php esc_html_e( 'Cancel', 'eventin' ); ?></button>
        </div>
        <?php } ?>
    </div>
</div>

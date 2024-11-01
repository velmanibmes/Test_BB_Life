<?php wp_enqueue_script('wp-event-manager-content-event-listing'); ?>
<div class="wpem-main wpem-event-listings-header">
    <div class="wpem-row">
        <div class="wpem-col wpem-col-12 wpem-col-sm-6 wpem-col-md-6 wpem-col-lg-8">
            <div class="wpem-event-listing-header-title">
                <?php if(isset($title)) : ?>
                    <h2 class="wpem-heading-text"><?php printf(__('%s', 'wp-event-manager'), $title);?></h2>
                <?php endif; ?>
            </div>
        </div>
        <div class="wpem-col wpem-col-12 wpem-col-sm-6 wpem-col-md-6 wpem-col-lg-4">
            <div class="wpem-event-layout-action-wrapper">
                <div class="wpem-event-layout-action">
                    <?php if ($layout_type == 'all') :  ?>
                        <?php do_action('start_event_listing_layout_icon'); ?>
                        <div class="wpem-event-layout-icon wpem-event-box-layout" title="<?php _e('Events Box View', 'wp-event-manager'); ?>" id="wpem-event-box-layout"><i class="wpem-icon-stop2"></i></div>
                        <div class="wpem-event-layout-icon wpem-event-list-layout wpem-active-layout" title="<?php _e('Events List View', 'wp-event-manager'); ?>" id="wpem-event-list-layout"><i class="wpem-icon-menu"></i></div>
                        <?php do_action('end_event_listing_layout_icon'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event listing view -->
<?php
if ($layout_type == 'box')
    $list_type_class = 'wpem-row wpem-event-listing-box-view';
else
    $list_type_class = 'wpem-event-listing-list-view';

$list_type_class = apply_filters('wpem_default_listing_layout_class', $list_type_class, $layout_type);

?>
<div class="event_listings_main">
    <div id="event-listing-view" class="wpem-main wpem-event-listings event_listings <?php echo $list_type_class;?>" data-id="<?php echo $layout_type;?>">
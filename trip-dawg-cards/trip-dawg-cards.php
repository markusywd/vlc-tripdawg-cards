<?php
/*
Plugin Name: Trip Dawg Cards
Plugin URI: https://github.com/YoungWebDesign/Trip-Dawg-Cards
Description: Create the Trip Dawg cards from custom post types and ACF fields.
Version: 1.0
Author: Young Web Design
Author URI: https://www.youngwebdesign.com
*/
// End if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
// Inlcude custom styles
function trip_dawg_cards_custom_style() {
    wp_enqueue_style('trip-dawg-cards-style', plugin_url(__FILE__) . 'trip-dawg-cards.css');
}
// Function to create a shortcode for that generates the Trip Dawg cards
function trip_dawg_cards_shortcode() {
    ob_start();
    ?>
    <div class="row justify-content-center">
    <?php
    $args = array(
        'post_type' => 'trip-dawg-connection',
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $tdc_image = get_field('tdc_image');
            if (!empty($tdc_image)) {
                $tdc_image_url = $tdc_image['url'];
                $tdc_image_alt = $tdc_image['alt'];
            }
            $tdc_content = get_field('tdc_content');
            $tdc_page_link = get_field('tdc_page_link');
            if (!empty($tdc_page_link)) {
                $tdc_page_link_url = $tdc_page_link['url'];
                $tdc_page_link_title = $tdc_page_link['title'];
            }

            ?>
            <div class="col-lg-4 col-6 mb-4">
                <div class="trip-dawg-card">
                    <div class="trip-dawg-card-image">
                        <img src="<?php echo $tdc_image_url; ?>" alt="<?php echo $tdc_image_alt; ?>" class="img-fluid">
                    </div>
                    <div class="trip-dawg-card-content">
                        <p><?php echo $tdc_content; ?></p>
                    </div>
                    <div class="trip-dawg-card-link">
                        <a href="<?php echo $tdc_page_link_url; ?>" class="btn btn-primary"><?php echo $tdc_page_link_title; ?></a>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    
    return ob_get_clean();
}
add_shortcode('trip-dawg-cards', 'trip_dawg_cards_shortcode');
add_action('wp_enqueue_scripts', 'trip_dawg_cards_custom_style');



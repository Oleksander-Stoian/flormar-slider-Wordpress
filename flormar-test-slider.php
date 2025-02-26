<?php
/*
Plugin Name: Flormar Test Slider
Description: Додає шорткод [flormar-test-slider] для виведення адаптивного слайдера товарів WooCommerce.
Version: 1.0
Author: Alex Stoian
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

/**
 * Підключення стилів та скриптів для слайдера
 */
function flormar_enqueue_slider_assets() {
    wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1' );
    wp_enqueue_style( 'slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array('slick-css'), '1.8.1' );
    wp_enqueue_style( 'flormar-slider-css', plugins_url( 'css/style.css', __FILE__ ), array('slick-css'), '1.0' );

    wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true );
    wp_enqueue_script( 'flormar-slider-init', plugins_url( 'js/slider-init.js', __FILE__ ), array('jquery','slick-js'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'flormar_enqueue_slider_assets' );

/**
 * Реєстрація шорткоду [flormar-test-slider]
 */
function flormar_test_slider_shortcode() {
    ob_start();
    ?>
    <div class="flormar-slider-wrapper">
        <h2 class="flormar-slider-title">המוצרים הנמכרים ביותר</h2>
        <div class="flormar-slider">
            <!-- Тут будуть товари WooCommerce -->
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'flormar-test-slider', 'flormar_test_slider_shortcode' );

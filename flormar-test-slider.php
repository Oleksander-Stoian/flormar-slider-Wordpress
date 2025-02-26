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
 * Підключення стилів та скриптів
 */
function flormar_enqueue_slider_assets() {
    wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1' );
    wp_enqueue_style( 'slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array('slick-css'), '1.8.1' );
    wp_enqueue_style( 'flormar-slider-css', plugins_url( 'css/style.css', __FILE__ ), array('slick-css'), '1.0' );

    wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true );
    wp_enqueue_script( 'flormar-slider-init', plugins_url( 'js/slider-init.js', __FILE__ ), array('jquery', 'slick-js'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'flormar_enqueue_slider_assets' );

/**
 * Реєстрація шорткоду [flormar-test-slider] з фільтрацією товарів за ціною
 */
function flormar_test_slider_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'min-price' => '',
        'max-price' => '',
    ), $atts, 'flormar-test-slider' );

    // Фільтрація товарів за ціною
    $meta_query = array();
    if ( ! empty( $atts['min-price'] ) ) {
        $meta_query[] = array(
            'key'     => '_price',
            'value'   => $atts['min-price'],
            'compare' => '>=',
            'type'    => 'NUMERIC'
        );
    }
    if ( ! empty( $atts['max-price'] ) ) {
        $meta_query[] = array(
            'key'     => '_price',
            'value'   => $atts['max-price'],
            'compare' => '<=',
            'type'    => 'NUMERIC'
        );
    }

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
    );
    if ( ! empty( $meta_query ) ) {
        $args['meta_query'] = $meta_query;
    }

    $products = new WP_Query( $args );

    if ( $products->have_posts() ) {
        ob_start();
        ?>
        <div class="flormar-slider-wrapper">
            <h2 class="flormar-slider-title">המוצרים הנמכרים ביותר</h2>

            <div class="flormar-slider">
                <?php while ( $products->have_posts() ) : $products->the_post(); global $product; ?>
                    <div class="flormar-slide">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'medium' ); ?>
                        </a>
                        <div class="flormar-divider"></div>
                        <h3 class="flormar-product-title"><?php the_title(); ?></h3>
                        <p class="flormar-product-price"><?php echo $product->get_price_html(); ?></p>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    } else {
        return '<p>Товари не знайдено.</p>';
    }
}
add_shortcode( 'flormar-test-slider', 'flormar_test_slider_shortcode' );
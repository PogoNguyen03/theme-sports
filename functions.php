<?php
/**
 * Kaiyun Sports Theme Functions
 */

// Enqueue styles and scripts
function kaiyun_sports_scripts() {
    wp_enqueue_style('kaiyun-sports-style', get_stylesheet_uri(), array(), '1.0.1');
    wp_enqueue_style('kaiyun-sports-icons', get_template_directory_uri() . '/css/icons.css', array('kaiyun-sports-style'), '1.0.1');
    wp_enqueue_style('kaiyun-sports-header', get_template_directory_uri() . '/css/header-new.css', array('kaiyun-sports-style'), '1.0.1');
    wp_enqueue_style('kaiyun-sports-main', get_template_directory_uri() . '/css/main.css', array('kaiyun-sports-style'), '1.0.1');
    wp_enqueue_script('kaiyun-sports-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.1', true);
    
    // Profile page stylesheet
    if (is_page_template('page-profile.php')) {
        wp_enqueue_style('kaiyun-sports-profile', get_template_directory_uri() . '/css/profile.css', array('kaiyun-sports-style'), '1.0.0');
    }
    
}
add_action('wp_enqueue_scripts', 'kaiyun_sports_scripts');

// Critical jQuery fix - must run BEFORE jQuery loads
function kaiyun_sports_jquery_fix() {
    ?>
    <script>
    // Critical fix for jQuery :has() selector - must run BEFORE jQuery
    (function() {
        console.log('Running critical jQuery fix script');
        
        // Override document.querySelector to prevent :has() issues
        var originalQuerySelector = document.querySelector;
        var originalQuerySelectorAll = document.querySelectorAll;
        
        document.querySelector = function(selector) {
            if (typeof selector === 'string' && (selector.includes(':has(') || selector.includes(':jqfake'))) {
                console.log('Blocked problematic selector:', selector);
                return null;
            }
            return originalQuerySelector.call(this, selector);
        };
        
        document.querySelectorAll = function(selector) {
            if (typeof selector === 'string' && (selector.includes(':has(') || selector.includes(':jqfake'))) {
                console.log('Blocked problematic selector:', selector);
                return document.createDocumentFragment();
            }
            return originalQuerySelectorAll.call(this, selector);
        };
        
        // Disable native :has() support at DOM level
        if (window.CSS && window.CSS.supports) {
            try {
                window.CSS.supports('selector(:has(*))');
            } catch (e) {
                console.log('Native :has() not supported, good');
            }
        }
        
        console.log('Critical jQuery fix applied successfully');
    })();
    </script>
    <?php
}
add_action('wp_head', 'kaiyun_sports_jquery_fix', 1);

// Add inline CSS to ensure games section displays correctly
function kaiyun_sports_inline_css() {
    ?>
    <style type="text/css">
    /* Force Games Section Styles */
    .games-section {
        background: #f5f7fa !important;
        padding: 60px 0 !important;
        display: block !important;
        visibility: visible !important;
    }
    
    .games-section .container {
        max-width: 100rem !important;
        margin: 0 auto !important;
        padding: 0 20px !important;
        width: 100% !important;
        display: block !important;
    }
    
    .games-content-wrapper {
        display: flex !important;
        flex-direction: column !important;
        gap: 30px !important;
    }
    
    .games-title-section {
        text-align: center !important;
        margin-bottom: 40px !important;
    }
    
    .games-title-img {
        max-width: 100% !important;
        height: auto !important;
        max-height: 110px !important;
        object-fit: contain !important;
    }
    
    .games-tabs-section {
        display: flex !important;
        justify-content: center !important;
    }
    
    /* .games-main-content {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 40px !important;
        background: #fff !important;
        border-radius: 15px !important;
        padding: 30px !important;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1) !important;
    } */
    
    .games-tabs-list {
        display: flex !important;
        gap: 20px !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
    }
    
    .games-tab-item {
        padding: 12px 24px !important;
        background: #fff !important;
        border: 2px solid #e1e8ed !important;
        border-radius: 25px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
    }
    
    .games-tab-item.active {
        background: #3498db !important;
        border-color: #3498db !important;
    }
    
    .games-tab-item span {
        color: #666 !important;
        font-size: 14px !important;
        font-weight: 500 !important;
    }
    
    .games-tab-item.active span {
        color: #fff !important;
    }
    
    .providers-list {
        display: flex !important;
        gap: 4px !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .provider-item {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 8px !important;
        /* padding: 15px !important; */
        border-radius: 10px !important;
        transition: all 0.3s ease !important;
        cursor: pointer !important;
    }
    
    .provider-icon {
        width: 58px;
    height: 58px;
    margin: 0 4px;
    background: url(/wp-content/uploads/2025/10/download-5.png) no-repeat 0 0 / cover;
    border-radius: 12.7px;
    box-shadow: 0 4px 8px 0 rgba(112, 146, 215, .14);
    position: relative;
    background-image: url(/wp-content/uploads/2025/10/download-5.png);
    }
    
    .provider-icon-img,
    .provider-icon-active {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
        transition: opacity 0.3s ease !important;
    }
    
    .provider-icon-active {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        opacity: 0 !important;
    }
    
    .provider-item.active .provider-icon-img {
        opacity: 0 !important;
    }
    
    .provider-item.active .provider-icon-active {
        opacity: 1 !important;
    }
    
    .games-tab-content {
        display: none !important;
    }
    
    .games-tab-content.active {
        display: grid !important;
        grid-template-columns: 2fr 1fr !important;
        gap: 40px !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    .games-left-section {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end;
        z-index: 3;
    }
    
    .games-main-image {
        width: 100% !important;
        max-width: 750px !important;
    }
    
    .main-sports-img {
        width: 100% !important;
        height: auto !important;
        object-fit: contain !important;
        border-radius: 10px !important;
    }
    
    .games-right-section {
        width: 700px;
        height: 454px;
        padding: 2rem 2rem 2rem 10rem;
        position: relative;
        margin-top: 35px;
        margin-left: -220px;
        background-color: none;
        border: none;
        background: url(/wp-content/uploads/2025/10/download.png) no-repeat 50% / 100%;
        border-radius: 24px;
        z-index: 2;
    }
    .sports-description, .sports-info-header, .sports-providers{
        padding-bottom: 1rem !important;
    }
    
    .sports-info-header {
        display: flex !important;
    }
    
    .sports-title-img {
        max-width: 100% !important;
        height: auto !important;
        max-height: 116px !important;
        object-fit: contain !important;
    }
    
    .return-rate-info {
        display: none !important;
        flex-direction: column !important;
        align-items: flex-start !important;
    }
    
    .return-rate-info.show-return {
        display: flex !important;
    }
    
    .rate-number {
        font-size: 36px !important;
        font-weight: bold !important;
        color: #3498db !important;
        line-height: 1 !important;
    }
    
    .rate-percent {
        font-size: 24px !important;
    }
    
    .rate-label {
        font-size: 14px !important;
        color: #666 !important;
        margin-top: 5px !important;
    }
    
    .sports-description p {
        color: #666 !important;
        font-size: 14px !important;
        margin: 0 !important;
        line-height: 1.6 !important;
    }
    
    .provider-name {
        font-size: 12px !important;
        color: #666 !important;
        margin: 0 !important;
        text-align: center !important;
    }
    
    .provider-item.active .provider-name {
        color: #3498db !important;
        font-weight: 600 !important;
    }
    
    @media (max-width: 768px) {
        .games-main-content {
            grid-template-columns: 1fr !important;
            gap: 30px !important;
        }
        
        .providers-list {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
        }
        
        .provider-icon {
            width: 50px !important;
            height: 50px !important;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'kaiyun_sports_inline_css');

// Add inline JavaScript for games section functionality
function kaiyun_sports_inline_js() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        console.log('Games section JavaScript loaded');
        
        // Hide return-rate-info when rate is zero
        function updateReturnRateVisibility(scope) {
            var $root = scope && scope.length ? scope : $(document);
            $root.find('.return-rate-info').each(function() {
                var text = $(this).find('.rate-number').text().trim().replace(',', '.');
                var value = parseFloat(text);
                if (!isNaN(value) && value <= 0) {
                    $(this).removeClass('show-return');
                } else {
                    $(this).addClass('show-return');
                }
            });
        }

        // Games tab switching - Enhanced
        $('.games-tab-item').off('click').on('click', function() {
            var tabIndex = $(this).data('tab');
            console.log('Switching to tab:', tabIndex);
            
            // Remove active class from all tabs and contents
            $('.games-tab-item').removeClass('active');
            $('.games-tab-content').removeClass('active');
            
            // Add active class to clicked tab and corresponding content
            $(this).addClass('active');
            $('.games-tab-content[data-tab="' + tabIndex + '"]').addClass('active');
            
            console.log('Active tab content found:', $('.games-tab-content[data-tab="' + tabIndex + '"]').length);
            
            // Update provider active states for the new tab
            var activeTabContent = $('.games-tab-content[data-tab="' + tabIndex + '"]');
            activeTabContent.find('.provider-item:first').addClass('active');
            activeTabContent.find('.provider-item:not(:first)').removeClass('active');

            // Update return-rate visibility for current tab
            updateReturnRateVisibility(activeTabContent);
        });
        
        // Provider item switching within each tab
        $('.provider-item').off('click').on('click', function() {
            var providerIndex = $(this).data('provider');
            var tabContent = $(this).closest('.games-tab-content');
            
            // Remove active class from all providers in this tab
            tabContent.find('.provider-item').removeClass('active');
            
            // Add active class to clicked provider
            $(this).addClass('active');
            
            console.log('Provider switched to:', providerIndex);
        });
        
        // Set first tab and first provider as active by default
        $('.games-tab-item:first').addClass('active');
        $('.games-tab-content:first').addClass('active');
        $('.games-tab-content:first .provider-item:first').addClass('active');
        
        // Initial update for return-rate visibility
        updateReturnRateVisibility($(document));

        console.log('Default states set');
    });
    </script>
    <?php
}
add_action('wp_footer', 'kaiyun_sports_inline_js');

// Theme setup
function kaiyun_sports_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'top-nav' => __('Top Navigation', 'kaiyun-sports'),
        'main-nav' => __('Main Navigation', 'kaiyun-sports'),
        'utility-nav' => __('Utility Navigation', 'kaiyun-sports'),
        'footer' => __('Footer Menu', 'kaiyun-sports'),
    ));
}
add_action('after_setup_theme', 'kaiyun_sports_setup');

// Customizer settings
function kaiyun_sports_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'kaiyun-sports'),
        'priority' => 30,
    ));
    
    // Hero Banner Images (Multiple) - Using custom control
    $wp_customize->add_setting('hero_banner_images', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    if (class_exists('WP_Customize_Multiple_Media_Control')) {
        $wp_customize->add_control(new WP_Customize_Multiple_Media_Control($wp_customize, 'hero_banner_images', array(
            'label' => __('Hero Banner Images', 'kaiyun-sports'),
            'section' => 'hero_section',
            'description' => __('Select multiple images for the hero slider. You can drag to reorder them.', 'kaiyun-sports'),
            'mime_type' => 'image',
        )));
    } elseif (class_exists('WP_Customize_Simple_Media_Control')) {
        $wp_customize->add_control(new WP_Customize_Simple_Media_Control($wp_customize, 'hero_banner_images', array(
            'label' => __('Hero Banner Images', 'kaiyun-sports'),
            'section' => 'hero_section',
            'description' => __('Select multiple images for the hero slider.', 'kaiyun-sports'),
            'mime_type' => 'image',
        )));
    } else {
        // Fallback to simple text input
        $wp_customize->add_control('hero_banner_images', array(
            'label' => __('Hero Banner Images (comma-separated IDs)', 'kaiyun-sports'),
            'section' => 'hero_section',
            'type' => 'text',
            'description' => __('Enter image IDs separated by commas (e.g., 123,456,789)', 'kaiyun-sports'),
        ));
    }
    
    // Hero Banner URLs (Multiple)
    $wp_customize->add_setting('hero_banner_urls', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_banner_urls', array(
        'label' => __('Hero Banner URLs (comma-separated)', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'text',
        'description' => __('Enter URLs separated by commas (e.g., https://example1.com,https://example2.com)', 'kaiyun-sports'),
    ));
    
    // Hero Banner Alt Texts (Multiple)
    $wp_customize->add_setting('hero_banner_alts', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_banner_alts', array(
        'label' => __('Hero Banner Alt Texts (comma-separated)', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'text',
        'description' => __('Enter alt texts separated by commas', 'kaiyun-sports'),
    ));
    
    // Slider Settings
    $wp_customize->add_setting('hero_slider_autoplay', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('hero_slider_autoplay', array(
        'label' => __('Auto Play Slider', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'checkbox',
    ));
    
    $wp_customize->add_setting('hero_slider_interval', array(
        'default' => 3000,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('hero_slider_interval', array(
        'label' => __('Slider Interval (milliseconds)', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'number',
        'description' => __('Default: 3000ms (3 seconds)', 'kaiyun-sports'),
        'input_attrs' => array(
            'min' => 1000,
            'max' => 10000,
            'step' => 500,
        ),
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_btn1_text', array(
        'default' => 'Đăng ký ngay',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_btn1_text', array(
        'label' => __('Button 1 Text', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_btn1_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_btn1_link', array(
        'label' => __('Button 1 Link', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'url',
    ));
    
    $wp_customize->add_setting('hero_btn2_text', array(
        'default' => 'Tìm hiểu thêm',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_btn2_text', array(
        'label' => __('Button 2 Text', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_btn2_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_btn2_link', array(
        'label' => __('Button 2 Link', 'kaiyun-sports'),
        'section' => 'hero_section',
        'type' => 'url',
    ));
    
    // Partners Section
    $wp_customize->add_section('partners_section', array(
        'title' => __('Partners Section', 'kaiyun-sports'),
        'priority' => 35,
    ));
    
    // Partners Images (Multiple) - Using custom control
    $wp_customize->add_setting('partners_images', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    if (class_exists('WP_Customize_Multiple_Media_Control')) {
        $wp_customize->add_control(new WP_Customize_Multiple_Media_Control($wp_customize, 'partners_images', array(
            'label' => __('Partners Images', 'kaiyun-sports'),
            'section' => 'partners_section',
            'description' => __('Select up to 7 images for partners. You can drag to reorder them.', 'kaiyun-sports'),
            'mime_type' => 'image',
        )));
    } else {
        // Fallback to simple text input
        $wp_customize->add_control('partners_images', array(
            'label' => __('Partners Images (comma-separated IDs)', 'kaiyun-sports'),
            'section' => 'partners_section',
            'type' => 'text',
            'description' => __('Enter image IDs separated by commas (e.g., 123,456,789)', 'kaiyun-sports'),
        ));
    }
    
    // Partners Names (Multiple)
    $wp_customize->add_setting('partners_names', array(
        'default' => 'Real Madrid,Inter Milan,AC Milan,Crystal Palace,Bayer Leverkusen,Real Betis,Manchester United,Chelsea',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('partners_names', array(
        'label' => __('Partners Names (comma-separated)', 'kaiyun-sports'),
        'section' => 'partners_section',
        'type' => 'text',
        'description' => __('Enter partner names separated by commas (e.g., Real Madrid,Inter Milan,AC Milan)', 'kaiyun-sports'),
    ));
    
    // Partners URLs (Multiple)
    $wp_customize->add_setting('partners_urls', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('partners_urls', array(
        'label' => __('Partners URLs (comma-separated)', 'kaiyun-sports'),
        'section' => 'partners_section',
        'type' => 'text',
        'description' => __('Enter URLs separated by commas (optional)', 'kaiyun-sports'),
    ));

    // Footer - Partners bar
    $wp_customize->add_section('footer_partners_section', array(
        'title' => __('Footer Partners', 'kaiyun-sports'),
        'priority' => 80,
    ));

    $wp_customize->add_setting('footer_partners_images', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    if (class_exists('WP_Customize_Multiple_Media_Control')) {
        $wp_customize->add_control(new WP_Customize_Multiple_Media_Control($wp_customize, 'footer_partners_images', array(
            'label' => __('Footer Partner Logos', 'kaiyun-sports'),
            'section' => 'footer_partners_section',
            'mime_type' => 'image',
            'description' => __('Select multiple logos; drag to reorder.', 'kaiyun-sports'),
        )));
    } else {
        $wp_customize->add_control('footer_partners_images', array(
            'label' => __('Footer Partner Logo IDs (comma-separated)', 'kaiyun-sports'),
            'section' => 'footer_partners_section',
            'type' => 'text',
        ));
    }

    $wp_customize->add_setting('footer_partners_urls', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_partners_urls', array(
        'label' => __('Footer Partner URLs (comma-separated)', 'kaiyun-sports'),
        'section' => 'footer_partners_section',
        'type' => 'text',
        'description' => __('Enter URLs in the same order as logos (optional).', 'kaiyun-sports'),
    ));

    // Live Section
    $wp_customize->add_section('live_section', array(
        'title' => __('Live Section', 'kaiyun-sports'),
        'priority' => 85,
    ));

    // Enable Live Section
    $wp_customize->add_setting('live_section_enabled', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('live_section_enabled', array(
        'label' => __('Enable Live Section', 'kaiyun-sports'),
        'section' => 'live_section',
        'type' => 'checkbox',
    ));

    // Live Section Title Text
    $wp_customize->add_setting('live_section_title_text', array(
        'default' => 'Live Matches',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('live_section_title_text', array(
        'label' => __('Section Title Text', 'kaiyun-sports'),
        'section' => 'live_section',
        'type' => 'text',
        'description' => __('Enter text title for the section', 'kaiyun-sports'),
        'active_callback' => function() { return get_theme_mod('live_section_enabled', false); },
    ));

    // Live Section Title Image
    $wp_customize->add_setting('live_section_title_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'live_section_title_image', array(
        'label' => __('Section Title Image (Optional)', 'kaiyun-sports'),
        'section' => 'live_section',
        'settings' => 'live_section_title_image',
        'mime_type' => 'image',
        'description' => __('Upload an image to use as section title. If provided, this will be used instead of text title.', 'kaiyun-sports'),
        'active_callback' => function() { return get_theme_mod('live_section_enabled', false); },
    )));

    // Number of Live Matches
    $wp_customize->add_setting('live_matches_count', array(
        'default' => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('live_matches_count', array(
        'label' => __('Number of Live Matches', 'kaiyun-sports'),
        'section' => 'live_section',
        'type' => 'select',
        'choices' => array(
            '1' => '1 trận đấu',
            '2' => '2 trận đấu', 
            '3' => '3 trận đấu',
            '4' => '4 trận đấu',
            '5' => '5 trận đấu',
            '6' => '6 trận đấu',
            '7' => '7 trận đấu',
            '8' => '8 trận đấu',
        ),
        'active_callback' => function() { return get_theme_mod('live_section_enabled', false); },
    ));

    // Live Match Fields (up to 8 matches)
    for ($i = 1; $i <= 8; $i++) {
        // Match League Name
        $wp_customize->add_setting("live_match_{$i}_league", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("live_match_{$i}_league", array(
            'label' => sprintf(__('Match %d - League Name', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'type' => 'text',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        ));

        // Match League Logo
        $wp_customize->add_setting("live_match_{$i}_league_logo", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "live_match_{$i}_league_logo", array(
            'label' => sprintf(__('Match %d - League Logo', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'settings' => "live_match_{$i}_league_logo",
            'mime_type' => 'image',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        )));

        // Match Status (Live or Time)
        $wp_customize->add_setting("live_match_{$i}_status", array(
            'default' => 'live',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("live_match_{$i}_status", array(
            'label' => sprintf(__('Match %d - Status', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'type' => 'select',
            'choices' => array(
                'live' => __('Live', 'kaiyun-sports'),
                'scheduled' => __('Scheduled', 'kaiyun-sports'),
            ),
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        ));

        // Match Time (for scheduled matches)
        $wp_customize->add_setting("live_match_{$i}_time", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("live_match_{$i}_time", array(
            'label' => sprintf(__('Match %d - Time (for scheduled)', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'type' => 'text',
            'description' => __('Format: 2025-10-02 15:45', 'kaiyun-sports'),
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        ));

        // Team 1 Name
        $wp_customize->add_setting("live_match_{$i}_team1_name", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("live_match_{$i}_team1_name", array(
            'label' => sprintf(__('Match %d - Team 1 Name', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'type' => 'text',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        ));

        // Team 1 Logo
        $wp_customize->add_setting("live_match_{$i}_team1_logo", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "live_match_{$i}_team1_logo", array(
            'label' => sprintf(__('Match %d - Team 1 Logo', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'settings' => "live_match_{$i}_team1_logo",
            'mime_type' => 'image',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        )));

        // Team 1 Score
        $wp_customize->add_setting("live_match_{$i}_team1_score", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("live_match_{$i}_team1_score", array(
            'label' => sprintf(__('Match %d - Team 1 Score', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'type' => 'text',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        ));

        // Team 2 Name
        $wp_customize->add_setting("live_match_{$i}_team2_name", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("live_match_{$i}_team2_name", array(
            'label' => sprintf(__('Match %d - Team 2 Name', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'type' => 'text',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        ));

        // Team 2 Logo
        $wp_customize->add_setting("live_match_{$i}_team2_logo", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "live_match_{$i}_team2_logo", array(
            'label' => sprintf(__('Match %d - Team 2 Logo', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'settings' => "live_match_{$i}_team2_logo",
            'mime_type' => 'image',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        )));

        // Team 2 Score
        $wp_customize->add_setting("live_match_{$i}_team2_score", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("live_match_{$i}_team2_score", array(
            'label' => sprintf(__('Match %d - Team 2 Score', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'type' => 'text',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        ));

        // Streamer Name
        $wp_customize->add_setting("live_match_{$i}_streamer_name", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("live_match_{$i}_streamer_name", array(
            'label' => sprintf(__('Match %d - Streamer Name', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'type' => 'text',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        ));

        // Streamer Avatar
        $wp_customize->add_setting("live_match_{$i}_streamer_avatar", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "live_match_{$i}_streamer_avatar", array(
            'label' => sprintf(__('Match %d - Streamer Avatar', 'kaiyun-sports'), $i),
            'section' => 'live_section',
            'settings' => "live_match_{$i}_streamer_avatar",
            'mime_type' => 'image',
            'active_callback' => function() use ($i) { 
                return get_theme_mod('live_section_enabled', false) && $i <= get_theme_mod('live_matches_count', 5); 
            },
        )));
    }

    // App Sections (simplified to only one enable control)
    $wp_customize->add_section('download_app_sections', array(
        'title' => __('App Download Sections', 'kaiyun-sports'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('app_section_1_enabled', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('app_section_1_enabled', array(
        'label' => __('Enable App Section', 'kaiyun-sports'),
        'section' => 'download_app_sections',
        'type' => 'checkbox',
    ));

    // Title image or text
    $wp_customize->add_setting('app_section_title_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('app_section_title_text', array(
        'label' => __('Section Title Text', 'kaiyun-sports'),
        'section' => 'download_app_sections',
        'type' => 'text',
        'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
    ));

    $wp_customize->add_setting('app_section_title_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    if (class_exists('WP_Customize_Media_Control')) {
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'app_section_title_image', array(
            'label' => __('Section Title Image (optional)', 'kaiyun-sports'),
            'section' => 'download_app_sections',
            'mime_type' => 'image',
            'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
        )));
    }

    // Description
    $wp_customize->add_setting('app_section_desc', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('app_section_desc', array(
        'label' => __('Section Description', 'kaiyun-sports'),
        'section' => 'download_app_sections',
        'type' => 'textarea',
        'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
    ));

    // Tabs (labels)
    $wp_customize->add_setting('app_section_tabs', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('app_section_tabs', array(
        'label' => __('Tab Titles (comma-separated)', 'kaiyun-sports'),
        'section' => 'download_app_sections',
        'type' => 'text',
        'description' => __('Ví dụ: Toàn site,Thể thao,Người thật,Đăng nhập', 'kaiyun-sports'),
        'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
    ));

    // Repeater UI (simple): number of tabs + per-tab fields
    $wp_customize->add_setting('app_tabs_count', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('app_tabs_count', array(
        'label' => __('Số lượng tabs', 'kaiyun-sports'),
        'section' => 'download_app_sections',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 8, 'step' => 1),
        'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
        'description' => __('Điền số tab, lưu lại rồi kéo xuống để điền nội dung từng tab.', 'kaiyun-sports'),
    ));

    // Register controls for up to 8 tabs to simulate an "Add" experience
    for ($i = 1; $i <= 8; $i++) {
        $active_cb = function() use ($i) {
            $enabled = (bool) get_theme_mod('app_section_1_enabled', false);
            $count = absint(get_theme_mod('app_tabs_count', 1));
            return $enabled && $i <= max(1, $count);
        };

        $wp_customize->add_setting("app_tab_{$i}_title", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("app_tab_{$i}_title", array(
            'label' => sprintf(__('Tab %d - Title', 'kaiyun-sports'), $i),
            'section' => 'download_app_sections',
            'type' => 'text',
            'active_callback' => $active_cb,
        ));

        $wp_customize->add_setting("app_tab_{$i}_dir", array('default' => '', 'sanitize_callback' => 'wp_kses_post'));
        $wp_customize->add_control("app_tab_{$i}_dir", array(
            'label' => sprintf(__('Tab %d - Description', 'kaiyun-sports'), $i),
            'section' => 'download_app_sections',
            'type' => 'textarea',
            'active_callback' => $active_cb,
        ));

        $wp_customize->add_setting("app_tab_{$i}_image", array('default' => 0, 'sanitize_callback' => 'absint'));
        if (class_exists('WP_Customize_Media_Control')) {
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "app_tab_{$i}_image", array(
                'label' => sprintf(__('Tab %d - Visual Header Images', 'kaiyun-sports'), $i),
                'section' => 'download_app_sections',
                'mime_type' => 'image',
                'active_callback' => $active_cb,
            )));
        }

        $wp_customize->add_setting("app_tab_{$i}_qr", array('default' => 0, 'sanitize_callback' => 'absint'));
        if (class_exists('WP_Customize_Media_Control')) {
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "app_tab_{$i}_qr", array(
                'label' => sprintf(__('Tab %d - QR Image', 'kaiyun-sports'), $i),
                'section' => 'download_app_sections',
                'mime_type' => 'image',
                'active_callback' => $active_cb,
            )));
        }

        $wp_customize->add_setting("app_tab_{$i}_url", array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("app_tab_{$i}_url", array(
            'label' => sprintf(__('Tab %d - Download URL', 'kaiyun-sports'), $i),
            'section' => 'download_app_sections',
            'type' => 'url',
            'active_callback' => $active_cb,
        ));
    }

    // Per-tab QR image IDs (comma-separated) and per-tab URLs (comma-separated)
    $wp_customize->add_setting('app_section_tab_qr_ids', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('app_section_tab_qr_ids', array(
        'label' => __('QR Image IDs for tabs (comma-separated)', 'kaiyun-sports'),
        'section' => 'download_app_sections',
        'type' => 'text',
        'description' => __('Mỗi tab tương ứng 1 ID ảnh QR (hoặc để trống).', 'kaiyun-sports'),
        'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
    ));

    $wp_customize->add_setting('app_section_tab_urls', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('app_section_tab_urls', array(
        'label' => __('Download URLs for tabs (comma-separated)', 'kaiyun-sports'),
        'section' => 'download_app_sections',
        'type' => 'text',
        'description' => __('Mỗi tab tương ứng 1 URL tải (có thể để trống).', 'kaiyun-sports'),
        'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
    ));

    // Visual images for left block
    $wp_customize->add_setting('app_section_visual_header', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    if (class_exists('WP_Customize_Multiple_Media_Control')) {
        $wp_customize->add_control(new WP_Customize_Multiple_Media_Control($wp_customize, 'app_section_visual_header', array(
            'label' => __('Visual Header Images (multiple)', 'kaiyun-sports'),
            'section' => 'download_app_sections',
            'mime_type' => 'image',
            'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
        )));
    } else {
        $wp_customize->add_control('app_section_visual_header', array(
            'label' => __('Visual Header Image IDs (comma-separated)', 'kaiyun-sports'),
            'section' => 'download_app_sections',
            'type' => 'text',
            'active_callback' => function() { return (bool) get_theme_mod('app_section_1_enabled', false); },
        ));
    }

    // Games Section
    $wp_customize->add_section('games_section', array(
        'title' => __('Games Section', 'kaiyun-sports'),
        'priority' => 90,
    ));

    // Enable Games Section
    $wp_customize->add_setting('games_section_enabled', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('games_section_enabled', array(
        'label' => __('Enable Games Section', 'kaiyun-sports'),
        'section' => 'games_section',
        'type' => 'checkbox',
    ));

    // Games Section Title Image
    $wp_customize->add_setting('games_section_title_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'games_section_title_image', array(
        'label' => __('Games Section Title Image', 'kaiyun-sports'),
        'section' => 'games_section',
        'settings' => 'games_section_title_image',
        'mime_type' => 'image',
        'active_callback' => function() { return get_theme_mod('games_section_enabled', true); },
    )));

    // Number of Games Tabs
    $wp_customize->add_setting('games_tabs_count', array(
        'default' => 7,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('games_tabs_count', array(
        'label' => __('Number of Games Tabs', 'kaiyun-sports'),
        'section' => 'games_section',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10,
            'step' => 1,
        ),
        'description' => __('Set number of tabs, save and scroll down to configure each tab.', 'kaiyun-sports'),
        'active_callback' => function() { return get_theme_mod('games_section_enabled', true); },
    ));

    // Games Tab Fields (up to 10 tabs)
    for ($i = 1; $i <= 10; $i++) {
        $active_cb = function() use ($i) {
            $enabled = get_theme_mod('games_section_enabled', true);
            $count = absint(get_theme_mod('games_tabs_count', 7));
            return $enabled && $i <= max(1, $count);
        };

        // Tab Name
        $default_tab_names = [
            1 => '体育赛事',
            2 => '真人娱乐', 
            3 => '棋牌游戏',
            4 => '电子竞技',
            5 => '彩票投注',
            6 => '电子游艺',
            7 => '娱乐游戏'
        ];
        
        $wp_customize->add_setting("games_tab_{$i}_name", array(
            'default' => isset($default_tab_names[$i]) ? $default_tab_names[$i] : '',
            'sanitize_callback' => function($input) {
                return wp_kses_post($input); // giữ Unicode, HTML cơ bản
            },
        ));
        $wp_customize->add_control("games_tab_{$i}_name", array(
            'label' => sprintf(__('Tab %d - Name', 'kaiyun-sports'), $i),
            'section' => 'games_section',
            'type' => 'text',
            'active_callback' => $active_cb,
        ));

        // Left Section Image (games-left-section)
        $wp_customize->add_setting("games_tab_{$i}_left_image", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "games_tab_{$i}_left_image", array(
            'label' => sprintf(__('Tab %d - Left Section Image', 'kaiyun-sports'), $i),
            'section' => 'games_section',
            'settings' => "games_tab_{$i}_left_image",
            'mime_type' => 'image',
            'description' => __('Image for games-left-section (main display image)', 'kaiyun-sports'),
            'active_callback' => $active_cb,
        )));

        // Sports Title Image
        $wp_customize->add_setting("games_tab_{$i}_sports_title_image", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "games_tab_{$i}_sports_title_image", array(
            'label' => sprintf(__('Tab %d - Sports Title Image', 'kaiyun-sports'), $i),
            'section' => 'games_section',
            'settings' => "games_tab_{$i}_sports_title_image",
            'mime_type' => 'image',
            'description' => __('Image for sports-title-image in right section', 'kaiyun-sports'),
            'active_callback' => $active_cb,
        )));

        // Return Rate Number
        $wp_customize->add_setting("games_tab_{$i}_return_rate", array(
            'default' => $i == 1 ? '1.18' : '0.00',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("games_tab_{$i}_return_rate", array(
            'label' => sprintf(__('Tab %d - Return Rate', 'kaiyun-sports'), $i),
            'section' => 'games_section',
            'type' => 'text',
            'description' => __('Enter rate without % symbol (e.g., 1.18)', 'kaiyun-sports'),
            'active_callback' => $active_cb,
        ));

        // Sports Description
        $wp_customize->add_setting("games_tab_{$i}_description", array(
            'default' => $i == 1 ? '业内最高赔率，覆盖世界各地赛事，让球、大小、半全场、波胆、单双、总入球、连串过关等多元竞猜。更有动画直播、视频直播，让您轻松体验聊球投注，乐在其中。' : '',
            'sanitize_callback' => 'wp_kses_post',
        ));
        $wp_customize->add_control("games_tab_{$i}_description", array(
            'label' => sprintf(__('Tab %d - Description', 'kaiyun-sports'), $i),
            'section' => 'games_section',
            'type' => 'textarea',
            'active_callback' => $active_cb,
        ));

        // Number of Providers for this tab
        $default_providers_count = [
            1 => 4,  // 体育赛事
            2 => 4,  // 真人娱乐
            3 => 4,  // 棋牌游戏
            4 => 4,  // 电子竞技
            5 => 4,  // 彩票投注
            6 => 4,  // 电子游艺
            7 => 4   // 娱乐游戏
        ];
        
        $wp_customize->add_setting("games_tab_{$i}_providers_count", array(
            'default' => isset($default_providers_count[$i]) ? $default_providers_count[$i] : 0,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control("games_tab_{$i}_providers_count", array(
            'label' => sprintf(__('Tab %d - Number of Providers', 'kaiyun-sports'), $i),
            'section' => 'games_section',
            'type' => 'number',
            'input_attrs' => array(
                'min' => 0,
                'max' => 8,
                'step' => 1,
            ),
            'description' => __('Set number of providers for this tab', 'kaiyun-sports'),
            'active_callback' => $active_cb,
        ));

        // Provider Fields (up to 8 providers per tab)
        for ($j = 1; $j <= 8; $j++) {
            $provider_active_cb = function() use ($i, $j) {
                $enabled = get_theme_mod('games_section_enabled', true);
                $tab_count = absint(get_theme_mod('games_tabs_count', 7));
                $default_providers_count = [
                    1 => 4, 2 => 4, 3 => 4, 4 => 4, 5 => 4, 6 => 4, 7 => 4
                ];
                $default_count = isset($default_providers_count[$i]) ? $default_providers_count[$i] : 0;
                $provider_count = absint(get_theme_mod("games_tab_{$i}_providers_count", $default_count));
                return $enabled && $i <= max(1, $tab_count) && $j <= max(0, $provider_count);
            };

            // Provider Name
            $default_provider_names = [
                1 => ['开云体育', '熊猫体育', 'IM体育', 'FB体育'],
                2 => ['AG真人', 'BBIN真人', 'EVO真人', 'SA真人'],
                3 => ['开元棋牌', '博雅棋牌', 'JJ棋牌', '欢乐棋牌'],
                4 => ['雷火电竞', '完美电竞', 'VPGAME', 'IM电竞'],
                5 => ['时时彩', '11选5', '快3', '排列3'],
                6 => ['PT电子', 'MG电子', 'PP电子', 'CQ9电子'],
                7 => ['捕鱼达人', '水果机', '老虎机', '百家乐']
            ];
            $default_name = '';
            if (isset($default_provider_names[$i]) && $j <= count($default_provider_names[$i])) {
                $default_name = $default_provider_names[$i][$j-1];
            }
            
            $wp_customize->add_setting("games_tab_{$i}_provider_{$j}_name", array(
                'default' => $default_name,
                'sanitize_callback' => function($input) {
                    return wp_kses_post($input); // không strip ký tự Trung/Hoa
                },
            ));
            $wp_customize->add_control("games_tab_{$i}_provider_{$j}_name", array(
                'label' => sprintf(__('Tab %d - Provider %d Name', 'kaiyun-sports'), $i, $j),
                'section' => 'games_section',
                'type' => 'text',
                'active_callback' => $provider_active_cb,
            ));

            // Provider Normal Image
            $wp_customize->add_setting("games_tab_{$i}_provider_{$j}_image", array(
                'default' => '',
                'sanitize_callback' => 'absint',
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "games_tab_{$i}_provider_{$j}_image", array(
                'label' => sprintf(__('Tab %d - Provider %d Normal Image', 'kaiyun-sports'), $i, $j),
                'section' => 'games_section',
                'settings' => "games_tab_{$i}_provider_{$j}_image",
                'mime_type' => 'image',
                'description' => __('Normal state provider icon', 'kaiyun-sports'),
                'active_callback' => $provider_active_cb,
            )));

            // Provider Active Image
            $wp_customize->add_setting("games_tab_{$i}_provider_{$j}_active_image", array(
                'default' => '',
                'sanitize_callback' => 'absint',
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "games_tab_{$i}_provider_{$j}_active_image", array(
                'label' => sprintf(__('Tab %d - Provider %d Active Image', 'kaiyun-sports'), $i, $j),
                'section' => 'games_section',
                'settings' => "games_tab_{$i}_provider_{$j}_active_image",
                'mime_type' => 'image',
                'description' => __('Active/hover state provider icon', 'kaiyun-sports'),
                'active_callback' => $provider_active_cb,
            )));
        }
    }

    // Removed: Visual Body Images per request
}
add_action('customize_register', 'kaiyun_sports_customize_register');

// Helper functions for Games Section
function get_games_section_data() {
    
    // Check if games section is enabled first
    if (!get_theme_mod('games_section_enabled', true)) {
        return false;
    }
    
    // Debug: Log customizer data
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Games Section Debug - Enabled: ' . get_theme_mod('games_section_enabled'));
        error_log('Games Section Debug - Tabs Count: ' . get_theme_mod('games_tabs_count'));
    }
    
    // Always force fresh data from customizer (no fallbacks)
    // Clear any potential caching issues
    wp_cache_flush();
    
    $tabs_count = absint(get_theme_mod('games_tabs_count', 7));
    
    $tabs_data = array();
    
    for ($i = 1; $i <= $tabs_count; $i++) {
        $tab_name = get_theme_mod("games_tab_{$i}_name", '');
        if (empty($tab_name)) {
            $tab_name = "Tab {$i}";
        }
        
        $default_providers_count = [
            1 => 4, 2 => 4, 3 => 4, 4 => 4, 5 => 4, 6 => 4, 7 => 4
        ];
        $default_count = isset($default_providers_count[$i]) ? $default_providers_count[$i] : 0;
        $providers_count = absint(get_theme_mod("games_tab_{$i}_providers_count", $default_count));
        $providers = array();
        
        for ($j = 1; $j <= $providers_count; $j++) {
            $default_provider_names = [
                1 => ['开云体育', '熊猫体育', 'IM体育', 'FB体育'],
                2 => ['AG真人', 'BBIN真人', 'EVO真人', 'SA真人'],
                3 => ['开元棋牌', '博雅棋牌', 'JJ棋牌', '欢乐棋牌'],
                4 => ['雷火电竞', '完美电竞', 'VPGAME', 'IM电竞'],
                5 => ['时时彩', '11选5', '快3', '排列3'],
                6 => ['PT电子', 'MG电子', 'PP电子', 'CQ9电子'],
                7 => ['捕鱼达人', '水果机', '老虎机', '百家乐']
            ];
            $default_name = '';
            if (isset($default_provider_names[$i]) && $j <= count($default_provider_names[$i])) {
                $default_name = $default_provider_names[$i][$j-1];
            }
            
            $provider_name = get_theme_mod("games_tab_{$i}_provider_{$j}_name", $default_name);
            if (empty($provider_name)) continue;
            
            $provider_image = get_theme_mod("games_tab_{$i}_provider_{$j}_image", '');
            $provider_active_image = get_theme_mod("games_tab_{$i}_provider_{$j}_active_image", '');
            
            $providers[] = array(
                'name' => $provider_name,
                'image' => $provider_image ? wp_get_attachment_url($provider_image) : '',
                'active_image' => $provider_active_image ? wp_get_attachment_url($provider_active_image) : '',
            );
        }
        
        $tabs_data[] = array(
            'name' => $tab_name,
            'left_image' => get_theme_mod("games_tab_{$i}_left_image", '') ? wp_get_attachment_url(get_theme_mod("games_tab_{$i}_left_image", '')) : '',
            'sports_title_image' => get_theme_mod("games_tab_{$i}_sports_title_image", '') ? wp_get_attachment_url(get_theme_mod("games_tab_{$i}_sports_title_image", '')) : '',
            'return_rate' => get_theme_mod("games_tab_{$i}_return_rate", '0.00'),
            'description' => get_theme_mod("games_tab_{$i}_description", ''),
            'providers' => $providers,
        );
    }
    
    $result = array(
        'title_image' => get_theme_mod('games_section_title_image', '') ? wp_get_attachment_url(get_theme_mod('games_section_title_image', '')) : '',
        'tabs' => $tabs_data,
    );
    
    // Debug: Log final result
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Games Section Debug - Final tabs count: ' . count($tabs_data));
        foreach ($tabs_data as $index => $tab) {
            error_log('Games Section Debug - Tab ' . $index . ': ' . $tab['name']);
        }
    }
    
    return $result;
}


// Add Customizer JavaScript for Live Section
function kaiyun_sports_customizer_live_section_script() {
    ?>
    <script type="text/javascript">
    (function($) {
        wp.customize.bind('ready', function() {
            // Function to toggle match fields visibility
            function toggleMatchFields() {
                var matchCount = wp.customize('live_matches_count').get();
                var enabled = wp.customize('live_section_enabled').get();
                
                for (var i = 1; i <= 8; i++) {
                    var shouldShow = enabled && i <= matchCount;
                    
                    // List of all field types for each match
                    var fieldTypes = [
                        'league', 'league_logo', 'status', 'time',
                        'team1_name', 'team1_logo', 'team1_score',
                        'team2_name', 'team2_logo', 'team2_score',
                        'streamer_name', 'streamer_avatar'
                    ];
                    
                    fieldTypes.forEach(function(fieldType) {
                        var controlId = 'live_match_' + i + '_' + fieldType;
                        var control = wp.customize.control(controlId);
                        if (control) {
                            if (shouldShow) {
                                control.container.show();
                            } else {
                                control.container.hide();
                            }
                        }
                    });
                }
            }
            
            // Initial toggle
            toggleMatchFields();
            
            // Listen for changes
            wp.customize('live_matches_count', function(value) {
                value.bind(toggleMatchFields);
            });
            
            wp.customize('live_section_enabled', function(value) {
                value.bind(toggleMatchFields);
            });
            
            // Games Section Dynamic Controls
            function toggleGamesTabFields() {
                var enabled = wp.customize('games_section_enabled').get();
                var tabsCount = parseInt(wp.customize('games_tabs_count').get()) || 7;
                
                // Show/hide tab fields
                for (var i = 1; i <= 10; i++) {
                    var showTab = enabled && i <= tabsCount;
                    wp.customize.control('games_tab_' + i + '_name').active.set(showTab);
                    wp.customize.control('games_tab_' + i + '_left_image').active.set(showTab);
                    wp.customize.control('games_tab_' + i + '_sports_title_image').active.set(showTab);
                    wp.customize.control('games_tab_' + i + '_return_rate').active.set(showTab);
                    wp.customize.control('games_tab_' + i + '_description').active.set(showTab);
                    wp.customize.control('games_tab_' + i + '_providers_count').active.set(showTab);
                    
                    // Show/hide provider fields
                    var providersCount = parseInt(wp.customize('games_tab_' + i + '_providers_count').get()) || 0;
                    for (var j = 1; j <= 8; j++) {
                        var showProvider = showTab && j <= providersCount;
                        wp.customize.control('games_tab_' + i + '_provider_' + j + '_name').active.set(showProvider);
                        wp.customize.control('games_tab_' + i + '_provider_' + j + '_image').active.set(showProvider);
                        wp.customize.control('games_tab_' + i + '_provider_' + j + '_active_image').active.set(showProvider);
                    }
                }
            }
            
            // Listen for changes
            wp.customize('games_section_enabled', function(value) {
                value.bind(toggleGamesTabFields);
            });
            
            wp.customize('games_tabs_count', function(value) {
                value.bind(toggleGamesTabFields);
            });
            
            // Listen for provider count changes
            for (var i = 1; i <= 10; i++) {
                wp.customize('games_tab_' + i + '_providers_count', function(value) {
                    value.bind(toggleGamesTabFields);
                });
            }
            
            // Initial call
            toggleGamesTabFields();
        });
    })(jQuery);
    </script>
    <?php
}
add_action('customize_controls_print_footer_scripts', 'kaiyun_sports_customizer_live_section_script');

// Helpers: show App Section 2 controls only when enabled
if (!function_exists('kaiyun_sports_app_section_2_active')) {
    function kaiyun_sports_app_section_2_active() {
        return (bool) get_theme_mod('app_section_2_enabled', false);
    }
}

// Load custom menu walkers
require get_template_directory() . '/inc/class-kaiyun-menu-walker.php';
require get_template_directory() . '/inc/class-kaiyun-utility-menu-walker.php';

// Load custom controls only when customizer is available
function kaiyun_sports_load_custom_controls() {
    if (class_exists('WP_Customize_Control')) {
        // Try to load advanced control first
        if (file_exists(get_template_directory() . '/inc/class-multiple-media-control.php')) {
            require get_template_directory() . '/inc/class-multiple-media-control.php';
        }
        
        // Load simple fallback control
        if (file_exists(get_template_directory() . '/inc/class-simple-media-control.php')) {
            require get_template_directory() . '/inc/class-simple-media-control.php';
        }
    }
}
add_action('customize_register', 'kaiyun_sports_load_custom_controls', 1);

// AJAX handler for getting image data
function kaiyun_sports_get_image_data() {
    // Check nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'customize-controls')) {
        wp_send_json_error('Invalid nonce');
        return;
    }
    
    $image_id = intval($_POST['image_id']);
    
    if ($image_id) {
        $image = wp_get_attachment_image_src($image_id, 'thumbnail');
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        $image_title = get_the_title($image_id);
        
        if ($image) {
            wp_send_json_success(array(
                'id' => $image_id,
                'url' => $image[0],
                'title' => $image_title,
                'alt' => $image_alt,
                'width' => $image[1],
                'height' => $image[2]
            ));
        } else {
            wp_send_json_error('Image not found');
        }
    } else {
        wp_send_json_error('Invalid image ID');
    }
}
add_action('wp_ajax_get_image_data', 'kaiyun_sports_get_image_data');

// ========== Category term media (icon + banner) meta fields ==========
// Add fields on Add form
add_action('category_add_form_fields', function() {
    ?>
    <div class="form-field term-logo-wrap">
        <label for="term_logo_id">分类图标 (Icon)</label>
        <input type="hidden" id="term_logo_id" name="term_logo_id" value="" />
        <div id="term_logo_preview" style="margin-top:6px;"></div>
        <p><button type="button" class="button upload-term-media" data-target="term_logo_id" data-preview="term_logo_preview">选择图标</button></p>
    </div>
    <div class="form-field term-banner-wrap">
        <label for="term_banner_id">分类横幅 (Banner)</label>
        <input type="hidden" id="term_banner_id" name="term_banner_id" value="" />
        <div id="term_banner_preview" style="margin-top:6px;"></div>
        <p><button type="button" class="button upload-term-media" data-target="term_banner_id" data-preview="term_banner_preview">选择横幅</button></p>
    </div>
    <div class="form-field term-subtext-wrap">
        <label for="term_subtext">分类文案 (Sub text)</label>
        <input type="text" id="term_subtext" name="term_subtext" value="" />
        <p class="description">可选，显示在图标右侧标题下方。</p>
    </div>
    <?php
});

// Add fields on Edit form
add_action('category_edit_form_fields', function($term) {
    $logo_id = get_term_meta($term->term_id, 'term_logo_id', true);
    $banner_id = get_term_meta($term->term_id, 'term_banner_id', true);
    $subtext = get_term_meta($term->term_id, 'term_subtext', true);
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'thumbnail') : '';
    $banner_url = $banner_id ? wp_get_attachment_image_url($banner_id, 'large') : '';
    ?>
    <tr class="form-field">
        <th scope="row"><label for="term_logo_id">分类图标 (Icon)</label></th>
        <td>
            <input type="hidden" id="term_logo_id" name="term_logo_id" value="<?php echo esc_attr($logo_id); ?>" />
            <div id="term_logo_preview" style="margin-top:6px;">
                <?php if ($logo_url) echo '<img src="' . esc_url($logo_url) . '" style="max-width:80px;height:auto;border:1px solid #ccd;" />'; ?>
            </div>
            <p><button type="button" class="button upload-term-media" data-target="term_logo_id" data-preview="term_logo_preview">选择图标</button></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="term_banner_id">分类横幅 (Banner)</label></th>
        <td>
            <input type="hidden" id="term_banner_id" name="term_banner_id" value="<?php echo esc_attr($banner_id); ?>" />
            <div id="term_banner_preview" style="margin-top:6px;">
                <?php if ($banner_url) echo '<img src="' . esc_url($banner_url) . '" style="max-width:300px;height:auto;border:1px solid #ccd;" />'; ?>
            </div>
            <p><button type="button" class="button upload-term-media" data-target="term_banner_id" data-preview="term_banner_preview">选择横幅</button></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="term_subtext">分类文案 (Sub text)</label></th>
        <td>
            <input type="text" id="term_subtext" name="term_subtext" value="<?php echo esc_attr($subtext); ?>" class="regular-text" />
        </td>
    </tr>
    <?php
});

// Save term meta
add_action('created_category', function($term_id){
    if (isset($_POST['term_logo_id'])) {
        update_term_meta($term_id, 'term_logo_id', absint($_POST['term_logo_id']));
    }
    if (isset($_POST['term_banner_id'])) {
        update_term_meta($term_id, 'term_banner_id', absint($_POST['term_banner_id']));
    }
    if (isset($_POST['term_subtext'])) {
        update_term_meta($term_id, 'term_subtext', sanitize_text_field($_POST['term_subtext']));
    }
});
add_action('edited_category', function($term_id){
    if (isset($_POST['term_logo_id'])) {
        update_term_meta($term_id, 'term_logo_id', absint($_POST['term_logo_id']));
    }
    if (isset($_POST['term_banner_id'])) {
        update_term_meta($term_id, 'term_banner_id', absint($_POST['term_banner_id']));
    }
    if (isset($_POST['term_subtext'])) {
        update_term_meta($term_id, 'term_subtext', sanitize_text_field($_POST['term_subtext']));
    }
});

// Enqueue media on term screens
add_action('admin_enqueue_scripts', function($hook){
    if ($hook === 'edit-tags.php' || $hook === 'term.php') {
        wp_enqueue_media();
        wp_add_inline_script('jquery', "
            jQuery(function($){
                $(document).on('click', '.upload-term-media', function(e){
                    e.preventDefault();
                    var target = $('#' + $(this).data('target'));
                    var previewId = $(this).data('preview');
                    var frame = wp.media({ title: 'Select image', multiple: false, library: { type: 'image' } });
                    frame.on('select', function(){
                        var att = frame.state().get('selection').first().toJSON();
                        target.val(att.id);
                        var \$img = jQuery('<img>').attr('src', att.url).css({maxWidth:'300px', height:'auto', border:'1px solid #ccd'});
                        jQuery('#' + previewId).empty().append(\$img);
                    });
                    frame.open();
                });
            });
        ");
    }
});

// Handle custom registration password fields (validate and set password)
add_action('register_post', function($user_login, $user_email, $errors){
    if (isset($_POST['password'], $_POST['password_confirm'])) {
        $pwd = (string) $_POST['password'];
        $pwd2 = (string) $_POST['password_confirm'];
        if ($pwd !== $pwd2) {
            $errors->add('password_mismatch', __('<strong>错误</strong>：两次输入的密码不一致。'));
        }
        if (strlen($pwd) < 6) {
            $errors->add('password_short', __('<strong>错误</strong>：密码长度至少 6 个字符。'));
        }
    } else {
        $errors->add('password_missing', __('<strong>错误</strong>：请输入密码并确认。'));
    }
}, 10, 3);

add_action('user_register', function($user_id){
    if (!empty($_POST['password'])) {
        wp_set_password((string) $_POST['password'], $user_id);
    }
});

// Fully handle custom registration from theme page (bypass wp-login endpoint)
add_action('init', function() {
    if (!isset($_POST['ky_register'])) {
        return;
    }
    if (!isset($_POST['ky_reg_nonce']) || !wp_verify_nonce($_POST['ky_reg_nonce'], 'ky_reg_nonce_action')) {
        wp_die(__('安全校验失败，请重试。'));
    }
    // Allow Unicode usernames
    $username = isset($_POST['user_login']) ? sanitize_user(wp_unslash($_POST['user_login']), false) : '';
    $email    = isset($_POST['user_email']) ? sanitize_email(wp_unslash($_POST['user_email'])) : '';
    $pwd      = isset($_POST['password']) ? (string) $_POST['password'] : '';
    $pwd2     = isset($_POST['password_confirm']) ? (string) $_POST['password_confirm'] : '';

    $errors = new WP_Error();
    if ($username === '' || $email === '' || $pwd === '' || $pwd2 === '') {
        $errors->add('required', __('请完整填写所有字段。'));
    }
    if ($pwd !== $pwd2) {
        $errors->add('mismatch', __('两次输入的密码不一致。'));
    }
    if (strlen($pwd) < 6) {
        $errors->add('short', __('密码长度至少 6 个字符。'));
    }
    if (username_exists($username)) {
        $errors->add('user_exists', __('用户名已存在。'));
    }
    if (!is_email($email) || email_exists($email)) {
        $errors->add('email_invalid', __('邮箱无效或已被使用。'));
    }

    if ($errors->has_errors()) {
        // Store errors in a transient to display after redirect back
        set_transient('ky_reg_errors', $errors->get_error_messages(), 120);
        wp_safe_redirect(wp_get_referer() ? wp_get_referer() : home_url('/'));
        exit;
    }

    $user_id = wp_insert_user(array(
        'user_login' => $username,
        'user_pass'  => $pwd,
        'user_email' => $email,
        'role'       => 'subscriber'
    ));

    if (is_wp_error($user_id)) {
        set_transient('ky_reg_errors', array($user_id->get_error_message()), 120);
        wp_safe_redirect(wp_get_referer() ? wp_get_referer() : home_url('/'));
        exit;
    }

    // Auto login
    $creds = array('user_login' => $username, 'user_password' => $pwd, 'remember' => true);
    $user  = wp_signon($creds, is_ssl());
    $redirect = isset($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url('/');
    wp_safe_redirect($redirect ?: home_url('/'));
    exit;
});

// Custom login handler (theme-side)
add_action('init', function(){
    if (!isset($_POST['ky_login'])) { return; }
    if (!isset($_POST['ky_login_nonce']) || !wp_verify_nonce($_POST['ky_login_nonce'], 'ky_login_nonce_action')) {
        set_transient('ky_login_errors', array(__('安全校验失败，请重试。')), 120);
        wp_safe_redirect(wp_get_referer() ? wp_get_referer() : home_url('/'));
        exit;
    }
    $username = isset($_POST['log']) ? (string) wp_unslash($_POST['log']) : '';
    $password = isset($_POST['pwd']) ? (string) $_POST['pwd'] : '';
    $remember = !empty($_POST['rememberme']);
    if ($username === '' || $password === '') {
        set_transient('ky_login_errors', array(__('请输入账号和密码。')), 120);
        wp_safe_redirect(wp_get_referer() ? wp_get_referer() : home_url('/'));
        exit;
    }
    $user = wp_signon(array(
        'user_login' => $username,
        'user_password' => $password,
        'remember' => $remember,
    ), is_ssl());
    if (is_wp_error($user)) {
        set_transient('ky_login_errors', array($user->get_error_message()), 120);
        wp_safe_redirect(wp_get_referer() ? wp_get_referer() : home_url('/'));
        exit;
    }
    $redirect = isset($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url('/');
    wp_safe_redirect($redirect ?: home_url('/'));
    exit;
});

// Auto resize and optimize images on upload
function kaiyun_sports_handle_image_upload($attachment_id) {
    if (!wp_attachment_is_image($attachment_id)) {
        return;
    }
    
    $file_path = get_attached_file($attachment_id);
    if (!$file_path || !file_exists($file_path)) {
        return;
    }
    
    // Get image info
    $image_info = getimagesize($file_path);
    if (!$image_info) {
        return;
    }
    
    $width = $image_info[0];
    $height = $image_info[1];
    $mime_type = $image_info['mime'];
    
    // Define maximum dimensions
    $max_width = 1920;  // Reduced from 2560
    $max_height = 1080; // Reduced from 2560
    $quality = 85;      // JPEG quality
    
    // Check if resize is needed
    if ($width <= $max_width && $height <= $max_height) {
        return;
    }
    
    // Calculate new dimensions
    $ratio = min($max_width / $width, $max_height / $height);
    $new_width = intval($width * $ratio);
    $new_height = intval($height * $ratio);
    
    // Create new image resource
    switch ($mime_type) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($file_path);
            break;
        case 'image/png':
            $source = imagecreatefrompng($file_path);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($file_path);
            break;
        case 'image/webp':
            $source = imagecreatefromwebp($file_path);
            break;
        default:
            return;
    }
    
    if (!$source) {
        return;
    }
    
    // Create new image
    $new_image = imagecreatetruecolor($new_width, $new_height);
    
    // Preserve transparency for PNG and GIF
    if ($mime_type == 'image/png' || $mime_type == 'image/gif') {
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
        $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
        imagefilledrectangle($new_image, 0, 0, $new_width, $new_height, $transparent);
    }
    
    // Resize image
    imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Save resized image
    switch ($mime_type) {
        case 'image/jpeg':
            imagejpeg($new_image, $file_path, $quality);
            break;
        case 'image/png':
            imagepng($new_image, $file_path, 9);
            break;
        case 'image/gif':
            imagegif($new_image, $file_path);
            break;
        case 'image/webp':
            imagewebp($new_image, $file_path, $quality);
            break;
    }
    
    // Clean up
    imagedestroy($source);
    imagedestroy($new_image);
    
    // Update attachment metadata
    $metadata = wp_generate_attachment_metadata($attachment_id, $file_path);
    wp_update_attachment_metadata($attachment_id, $metadata);
}
add_action('add_attachment', 'kaiyun_sports_handle_image_upload');
add_action('wp_handle_upload', 'kaiyun_sports_handle_upload_resize');

// Handle upload resize
function kaiyun_sports_handle_upload_resize($upload) {
    if (isset($upload['file']) && wp_attachment_is_image($upload['file'])) {
        $attachment_id = attachment_url_to_postid($upload['url']);
        if ($attachment_id) {
            kaiyun_sports_handle_image_upload($attachment_id);
        }
    }
    return $upload;
}

// Increase upload limits
function kaiyun_sports_increase_upload_limits() {
    // Increase memory limit
    if (function_exists('ini_set')) {
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);
        ini_set('upload_max_filesize', '50M');
        ini_set('post_max_size', '50M');
        ini_set('max_input_time', 300);
    }
}
add_action('init', 'kaiyun_sports_increase_upload_limits');

// Add custom upload size limit
function kaiyun_sports_upload_size_limit($size) {
    return 50 * 1024 * 1024; // 50MB
}
add_filter('upload_size_limit', 'kaiyun_sports_upload_size_limit');

// Advanced image optimization
function kaiyun_sports_optimize_image($file_path, $quality = 85) {
    if (!file_exists($file_path)) {
        return false;
    }
    
    $image_info = getimagesize($file_path);
    if (!$image_info) {
        return false;
    }
    
    $mime_type = $image_info['mime'];
    $original_size = filesize($file_path);
    
    // Only optimize if file is larger than 100KB
    if ($original_size < 100 * 1024) {
        return true;
    }
    
    // Create image resource
    switch ($mime_type) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($file_path);
            break;
        case 'image/png':
            $source = imagecreatefrompng($file_path);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($file_path);
            break;
        case 'image/webp':
            $source = imagecreatefromwebp($file_path);
            break;
        default:
            return true;
    }
    
    if (!$source) {
        return false;
    }
    
    // Get dimensions
    $width = imagesx($source);
    $height = imagesy($source);
    
    // Create optimized image
    $optimized = imagecreatetruecolor($width, $height);
    
    // Preserve transparency
    if ($mime_type == 'image/png' || $mime_type == 'image/gif') {
        imagealphablending($optimized, false);
        imagesavealpha($optimized, true);
        $transparent = imagecolorallocatealpha($optimized, 255, 255, 255, 127);
        imagefilledrectangle($optimized, 0, 0, $width, $height, $transparent);
    }
    
    // Copy and optimize
    imagecopy($optimized, $source, 0, 0, 0, 0, $width, $height);
    
    // Save optimized image
    $temp_file = $file_path . '.tmp';
    $success = false;
    
    switch ($mime_type) {
        case 'image/jpeg':
            $success = imagejpeg($optimized, $temp_file, $quality);
            break;
        case 'image/png':
            $success = imagepng($optimized, $temp_file, 9);
            break;
        case 'image/gif':
            $success = imagegif($optimized, $temp_file);
            break;
        case 'image/webp':
            $success = imagewebp($optimized, $temp_file, $quality);
            break;
    }
    
    // Clean up
    imagedestroy($source);
    imagedestroy($optimized);
    
    if ($success && file_exists($temp_file)) {
        $new_size = filesize($temp_file);
        
        // Only replace if new file is smaller
        if ($new_size < $original_size) {
            rename($temp_file, $file_path);
            return true;
        } else {
            unlink($temp_file);
        }
    }
    
    return true;
}

// Hook into image upload to optimize
function kaiyun_sports_optimize_uploaded_image($attachment_id) {
    if (!wp_attachment_is_image($attachment_id)) {
        return;
    }
    
    $file_path = get_attached_file($attachment_id);
    if ($file_path && file_exists($file_path)) {
        kaiyun_sports_optimize_image($file_path);
    }
}
add_action('add_attachment', 'kaiyun_sports_optimize_uploaded_image');

// Create multiple image sizes for better performance
function kaiyun_sports_add_image_sizes() {
    // Hero banner sizes
    add_image_size('hero-banner-large', 1920, 1080, true);
    add_image_size('hero-banner-medium', 1200, 675, true);
    add_image_size('hero-banner-small', 800, 450, true);
    
    // General banner sizes
    add_image_size('banner-large', 1600, 900, true);
    add_image_size('banner-medium', 1200, 675, true);
    add_image_size('banner-small', 800, 450, true);
}
add_action('after_setup_theme', 'kaiyun_sports_add_image_sizes');

// Smart image selection for different screen sizes
function kaiyun_sports_get_optimized_image($attachment_id, $size = 'hero-banner-large') {
    if (!$attachment_id) {
        return false;
    }
    
    $image = wp_get_attachment_image_src($attachment_id, $size);
    if ($image) {
        return $image[0];
    }
    
    // Fallback to full size
    $image = wp_get_attachment_image_src($attachment_id, 'full');
    return $image ? $image[0] : false;
}

// Add custom post types
function kaiyun_sports_post_types() {
    // Sports Events
    register_post_type('sports_event', array(
        'labels' => array(
            'name' => 'Sự kiện thể thao',
            'singular_name' => 'Sự kiện thể thao',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-awards',
    ));
    
    // Games
    register_post_type('game', array(
        'labels' => array(
            'name' => 'Game',
            'singular_name' => 'Game',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-games',
    ));
}
add_action('init', 'kaiyun_sports_post_types');

// Add custom taxonomies
function kaiyun_sports_taxonomies() {
    // Game Categories
    register_taxonomy('game_category', 'game', array(
        'labels' => array(
            'name' => 'Danh mục game',
            'singular_name' => 'Danh mục game',
        ),
        'hierarchical' => true,
        'public' => true,
    ));
    
    // Sports Categories
    register_taxonomy('sports_category', 'sports_event', array(
        'labels' => array(
            'name' => 'Danh mục thể thao',
            'singular_name' => 'Danh mục thể thao',
        ),
        'hierarchical' => true,
        'public' => true,
    ));
}
add_action('init', 'kaiyun_sports_taxonomies');

// Add widget areas
function kaiyun_sports_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'kaiyun-sports'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'kaiyun-sports'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widgets', 'kaiyun-sports'),
        'id' => 'footer-widgets',
        'description' => __('Add widgets here.', 'kaiyun-sports'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="footer-widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'kaiyun_sports_widgets_init');

// Custom excerpt length
function kaiyun_sports_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'kaiyun_sports_excerpt_length');

// Custom excerpt more
function kaiyun_sports_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'kaiyun_sports_excerpt_more');

// Clear cache when theme is active
function kaiyun_sports_clear_cache() {
    if (current_user_can('manage_options') && isset($_GET['clear_cache'])) {
        // Clear WordPress cache
        wp_cache_flush();
        
        // Clear object cache
        if (function_exists('wp_cache_delete')) {
            wp_cache_delete('alloptions', 'options');
        }
        
        // Clear autoload cache
        delete_option('_transient_theme_mods_' . get_option('stylesheet'));
        
        echo '<div style="background: #2ecc71; color: white; padding: 15px; margin: 20px; position: fixed; top: 20px; right: 20px; z-index: 9999;">';
        echo '<h3>✅ Cache Cleared!</h3>';
        echo '<p>All WordPress cache has been cleared.</p>';
        echo '<button onclick="this.parentElement.style.display=\'none\'">Remove</button>';
        echo '</div>';
    }
}
add_action('wp_loaded', 'kaiyun_sports_clear_cache');

// Debug function to check customizer data (only for admins)
function kaiyun_sports_debug_customizer_data() {
    if (current_user_can('manage_options') && isset($_GET['debug_games'])) {
        echo '<div style="background: #fff; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
        echo '<h3>Games Section Customizer Data Debug</h3>';
        
        echo '<p><strong>Games Section Enabled:</strong> ' . (get_theme_mod('games_section_enabled', true) ? 'Yes' : 'No') . '</p>';
        echo '<p><strong>Tabs Count:</strong> ' . get_theme_mod('games_tabs_count', 7) . '</p>';
        
        $tabs_count = absint(get_theme_mod('games_tabs_count', 7));
        
        for ($i = 1; $i <= $tabs_count; $i++) {
            echo '<h4>Tab ' . $i . ':</h4>';
            echo '<ul>';
            echo '<li>Name: ' . get_theme_mod("games_tab_{$i}_name", 'NOT SET') . '</li>';
            echo '<li>Left Image: ' . get_theme_mod("games_tab_{$i}_left_image", 'NOT SET') . '</li>';
            echo '<li>Sports Title Image: ' . get_theme_mod("games_tab_{$i}_sports_title_image", 'NOT SET') . '</li>';
            echo '<li>Return Rate: ' . get_theme_mod("games_tab_{$i}_return_rate", 'NOT SET') . '</li>';
            echo '<li>Description: ' . (get_theme_mod("games_tab_{$i}_description", '') ? 'SET' : 'NOT SET') . '</li>';
            echo '<li>Providers Count: ' . get_theme_mod("games_tab_{$i}_providers_count", 'NOT SET') . '</li>';
            echo '</ul>';
            
            // Show providers for this tab
            $providers_count = absint(get_theme_mod("games_tab_{$i}_providers_count", 0));
            if ($providers_count > 0) {
                echo '<p><strong>Providers:</strong></p><ul>';
                for ($j = 1; $j <= $providers_count; $j++) {
                    echo '<li>Provider ' . $j . ': ' . get_theme_mod("games_tab_{$i}_provider_{$j}_name", 'NOT SET') . '</li>';
                }
                echo '</ul>';
            }
        }
        
        echo '</div>';
    }
}
add_action('wp_footer', 'kaiyun_sports_debug_customizer_data');

// Add custom CSS for admin
function kaiyun_sports_admin_styles() {
    echo '<style>
        .wp-admin #wpbody-content .metabox-holder {
            padding-top: 20px;
        }
    </style>';
}
add_action('admin_head', 'kaiyun_sports_admin_styles');
?>

<?php get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <?php 
        $banner_images = get_theme_mod('hero_banner_images', '');
        $banner_urls = get_theme_mod('hero_banner_urls', '');
        $banner_alts = get_theme_mod('hero_banner_alts', '');
        $autoplay = get_theme_mod('hero_slider_autoplay', true);
        $interval = get_theme_mod('hero_slider_interval', 3000);
        
        // Ensure autoplay is properly converted to boolean
        $autoplay = filter_var($autoplay, FILTER_VALIDATE_BOOLEAN);
        
        if ($banner_images) {
            $image_ids = array_map('trim', explode(',', $banner_images));
            $urls = $banner_urls ? array_map('trim', explode(',', $banner_urls)) : array();
            $alts = $banner_alts ? array_map('trim', explode(',', $banner_alts)) : array();

            // Debug: Log slider settings
            error_log('Hero Slider Settings - Autoplay: ' . ($autoplay ? 'true' : 'false') . ', Interval: ' . $interval . ', Images: ' . count($image_ids));
            
            echo '<div class="hero-slider" data-autoplay="' . ($autoplay ? 'true' : 'false') . '" data-interval="' . esc_attr($interval) . '">';
            echo '<div class="slider-container">';
            
            foreach ($image_ids as $index => $image_id) {
                if ($image_id) {
                    $banner_src = wp_get_attachment_image_src($image_id, 'full');
                    if ($banner_src) {
                        $url = isset($urls[$index]) ? $urls[$index] : '';
                        $alt = isset($alts[$index]) ? $alts[$index] : 'Banner ' . ($index + 1);
                        
                        echo '<div class="slide' . ($index === 0 ? ' active' : '') . '">';
                        if ($url) {
                            echo '<a href="' . esc_url($url) . '" target="_blank">';
                        }
                        // Use optimized image size
                        $optimized_src = kaiyun_sports_get_optimized_image($image_id, 'hero-banner-large');
                        $image_url = $optimized_src ? $optimized_src : $banner_src[0];
                        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($alt) . '" class="hero-banner-image">';
                        if ($url) {
                            echo '</a>';
                        }
                        echo '</div>';
                    }
                }
            }
            
            echo '</div>';
            
            // Navigation dots
            if (count($image_ids) > 1) {
                echo '<div class="slider-dots">';
                foreach ($image_ids as $index => $image_id) {
                    if ($image_id) {
                        echo '<span class="dot' . ($index === 0 ? ' active' : '') . '" data-slide="' . $index . '"></span>';
                    }
                }
                echo '</div>';
            }
            
            // Navigation arrows
            if (count($image_ids) > 1) {
                echo '<button class="slider-prev">‹</button>';
                echo '<button class="slider-next">›</button>';
            }
            
            echo '</div>';
        } else {
            // Fallback content when no banner images
            echo '<div class="hero-content">';
            echo '<h1 class="hero-title">' . esc_html(get_theme_mod('hero_title', '')) . '</h1>';
            echo '<p class="hero-subtitle">' . esc_html(get_theme_mod('hero_subtitle', '')) . '</p>';
            echo '<div class="hero-cta">';
            echo '<a href="' . esc_url(get_theme_mod('hero_btn1_link', '')) . '" class="btn btn-primary">' . esc_html(get_theme_mod('hero_btn1_text', '')) . '</a>';
            echo '<a href="' . esc_url(get_theme_mod('hero_btn2_link', '')) . '" class="btn btn-secondary">' . esc_html(get_theme_mod('hero_btn2_text', '')) . '</a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </section>

    <!-- Partners Section -->
    <section class="partners-section">
        <div class="container">
            <div class="partners-grid">
                <?php
                $partners_images = get_theme_mod('partners_images', '');
                $partners_names = get_theme_mod('partners_names', '');
                $partners_urls = get_theme_mod('partners_urls', '');

                // Default partner data if no custom images
                $default_partners = array();

                if ($partners_images) {
                    // Use custom images
                    $image_ids = array_map('trim', explode(',', $partners_images));
                    $names = $partners_names ? array_map('trim', explode(',', $partners_names)) : array();
                    $urls = $partners_urls ? array_map('trim', explode(',', $partners_urls)) : array();

                    // Limit to 7 partners
                    $image_ids = array_slice($image_ids, 0, 7);

                    foreach ($image_ids as $index => $image_id) {
                        if ($image_id) {
                            $partner_src = wp_get_attachment_image_src($image_id, 'thumbnail');
                            $name = isset($names[$index]) ? $names[$index] : 'Partner ' . ($index + 1);
                            $url = isset($urls[$index]) ? $urls[$index] : '';

                            echo '<div class="partner-item">';
                            if ($url) {
                                echo '<a href="' . esc_url($url) . '" target="_blank" style="text-decoration: none; color: inherit;">';
                            }
                            if ($partner_src) {
                                // Use full size to avoid WordPress hard-cropped thumbnails
                                $full_src = wp_get_attachment_image_src($image_id, 'full');
                                $display_src = $full_src ? $full_src[0] : $partner_src[0];
                                echo '<div class="partner-img"><img src="' . esc_url($display_src) . '" alt="' . esc_attr($name) . '" class="partner-image"></div>';
                            } else {
                                // Fallback to default logo
                                $default_logo = isset($default_partners[$index]) ? $default_partners[$index]['logo'] : 'P';
                                echo '<div class="partner-img"><div class="partner-logo">' . esc_html($default_logo) . '</div></div>';
                            }
                            if ($url) {
                                echo '</a>';
                            }
                            echo '</div>';
                        }
                    }
                } else {
                    // Use default partners
                    foreach ($default_partners as $index => $partner) {
                        echo '<div class="partner-item">';
                        echo '<div class="partner-logo">' . esc_html($partner['logo']) . '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- App Download Section (single based on Customizer) -->
    <?php if (get_theme_mod('app_section_1_enabled', false)): ?>
        <?php 
        $title_text = get_theme_mod('app_section_title_text', '');
        $title_img_id = intval(get_theme_mod('app_section_title_image', 0));
        $title_img_src = $title_img_id ? wp_get_attachment_image_src($title_img_id, 'full') : false;
        $desc = get_theme_mod('app_section_desc', '');
        $header_images = get_theme_mod('app_section_visual_header', '');
        $body_images = ''; // Removed per request
        // Build tabs from repeater (count + per-tab fields)
        $tabs_struct = array();
        $tabs_count = max(1, absint(get_theme_mod('app_tabs_count', 1)));
        for ($i = 1; $i <= $tabs_count; $i++) {
            $t = array(
                'title' => get_theme_mod('app_tab_' . $i . '_title', ''),
                'dir' => get_theme_mod('app_tab_' . $i . '_dir', ''),
                'image_id' => absint(get_theme_mod('app_tab_' . $i . '_image', 0)),
                'qr_id' => absint(get_theme_mod('app_tab_' . $i . '_qr', 0)),
                'url' => get_theme_mod('app_tab_' . $i . '_url', ''),
            );
            if (!empty($t['title']) || !empty($t['dir']) || $t['image_id'] || $t['qr_id'] || !empty($t['url'])) {
                $tabs_struct[] = $t;
            }
        }

        // Build client payload with resolved URLs for image/qr
        $tabs_payload = array();
        foreach ($tabs_struct as $tab) {
            $img_url = '';
            $qr_url = '';
            if (!empty($tab['image_id'])) {
                $img_src = wp_get_attachment_image_src($tab['image_id'], 'full');
                $img_url = $img_src ? $img_src[0] : '';
            }
            if (!empty($tab['qr_id'])) {
                $qr_src = wp_get_attachment_image_src($tab['qr_id'], 'full');
                $qr_url = $qr_src ? $qr_src[0] : '';
            }
            $tabs_payload[] = array(
                'title' => $tab['title'],
                'dir' => $tab['dir'],
                'image_url' => $img_url,
                'qr_url' => $qr_url,
                'url' => $tab['url'],
            );
        }
        ?>
    <section class="app-section">
            <?php if ($title_img_src || !empty($title_text)): ?>
                <div class="app-section-title">
                    <?php if ($title_img_src): ?>
                        <img src="<?php echo esc_url($title_img_src[0]); ?>" alt="title" class="app-title-hero">
                    <?php else: ?>
                        <h2 class="app-title-hero-text"><?php echo esc_html($title_text); ?></h2>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="container app-download-wrap" data-app-tabs='<?php echo esc_attr(wp_json_encode($tabs_payload)); ?>'>
                <div class="app-visual app-visual-hero">
                    <?php // Use image of first tab (per-tab visual)
                    $first_visual_id = isset($tabs_struct[0]['image_id']) ? absint($tabs_struct[0]['image_id']) : 0;
                    if ($first_visual_id) {
                        $src = wp_get_attachment_image_src($first_visual_id, 'full');
                        if ($src): ?>
                            <div class="app-visual-header"><img data-role="visual-image" src="<?php echo esc_url($src[0]); ?>"
                                    alt="mockup"></div>
                        <?php endif; 
                    } elseif (!empty($header_images)) { // fallback global visuals if provided
                        $h_ids = array_filter(array_map('trim', explode(',', $header_images))); ?>
                        <div class="app-visual-header">
                            <?php foreach ($h_ids as $hid):
                                $src = wp_get_attachment_image_src(intval($hid), 'full');
                                if ($src): ?>
                                <img data-role="visual-image" src="<?php echo esc_url($src[0]); ?>" alt="mockup">
                            <?php endif; endforeach; ?>
                        </div>
                    <?php } ?>
                    </div>
                <div class="app-card app-card-elevated">
                    <div class="app-card-header">
                        <?php if (!empty($tabs_struct)): ?>
                            <div class="app-tabs app-tabs-right">
                                <?php foreach ($tabs_struct as $t_index => $tab): ?>
                                    <button
                                        class="app-tab<?php echo $t_index === 0 ? ' active' : ''; ?>"><?php echo esc_html($tab['title']); ?></button>
                                <?php endforeach; ?>
                    </div>
                        <?php endif; ?>
                        <?php if (!empty($tabs_struct)): ?>
                            <?php $first_dir = isset($tabs_struct[0]['dir']) ? $tabs_struct[0]['dir'] : ''; ?>
                            <p class="app-desc-left" data-role="tab-dir"><?php echo wp_kses_post($first_dir); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="app-card-body compact">
                        <?php $first_qr_id = isset($tabs_struct[0]['qr_id']) ? intval($tabs_struct[0]['qr_id']) : 0;
                        $first_qr_src = $first_qr_id ? wp_get_attachment_image_src($first_qr_id, 'full') : false;
                        $first_url = isset($tabs_struct[0]['url']) ? $tabs_struct[0]['url'] : ''; ?>
                        <div class="app-qr app-qr-box" data-role="qr-box" <?php echo $first_qr_src ? '' : ' style="display:none;"'; ?>>
                            <?php if ($first_qr_src): ?>
                                <img data-role="qr-image" src="<?php echo esc_url($first_qr_src[0]); ?>" alt="QR">
                                <div class="app-qr-caption">扫码下载 支持iOS&Android</div>
                            <?php endif; ?>
                </div>
                        <div class="app-links-list" data-role="links" <?php echo !empty($first_url) ? '' : ' style="display:none;"'; ?>>
                            <?php if (!empty($first_url)): ?>
                                <a class="app-link-text" href="<?php echo esc_url($first_url); ?>" target="_blank"
                                    rel="noopener"><?php echo esc_html($first_url); ?></a>
                            <?php endif; ?>
            </div>
                    </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (get_theme_mod('live_section_enabled', false)): ?>
    <!-- Live Section -->
    <section class="live-section">
        <div class="container">
            <?php 
            $live_title_text = get_theme_mod('live_section_title_text', '');
            $live_title_image_id = get_theme_mod('live_section_title_image', '');
            
            // Show title (image has priority over text)
            if ($live_title_image_id) {
                $live_title_image_url = wp_get_attachment_image_src($live_title_image_id, 'full');
                if ($live_title_image_url) {
                    echo '<div class="live-section-title">';
                    echo '<img src="' . esc_url($live_title_image_url[0]) . '" alt="' . esc_attr($live_title_text) . '" class="live-title-image">';
                    echo '</div>';
                }
            } elseif ($live_title_text) {
                echo '<div class="live-section-title">';
                echo '<h2 class="section-title">' . esc_html($live_title_text) . '</h2>';
                echo '</div>';
            }
            ?>
            
            <div class="live-section-wrapper">
                <!-- Filter and Search Bar -->
                <div class="live-filter-bar">
                    <div class="live-filters">
                        <div class="filter-tabs">
                            <div class="filter-tab active">
                                <span>全部</span>
                            </div>
                        </div>
                        <div class="filter-divider"></div>
                        <ul class="sport-filters">
                            <span class="sport-filter active">足球</span>
                        </ul>
                    </div>
                    <input maxlength="60" placeholder="搜索主播" class="live-search-input" value="">
                </div>

                <!-- Live Matches Slider -->
                <div class="live-matches-container">
                    <div class="swiper-container live-swiper">
                        <div class="swiper-wrapper">
                            <?php 
                            $matches_count = get_theme_mod('live_matches_count', 3);
                            for ($i = 1; $i <= $matches_count; $i++):
                                $league = get_theme_mod("live_match_{$i}_league", '');
                                $league_logo_id = get_theme_mod("live_match_{$i}_league_logo", '');
                                $status = get_theme_mod("live_match_{$i}_status", 'live');
                                $time = get_theme_mod("live_match_{$i}_time", '');
                                $team1_name = get_theme_mod("live_match_{$i}_team1_name", '');
                                $team1_logo_id = get_theme_mod("live_match_{$i}_team1_logo", '');
                                $team1_score = get_theme_mod("live_match_{$i}_team1_score", '');
                                $team2_name = get_theme_mod("live_match_{$i}_team2_name", '');
                                $team2_logo_id = get_theme_mod("live_match_{$i}_team2_logo", '');
                                $team2_score = get_theme_mod("live_match_{$i}_team2_score", '');
                                $streamer_name = get_theme_mod("live_match_{$i}_streamer_name", '');
                                $streamer_avatar_id = get_theme_mod("live_match_{$i}_streamer_avatar", '');

                                // Skip if no essential data
                                    if (!$league && !$team1_name && !$team2_name)
                                        continue;

                                $league_logo_url = $league_logo_id ? wp_get_attachment_image_src($league_logo_id, 'thumbnail')[0] : '';
                                $team1_logo_url = $team1_logo_id ? wp_get_attachment_image_src($team1_logo_id, 'thumbnail')[0] : '';
                                $team2_logo_url = $team2_logo_id ? wp_get_attachment_image_src($team2_logo_id, 'thumbnail')[0] : '';
                                $streamer_avatar_url = $streamer_avatar_id ? wp_get_attachment_image_src($streamer_avatar_id, 'thumbnail')[0] : '';
                            ?>
                                    <div class="swiper-slide live-match-slide" data-league="<?php echo esc_attr($league); ?>"
                                        data-league-logo="<?php echo esc_url($league_logo_url); ?>"
                                        data-status="<?php echo esc_attr($status); ?>"
                                        data-time="<?php echo esc_attr($time); ?>"
                                        data-team1-name="<?php echo esc_attr($team1_name); ?>"
                                        data-team1-logo="<?php echo esc_url($team1_logo_url); ?>"
                                        data-team1-score="<?php echo esc_attr($team1_score); ?>"
                                        data-team2-name="<?php echo esc_attr($team2_name); ?>"
                                        data-team2-logo="<?php echo esc_url($team2_logo_url); ?>"
                                        data-team2-score="<?php echo esc_attr($team2_score); ?>"
                                        data-streamer-name="<?php echo esc_attr($streamer_name); ?>"
                                        data-streamer-avatar="<?php echo esc_url($streamer_avatar_url); ?>">
                                <div class="live-match-card">
                                    <div class="match-header">
                                        <div class="league-info" title="<?php echo esc_attr($league); ?>">
                                            <?php if ($league_logo_url): ?>
                                                        <img src="<?php echo esc_url($league_logo_url); ?>"
                                                            alt="<?php echo esc_attr($league); ?>">
                                            <?php endif; ?>
                                            <div><?php echo esc_html($league); ?></div>
                                        </div>
                                        <span class="match-status">
                                            <?php if ($status === 'live'): ?>
                                                直播中
                                            <?php else: ?>
                                                <?php 
                                                if ($time) {
                                                    $date_time = explode(' ', $time);
                                                    echo esc_html($date_time[0]);
                                                    if (isset($date_time[1])) {
                                                        echo '<span>' . esc_html($date_time[1]) . '</span>';
                                                    }
                                                }
                                                ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>

                                    <div class="match-teams">
                                        <div class="teams-info">
                                            <div class="team">
                                                <?php if ($status === 'live' && $team1_score): ?>
                                                    <div class="team-score"><?php echo esc_html($team1_score); ?></div>
                                                <?php endif; ?>
                                                <div class="team-logo">
                                                    <?php if ($team1_logo_url): ?>
                                                                <img src="<?php echo esc_url($team1_logo_url); ?>" width="20"
                                                                    height="20" loading="eager"
                                                                    alt="<?php echo esc_attr($team1_name); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                        <p title="<?php echo esc_attr($team1_name); ?>">
                                                            <?php echo esc_html($team1_name); ?></p>
                                            </div>
                                            <div class="team">
                                                <?php if ($status === 'live' && $team2_score): ?>
                                                    <div class="team-score"><?php echo esc_html($team2_score); ?></div>
                                                <?php endif; ?>
                                                <div class="team-logo">
                                                    <?php if ($team2_logo_url): ?>
                                                                <img src="<?php echo esc_url($team2_logo_url); ?>" width="20"
                                                                    height="20" loading="eager"
                                                                    alt="<?php echo esc_attr($team2_name); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                        <p title="<?php echo esc_attr($team2_name); ?>">
                                                            <?php echo esc_html($team2_name); ?></p>
                                            </div>
                                        </div>

                                        <?php if ($streamer_name): ?>
                                        <div class="streamer-info">
                                            <div class="streamer-avatar">
                                                <?php if ($streamer_avatar_url): ?>
                                                                <img src="<?php echo esc_url($streamer_avatar_url); ?>"
                                                                    alt="<?php echo esc_attr($streamer_name); ?>">
                                                <?php endif; ?>
                                                <div class="avatar-overlay"></div>
                                            </div>
                                            <div class="streamer-name"><?php echo esc_html($streamer_name); ?></div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>
            </div>
                    </div>
                    <div class="live-swiper-button-next"></div>
                    <div class="live-swiper-button-prev"></div>
                </div>

                <!-- Match Details and Betting Section -->
                <div class="live-match-details">
                    <div class="match-detail-header">
                        <div class="selected-match-info">
                            <div class="match-teams-display">
                                <?php
                                // Get first match data for initial display
                                $first_team1_name = get_theme_mod('live_match_1_team1_name', 'Team 1');
                                $first_team2_name = get_theme_mod('live_match_1_team2_name', 'Team 2');
                                $first_team1_logo_id = get_theme_mod('live_match_1_team1_logo', '');
                                $first_team2_logo_id = get_theme_mod('live_match_1_team2_logo', '');
                                $first_team1_score = get_theme_mod('live_match_1_team1_score', '0');
                                $first_team2_score = get_theme_mod('live_match_1_team2_score', '0');
                                
                                $first_team1_logo_url = $first_team1_logo_id ? wp_get_attachment_image_src($first_team1_logo_id, 'thumbnail')[0] : '';
                                $first_team2_logo_url = $first_team2_logo_id ? wp_get_attachment_image_src($first_team2_logo_id, 'thumbnail')[0] : '';
                                ?>
                                <div class="team-display">
                                        <span class="team-name" id="detail-team1-name"
                                            title="<?php echo esc_attr($first_team1_name); ?>"><?php echo esc_html($first_team1_name); ?></span>
                                    <div class="team-logo-display">
                                        <div class="team-logo-wrapper">
                                                <img id="detail-team1-logo"
                                                    src="<?php echo esc_url($first_team1_logo_url); ?>" width="48"
                                                    height="48" alt="<?php echo esc_attr($first_team1_name); ?>" <?php echo !$first_team1_logo_url ? 'style="display:none;"' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="match-score-display">
                                        <p id="detail-team1-score"><?php echo esc_html($first_team1_score); ?></p>
                                        <p>:</p>
                                        <p id="detail-team2-score"><?php echo esc_html($first_team2_score); ?></p>
                                </div>
                                <div class="team-display">
                                    <div class="team-logo-display">
                                        <div class="team-logo-wrapper">
                                                <img id="detail-team2-logo"
                                                    src="<?php echo esc_url($first_team2_logo_url); ?>" width="48"
                                                    height="48" alt="<?php echo esc_attr($first_team2_name); ?>" <?php echo !$first_team2_logo_url ? 'style="display:none;"' : ''; ?>>
                                            </div>
                                        </div>
                                        <span class="team-name" id="detail-team2-name"
                                            title="<?php echo esc_attr($first_team2_name); ?>"><?php echo esc_html($first_team2_name); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Live Stream and Chat Area -->
                    <div class="live-stream-area">
                        <div class="stream-container">
                                <div class="stream-placeholder" id="stream-content">
                                <?php
                                // Get first match data for stream area
                                $first_league = get_theme_mod('live_match_1_league', '');
                                $first_status = get_theme_mod('live_match_1_status', 'live');
                                $first_streamer = get_theme_mod('live_match_1_streamer_name', '');
                                
                                if ($first_league || $first_team1_name || $first_team2_name) {
                                    if ($first_status === 'live') {
                                        echo '<div class="live-stream-info">';
                                            if ($first_league)
                                                echo '<h3 id="stream-league">' . esc_html($first_league) . '</h3>';
                                            echo '<p id="stream-teams">' . esc_html($first_team1_name) . ' vs ' . esc_html($first_team2_name) . '</p>';
                                        echo '<p class="live-indicator">🔴 LIVE</p>';
                                            if ($first_streamer)
                                                echo '<p id="stream-streamer">Streamer: ' . esc_html($first_streamer) . '</p>';
                                        echo '</div>';
                                    } else {
                                        $first_time = get_theme_mod('live_match_1_time', '');
                                        echo '<div class="scheduled-stream-info">';
                                            if ($first_league)
                                                echo '<h3 id="stream-league">' . esc_html($first_league) . '</h3>';
                                            echo '<p id="stream-teams">' . esc_html($first_team1_name) . ' vs ' . esc_html($first_team2_name) . '</p>';
                                            if ($first_time)
                                                echo '<p class="scheduled-time" id="stream-time">' . esc_html($first_time) . '</p>';
                                            if ($first_streamer)
                                                echo '<p id="stream-streamer">Streamer: ' . esc_html($first_streamer) . '</p>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>Live stream will be displayed here</p>';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="live-chat-area">
                            <div class="chat-container">
                                <div class="chat-messages" id="chatScrollBox">
                                    <div class="chat-scroll-wrapper" id="chat-scroll_warpper">
                                        <?php if ($first_league || $first_team1_name || $first_team2_name): ?>
                                                <div class="match-chat-header" id="chat-header">
                                                    <p><strong id="chat-teams"><?php echo esc_html($first_team1_name); ?> vs
                                                            <?php echo esc_html($first_team2_name); ?></strong></p>
                                            <?php if ($first_league): ?>
                                                        <p class="chat-league" id="chat-league">
                                                            <?php echo esc_html($first_league); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                        <p class="login-prompt">请<span> 登录 </span>后再参与发言</p>
                                    </div>
                                </div>
                                <div class="chat-input-area">
                                    <div class="app-download-prompt">
                                        <div class="qr-code-container">
                                            <canvas height="52" width="52" style="height: 65px; width: 65px;"></canvas>
                                        </div>
                                        <div class="download-text">
                                            <p class="download-title">下载APP享受晒<br>单的快乐</p>
                                            <p class="download-subtitle">"码"上下载</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Betting Options -->
                        <!-- <div class="betting-section">
                        <div class="betting-options">
                            <div class="betting-group">
                                <span class="betting-title">独赢盘</span>
                                <div class="betting-choices">
                                    <div class="betting-option">
                                        <span class="option-label">主胜</span>
                                        <div class="option-odds">
                                            <div class="odds-value">1.11</div>
                                        </div>
                                    </div>
                                    <div class="betting-option">
                                        <span class="option-label">和局</span>
                                        <div class="option-odds">
                                            <div class="odds-value">5.70</div>
                                        </div>
                                    </div>
                                    <div class="betting-option">
                                        <span class="option-label">客胜</span>
                                        <div class="option-odds">
                                            <div class="odds-value">20.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="betting-group">
                                <span class="betting-title">让球盘</span>
                                <div class="betting-choices">
                                    <div class="betting-option">
                                        <span class="option-label">-0/0.5</span>
                                        <div class="option-odds">
                                            <div class="odds-value">2.36</div>
                                        </div>
                                    </div>
                                    <div class="betting-option">
                                        <span class="option-label">+0/0.5</span>
                                        <div class="option-odds">
                                            <div class="odds-value">1.55</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="betting-group">
                                <span class="betting-title">大小盘</span>
                                <div class="betting-choices">
                                    <div class="betting-option">
                                        <span class="option-label">大 3.5</span>
                                        <div class="option-odds">
                                            <div class="odds-value">1.83</div>
                                        </div>
                                    </div>
                                    <div class="betting-option">
                                        <span class="option-label">小 3.5</span>
                                        <div class="option-odds">
                                            <div class="odds-value">1.97</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="place-bet-button">投一注</div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Hot Games Section -->
    <?php
    // Get Games Section Data from Customizer
    $games_data = get_games_section_data();
    
    // Debug: Comprehensive debug info
    if (current_user_can('manage_options') && isset($_GET['debug'])) {
        echo '<div style="background: #fff; padding: 15px; margin: 20px; border: 2px solid #3498db; position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 350px; font-size: 12px;">';
        echo '<h3>🔍 DEBUG:</h3>';
        echo '<p><strong>Template:</strong> index.php</p>';
        echo '<p><strong>Games Data:</strong> ' . ($games_data ? '✅' : '❌') . '</p>';
        echo '<p><strong>Section Enabled:</strong> ' . (get_theme_mod('games_section_enabled', true) ? '✅' : '❌') . '</p>';
        echo '<p><strong>Tabs Count:</strong> ' . get_theme_mod('games_tabs_count', 7) . '</p>';
        if ($games_data) {
            echo '<p><strong>Data Tabs:</strong> ' . count($games_data['tabs']) . '</p>';
            echo '<p><strong>Will Render:</strong> ' . (!empty($games_data['tabs']) ? '✅' : '❌') . '</p>';
        }
        echo '<button onclick="this.parentElement.style.display=\'none\'">Close</button>';
        echo '</div>';
    }
    
    
    // print_r($games_data);
    
    if ($games_data && !empty($games_data['tabs'])):
        ?>
    <section class="games-section">
        <div class="container">
                <!-- Games Title Image -->
                <?php if (!empty($games_data['title_image'])): ?>
                    <div class="games-title-section">
                        <div class="games-title-image">
                            <img src="<?php echo esc_url($games_data['title_image']); ?>" alt="Games Title"
                                class="games-title-img">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Games Content -->
                <div class="games-content-wrapper">
                    <!-- Games Tabs -->
                    <div class="games-tabs-section">
                        <ul class="games-tabs-list">
                            <?php foreach ($games_data['tabs'] as $index => $tab): ?>
                                <li class="games-tab-item <?php echo $index === 0 ? 'active' : ''; ?>"
                                    data-tab="<?php echo $index; ?>">
                                    <span><?php echo esc_html($tab['name']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Games Main Content -->
                    <div class="games-main-content">
                        <?php foreach ($games_data['tabs'] as $index => $tab): ?>
                            <div class="games-tab-content <?php echo $index === 0 ? 'active' : ''; ?>"
                                data-tab="<?php echo $index; ?>">
                                <!-- Left Side - Main Image and Info -->
                                <div class="games-left-section">
                                    <div class="games-main-image">
                                        <?php if (!empty($tab['left_image'])): ?>
                                            <img src="<?php echo esc_url($tab['left_image']); ?>"
                                                alt="<?php echo esc_attr($tab['name']); ?>" class="main-sports-img">
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Right Side - Info and Providers -->
                                <div class="games-right-section">
                                    <!-- Sports Title and Return Rate -->
                                    <div class="sports-info-header">
                                        <?php if (!empty($tab['sports_title_image'])): ?>
                                            <div class="sports-title-image">
                                                <img src="<?php echo esc_url($tab['sports_title_image']); ?>"
                                                    alt="<?php echo esc_attr($tab['name']); ?>" class="sports-title-img">
                                            </div>
                                        <?php endif; ?>
                                        <div class="return-rate-info">
                                            <span class="rate-number"><?php echo esc_html($tab['return_rate']); ?><span
                                                    class="rate-percent">%</span></span>
                                            <span class="rate-label">最高返水</span>
                                        </div>
                                    </div>

                                    <!-- Sports Description -->
                                    <?php if (!empty($tab['description'])): ?>
                                        <div class="sports-description">
                                            <p><?php echo wp_kses_post($tab['description']); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Sports Providers -->
                                    <?php if (!empty($tab['providers'])): ?>
                                        <div class="sports-providers">
                                            <ul class="providers-list">
                                                <?php foreach ($tab['providers'] as $provider_index => $provider): ?>
                                                    <li class="provider-item <?php echo $provider_index === 0 ? 'active' : ''; ?>"
                                                        data-provider="<?php echo $provider_index; ?>">
                                                        <div class="provider-icon">
                                                            <?php if (!empty($provider['image'])): ?>
                                                                <img src="<?php echo esc_url($provider['image']); ?>"
                                                                    alt="<?php echo esc_attr($provider['name']); ?>"
                                                                    class="provider-icon-img">
                                                            <?php endif; ?>
                                                            <?php if (!empty($provider['active_image'])): ?>
                                                                <img src="<?php echo esc_url($provider['active_image']); ?>"
                                                                    alt="<?php echo esc_attr($provider['name']); ?>"
                                                                    class="provider-icon-active">
                                                            <?php endif; ?>
                                                        </div>
                                                        <p class="provider-name"><?php echo esc_html($provider['name']); ?></p>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                        </div>
        </section>
    <?php endif; ?>

    

    <!-- Quality Services Section -->
    <section class="services-section">
        <div class="container">
            <!-- Services Title Image -->
            <div class="services-title-section">
                <div class="services-title-image">
                    <img src="/wp-content/uploads/2025/10/homepage_title04-517629875d7dbcfe8dc623e75b5aebb7.png"
                        alt="Quality Services" class="services-title-img">
                </div>
            </div>

            <!-- Services Content -->
            <div class="services-content-wrapper">
                <!-- Progress Circle Services -->
                <div class="services-progress-section">
                    <div class="services-progress-grid">
                        <div class="service-progress-item">
                            <div class="progress-circle-container">
                                <div class="progress-text-overlay">
                                    <p class="progress-label">CURRENT SPEED</p>
                                    <p class="progress-number">60</p>
                                    <p class="progress-unit">秒</p>
                                </div>
                                <div class="progress-circle-wrapper bg-deposit glow">
                                    <canvas class="progress-circle" width="15rem" height="15rem"
                                        data-progress="60"></canvas>
                                </div>
                            </div>
                            <p class="service-main-title">平均存款时间</p>
                            <p class="service-sub-title">AVERAGE TIME OF DEPOSIT</p>
                        </div>

                        <div class="service-progress-item">
                            <div class="progress-circle-container">
                                <div class="progress-text-overlay">
                                    <p class="progress-label">TOTALLY AMOUNT</p>
                                    <p class="progress-number">80</p>
                                    <p class="progress-unit">家</p>
                                </div>
                                <div class="progress-circle-wrapper">
                                    <canvas class="progress-circle" width="128" height="128"
                                        data-progress="80"></canvas>
                                </div>
                            </div>
                            <p class="service-main-title">合作支付平台</p>
                            <p class="service-sub-title">PAYMENT PLATFORM PARTNERS</p>
                        </div>

                        <div class="service-progress-item">
                            <div class="progress-circle-container">
                                <div class="progress-text-overlay">
                                    <p class="progress-label">CURRENT SPEED</p>
                                    <p class="progress-number">90</p>
                                    <p class="progress-unit">秒</p>
                                </div>
                                <div class="progress-circle-wrapper">
                                    <canvas class="progress-circle" width="128" height="128"
                                        data-progress="90"></canvas>
                                </div>
                            </div>
                            <p class="service-main-title">平均取款时间</p>
                            <p class="service-sub-title">AVERAGE TIME OF WITHDRAW</p>
                        </div>

                        <div class="service-progress-item">
                            <div class="progress-circle-container">
                                <div class="progress-text-overlay">
                                    <p class="progress-label">TOTALLY AMOUNT</p>
                                    <p class="progress-number">32</p>
                                    <p class="progress-unit">家</p>
                                </div>
                                <div class="progress-circle-wrapper">
                                    <canvas class="progress-circle" width="128" height="128"
                                        data-progress="32"></canvas>
                                </div>
                            </div>
                            <p class="service-main-title">合作游戏平台</p>
                            <p class="service-sub-title">GAMING PROVIDER PARTNERS</p>
                        </div>
                    </div>
                </div>

                <!-- Feature Services -->
                <div class="services-features-section">
                    <div class="services-features-grid">
                        <div class="service-feature-item">
                            <div class="service-feature-icon">
                                <img src="/wp-content/uploads/2025/10/download-4.png" alt="Fast Deposit">
                            </div>
                            <div class="service-feature-content">
                                <p class="feature-title">极速存取转款</p>
                                <p class="feature-description">最新技术自主研发的财务处理系统真正做到极速存、取、转独家网络优化技术，为您提供一流的游戏体验，最大优化网络延迟。
                                </p>
                            </div>
                        </div>

                        <div class="service-feature-item">
                            <div class="service-feature-icon">
                                <img src="/wp-content/uploads/2025/10/download-1.png" alt="Multiple Events">
                            </div>
                            <div class="service-feature-content">
                                <p class="feature-title">海量赛事种类</p>
                                <p class="feature-description">每天为您提供近千场精彩体育赛事，更有真人、彩票、电子游戏等多种娱乐方式选择，让您拥有完美游戏体验。</p>
                            </div>
                        </div>

                        <div class="service-feature-item">
                            <div class="service-feature-icon">
                                <img src="/wp-content/uploads/2025/10/download-2.png" alt="Security">
                            </div>
                            <div class="service-feature-content">
                                <p class="feature-title">加密安全管理</p>
                                <p class="feature-description">
                                    独家开发，采用128位加密技术和严格的安全管理体系，客户资金得到最完善的保障，让您全情尽享娱乐、赛事投注、无后顾之忧！</p>
                            </div>
                        </div>

                        <div class="service-feature-item">
                            <div class="service-feature-icon">
                                <img src="/wp-content/uploads/2025/10/download-3.png" alt="Multi Platform">
                            </div>
                            <div class="service-feature-content">
                                <p class="feature-title">三端任您选择</p>
                                <p class="feature-description">
                                    引领市场的卓越技术，自主研发了全套终端应用，让您随时随地，娱乐投注随心所欲！7x24小时在线客服提供最贴心、最优质的服务。</p>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
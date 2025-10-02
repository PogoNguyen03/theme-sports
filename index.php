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
            echo '<h1 class="hero-title">' . esc_html(get_theme_mod('hero_title', 'Chào mừng đến với Kaiyun Sports')) . '</h1>';
            echo '<p class="hero-subtitle">' . esc_html(get_theme_mod('hero_subtitle', 'Trải nghiệm cá cược thể thao hàng đầu với tỷ lệ cược tốt nhất')) . '</p>';
            echo '<div class="hero-cta">';
            echo '<a href="' . esc_url(get_theme_mod('hero_btn1_link', '#')) . '" class="btn btn-primary">' . esc_html(get_theme_mod('hero_btn1_text', 'Đăng ký ngay')) . '</a>';
            echo '<a href="' . esc_url(get_theme_mod('hero_btn2_link', '#')) . '" class="btn btn-secondary">' . esc_html(get_theme_mod('hero_btn2_text', 'Tìm hiểu thêm')) . '</a>';
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
                $partners_names = get_theme_mod('partners_names', 'Real Madrid,Inter Milan,AC Milan,Crystal Palace,Bayer Leverkusen,Real Betis,Manchester United,Chelsea');
                $partners_urls = get_theme_mod('partners_urls', '');

                // Default partner data if no custom images
                $default_partners = array(
                    array('logo' => 'RM', 'name' => 'Real Madrid'),
                    array('logo' => 'IM', 'name' => 'Inter Milan'),
                    array('logo' => 'AC', 'name' => 'AC Milan'),
                    array('logo' => 'CP', 'name' => 'Crystal Palace'),
                    array('logo' => 'BL', 'name' => 'Bayer Leverkusen'),
                    array('logo' => 'RB', 'name' => 'Real Betis'),
                    array('logo' => 'MU', 'name' => 'Manchester United')
                );

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
                            <div class="app-visual-header"><img data-role="visual-image" src="<?php echo esc_url($src[0]); ?>" alt="mockup"></div>
                        <?php endif; 
                    } elseif (!empty($header_images)) { // fallback global visuals if provided
                        $h_ids = array_filter(array_map('trim', explode(',', $header_images))); ?>
                        <div class="app-visual-header">
                            <?php foreach ($h_ids as $hid): $src = wp_get_attachment_image_src(intval($hid), 'full'); if ($src): ?>
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
                                    <button class="app-tab<?php echo $t_index === 0 ? ' active' : ''; ?>"><?php echo esc_html($tab['title']); ?></button>
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
                        <div class="app-qr app-qr-box" data-role="qr-box"<?php echo $first_qr_src ? '' : ' style="display:none;"'; ?>>
                            <?php if ($first_qr_src): ?>
                                <img data-role="qr-image" src="<?php echo esc_url($first_qr_src[0]); ?>" alt="QR">
                                <div class="app-qr-caption">扫码下载 支持iOS&Android</div>
                            <?php endif; ?>
                </div>
                        <div class="app-links-list" data-role="links"<?php echo !empty($first_url) ? '' : ' style="display:none;"'; ?>>
                            <?php if (!empty($first_url)): ?>
                                <a class="app-link-text" href="<?php echo esc_url($first_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($first_url); ?></a>
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
            $live_title_text = get_theme_mod('live_section_title_text', 'Live Matches');
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
                                if (!$league && !$team1_name && !$team2_name) continue;

                                $league_logo_url = $league_logo_id ? wp_get_attachment_image_src($league_logo_id, 'thumbnail')[0] : '';
                                $team1_logo_url = $team1_logo_id ? wp_get_attachment_image_src($team1_logo_id, 'thumbnail')[0] : '';
                                $team2_logo_url = $team2_logo_id ? wp_get_attachment_image_src($team2_logo_id, 'thumbnail')[0] : '';
                                $streamer_avatar_url = $streamer_avatar_id ? wp_get_attachment_image_src($streamer_avatar_id, 'thumbnail')[0] : '';
                            ?>
                            <div class="swiper-slide live-match-slide" 
                                 data-league="<?php echo esc_attr($league); ?>"
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
                                                <img src="<?php echo esc_url($league_logo_url); ?>" alt="<?php echo esc_attr($league); ?>">
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
                                                        <img src="<?php echo esc_url($team1_logo_url); ?>" width="20" height="20" loading="eager" alt="<?php echo esc_attr($team1_name); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <p title="<?php echo esc_attr($team1_name); ?>"><?php echo esc_html($team1_name); ?></p>
                                            </div>
                                            <div class="team">
                                                <?php if ($status === 'live' && $team2_score): ?>
                                                    <div class="team-score"><?php echo esc_html($team2_score); ?></div>
                                                <?php endif; ?>
                                                <div class="team-logo">
                                                    <?php if ($team2_logo_url): ?>
                                                        <img src="<?php echo esc_url($team2_logo_url); ?>" width="20" height="20" loading="eager" alt="<?php echo esc_attr($team2_name); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <p title="<?php echo esc_attr($team2_name); ?>"><?php echo esc_html($team2_name); ?></p>
                                            </div>
                                        </div>

                                        <?php if ($streamer_name): ?>
                                        <div class="streamer-info">
                                            <div class="streamer-avatar">
                                                <?php if ($streamer_avatar_url): ?>
                                                    <img src="<?php echo esc_url($streamer_avatar_url); ?>" alt="<?php echo esc_attr($streamer_name); ?>">
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
                                    <span class="team-name" id="detail-team1-name" title="<?php echo esc_attr($first_team1_name); ?>"><?php echo esc_html($first_team1_name); ?></span>
                                    <div class="team-logo-display">
                                        <div class="team-logo-wrapper">
                                            <img id="detail-team1-logo" src="<?php echo esc_url($first_team1_logo_url); ?>" width="48" height="48" alt="<?php echo esc_attr($first_team1_name); ?>" <?php echo !$first_team1_logo_url ? 'style="display:none;"' : ''; ?>>
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
                                            <img id="detail-team2-logo" src="<?php echo esc_url($first_team2_logo_url); ?>" width="48" height="48" alt="<?php echo esc_attr($first_team2_name); ?>" <?php echo !$first_team2_logo_url ? 'style="display:none;"' : ''; ?>>
                                        </div>
                                    </div>
                                    <span class="team-name" id="detail-team2-name" title="<?php echo esc_attr($first_team2_name); ?>"><?php echo esc_html($first_team2_name); ?></span>
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
                                        if ($first_league) echo '<h3 id="stream-league">' . esc_html($first_league) . '</h3>';
                                        echo '<p id="stream-teams">' . esc_html($first_team1_name) . ' vs ' . esc_html($first_team2_name) . '</p>';
                                        echo '<p class="live-indicator">🔴 LIVE</p>';
                                        if ($first_streamer) echo '<p id="stream-streamer">Streamer: ' . esc_html($first_streamer) . '</p>';
                                        echo '</div>';
                                    } else {
                                        $first_time = get_theme_mod('live_match_1_time', '');
                                        echo '<div class="scheduled-stream-info">';
                                        if ($first_league) echo '<h3 id="stream-league">' . esc_html($first_league) . '</h3>';
                                        echo '<p id="stream-teams">' . esc_html($first_team1_name) . ' vs ' . esc_html($first_team2_name) . '</p>';
                                        if ($first_time) echo '<p class="scheduled-time" id="stream-time">' . esc_html($first_time) . '</p>';
                                        if ($first_streamer) echo '<p id="stream-streamer">Streamer: ' . esc_html($first_streamer) . '</p>';
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
                                            <p><strong id="chat-teams"><?php echo esc_html($first_team1_name); ?> vs <?php echo esc_html($first_team2_name); ?></strong></p>
                                            <?php if ($first_league): ?>
                                            <p class="chat-league" id="chat-league"><?php echo esc_html($first_league); ?></p>
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
    <section class="games-section">
        <div class="container">
            <!-- Games Title Image -->
            <div class="games-title-section">
                <div class="games-title-image">
                    <img src="/wp-content/uploads/2025/10/homepage_title03-8477e727dd0567923c277e35ed3ab2c4.png" alt="Hot Games" class="games-title-img">
                </div>
            </div>
            
            <!-- Games Content -->
            <div class="games-content-wrapper">
                <!-- Games Tabs -->
                <div class="games-tabs-section">
                    <ul class="games-tabs-list">
                        <li class="games-tab-item active">
                            <span>体育赛事</span>
                        </li>
                        <li class="games-tab-item">
                            <span>真人娱乐</span>
                        </li>
                        <li class="games-tab-item">
                            <span>棋牌游戏</span>
                        </li>
                        <li class="games-tab-item">
                            <span>电子竞技</span>
                        </li>
                        <li class="games-tab-item">
                            <span>彩票投注</span>
                        </li>
                        <li class="games-tab-item">
                            <span>电子游艺</span>
                        </li>
                        <li class="games-tab-item">
                            <span>娱乐游戏</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Games Main Content -->
                <div class="games-main-content">
                    <!-- Left Side - Main Image and Info -->
                    <div class="games-left-section">
                        <div class="games-main-image">
                            <img src="/wp-content/uploads/2025/10/1-1.png" alt="Sports Image" class="main-sports-img">
                        </div>
                    </div>
                    
                    <!-- Right Side - Info and Providers -->
                    <div class="games-right-section">
                        <!-- Sports Title and Return Rate -->
                        <div class="sports-info-header">
                            <div class="sports-title-image">
                                <img src="/wp-content/uploads/2025/10/1-2.png" alt="Sports Title" class="sports-title-img">
                            </div>
                            <div class="return-rate-info">
                                <span class="rate-number">1.18<span class="rate-percent">%</span></span>
                                <span class="rate-label">最高返水</span>
                            </div>
                        </div>
                        
                        <!-- Sports Description -->
                        <div class="sports-description">
                            <p>业内最高赔率，覆盖世界各地赛事，让球、大小、半全场、波胆、单双、总入球、连串过关等多元竞猜。更有动画直播、视频直播，让您轻松体验聊球投注，乐在其中。</p>
                        </div>
                        
                        <!-- Sports Providers -->
                        <div class="sports-providers">
                            <ul class="providers-list">
                                <li class="provider-item active">
                                    <div class="provider-icon">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAA51BMVEV3gKN3gKR4gKN4gKN5f6R2gKJ3gKNMaXFwgJ94gKN2f6R4gJ94gKKAgJ92f6R1gKV3gKJ3gJ91gJ96gKV4gKJ2gKR2gKR/gJ95gKZ4f6N5gJ95gKR3gKJ3f6J3f6R6f6V/gKB2f6J3gKN3f6R1f592f6J3gKR4gKN3gKN3gKJ5gKR4f6J2gKR1f6V4gKJ5f6R4f6J2f6R4gKR4f594gKJ4f6JwgJ94gJ95gJ94gKR2gKN4gKN4gKJ3f6J3gJ92gKJ3f6V4gKN3f6N4gKN1f593gKJ2gKZ3gKVwgKB/gKB5f6Z3f6V1gKX+YfkFAAAATXRSTlOAeEhAcFBAABCAOCBgCHAwWCAYMGhwOAgoSChwYGB4MAlQf3cYT3c/AV9vaG8wAW9nbwEgZ2ARISloAX9fWCFPWEdAARlXUFgRCChgMQtqZLkAAAAJcEhZcwAAFiUAABYlAUlSJPAAAAVOSURBVHic7Zhnk9woEIZbSCTl0shy2OTd2117g8/xoi/n//97rkAgUJhZZJev6qrUn2YA8ajfbqAR0P/AYIQMsVGuQTbKNchGuQbZKNcgG+UaZKNc/0O52CRbT5LPCGFh7IG0eNKFTybskyFJGINlpEFAFdzD0adAEqJ8qC00nYXX2zwQIhEBIjgws3mm22oF/LGQSaCjwKx3Zro7shgz3cqKZBAkBPDW6jfqgQSmja+tGM3mzBmCANJ6dNaVK7MYfjNGsxNHCLEZFNcT5qqFGUf4806L7wRhAKC1akiz7GB1QKwW4CcukAwgFbFvSyMahYVmwr1yWIq1j4NG41EIESFmOWs7MjWONoNeNeUJpVFwIKf7PDEjO44kQXcZLsSfgvmILUrBjp6GyGnK5IAjqC/EgZg5APCKRWBlyBEIZQiHyQFHwt408gG4mJ0juXh5MmgXbjtS9KeqfP8KIl6jm8bHIG1HWA1tzaM6ZEYHwHdDIC1HkuDwYrjLd9/5UqaoRy9wdwTpv97RQ8QDuHOHxE1HSI18Vg+ZhCt85q8b68+XsXGETIwjzE6sst7cyb5EIQlJvokt/Vg3iQ9DcOPkXeo/WAvuB36EZOaW08m2PldEKFNXCGs4Um/moe4u8+VGR+03SrOgTjgM3BXScEQnb6qLFhb4K+AExwHw8vezpWxRfaF1vh2HNBzRjFg/vAgI1jv9D8LJs4QWGxWYpTPEdkQzwrp3debXp0klZPqXh1RD5AqxdnSmGGlBqXqYzSJTQlS9XGRutdSZK6ReFIAVAyWUTtXDeBpDmvttSLyRq5S5Bt7sKKI8UhEn6pRhFyzIA+Aitb9mlbBcbMVIrkIGV04Qs6OIQ5VLN1gMajvJfqXTvZh4utruAaoKkABwIhdIxLdOELtEBNiJfST06jW2mosjRGRC1T/DcPWh2ALkDwu5VWAXiFVZAfdEUkViI8tVdxw1IcCFmHcAs7wQr8OnLhCrjpJKSQTUKdyByGxaeKrIX0HhAJm0lJrrHKCVbSNKuKh+dA5+I5t9Bdm9oA6QvGaEjaKb6f7ln9kGgG/VQF7K5lO8il9Reg+XDhCzEGfNxc/UABT+7b33+Plc+gPAY8kIeBkklH5/zhwgZkeZNiPE1IDlFkOaPRZqzaZvNiWj1znw3Wvx+LcuJZGJCGtGiKkRi3TNeSmylYbgxaKim60FD/9E6ZebqQNEh1mXkWGn5KaIxABz+bMo1ViR4g+M0qwT9j5I0Hpz0r2bspfveRWI+tYlcgBf9jtyqBaWz9EWJDbexkjVvPpYzgFWLxil805q9UG+queM2vKBWWQxwXxFr9nbf0SC8XN/gvFtROnbG+YAMZWo3qmWfXf5xSNZyQSeEczhpqD0j9sppde499YIR2sUYUm1GIR5ZooFfvluyznnMPPnlN7PhR8/oyobnoKYUrSe0PowUVojs1s8JW82cDGlp/NSyHSPvqAuEKNWdecUFhlXoLGJZ+XLnBCC4gck4ncaH2C0ISYAZ6ZxayBQ14/SFpM5CbMqH95tDjHaEJOv1uXA/iwBaf/HlFN0Yd2Zj0NM3O2iOQJLMUhPFh0E8V4f+S7VgqBOJi2WCaXPNhYEAHJdt1BKr3+Zx3B1UKoeiBXkdJVl2UoVPqIm4Q3OfouR7yNc7oGfXx7/vNZOYftDGgevuj1VmIC3OGrQ1Y9PfcFrQxIMXO4UwPlO34K1mzgAuf7q+QEublqDXCCUsrWPMUZh1PcwW6Pd8wpzfvF4Nn+VfL5Ptowx14+cHw8ZaCNkkI1yDbJRrkE2yjXIRrkG2SjXIBvlokPk+hfVKA51iM1VGgAAAABJRU5ErkJggg==" alt="开云体育" class="provider-icon-img">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAAilBMVEVMaXH////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////iVxWkAAAALXRSTlMAv94QAYBA3yD+75+QIWB/oO5vMHCPX76vUBGeQc/OYXGuUbBPMV6RoW4/zYEW6SfTAAAACXBIWXMAABYlAAAWJQFJUiTwAAAE5ElEQVR4nO1Y2ZLbKhQECQRosXZbli17PMudJDfn/38vBWKT7UnwTKUqD+onC2SaPxtHILRixYoVK1asWLHiT+DJZp/E6O+BNzgFBZzckicJ/zJD3GDwUC4Y8pk8zZIvUZRag0XnJt/cnOi+RsFyWjFHktpZ4o3C4bMcCTNe4J4ebqaPHkdkRnn7WHQ0AOle/87vkDA3Jvaej1gTHgk9ALNvb27NtfGE0KWPom0gR+lzoMqu96JHuCfkpEYKNyIWQfghOAAYWy1M83pDqx1CvBEQQVo2AEz63j5pyEGJxi1Yz4KJMlaKmT/4e1DpYj7wayF6h/zG6aiQD5cYoSMLjel579kHQmJ2m4ajfGh5mfNxkj8DioBaZoo/ENJfB5bOTSFV1O0o/3AJkMLzrIk/ENLc4ZgtrLbToyIFEI9l5bWQ9i4HUvufSdDT1dwfcS2EO9LlOjpRZERL2+2+ICS2z2Jzs58BD1SZ6fiYva6F9DY/fhc/JL2zh4+Bl0JKS9naV5ImzzK6X+QfVb4JROKEcD+wJlvcy3TKG9rQgWGvmBQAQzBJtfDy3jxUxuAlo0mu3HTaJtieK9L1USgHXwhpTTHvzH6nYc/OevCA0IaZ+ksqEJ8SYoKXGZcXjPYANJNVcRqqVzliWJ5A8E8IMRzY/HlkNNOVngxS5CFGb+bEeg4m8YUYjs5Mkj6j9jSZDRk9p7n2yzGUxKvoXHOwFiH95yI62hbCtC4UIJ9TvQglsUkBmebIY4S2et1qi4EN5TUJjpTLilDHu4oi2yPt8VKfMkVdsIGp85wQ/s2SQK6ysID6wYqiDlXRxwgVGMyZPKCN9ITYvsteWXWAQpJQlSDHwArpt4ggdi1CpEvtMZ836ggB0en4+ybqQ4sBXiKZqcewrtLvrKDuECJH7DVFOFmSzCeu7EAusqw9if8eFKIspSjAhrAlkSeU+iEDYkwhrRKEyLtwFTSkNCpL2dqY6PldQhRJbXrYOZoo1IoEB5WuwZJ0i6ab6/nL63iWYvGwaCTHqpddOglyiUvEaJn8XL+QP+H6uQbRUaOXzCf9JB1/DEpFV1G2Sw9x/cIeV8DOpxYhKmRwYXYqEHkBwCeZqbsHK8rSQ1y/MUbPACd1rnRibk/ZngKITKZnFBJbJi5NG9ndtNykp9g0kG+TfhcABlnOztFj8TvvnN72QYWUghdfXQOAqA6hQlwi6txzJNipxbnueZ+17wcQ7xFHpAnKdi3fpYUzF9gkI7uyEj0hRTGfwKJMsixqESp2IaHlOlFTqWwLAV7fOJ7KXElkPyshU5YU8mAkGX+8R5GIHUla2PfiLDpiGcDAykbWz+iHjIgGfcbtiyYPJpl1Gpso21DMRL0lY3OSZiJ92Bejs9Zkx1yiAGQeC9qcogulNMdR/0OaEIdxeA7Qp6DEzmOZnMWk0ZKmbLYqHsgxCuS4lxQI8dpjYU++GAMy5rXJ1Qf8nnujifKwAduOVzykoPX/4bcR7pYjLeRKhMT7GKE2ggWGbUEIIXKekLcOQx1qKrVntxDLz+dNfpnNxrOFGPXdnuWU5tkkvxIPj12v+U4GUc9fTzNNdM1jXuofvcGLMzGvJYTYma9gIzOL9KQlEPXu+2cuKPmeHg6Hvrl7u8n3/e4kZtSnw/e/eQXKOf/6JeeKFStWrFixYsW/gl+I4A6Vfp66jwAAAABJRU5ErkJggg==" alt="开云体育 Active" class="provider-icon-active">
                                    </div>
                                    <p class="provider-name">开云体育</p>
                                </li>
                                <li class="provider-item">
                                    <div class="provider-icon">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkBAMAAACCzIhnAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAkUExURUdwTHd/o3N/n3Z/o3V/pHd/o3V9o3h/nXR9oHd/onR/nwD//05TVk4AAAAMdFJOUwCADG40eEMiUWAYASRaW8QAAANASURBVHja7Va9UxNREL85M6CkWi6XIVSPCxLtvESGQAUECWB1AhmwIoqEMkQ+LEExUhLGAdNlKLBlxBnH8Z9zd+9d3n0EtNLmfsUl7+V+bz9+u/uixYgRI0aM/4Hc/Em73f7SLAvtrzCwMA4Io1m2/pKw6BChuCQN7P6RcWUTYW3WW/fB07sJ+msAMM2a2hkBeH8Xo/+IGJW6poBGDXEHo4WM1Qs09nW37PISgJi63StimK9yCwUoUnbnt7a2toH2xG2MKgBkmh8Bzhu8dmjN2cjfQnmLx9moyLrM1n0gHAERezMeAQCd+9nzYgY43fyc7qkgesCh+HJFGOKPF1GCd2amrikNXVSZ2IPRpxhKQ8YkP0U0W26UIQ0ZaQrQiBrJ+hiWxbKChFk1ACY2woykTSchQ9//4OBbxZrQWpJijNkOlAbDlHt0Gh50Re85RnNuqaE9lJQUVl7KToUpGIlzpmmL7F5NXNPed0k51JLfrmAomi7qimeglFTxC/bCiGqyLrBgEJ/U7o6bMC1K4fozp6lggt2UOCEcylgjwU9p/eiHeRE8ykKInpQqZAQXTCV3cNBREdrSsShFB9hwC2bVQRcnZwNVZ4rkfqsEZoDyAFLUkIziZsOyuhEyTvcASqGOmcHYb4BQaWAh/JLbN56UqGk2pIv9UtPJbRxF14EIXZijdvoGAuonzA6faMwGpw14qOvWPAwHQhlmI4bq1YD4KOJoK916ovkwwpGoBlbiy1h+Yhp3UFGFJhs54yTNbbfbzXLHte6VJQVVC3TlKRlJEWHRka4cC18wVmRc9As0YuDBYy1qlfHl40uhX8qOIPV5nA0GtKcmziPDMYHgrMrylz2W5yLYCGbTgTQyWJlxd3TVfUPnOfe4CDfLNNdxBkd3boHeWK53K8ZIRCffY6x8lroi1BWT5u+lQqGQz7KafsYPB1YEhsMMNdIq3dlDoayErpSMwHlMT01xeBR0k2B2/Iw3PO/2gqM9QfFMeAuWWaEElTrvToXuDbIj7dp+t/SSSRokdyjcUE4Qaw3+vi/8F7Z7wQ046FwI74BwHv4/kpPrLDoXwajNpPXgT0n5Saai0He3TzaXtBgxYsSI8Q/wG+HnqkQA/EvnAAAAAElFTkSuQmCC" alt="熊猫体育" class="provider-icon-img">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAA5UExURUdwTP///////////////////////////////////////////////////////////////////////308lk0AAAASdFJOUwCAQJ/vvwEg3xBwYO4wj89Qr+DEu0UAAANfSURBVHja7ZfdduMqDIXDnyXA2Fjv/7BngamEm+CknbmZs/iu7CZhS2xJhcdkMplMJpPJZPK/AnJUxriTw6io/eNvkoLZLX2BRsUM8HcFXL9+SNf4dfxjBb0hC1gTn6JfNiL8IxmvvhQs2U2/9IkKxv86iYNTaArPLC0KhN9JOFZwpwIknWPM6dER2Kv0i2p1nIXykIPZsZquz4ijahguiRV+6sVGDWfUYevD1jUFWP58p8IvdizjmQMS2vrgor8YYYg5iHE/SaMtYemEFZhIgu0Ew+eth1QQR0YV1TBIP7YlUId7WbiKLqhO8DONbSQhAF3ZHTH+MzuYAwbtt9M3Nq41/ERjf50FAEiImr6zKiKsGnr7gQY2CZ+3A1ucdj9UaZXF0TfQb1hrMSC9tX7nijrLTDniYsZjCzEmDdyJQiytdRCF/X0Vm7agq9FECdjVDIRAF462p0m9ry/Vcg91HZkbwb+xHvr22ccC3MW2pqGRC7/3/7X3Snr0pr5k5FkbitsHS4xsDEb4NgjuRM4STF0a1um7SoQvBiIjQ5zvXLUKdCH5V19HYtSnIlAb9zJWrLVk6wO6CM/+XabiopWjgOVtLOLanPauKcjxSoP0u/jX4xZd/xCxvNxV1pql5Svrlv3t2UGIvooA1qYZu76mqiEKY9MX9TS7fNkpVcXDOJGrBoa7iZ3oifx4eO9DUU9jR0RjeBwc7xbhY/FlCilHOC6tIBqr8t16jVG/N+LibP1tHo8uo0TDAa8PMWym3hE2lRMrPc/6g11S46uEE43QloHg7MVaQhNhkAoAf22okcu/iL07aXrlWjsSorVoYirDwycvx66OrXuFkUjRqF7ucErY1ox8nLcuwjLqRoQseo8xZ8NuLHGy4krCoXsZ1buOrOfHJRnYjkXjOVNcqBZ6HY0skUTGcyj7EmSIvTm+76ldmohsrWJBG94NWSVgAwClJQcs2ZYYSos391lCAJZRy/DEucZxGtIcCeV5KINRZPqdK4PpGXHZaXb/br7hSCZIbM8sEbtxG4dXMkmGZfxyPbusg9jKdF7l5pGrsf7DGx6Z7GXOaOVHV+fL9SxZ3rY7tCFm34KG5S6mDNd35G17A4SdhNVl//gU1vwEn4MyxqgQ02MymUwmk8lkMvmX+A8UC2cCam8cywAAAABJRU5ErkJggg==" alt="熊猫体育 Active" class="provider-icon-active">
                                    </div>
                                    <p class="provider-name">熊猫体育</p>
                                </li>
                                <li class="provider-item">
                                    <div class="provider-icon">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkBAMAAACCzIhnAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAkUExURXmBo0xpcXmBo39/n3mBoXp/pHh/o3Z/n3mBo3d/n3iBo3mBol4PWhAAAAAMdFJOU4AAQQhkLzgdeBBwUycL2rwAAAHBSURBVHja7dcxT8JQEAfwZwVEWLwW2hAW+g1ocHKqYXEsLia6lNnFbsSJwWB0gs0wNXFQNxz085m+exO5d5xJQzTpDSVv+KX0n969VwW/ropUpCL7JN7tu9qqh68VR4JYEVWb2AgK0qysJFWWcmzEVdYKLWRgJw5NXMXUlCRLjjySJOZIjSJdxVZGkA5Pzgmy5MkhQRKeNAiy4UmbIDFPWgSZ86RJELWj/h1xRkWbvfkYUpYKyFS3wARbpw6ugETg6Wu/WBwAbHYT/AXwcnytzuQEXrB7e3Mpwe5pZgCJnOgAPnAgSEnfdO9GTDCAEAOQEQyggQGIyBVAYIbEnZBcrwBSDMAXkmRsAogwAAlxALwYAzgVkmIIr00AuZAcbQUgIE0TwBOALyRqjG9LKwIYCEnbzLZPgI6IYFhr0wK5jOgA5rqtYSYjOoABBuAKiXoFGGIAnmBcpGbYnygMgCEh+Poam1WCO3iXIY1R8e8XlwpXQY7T7X5vM7mcLSnnSa2c7TXlSZ0gQ54cl3MgCXgyKedwBTP2UUjicyQs6zgqP/RKbrMAG+nZDvCZlUA3ZgRNoHdzsQ2ev6Pq860iFfnb5Af9ow875OptrQAAAABJRU5ErkJggg==" alt="IM体育" class="provider-icon-img">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAAflBMVEVMaXH///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////+cf0nxAAAAKXRSTlMAf+/fcAGA/hBgICHuEd7OQK++MHHPQb+gX2+fj1GeUDFekGHNro5uP38/7wEAAAAJcEhZcwAAFiUAABYlAUlSJPAAAAIgSURBVHic7ZjrjtsgEIVnTQzE8T1Odjd7672d93/BCgyK2VrNgGFVqZxfHGzxCY5txgBkZWVlZWVlUSUvT6zAGypOw2MFoervkaz7xyDE0QOh1AXM5oK+Ene+jDtvBnpTQhjoSQljIIodnVEFMhDrIxlyCobgSGXswxkoeiLE8wUJmkp4IkpCJl8tpD5gwyYIvqZ+tpRaEuTmt/3vqkkQ3CaRIUmXi0u5M03Wg20qtT1McSD6veJzW+3h/DqSa7dA9BdCLtqDM1I5xIAsvW5KZkfSzIalgEBl31Su7aFIAYE3dwt8SQIBm3Y7l1k8CQQezMVOu/IhCUTatH/AavhRIGDTNtvT+/C3QvZz2mc7nGtjQdic9uSGP8WF4Ek6aXeujQTBZ93V2C3a2C4uBCfdd2Bu+CwuBM+6sxdOxWhtLEhx0L12c6ldGwmCJu0v5qbWtZEg+KS7S5v2OxsJIuYfqkO7buNA0KT9yX5f3pY2FgRN2nzNRoNg2yjfrNmthcTuemlQl8o16wvRG7kZmQOUi3pfpV1+XbPexd3UNHbdi+nleXEFxa48szX7vxXcxUf8BLFtkI4E+aPI8dNAgiz/EPwlPpMgchuk+neOPaBPv1oAMIZDvlEZcKyDJ1KRIcEPmPA6hOQfwIAgivA+GObXco2o+uLLAKg6L4wY6QepS+1HQeQIMf4KQujZ7L93tbihun39STt4zMrKysrKylL6DfFC/rp35mTPAAAAAElFTkSuQmCC" alt="IM体育 Active" class="provider-icon-active">
                                    </div>
                                    <p class="provider-name">IM体育</p>
                                </li>
                                <li class="provider-item">
                                    <div class="provider-icon">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkBAMAAACCzIhnAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAhUExURXmBo0xpcXiBo3eAo3d/n3J/n3iBo3p/pHmAonZ/o3R/n2L6l5cAAAALdFJOU4AAckEgDWIuVDgYYuHO4wAAAXZJREFUeNrt10FOwlAUheGmioAjHihQRoWEOY1xLonO6Q7QFdCJY9iB7qBLNTEkhPwv79w7cWLv/EtPcnLvS7Pgno50pCN/Th6yyNwkSREjyySZx0idJNNoriTZxXKlyQtFXqfJF8kwpMmR5CTIPpIrTR4zTB/ty/JPghSRXCCq/NsAosqvFBkhVyCJl5+/nudNkEv5A7ViLL+vCMvv2cmlP0FYfmMmM6yuJJOzuAuCsPyhIix/8PQ7jYG02dVsDeSAYyTJBsdIkj2OpCQlcimyuPrIu4XMsPSSTHCMJJniGEkyRi5JWuQCSZVf2cgGuUAS5d8HG/lYrVbIZX3382AnE+NRYpuVg4xs54J3fK0I73jjIXvcfUlK5jK9yI2HFFx60/O6VoRLVrtIi1ym53XpI0fkkqRELkUWOJKSFFh6SeY4RiSs5eQkLXJJckAuENZSeUmJXIoseIz0K1Z5yTwPXjLuucnu200+g5s8+8n23/8jdyQ1P7DFOotlCKfQAAAAAElFTkSuQmCC" alt="FB体育" class="provider-icon-img">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAzUExURUxpcf////////////////////////////////////////////////////////////////Hv/K4AAAAQdFJOUwBw758gXL9A3oAwr5AQz85F/MfOAAABLUlEQVR42u3VS26AMAwA0YEk4PBpuf9pu+imClJFaWaXdwEkD44ZhmEYhuGF9Xqq8tp0PRS8t18PZd778IfF+XhYfvc5g959Ar17AuzukUHvXkDvngC7e2TQu6+gd6/8l7Tqv3ePtXVC7+6J/tKTjeje/aS/q7E7992fVrmf2P6O5hsLguV+mvzuqf5Q6GJT38V797sqdG+F0V37mecHwxK7L4Ddfc6gdy+gd0+A3T0y6N0L6N0PwO4eJ+jdN3r6jG+3VdfvfKCo+pFv01QczbuoJ4mMY2pW3U6SsMzNsOQkBfQkB+hJ4sRPktFszaqrSQLR3gzLTFJBT7KAniQyfpICepKEavOHBaUZlpbkQBbNu2glyaAnqaAnCXThD4t8TejKgq9mfCvDMAx/8QWu3lT/f8GDLwAAAABJRU5ErkJggg==" alt="FB体育 Active" class="provider-icon-active">
                                    </div>
                                    <p class="provider-name">FB体育</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Quality Services Section -->
    <section class="services-section">
        <div class="container">
            <!-- Services Title Image -->
            <div class="services-title-section">
                <div class="services-title-image">
                    <img src="/wp-content/uploads/2025/10/homepage_title04-517629875d7dbcfe8dc623e75b5aebb7.png" alt="Quality Services" class="services-title-img">
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
                                    <canvas class="progress-circle" width="15rem" height="15rem" data-progress="60"></canvas>
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
                                    <canvas class="progress-circle" width="128" height="128" data-progress="80"></canvas>
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
                                    <canvas class="progress-circle" width="128" height="128" data-progress="90"></canvas>
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
                                    <canvas class="progress-circle" width="128" height="128" data-progress="32"></canvas>
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
                                <p class="feature-description">最新技术自主研发的财务处理系统真正做到极速存、取、转独家网络优化技术，为您提供一流的游戏体验，最大优化网络延迟。</p>
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
                                <p class="feature-description">独家开发，采用128位加密技术和严格的安全管理体系，客户资金得到最完善的保障，让您全情尽享娱乐、赛事投注、无后顾之忧！</p>
                            </div>
                        </div>
                        
                        <div class="service-feature-item">
                            <div class="service-feature-icon">
                                <img src="/wp-content/uploads/2025/10/download-3.png" alt="Multi Platform">
                            </div>
                            <div class="service-feature-content">
                                <p class="feature-title">三端任您选择</p>
                                <p class="feature-description">引领市场的卓越技术，自主研发了全套终端应用，让您随时随地，娱乐投注随心所欲！7x24小时在线客服提供最贴心、最优质的服务。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
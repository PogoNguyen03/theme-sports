<footer class="site-footer">
    <?php
    $footer_images = get_theme_mod('footer_partners_images', '');
    $footer_urls = get_theme_mod('footer_partners_urls', '');
    $footer_image_ids = $footer_images ? array_filter(array_map('trim', explode(',', $footer_images))) : array();
    $footer_link_urls = $footer_urls ? array_map('trim', explode(',', $footer_urls)) : array();
    ?>
    <?php if (!empty($footer_image_ids)): ?>
        <div class="footer-partners">
            <div class="container footer-partners-wrap">
                <?php foreach ($footer_image_ids as $idx => $img_id):
                    $src = wp_get_attachment_image_src(intval($img_id), 'medium');
                    if (!$src)
                        continue;
                    $url = isset($footer_link_urls[$idx]) ? $footer_link_urls[$idx] : '';
                    ?>
                    <div class="footer-partner-item">
                        <?php if ($url): ?><a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener nofollow">
                            <?php endif; ?>
                            <img src="<?php echo esc_url($src[0]); ?>" alt="partner">
                            <?php if ($url): ?></a><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="footer-widgets">
        <div class="container footer-widgets-wrap">
            <?php if (is_active_sidebar('footer-widgets')): ?>
                <?php dynamic_sidebar('footer-widgets'); ?>
            <?php else: ?>
                <div class="widget widget_categories">
                    <ul>
                        <?php
                        wp_list_categories(array(
                            'title_li'    => '',
                            'show_count'  => false,
                            'hide_empty'  => false, // vẫn hiển thị danh mục rỗng
                            'hierarchical'=> true,
                            'orderby'     => 'name',
                            'order'       => 'ASC',
                            'exclude'     => array(get_option('default_category')), // ẩn Uncategorized
                        ));
                        ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 版权所有。</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
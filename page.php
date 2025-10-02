<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="text-align: center; margin-bottom: 40px;">
                    <h1 class="entry-title" style="font-size: 36px; color: #2c3e50; margin-bottom: 20px;">
                        <?php the_title(); ?>
                    </h1>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail" style="margin-bottom: 30px; text-align: center;">
                        <?php the_post_thumbnail('large', array('style' => 'max-width: 100%; height: auto; border-radius: 10px;')); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content" style="line-height: 1.8; color: #333; font-size: 16px;">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links" style="margin: 30px 0; text-align: center;">',
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <?php if (get_edit_post_link()) : ?>
                    <footer class="entry-footer" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; text-align: center;">
                        <?php
                        edit_post_link(
                            sprintf(
                                wp_kses(
                                    __('Chỉnh sửa <span class="screen-reader-text">%s</span>', 'kaiyun-sports'),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                get_the_title()
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                        ?>
                    </footer>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>


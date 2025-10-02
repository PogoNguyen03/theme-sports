<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="text-align: center; margin-bottom: 40px;">
                    <h1 class="entry-title" style="font-size: 36px; color: #2c3e50; margin-bottom: 20px;">
                        <?php the_title(); ?>
                    </h1>
                    <div class="entry-meta" style="color: #666; font-size: 14px;">
                        <span class="posted-on">
                            <time class="entry-date published" datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </span>
                        <span class="byline"> bởi 
                            <span class="author vcard">
                                <a class="url fn n" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                    <?php the_author(); ?>
                                </a>
                            </span>
                        </span>
                    </div>
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

                <footer class="entry-footer" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                        <div class="entry-categories">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                echo '<span style="color: #666; margin-right: 10px;">Danh mục:</span>';
                                foreach ($categories as $category) {
                                    echo '<a href="' . get_category_link($category->term_id) . '" style="color: #3498db; text-decoration: none; margin-right: 10px; padding: 5px 10px; background: #f8f9fa; border-radius: 15px; font-size: 12px;">' . $category->name . '</a>';
                                }
                            }
                            ?>
                        </div>
                        
                        <div class="entry-tags">
                            <?php
                            $tags = get_the_tags();
                            if (!empty($tags)) {
                                echo '<span style="color: #666; margin-right: 10px;">Thẻ:</span>';
                                foreach ($tags as $tag) {
                                    echo '<a href="' . get_tag_link($tag->term_id) . '" style="color: #e74c3c; text-decoration: none; margin-right: 10px; padding: 5px 10px; background: #f8f9fa; border-radius: 15px; font-size: 12px;">#' . $tag->name . '</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </footer>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>

        <nav class="navigation post-navigation" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="nav-previous">
                    <?php
                    $prev_post = get_previous_post();
                    if (!empty($prev_post)) :
                    ?>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" style="color: #3498db; text-decoration: none; padding: 10px 20px; background: #f8f9fa; border-radius: 5px; transition: all 0.3s;" onmouseover="this.style.background='#3498db'; this.style.color='white';" onmouseout="this.style.background='#f8f9fa'; this.style.color='#3498db';">
                            ← <?php echo $prev_post->post_title; ?>
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="nav-next">
                    <?php
                    $next_post = get_next_post();
                    if (!empty($next_post)) :
                    ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" style="color: #3498db; text-decoration: none; padding: 10px 20px; background: #f8f9fa; border-radius: 5px; transition: all 0.3s;" onmouseover="this.style.background='#3498db'; this.style.color='white';" onmouseout="this.style.background='#f8f9fa'; this.style.color='#3498db';">
                            <?php echo $next_post->post_title; ?> →
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</main>

<?php get_footer(); ?>


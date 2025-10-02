<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        <header class="page-header" style="text-align: center; margin-bottom: 40px;">
            <h1 class="page-title" style="font-size: 36px; color: #2c3e50; margin-bottom: 20px;">
                <?php
                printf(
                    esc_html__('Kết quả tìm kiếm cho: %s', 'kaiyun-sports'),
                    '<span style="color: #3498db;">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>

        <div class="search-form-container" style="margin-bottom: 40px; text-align: center;">
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>" style="display: inline-flex; max-width: 500px; width: 100%;">
                <label class="screen-reader-text" for="search-field"><?php echo _x('Tìm kiếm:', 'label', 'kaiyun-sports'); ?></label>
                <input type="search" id="search-field" class="search-field" placeholder="<?php echo esc_attr_x('Tìm kiếm...', 'placeholder', 'kaiyun-sports'); ?>" value="<?php echo get_search_query(); ?>" name="s" style="flex: 1; padding: 15px 20px; border: 2px solid #e9ecef; border-radius: 25px 0 0 25px; font-size: 16px; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#3498db';" onblur="this.style.borderColor='#e9ecef';" />
                <button type="submit" class="search-submit" style="padding: 15px 30px; background: #3498db; color: white; border: none; border-radius: 0 25px 25px 0; cursor: pointer; font-size: 16px; transition: background 0.3s;" onmouseover="this.style.background='#2980b9';" onmouseout="this.style.background='#3498db';">
                    <span class="screen-reader-text"><?php echo _x('Tìm kiếm', 'submit button', 'kaiyun-sports'); ?></span>
                    🔍
                </button>
            </form>
        </div>

        <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?> style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.1)';">
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail" style="height: 200px; overflow: hidden;">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content" style="padding: 20px;">
                            <header class="entry-header">
                                <h2 class="entry-title" style="font-size: 20px; margin-bottom: 15px; color: #2c3e50;">
                                    <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#3498db';" onmouseout="this.style.color='#2c3e50';">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <div class="entry-meta" style="color: #666; font-size: 14px; margin-bottom: 15px;">
                                    <span class="posted-on">
                                        <time class="entry-date published" datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </span>
                                    <span class="byline"> bởi 
                                        <span class="author vcard">
                                            <a class="url fn n" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" style="color: #3498db; text-decoration: none;">
                                                <?php the_author(); ?>
                                            </a>
                                        </span>
                                    </span>
                                </div>
                            </header>

                            <div class="entry-summary" style="color: #666; line-height: 1.6; margin-bottom: 20px;">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="entry-footer" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                <div class="entry-categories">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        foreach ($categories as $category) {
                                            echo '<a href="' . get_category_link($category->term_id) . '" style="color: #3498db; text-decoration: none; padding: 5px 10px; background: #f8f9fa; border-radius: 15px; font-size: 12px; margin-right: 5px;">' . $category->name . '</a>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="read-more" style="color: #e74c3c; text-decoration: none; font-weight: 500; transition: color 0.3s;" onmouseover="this.style.color='#c0392b';" onmouseout="this.style.color='#e74c3c';">
                                    Đọc thêm →
                                </a>
                            </footer>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="no-posts" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666;">
                    <h2 style="font-size: 24px; margin-bottom: 20px; color: #2c3e50;">Không tìm thấy kết quả nào</h2>
                    <p style="margin-bottom: 30px;">Xin lỗi, không có bài viết nào phù hợp với từ khóa tìm kiếm của bạn.</p>
                    <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                        <a href="<?php echo home_url(); ?>" class="btn btn-primary" style="padding: 12px 24px; background: #3498db; color: white; text-decoration: none; border-radius: 25px; transition: all 0.3s;" onmouseover="this.style.background='#2980b9'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#3498db'; this.style.transform='translateY(0)';">
                            Về trang chủ
                        </a>
                        <a href="<?php echo home_url('/blog'); ?>" class="btn btn-secondary" style="padding: 12px 24px; background: transparent; color: #3498db; text-decoration: none; border: 2px solid #3498db; border-radius: 25px; transition: all 0.3s;" onmouseover="this.style.background='#3498db'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.color='#3498db';">
                            Xem tất cả bài viết
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php
        // Pagination
        if (have_posts()) {
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('← Trước', 'kaiyun-sports'),
                'next_text' => __('Tiếp →', 'kaiyun-sports'),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Trang', 'kaiyun-sports') . ' </span>',
            ));
        }
        ?>
    </div>
</main>

<?php get_footer(); ?>


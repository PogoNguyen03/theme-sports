<?php
/**
 * Simple Media Control for WordPress Customizer
 * Fallback when advanced control is not available
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Only load if WordPress Customizer is available
if (!class_exists('WP_Customize_Control')) {
    return;
}

if (!class_exists('WP_Customize_Simple_Media_Control')) {
    class WP_Customize_Simple_Media_Control extends WP_Customize_Control {
        
        public $type = 'simple_media';
        public $mime_type = 'image';
        
        public function enqueue() {
            wp_enqueue_media();
        }
        
        public function render_content() {
            $value = $this->value();
            $images = $value ? explode(',', $value) : array();
            ?>
            <div class="simple-media-control">
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <?php if (!empty($this->description)): ?>
                        <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                    <?php endif; ?>
                </label>
                
                <div class="media-controls">
                    <button type="button" class="button button-primary add-media-btn">
                        <span class="dashicons dashicons-plus-alt"></span>
                        <?php _e('Add Images', 'kaiyun-sports'); ?>
                    </button>
                    <button type="button" class="button clear-all-btn" <?php echo empty($images) ? 'style="display:none;"' : ''; ?>>
                        <span class="dashicons dashicons-trash"></span>
                        <?php _e('Clear All', 'kaiyun-sports'); ?>
                    </button>
                </div>
                
                <div class="media-preview-container">
                    <div class="media-preview-list">
                        <?php if (!empty($images)): ?>
                            <?php foreach ($images as $image_id): ?>
                                <?php if ($image_id): ?>
                                    <?php $this->render_image_preview($image_id); ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-images-message">
                                <span class="dashicons dashicons-format-image"></span>
                                <p><?php _e('No images selected. Click "Add Images" to get started.', 'kaiyun-sports'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr($value); ?>" class="media-ids-input" />
            </div>
            <?php
        }
        
        private function render_image_preview($image_id) {
            $image = wp_get_attachment_image_src($image_id, 'thumbnail');
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $image_title = get_the_title($image_id);
            
            if (!$image) return;
            ?>
            <div class="media-preview-item" data-id="<?php echo esc_attr($image_id); ?>">
                <div class="media-preview-image">
                    <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
                    <div class="media-preview-overlay">
                        <button type="button" class="button button-small remove-image-btn" title="<?php _e('Remove Image', 'kaiyun-sports'); ?>">
                            <span class="dashicons dashicons-no-alt"></span>
                        </button>
                    </div>
                </div>
                <div class="media-preview-info">
                    <div class="media-preview-title" title="<?php echo esc_attr($image_title); ?>">
                        <?php echo esc_html($image_title); ?>
                    </div>
                    <div class="media-preview-meta">
                        <?php echo esc_html($image[1] . ' × ' . $image[2]); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

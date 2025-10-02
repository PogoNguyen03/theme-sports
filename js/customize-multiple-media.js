jQuery(document).ready(function($) {
    'use strict';
    
    // Fallback for simple media button functionality
    $(document).on('click', '.add-media-btn', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var $container = $button.closest('.multiple-media-control');
        
        // Simple media frame
        if (typeof wp !== 'undefined' && wp.media) {
            var frame = wp.media({
                title: 'Select Images',
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var imageIds = [];
                
                selection.map(function(attachment) {
                    imageIds.push(attachment.id);
                });
                
                // Show progress bar
                var $progress = $container.find('.upload-progress');
                var $progressFill = $progress.find('.progress-fill');
                var $progressText = $progress.find('.progress-text');
                $progress.show();
                
                // Add images to preview with progress
                var $previewList = $container.find('.media-preview-list');
                var $noImagesMessage = $previewList.find('.no-images-message');
                $noImagesMessage.remove();
                
                var totalImages = imageIds.length;
                var processedImages = 0;
                
                imageIds.forEach(function(imageId, index) {
                    if (!$previewList.find('[data-id="' + imageId + '"]').length) {
                        var attachment = wp.media.attachment(imageId);
                        var imageUrl = attachment.get('url');
                        var imageTitle = attachment.get('title');
                        var imageAlt = attachment.get('alt');
                        var imageWidth = attachment.get('width');
                        var imageHeight = attachment.get('height');
                        
                        // Check if image is large
                        var isLarge = imageWidth > 1920 || imageHeight > 1080;
                        
                        var previewHtml = '<div class="media-preview-item' + (isLarge ? ' optimizing' : '') + '" data-id="' + imageId + '">' +
                            '<div class="media-preview-image">' +
                                '<img src="' + imageUrl + '" alt="' + imageAlt + '" />' +
                                '<div class="media-preview-overlay">' +
                                    '<button type="button" class="button button-small remove-image-btn" title="Remove Image">' +
                                        '<span class="dashicons dashicons-no-alt"></span>' +
                                    '</button>' +
                                '</div>' +
                            '</div>' +
                            '<div class="media-preview-info">' +
                                '<div class="media-preview-title">' + imageTitle + '</div>' +
                                '<div class="media-preview-meta">' + imageWidth + ' × ' + imageHeight + (isLarge ? ' (Optimizing...)' : '') + '</div>' +
                            '</div>' +
                            '<div class="media-preview-url">' +
                                '<input type="url" class="image-url-input" placeholder="Image URL (optional)" />' +
                            '</div>' +
                            '<div class="media-preview-alt">' +
                                '<input type="text" class="image-alt-input" placeholder="Alt text" value="' + imageAlt + '" />' +
                            '</div>' +
                        '</div>';
                        
                        $previewList.append(previewHtml);
                        
                        // Simulate optimization for large images
                        if (isLarge) {
                            setTimeout(function() {
                                var $item = $previewList.find('[data-id="' + imageId + '"]');
                                $item.removeClass('optimizing').addClass('optimized');
                                
                                processedImages++;
                                var progress = (processedImages / totalImages) * 100;
                                $progressFill.css('width', progress + '%');
                                $progressText.text('Optimizing images... ' + processedImages + '/' + totalImages);
                                
                                if (processedImages === totalImages) {
                                    setTimeout(function() {
                                        $progress.hide();
                                        $progressText.text('Uploading and optimizing images...');
                                        $progressFill.css('width', '0%');
                                    }, 1000);
                                }
                            }, 1000 + (index * 500));
                        } else {
                            processedImages++;
                            var progress = (processedImages / totalImages) * 100;
                            $progressFill.css('width', progress + '%');
                            $progressText.text('Processing images... ' + processedImages + '/' + totalImages);
                            
                            if (processedImages === totalImages) {
                                setTimeout(function() {
                                    $progress.hide();
                                    $progressText.text('Uploading and optimizing images...');
                                    $progressFill.css('width', '0%');
                                }, 1000);
                            }
                        }
                    }
                });
                
                // Update setting value
                setTimeout(function() {
                    var imageIds = [];
                    $previewList.find('.media-preview-item').each(function() {
                        imageIds.push($(this).data('id'));
                    });
                    
                    $container.find('.media-ids-input').val(imageIds.join(',')).trigger('change');
                    $container.find('.clear-all-btn').show();
                }, 2000);
            });
            
            frame.open();
        } else {
            alert('Media library not available. Please refresh the page.');
        }
    });
    
    // Remove image functionality
    $(document).on('click', '.remove-image-btn', function(e) {
        e.preventDefault();
        var $item = $(this).closest('.media-preview-item');
        var $container = $item.closest('.multiple-media-control');
        
        $item.fadeOut(300, function() {
            $(this).remove();
            
            var $previewList = $container.find('.media-preview-list');
            if ($previewList.find('.media-preview-item').length === 0) {
                $previewList.append('<div class="no-images-message"><span class="dashicons dashicons-format-image"></span><p>No images selected. Click "Add Images" to get started.</p></div>');
                $container.find('.clear-all-btn').hide();
            }
            
            // Update setting value
            var imageIds = [];
            $previewList.find('.media-preview-item').each(function() {
                imageIds.push($(this).data('id'));
            });
            
            $container.find('.media-ids-input').val(imageIds.join(',')).trigger('change');
        });
    });
    
    // Clear all functionality
    $(document).on('click', '.clear-all-btn', function(e) {
        e.preventDefault();
        var $container = $(this).closest('.multiple-media-control');
        var $previewList = $container.find('.media-preview-list');
        
        $previewList.find('.media-preview-item').fadeOut(300, function() {
            $(this).remove();
        });
        
        setTimeout(function() {
            $previewList.append('<div class="no-images-message"><span class="dashicons dashicons-format-image"></span><p>No images selected. Click "Add Images" to get started.</p></div>');
            $container.find('.clear-all-btn').hide();
            $container.find('.media-ids-input').val('').trigger('change');
        }, 300);
    });
    
    // Multiple Media Control
    if (typeof wp !== 'undefined' && wp.customize) {
        
        wp.customize.controlConstructor['multiple_media'] = wp.customize.Control.extend({
            
            ready: function() {
                var control = this;
                var container = control.container;
                
                // Initialize the control
                this.initMultipleMediaControl();
            },
            
            initMultipleMediaControl: function() {
                var control = this;
                var container = control.container;
                var $container = $(container);
                
                // Add media button
                $container.find('.add-media-btn').on('click', function(e) {
                    e.preventDefault();
                    control.openMediaLibrary();
                });
                
                // Clear all button
                $container.find('.clear-all-btn').on('click', function(e) {
                    e.preventDefault();
                    control.clearAllImages();
                });
                
                // Remove individual image
                $container.on('click', '.remove-image-btn', function(e) {
                    e.preventDefault();
                    var $item = $(this).closest('.media-preview-item');
                    control.removeImage($item);
                });
                
                // Edit individual image
                $container.on('click', '.edit-image-btn', function(e) {
                    e.preventDefault();
                    var $item = $(this).closest('.media-preview-item');
                    var imageId = $item.data('id');
                    control.editImage(imageId);
                });
                
                // Update URL and Alt text
                $container.on('input', '.image-url-input, .image-alt-input', function() {
                    control.updateImageData();
                });
                
                // Initialize drag and drop
                this.initDragAndDrop();
            },
            
            openMediaLibrary: function() {
                var control = this;
                
                // Create media frame
                var frame = wp.media({
                    title: 'Select Images',
                    multiple: true,
                    library: {
                        type: 'image'
                    }
                });
                
                frame.on('select', function() {
                    var selection = frame.state().get('selection');
                    var imageIds = [];
                    
                    selection.map(function(attachment) {
                        imageIds.push(attachment.id);
                    });
                    
                    control.addImages(imageIds);
                });
                
                frame.open();
            },
            
            addImages: function(imageIds) {
                var control = this;
                var $container = $(control.container);
                var $previewList = $container.find('.media-preview-list');
                var $noImagesMessage = $previewList.find('.no-images-message');
                
                // Remove no images message
                $noImagesMessage.remove();
                
                // Add each image
                imageIds.forEach(function(imageId) {
                    if (!$previewList.find('[data-id="' + imageId + '"]').length) {
                        control.renderImagePreview(imageId);
                    }
                });
                
                // Update the setting value
                control.updateSettingValue();
                
                // Show clear all button
                $container.find('.clear-all-btn').show();
            },
            
            removeImage: function($item) {
                var control = this;
                var $container = $(control.container);
                var $previewList = $container.find('.media-preview-list');
                
                $item.fadeOut(300, function() {
                    $(this).remove();
                    
                    // Show no images message if empty
                    if ($previewList.find('.media-preview-item').length === 0) {
                        $previewList.append('<div class="no-images-message"><span class="dashicons dashicons-format-image"></span><p>No images selected. Click "Add Images" to get started.</p></div>');
                        $container.find('.clear-all-btn').hide();
                    }
                    
                    control.updateSettingValue();
                });
            },
            
            clearAllImages: function() {
                var control = this;
                var $container = $(control.container);
                var $previewList = $container.find('.media-preview-list');
                
                $previewList.find('.media-preview-item').fadeOut(300, function() {
                    $(this).remove();
                });
                
                setTimeout(function() {
                    $previewList.append('<div class="no-images-message"><span class="dashicons dashicons-format-image"></span><p>No images selected. Click "Add Images" to get started.</p></div>');
                    $container.find('.clear-all-btn').hide();
                    control.updateSettingValue();
                }, 300);
            },
            
            editImage: function(imageId) {
                var frame = wp.media({
                    title: 'Edit Image',
                    button: {
                        text: 'Update Image'
                    },
                    library: {
                        type: 'image'
                    }
                });
                
                // Set the selected attachment
                var attachment = wp.media.attachment(imageId);
                frame.state().get('selection').add(attachment);
                
                frame.on('select', function() {
                    var selection = frame.state().get('selection').first();
                    // Update the image preview
                    var $item = $('.media-preview-item[data-id="' + imageId + '"]');
                    var $img = $item.find('img');
                    $img.attr('src', selection.get('url'));
                });
                
                frame.open();
            },
            
            renderImagePreview: function(imageId) {
                var control = this;
                var $container = $(control.container);
                var $previewList = $container.find('.media-preview-list');
                
                // Get image data via AJAX
                $.ajax({
                    url: kaiyunMediaControl.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'get_image_data',
                        image_id: imageId,
                        nonce: kaiyunMediaControl.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            var imageData = response.data;
                            var previewHtml = control.generateImagePreviewHtml(imageData);
                            $previewList.append(previewHtml);
                        }
                    },
                    error: function() {
                        console.log('Error loading image data');
                    }
                });
            },
            
            generateImagePreviewHtml: function(imageData) {
                return '<div class="media-preview-item" data-id="' + imageData.id + '" draggable="true">' +
                    '<div class="media-preview-image">' +
                        '<img src="' + imageData.url + '" alt="' + imageData.alt + '" />' +
                        '<div class="media-preview-overlay">' +
                            '<button type="button" class="button button-small remove-image-btn" title="Remove Image">' +
                                '<span class="dashicons dashicons-no-alt"></span>' +
                            '</button>' +
                            '<button type="button" class="button button-small edit-image-btn" title="Edit Image">' +
                                '<span class="dashicons dashicons-edit"></span>' +
                            '</button>' +
                        '</div>' +
                    '</div>' +
                    '<div class="media-preview-info">' +
                        '<div class="media-preview-title" title="' + imageData.title + '">' + imageData.title + '</div>' +
                        '<div class="media-preview-meta">' + imageData.width + ' × ' + imageData.height + '</div>' +
                    '</div>' +
                    '<div class="media-preview-url">' +
                        '<input type="url" class="image-url-input" placeholder="Image URL (optional)" />' +
                    '</div>' +
                    '<div class="media-preview-alt">' +
                        '<input type="text" class="image-alt-input" placeholder="Alt text" value="' + imageData.alt + '" />' +
                    '</div>' +
                '</div>';
            },
            
            updateSettingValue: function() {
                var control = this;
                var $container = $(control.container);
                var imageIds = [];
                
                $container.find('.media-preview-item').each(function() {
                    imageIds.push($(this).data('id'));
                });
                
                control.setting.set(imageIds.join(','));
            },
            
            updateImageData: function() {
                var control = this;
                var $container = $(control.container);
                var imageData = {
                    ids: [],
                    urls: [],
                    alts: []
                };
                
                $container.find('.media-preview-item').each(function() {
                    var $item = $(this);
                    imageData.ids.push($item.data('id'));
                    imageData.urls.push($item.find('.image-url-input').val());
                    imageData.alts.push($item.find('.image-alt-input').val());
                });
                
                // Update related settings
                var urlsSetting = wp.customize('hero_banner_urls');
                var altsSetting = wp.customize('hero_banner_alts');
                
                if (urlsSetting) {
                    urlsSetting.set(imageData.urls.join(','));
                }
                if (altsSetting) {
                    altsSetting.set(imageData.alts.join(','));
                }
            },
            
            initDragAndDrop: function() {
                var control = this;
                var $container = $(control.container);
                var $previewList = $container.find('.media-preview-list');
                
                // Make items draggable
                $previewList.on('dragstart', '.media-preview-item', function(e) {
                    $(this).addClass('dragging');
                    e.originalEvent.dataTransfer.effectAllowed = 'move';
                    e.originalEvent.dataTransfer.setData('text/html', this.outerHTML);
                });
                
                $previewList.on('dragend', '.media-preview-item', function(e) {
                    $(this).removeClass('dragging');
                });
                
                // Handle drag over
                $previewList.on('dragover', function(e) {
                    e.preventDefault();
                    e.originalEvent.dataTransfer.dropEffect = 'move';
                    $(this).addClass('drag-over');
                });
                
                $previewList.on('dragleave', function(e) {
                    $(this).removeClass('drag-over');
                });
                
                // Handle drop
                $previewList.on('drop', function(e) {
                    e.preventDefault();
                    $(this).removeClass('drag-over');
                    
                    var $draggedItem = $('.media-preview-item.dragging');
                    var $targetItem = $(e.target).closest('.media-preview-item');
                    
                    if ($targetItem.length && !$targetItem.hasClass('dragging')) {
                        if (e.originalEvent.clientY < $targetItem.offset().top + $targetItem.height() / 2) {
                            $targetItem.before($draggedItem);
                        } else {
                            $targetItem.after($draggedItem);
                        }
                        
                        control.updateSettingValue();
                    }
                });
            }
        });
    }
});
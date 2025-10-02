// Fix jQuery :has() selector compatibility issue before DOM ready
(function() {
    // Prevent jQuery from detecting native :has() support to avoid syntax errors
    if (typeof jQuery !== 'undefined') {
        // Force jQuery to use its own :has() implementation instead of native CSS
        if (jQuery.support) {
            jQuery.support.cssHas = false;
        }
        
        // For newer jQuery versions, override the detection
        var originalReady = jQuery.ready;
        jQuery.ready = function() {
            // Disable native :has() detection
            if (jQuery.expr && jQuery.expr.pseudos && jQuery.expr.pseudos.has) {
                var originalHas = jQuery.expr.pseudos.has;
                jQuery.expr.pseudos.has = function(elem, i, match) {
                    try {
                        // Use jQuery's own implementation, not native CSS
                        var selector = match[3];
                        return jQuery(elem).find(selector).length > 0;
                    } catch (e) {
                        return false;
                    }
                };
            }
            
            // Call original ready function
            if (originalReady) {
                return originalReady.apply(this, arguments);
            }
        };
    }
})();

jQuery(document).ready(function($) {
    // Additional safety check for :has() selector
    try {
    // Hero Slider functionality
    function initHeroSlider() {
        var $slider = $('.hero-slider');
        if ($slider.length === 0) {
            console.log('Hero slider not found');
            return;
        }
        
        var $slides = $slider.find('.slide');
        var $dots = $slider.find('.dot');
        var $prevBtn = $slider.find('.slider-prev');
        var $nextBtn = $slider.find('.slider-next');
        var currentSlide = 0;
        var totalSlides = $slides.length;
        var autoplay = $slider.data('autoplay') === 'true' || $slider.data('autoplay') === true;
        var interval = parseInt($slider.data('interval')) || 3000;
        
        // Fallback: if no data attributes, enable autoplay by default
        if ($slider.data('autoplay') === undefined) {
            autoplay = true;
            console.log('No autoplay data attribute found, enabling by default');
        }
        var autoplayTimer;
        
        // Debug logging
        console.log('Hero Slider Initialized:');
        console.log('- Total slides:', totalSlides);
        console.log('- Autoplay enabled:', autoplay);
        console.log('- Interval:', interval + 'ms');
        console.log('- Slider element:', $slider[0]);
        
        // Function to show specific slide
        function showSlide(index) {
            $slides.removeClass('active');
            $dots.removeClass('active');
            
            $slides.eq(index).addClass('active');
            $dots.eq(index).addClass('active');
            
            currentSlide = index;
        }
        
        // Function to go to next slide
        function nextSlide() {
            var next = (currentSlide + 1) % totalSlides;
            showSlide(next);
        }
        
        // Function to go to previous slide
        function prevSlide() {
            var prev = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(prev);
        }
        
        // Start autoplay
        function startAutoplay() {
            if (autoplay && totalSlides > 1) {
                console.log('Starting autoplay with interval:', interval + 'ms');
                autoplayTimer = setInterval(nextSlide, interval);
            } else {
                console.log('Autoplay not started - autoplay:', autoplay, 'totalSlides:', totalSlides);
            }
        }
        
        // Stop autoplay
        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }
        
        // Event handlers
        $nextBtn.on('click', function() {
            stopAutoplay();
            nextSlide();
            startAutoplay();
        });
        
        $prevBtn.on('click', function() {
            stopAutoplay();
            prevSlide();
            startAutoplay();
        });
        
        $dots.on('click', function() {
            var slideIndex = $(this).data('slide');
            stopAutoplay();
            showSlide(slideIndex);
            startAutoplay();
        });
        
        // Pause autoplay on hover
        $slider.on('mouseenter', stopAutoplay);
        $slider.on('mouseleave', startAutoplay);
        
        // Touch/swipe support for mobile
        var startX = 0;
        var startY = 0;
        var endX = 0;
        var endY = 0;
        
        $slider.on('touchstart', function(e) {
            startX = e.originalEvent.touches[0].clientX;
            startY = e.originalEvent.touches[0].clientY;
        });
        
        $slider.on('touchend', function(e) {
            endX = e.originalEvent.changedTouches[0].clientX;
            endY = e.originalEvent.changedTouches[0].clientY;
            
            var diffX = startX - endX;
            var diffY = startY - endY;
            
            // Only trigger if horizontal swipe is more significant than vertical
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                stopAutoplay();
                if (diffX > 0) {
                    nextSlide(); // Swipe left - next slide
                } else {
                    prevSlide(); // Swipe right - previous slide
                }
                startAutoplay();
            }
        });
        
        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if ($slider.is(':visible')) {
                if (e.keyCode === 37) { // Left arrow
                    stopAutoplay();
                    prevSlide();
                    startAutoplay();
                } else if (e.keyCode === 39) { // Right arrow
                    stopAutoplay();
                    nextSlide();
                    startAutoplay();
                }
            }
        });
        
        // Initialize
        if (totalSlides > 0) {
            console.log('Initializing slider with', totalSlides, 'slides');
            showSlide(0);
            startAutoplay();
            
            // Force autoplay after 1 second if not started
            setTimeout(function() {
                if (!autoplayTimer && autoplay && totalSlides > 1) {
                    console.log('Force starting autoplay after timeout');
                    startAutoplay();
                }
            }, 1000);
        } else {
            console.log('No slides found, slider not initialized');
        }
    }
    
    // Initialize slider
    initHeroSlider();
    
    // Live tabs functionality
    $('.live-tab').on('click', function() {
        $('.live-tab').removeClass('active');
        $(this).addClass('active');
        
        // Here you would typically load different content based on the tab
        console.log('Switched to tab: ' + $(this).text());
    });

    // App-section tabs: update visual, QR and link on click
    $(document).on('click', '.app-tab', function() {
        var $tab = $(this);
        var $wrap = $tab.closest('.app-section').find('.app-download-wrap');
        var tabsDataRaw = $wrap.attr('data-app-tabs') || '[]';
        var tabsData = [];
        try { tabsData = JSON.parse(tabsDataRaw); } catch(e) { tabsData = []; }

        // set active state
        $tab.closest('.app-tabs').find('.app-tab').removeClass('active');
        $tab.addClass('active');

        var idx = $tab.index();
        if (!tabsData[idx]) return;

        var tabInfo = tabsData[idx];
        // Update visual image
        var $visualImg = $wrap.closest('.app-section').find('[data-role="visual-image"]').first();
        if ($visualImg.length && tabInfo.image_url) {
            $visualImg.attr('src', tabInfo.image_url);
        }

        // Update QR
        var $qrBox = $wrap.find('[data-role="qr-box"]');
        var $qrImg = $qrBox.find('[data-role="qr-image"]');
        if (tabInfo.qr_url) {
            if ($qrImg.length === 0) {
                $qrImg = $('<img data-role="qr-image" alt="QR" />').appendTo($qrBox);
            }
            $qrImg.attr('src', tabInfo.qr_url);
            $qrBox.show();
        } else {
            $qrImg.remove();
            $qrBox.hide();
        }

        // Update link list (show only current tab URL)
        var $links = $wrap.find('[data-role="links"]');
        $links.empty();
        if (tabInfo.url) {
            $('<a class="app-link-text" target="_blank" rel="noopener"></a>').attr('href', tabInfo.url).text(tabInfo.url).appendTo($links);
            $links.show();
        } else {
            $links.hide();
        }

        // Update per-tab description (dir)
        var $dir = $wrap.closest('.app-section').find('[data-role="tab-dir"]');
        if ($dir.length) {
            $dir.html(tabInfo.dir || '');
        }
    });
    
    // Live Section Functionality
    if ($('.live-section').length) {
        // Check if Swiper container exists
        if ($('.swiper-container.live-swiper').length === 0) {
            console.error('Swiper container not found');
            return;
        }
        
        // Initialize Live Swiper
        var liveSwiper = new Swiper('.swiper-container.live-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 12,
            freeMode: false,
            loop: false,
            navigation: {
                nextEl: '.live-swiper-button-next',
                prevEl: '.live-swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 12
                }
            },
            allowTouchMove: true,
            simulateTouch: true,
            touchStartPreventDefault: false,
            on: {
                slideChange: function() {
                    // Auto-select the active slide when swiping
                    var activeIndex = this.activeIndex;
                    var $activeSlide = $('.live-match-slide').eq(activeIndex);
                    var $activeCard = $activeSlide.find('.live-match-card');
                    if ($activeCard.length > 0) {
                        selectMatch($activeCard);
                    }
                }
            }
        });

        // Ensure navigation buttons are properly initialized
        setTimeout(function() {
            if (liveSwiper && liveSwiper.navigation) {
                liveSwiper.navigation.init();
                liveSwiper.navigation.update();
            }
        }, 100);
        
        // Check if navigation buttons exist
        console.log('Navigation buttons found:', {
            next: $('.live-swiper-button-next').length,
            prev: $('.live-swiper-button-prev').length
        });
        
        // Manual navigation button handlers as fallback
        $('.live-swiper-button-next').on('click', function() {
            console.log('Next button clicked');
            if (liveSwiper) {
                liveSwiper.slideNext();
            }
        });
        
        $('.live-swiper-button-prev').on('click', function() {
            console.log('Prev button clicked');
            if (liveSwiper) {
                liveSwiper.slidePrev();
            }
        });

        // Function to handle match selection
        function selectMatch($card) {
            // Remove active class from all cards
            $('.live-match-card').removeClass('active');
            
            // Add active class to selected card
            $card.addClass('active');
            
            // Get match data from the parent slide's data attributes
            var $slide = $card.closest('.live-match-slide');
            
            // Extract all match information from data attributes using .attr() to avoid jQuery cache
            var matchData = {
                league: $slide.attr('data-league') || '',
                leagueLogo: $slide.attr('data-league-logo') || '',
                status: ($slide.attr('data-status') || '').toLowerCase(),
                time: $slide.attr('data-time') || '',
                team1Name: $slide.attr('data-team1-name') || 'Team 1',
                team2Name: $slide.attr('data-team2-name') || 'Team 2',
                team1Logo: $slide.attr('data-team1-logo') || '',
                team2Logo: $slide.attr('data-team2-logo') || '',
                team1Score: $slide.attr('data-team1-score') || '0',
                team2Score: $slide.attr('data-team2-score') || '0',
                streamerName: $slide.attr('data-streamer-name') || '',
                streamerAvatar: $slide.attr('data-streamer-avatar') || ''
            };
            
            // Update match details display with all information
            updateMatchDetails(matchData);
        }

        // Live match card selection - simplified approach
        $(document).on('click', '.live-match-card', function(e) {
            e.preventDefault();
            e.stopPropagation();
            selectMatch($(this));
        });
        
        // Handle clicks on entire slide
        $(document).on('click', '.live-match-slide', function(e) {
            var $matchCard = $(this).find('.live-match-card');
            if ($matchCard.length > 0) {
                selectMatch($matchCard);
            }
        });

        // Auto-select first match on load and initialize details
        setTimeout(function() {
            var $firstCard = $('.live-match-card').first();
            if ($firstCard.length > 0) {
                selectMatch($firstCard);
            }
        }, 100);

        // Make selectMatch function globally available for testing
        window.selectMatch = selectMatch;

        // Filter functionality
        $('.filter-tab, .sport-filter').on('click', function() {
            // Remove active class from siblings
            $(this).siblings().removeClass('active');
            // Add active class to clicked filter
            $(this).addClass('active');
            
            // Here you would typically filter matches based on the selected filter
        });

        // Search functionality
        $('.live-search-input').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            
            $('.live-match-slide').each(function() {
                var $slide = $(this);
                var streamerName = $slide.find('.streamer-name').text().toLowerCase();
                var team1Name = $slide.find('.team p').first().text().toLowerCase();
                var team2Name = $slide.find('.team p').last().text().toLowerCase();
                var leagueName = $slide.find('.league-info div').text().toLowerCase();
                
                if (streamerName.includes(searchTerm) || 
                    team1Name.includes(searchTerm) || 
                    team2Name.includes(searchTerm) || 
                    leagueName.includes(searchTerm)) {
                    $slide.show();
                } else {
                    $slide.hide();
                }
            });
        });

        // Betting options functionality
        $('.betting-option').on('click', function() {
            // Remove active class from all betting options in the same group
            $(this).siblings().removeClass('active');
            // Add active class to clicked option
            $(this).addClass('active');
            
            // Get betting information
            var betType = $(this).closest('.betting-group').find('.betting-title').text();
            var betOption = $(this).find('.option-label').text();
            var odds = $(this).find('.odds-value').text();
            
            // Bet selected: betType, betOption, odds
            
            // Here you would typically handle the betting logic
            // For now, just show a simple notification
            showBettingNotification(betType, betOption, odds);
        });

        // Place bet button
        $('.place-bet-button').on('click', function() {
            var activeBets = $('.betting-option.active');
            if (activeBets.length > 0) {
                // Show betting confirmation (simplified)
                alert('投注功能将在实际应用中实现');
            } else {
                alert('请先选择投注选项');
            }
        });
    }

    // Function to update match details display
    function updateMatchDetails(matchData) {
        // Update team names using specific IDs
        $('#detail-team1-name').text(matchData.team1Name).attr('title', matchData.team1Name);
        $('#detail-team2-name').text(matchData.team2Name).attr('title', matchData.team2Name);
        
        // Update team logos using specific IDs
        if (matchData.team1Logo) {
            $('#detail-team1-logo').attr('src', matchData.team1Logo).attr('alt', matchData.team1Name).show();
        } else {
            $('#detail-team1-logo').hide();
        }
        
        if (matchData.team2Logo) {
            $('#detail-team2-logo').attr('src', matchData.team2Logo).attr('alt', matchData.team2Name).show();
        } else {
            $('#detail-team2-logo').hide();
        }
        
        // Update scores using specific IDs
        $('#detail-team1-score').text(matchData.team1Score);
        $('#detail-team2-score').text(matchData.team2Score);
        
        // Update stream content
        var $streamContent = $('#stream-content');
        var isLive = (matchData.status === 'live');
        
        if (isLive) {
            var liveHtml = '<div class="live-stream-info">' +
                '<h3 id="stream-league">' + matchData.league + '</h3>' +
                '<p id="stream-teams">' + matchData.team1Name + ' vs ' + matchData.team2Name + '</p>' +
                '<p class="live-indicator">🔴 LIVE</p>';
            if (matchData.streamerName) {
                liveHtml += '<p id="stream-streamer">Streamer: ' + matchData.streamerName + '</p>';
            }
            liveHtml += '</div>';
            $streamContent.html(liveHtml);
        } else {
            var scheduledHtml = '<div class="scheduled-stream-info">' +
                '<h3 id="stream-league">' + matchData.league + '</h3>' +
                '<p id="stream-teams">' + matchData.team1Name + ' vs ' + matchData.team2Name + '</p>';
            if (matchData.time) {
                scheduledHtml += '<p class="scheduled-time" id="stream-time">' + matchData.time + '</p>';
            }
            if (matchData.streamerName) {
                scheduledHtml += '<p id="stream-streamer">Streamer: ' + matchData.streamerName + '</p>';
            }
            scheduledHtml += '</div>';
            $streamContent.html(scheduledHtml);
        }
        
        // Update chat header using specific IDs
        $('#chat-teams').text(matchData.team1Name + ' vs ' + matchData.team2Name);
        if (matchData.league) {
            $('#chat-league').text(matchData.league).show();
        } else {
            $('#chat-league').hide();
        }
    }

    // Function to show betting notification
    function showBettingNotification(betType, betOption, odds) {
        // Create a simple notification
        var notificationHtml = '<div class="notification-content">' +
            '<h4>投注选择</h4>' +
            '<p><strong>类型:</strong> ' + betType + '</p>' +
            '<p><strong>选项:</strong> ' + betOption + '</p>' +
            '<p><strong>赔率:</strong> ' + odds + '</p>' +
            '<button class="close-notification">关闭</button>' +
            '</div>';
        var $notification = $('<div class="betting-notification">')
            .html(notificationHtml)
            .css({
                position: 'fixed',
                top: '20px',
                right: '20px',
                background: '#1e2430',
                border: '1px solid #3498db',
                borderRadius: '8px',
                padding: '20px',
                color: '#fff',
                zIndex: 1000,
                maxWidth: '300px'
            });
        
        $('body').append($notification);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
        
        // Close button functionality
        $notification.find('.close-notification').on('click', function() {
            $notification.fadeOut(300, function() {
                $(this).remove();
            });
        });
    }

    // Games tabs functionality
    $('.games-tab').on('click', function() {
        $('.games-tab').removeClass('active');
        $(this).addClass('active');
        
        // Here you would typically load different games based on the tab
    });
    
    // Smooth scrolling for anchor links
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
                return false;
            }
        }
    });
    
    // Mobile menu toggle (if you add mobile menu later)
    $('.mobile-menu-toggle').on('click', function() {
        $('.mobile-menu').toggleClass('active');
    });
    
    // Chat functionality (basic)
    $('.chat-input button').on('click', function() {
        var message = $('.chat-input input').val();
        if (message.trim() !== '') {
            var chatMessage = '<div style="margin-bottom: 10px; padding: 5px; background: #34495e; border-radius: 5px;"><strong>You:</strong> ' + message + '</div>';
            $('.chat-messages').append(chatMessage);
            $('.chat-input input').val('');
            
            // Scroll to bottom of chat
            $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
        }
    });
    
    // Enter key for chat
    $('.chat-input input').on('keypress', function(e) {
        if (e.which == 13) {
            $('.chat-input button').click();
        }
    });
    
    // Game card hover effects
    $('.game-card').hover(
        function() {
            $(this).find('.game-image').css('transform', 'scale(1.05)');
        },
        function() {
            $(this).find('.game-image').css('transform', 'scale(1)');
        }
    );
    
    // Partner item hover effects
    $('.partner-item').hover(
        function() {
            $(this).css('transform', 'translateY(-10px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );
    
    // Service item hover effects
    $('.service-item').hover(
        function() {
            $(this).find('.service-icon').css('transform', 'scale(1.1)');
        },
        function() {
            $(this).find('.service-icon').css('transform', 'scale(1)');
        }
    );
    
    // Add loading animation for buttons
    $('.btn').on('click', function() {
        var $btn = $(this);
        var originalText = $btn.text();
        
        $btn.text('Đang tải...');
        $btn.prop('disabled', true);
        
        // Simulate loading (remove this in production)
        setTimeout(function() {
            $btn.text(originalText);
            $btn.prop('disabled', false);
        }, 1000);
    });
    
    // Parallax effect for hero section (disabled to fix sticky header)
    // $(window).scroll(function() {
    //     var scrolled = $(this).scrollTop();
    //     var parallax = $('.hero-section');
    //     var speed = scrolled * 0.5;
    //     
    //     parallax.css('transform', 'translateY(' + speed + 'px)');
    // });
    
    // Add animation classes when elements come into view
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    
    function addAnimationClasses() {
        $('.game-card, .partner-item, .service-item').each(function() {
            if (isElementInViewport(this)) {
                $(this).addClass('animate-in');
            }
        });
    }
    
    // Check on scroll
    $(window).on('scroll', addAnimationClasses);
    
    // Check on load
    addAnimationClasses();
    
    // Add CSS for animations
    var animationCSS = '.game-card, .partner-item, .service-item {' +
        'opacity: 0;' +
        'transform: translateY(30px);' +
        'transition: all 0.6s ease;' +
        '}' +
        '.game-card.animate-in, .partner-item.animate-in, .service-item.animate-in {' +
        'opacity: 1;' +
        'transform: translateY(0);' +
        '}';
    $('<style>')
        .prop('type', 'text/css')
        .html(animationCSS)
        .appendTo('head');
        
    } catch (error) {
        console.error('jQuery compatibility error:', error);
        // Fallback: basic functionality without problematic selectors
        console.log('Running in compatibility mode');
    }

    // Progress Circle Animation
    function drawProgressCircle(canvas, progress) {
        const ctx = canvas.getContext('2d');
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = canvas.width * 0.35; // Responsive radius based on canvas size
        const lineWidth = canvas.width * 0.06; // Responsive line width
        
        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Background circle
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
        ctx.strokeStyle = '#e1e8ed';
        ctx.lineWidth = lineWidth;
        ctx.stroke();
        
        // Progress circle
        const progressAngle = (progress / 100) * 2 * Math.PI;
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, -Math.PI / 2, -Math.PI / 2 + progressAngle);
        ctx.strokeStyle = '#3498db';
        ctx.lineWidth = lineWidth;
        ctx.lineCap = 'round';
        ctx.stroke();
    }
    
    function animateProgressCircle(canvas, targetProgress) {
        let currentProgress = 0;
        const increment = targetProgress / 60; // 60 frames for smooth animation
        
        function animate() {
            currentProgress += increment;
            if (currentProgress >= targetProgress) {
                currentProgress = targetProgress;
            }
            
            drawProgressCircle(canvas, currentProgress);
            
            if (currentProgress < targetProgress) {
                requestAnimationFrame(animate);
            }
        }
        
        animate();
    }
    
    // Initialize progress circles when they come into view
    function initProgressCircles() {
        const circles = document.querySelectorAll('.progress-circle');
        
        circles.forEach(canvas => {
            const progress = parseInt(canvas.getAttribute('data-progress')) || 0;
            
            // Set canvas size - get actual size from CSS
            const computedStyle = window.getComputedStyle(canvas.parentElement);
            const canvasSize = parseInt(computedStyle.width);
            canvas.width = canvasSize;
            canvas.height = canvasSize;
            
            // Check if element is in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Delay animation slightly for better effect
                        setTimeout(() => {
                            animateProgressCircle(canvas, progress);
                        }, 200);
                        observer.unobserve(canvas);
                    }
                });
            }, {
                threshold: 0.5
            });
            
            observer.observe(canvas);
        });
    }
    
    // Initialize progress circles
    initProgressCircles();
});

document.addEventListener("DOMContentLoaded", function() {
    const tabs = document.querySelectorAll(".games-tab-item");
    const contents = document.querySelectorAll(".games-main-content");

    tabs.forEach((tab, index) => {
        tab.addEventListener("click", () => {
            // Bỏ active tab cũ
            tabs.forEach(t => t.classList.remove("active"));
            contents.forEach(c => c.classList.remove("active"));

            // Active tab mới
            tab.classList.add("active");
            contents[index].classList.add("active");
        });
    });
});
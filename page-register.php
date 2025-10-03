<?php
/*
Template Name: Đăng ký (Auth)
*/
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo esc_html(get_the_title()); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/css/auth.css'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class('auth-body'); ?>>
	<div class="auth-wrap">
		<div class="auth-card">
			<div class="auth-header">
				<div class="auth-brand">
					<img src="<?php echo esc_url( get_site_url(null, '/wp-content/uploads/2025/10/football.png') ); ?>" alt="logo" />
					<!-- <span>kaiyun.com</span> -->
				</div>
				<!-- <div class="auth-sub">创建新账户</div> -->
			</div>
			<div class="auth-body-inner">
				<?php 
					$__ky_errors = get_transient('ky_reg_errors');
					if (!empty($__ky_errors) && is_array($__ky_errors)) {
						delete_transient('ky_reg_errors');
						echo '<div class="auth-errors" style="margin-bottom:12px;color:#ffb3b3;background:rgba(255,0,0,.08);border:1px solid rgba(255,0,0,.25);padding:10px;border-radius:8px;">';
						foreach ($__ky_errors as $msg) { echo '<div>• ' . esc_html($msg) . '</div>'; }
						echo '</div>';
					}
				?>
				<form method="post" action="">
					<div class="auth-input">
						<span class="auth-ico ico-user"></span>
						<input type="text" name="user_login" placeholder="用户名" required>
					</div>
					<div class="auth-input">
						<span class="auth-ico ico-pass"></span>
						<input type="email" name="user_email" placeholder="邮箱" required>
					</div>
					<div class="auth-input">
						<span class="auth-ico ico-pass"></span>
						<input type="password" name="password" placeholder="密码" minlength="6" required>
					</div>
					<div class="auth-input">
						<span class="auth-ico ico-pass"></span>
						<input type="password" name="password_confirm" placeholder="确认密码" minlength="6" required>
					</div>
					<?php do_action('register_form'); ?>
					<?php wp_nonce_field('ky_reg_nonce_action', 'ky_reg_nonce'); ?>
					<input type="hidden" name="ky_register" value="1" />
					<button class="auth-btn" type="submit">注册</button>
					<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url('/') ); ?>" />
				</form>
			</div>
			<div class="auth-quick">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path('login') ) ); ?>">
					<img src="<?php echo esc_url( get_site_url(null, '/wp-content/uploads/2025/10/user.png') ); ?>" alt="Đăng nhập">
					<span>登录</span>
				</a>
				<a href="tel:+000000000">
					<img src="<?php echo esc_url( get_site_url(null, '/wp-content/uploads/2025/10/call.png') ); ?>" alt="Liên hệ">
					<span>联系</span>
				</a>
				<a href="<?php echo esc_url( home_url('/') ); ?>">
					<img src="<?php echo esc_url( get_site_url(null, '/wp-content/uploads/2025/10/football.png') ); ?>" alt="Trang chủ">
					<span>首页</span>
				</a>
			</div>
		</div>
	</div>
	<?php wp_footer(); ?>
</body>
</html>



<?php
/*
Template Name: Hồ sơ người dùng (Profile)
*/

if ( ! is_user_logged_in() ) {
	wp_safe_redirect( wp_login_url( get_permalink() ) );
	exit;
}

$current_user = wp_get_current_user();
$avatar_url   = get_avatar_url( $current_user->ID, array('size' => 96) );
$display_name = $current_user->display_name ? $current_user->display_name : $current_user->user_login;
$user_email   = $current_user->user_email;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo esc_html( get_the_title() ?: '个人资料' ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/profile.css' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class('profile-body'); ?>>
	<div class="profile-wrap">
		<div class="profile-container">
			<aside class="profile-sidebar">
				<div class="profile-usercard">
					<img class="profile-avatar" src="<?php echo esc_url($avatar_url); ?>" alt="avatar">
					<div class="profile-username"><?php echo esc_html($display_name); ?></div>
					<div class="profile-useremail"><?php echo esc_html($user_email); ?></div>
				</div>
				<ul class="profile-menu">
					<li class="active" data-tab="basic">个人资料</li>
					<li data-tab="vip">VIP特权</li>
					<li data-tab="message">消息中心</li>
					<li data-tab="security">账户安全</li>
					<li data-tab="bank">银行卡</li>
					<li data-tab="records">投注记录</li>
					<li data-tab="wallet">资金记录</li>
					<li data-tab="app">APP中心</li>
				</ul>
			</aside>
			<main class="profile-main">
				<section class="card" data-pane="basic">
					<h2 class="card-title">基本资料</h2>
					<form class="basic-form" method="post" action="">
						<div class="form-row">
							<label>昵称</label>
							<input type="text" name="display_name" value="<?php echo esc_attr($display_name); ?>" />
						</div>
						<div class="form-row">
							<label>邮箱</label>
							<input type="email" name="user_email" value="<?php echo esc_attr($user_email); ?>" />
						</div>
						<div class="form-row">
							<label>性别</label>
							<div class="radio-group">
								<label><input type="radio" name="gender" value="male" /> 男</label>
								<label><input type="radio" name="gender" value="female" /> 女</label>
							</div>
						</div>
						<div class="form-row">
							<label>生日</label>
							<input type="date" name="birthday" />
						</div>
						<div class="form-actions">
							<button type="submit" class="btn-primary" name="ky_profile_save" value="1">保存</button>
						</div>
						<?php wp_nonce_field('ky_profile_save', 'ky_profile_nonce'); ?>
					</form>
				</section>

				<section class="card" data-pane="security">
					<h2 class="card-title">账户安全</h2>
					<ul class="security-list">
						<li><span>绑定邮箱</span><a class="btn-line" href="<?php echo esc_url( admin_url('profile.php') ); ?>">修改</a></li>
						<li><span>登录密码</span><a class="btn-line" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">重置</a></li>
						<li><span>二次密码</span><a class="btn-line" href="#">设置</a></li>
					</ul>
				</section>
			</main>
		</div>
	</div>

	<?php wp_footer(); ?>
	<script>
	(function(){
		var menu = document.querySelectorAll('.profile-menu li');
		var panes = document.querySelectorAll('.profile-main .card');
		menu.forEach(function(item){
			item.addEventListener('click', function(){
				menu.forEach(function(i){ i.classList.remove('active'); });
				item.classList.add('active');
				var tab = item.getAttribute('data-tab');
				panes.forEach(function(p){
					p.style.display = (p.getAttribute('data-pane') === tab || (tab==='basic' && p.getAttribute('data-pane')==='basic')) ? 'block' : 'none';
				});
			});
		});
		panes.forEach(function(p){ p.style.display = p.getAttribute('data-pane')==='basic' ? 'block' : 'none'; });
	})();
	</script>
</body>
</html>



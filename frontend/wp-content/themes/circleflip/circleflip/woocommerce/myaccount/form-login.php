<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
<div class="col2-set" id="customer_login">

	

<?php endif; ?>
	<div class="container">
		<div class="row">
			<div class="span6">
				<h2><?php _e( 'Login', 'woocommerce' ); ?></h2>
		
				<form method="post" class="login">
		
					<?php do_action( 'woocommerce_login_form_start' ); ?>
		
					<p class="form-row form-row-wide">
						<input type="text" class="input-text" name="username" id="username" placeholder="<?php _e( 'Username or email address', 'woocommerce' ); ?>*" />
					</p>
					<p class="form-row form-row-wide">
						<input class="input-text" type="password" name="password" id="password" placeholder="<?php _e( 'Password', 'woocommerce' ); ?>*"/>
					</p>
		
					<?php do_action( 'woocommerce_login_form' ); ?>
		
					<p class="form-row">
						<?php wp_nonce_field( 'woocommerce-login' ); ?>
						<button type="submit" class="button red btnStyle2" name="login">
							<span><?php _e( 'Login', 'woocommerce' ); ?></span>
							<span class="btnBefore"></span>
							<span class="btnAfter"></span>
						</button>
						<label for="rememberme" class="inline">
							<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
						</label>
					</p>
					<p class="lost_password">
						<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
					</p>
		
					<?php do_action( 'woocommerce_login_form_end' ); ?>
		
				</form>
			</div>
		</div>
	
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

		<div class="container">
			<div class="row">
				<div class="span6">
				<h2><?php _e( 'Register', 'woocommerce' ); ?></h2>
		
				<form method="post" class="register">
		
					<?php do_action( 'woocommerce_register_form_start' ); ?>
		
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
		
						<p class="form-row form-row-wide">
							<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" placeholder="<?php _e( 'Username', 'woocommerce' ); ?>*"/>
						</p>
		
					<?php endif; ?>
		
					<p class="form-row form-row-wide">
						<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" placeholder="<?php _e( 'Email address', 'woocommerce' ); ?>*"/>
					</p>
		
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
			
						<p class="form-row form-row-wide">
							<input type="password" class="input-text" name="password" id="reg_password" value="<?php if ( ! empty( $_POST['password'] ) ) echo esc_attr( $_POST['password'] ); ?>" placeholder="<?php _e( 'Password', 'woocommerce' ); ?>*" />
						</p>
		
					<?php endif; ?>
		
					<!-- Spam Trap -->
					<div style="left:-999em; position:absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
		
					<?php do_action( 'woocommerce_register_form' ); ?>
					<?php do_action( 'register_form' ); ?>
		
					<p class="form-row">
						<?php wp_nonce_field( 'woocommerce-register', 'register' ); ?>
						<button type="submit" class="button red btnStyle2" name="register">
							<span><?php _e( 'Register', 'woocommerce' ); ?></span>
							<span class="btnBefore"></span>
							<span class="btnAfter"></span>
						</button>
					</p>
		
					<?php do_action( 'woocommerce_register_form_end' ); ?>
		
				</form>
			</div>
		</div>
	</div>

</div>
<?php endif; ?>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
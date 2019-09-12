<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class contactform_widget extends WP_Widget {
	// constructor
	public function __construct() {
		$widget_ops = array( 'classname' => 'contactform-widget', 'description' => esc_attr__('Display your contact form in a widget.', 'contact-form') );
		parent::__construct( 'contactform-widget', esc_attr__('Contact Form', 'contact-form'), $widget_ops );
	}

	// set widget and title in dashboard
	function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'text' => '',
			'attributes' => ''
		));
		$title = !empty( $instance['title'] ) ? $instance['title'] : __('Contact Form', 'contact-form');
		$text = $instance['text'];
		$attributes = $instance['attributes'];
		?>

       <!--

We offer customers e-Commerce packages that are customized as per specific needs and budget. So, if you have an idea and wish to turn it into an online store, We can
help you do it. Contact me for an Ecommerce solution that works best for your company.

We offer ecommerce development services in the following areas.

Ecommerce Application Development
Ecommerce Cart Development
Shopping Cart Development
Payment Gateway Integration
Custom Ecommerce Website Design
Maintenance and Support

Since eCommerce domain is evolving at a rapid pace, eCommerce solutions have started playing the vital role in implementing the business process online. This is where
eCommerce solutions come in. We offer you a wide range of ecommerce services ranging from consultancy to development & marketing.

We pioneers in developing e-commerce websites leveraging the latest and the best Open Source Technology. We are experts in creating graphically attractive and
user-friendly websites for different business setups and requirements.

Our Ecommerce website designers are adept at Ecommerce Website Development with integrated shopping cart software and comprehensible features that enable your customers to quickly and easily complete their transactions. Over the years, we’ve built quite a number of e-commerce websites for businesses selling different products and / or services.

       -->
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_attr_e('Title', 'contact-form'); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
 		</p>
		<p>
		<label for="<?php echo $this->get_field_id('text'); ?>"><?php esc_attr_e('Text above form', 'contact-form'); ?>:</label>
		<textarea class="widefat monospace" rows="6" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo wp_kses_post( $text ); ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'attributes' ); ?>"><?php esc_attr_e('Attributes', 'contact-form'); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'attributes' ); ?>" name="<?php echo $this->get_field_name( 'attributes' ); ?>" type="text" placeholder="<?php esc_attr_e( 'Example: email_to=&quot;your-email-here&quot;', 'contact-form' ); ?>" value="<?php echo esc_attr( $attributes ); ?>">
 		</p>
		<?php $link_label = __( 'click here', 'contact-form' ); ?>
		<?php $link_wp = '<a href="https://wordpress.org/plugins/contact-form" target="_blank">'.$link_label.'</a>'; ?>
		<?php $link_settings = '<a href="'.admin_url( 'options-general.php?page=contactform' ).'">'.$link_label.'</a>'; ?>
		<p><?php printf( esc_attr__( 'For info, available attributes and support %s.', 'contact-form' ), $link_wp ); ?></p>
		<p><?php printf( esc_attr__( 'For plugin settings %s.', 'contact-form' ), $link_settings ); ?></p>
		<?php
	}

	// update widget
	function update( $new_instance, $old_instance ) {
		$instance = array();

		// sanitize content
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['text'] = wp_kses_post( $new_instance['text'] );
		$instance['attributes'] = sanitize_text_field( $new_instance['attributes'] );

		return $instance;
	}

	// display widget with form in frontend
	function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', esc_attr($instance['title']) ). $args['after_title'];
		}

		if ( !empty( $instance['text'] ) ) {
			echo '<div class="contactform-widget-text">'.wpautop( wp_kses_post($instance['text']).'</div>');
		}

		$content = '[contact-widget ';
		if ( !empty( $instance['attributes'] ) ) {
			$content .= wp_strip_all_tags($instance['attributes']);
		}
		$content .= ']';
		echo do_shortcode( $content );

		echo $args['after_widget'];
	}
}

<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Adds Logo_Widget widget.
 */
class Social_Widget extends WP_Widget {

	private $socialfields, $icons;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'social_widget', // Base ID
			esc_html__( 'Social Widget', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'A Widget for all your Socials', 'text_domain' ), ) // Args
		);

		$this->socialfields = array(
			'social_email' 		=> 'Email',
			'social_search' 	=> 'Search',
			'social_pinterest'	=> 'Pinterest',
			'social_facebook' 	=> 'Facebook',
			'social_twitter' 	=> 'Twitter',
			'social_linkedin' 	=> 'Linkedin',
			'social_youtube' 	=> 'Youtube',
		);

		$this->icons = array (
			'social_email' 		=> 'fa-email',
			'social_search' 	=> 'fa-search',
			'social_pinterest'	=> 'fa-pinterest',
			'social_facebook' 	=> 'fa-facebook',
			'social_twitter' 	=> 'fa-twitter',
			'social_linkedin' 	=> 'fa-linkedin',
			'social_youtube' 	=> 'fa-youtube',
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		printf('<div class="social-container">');

		foreach ($this->icons as $key => $icon) :
			if ( ! empty( $instance[$key] ) ) {
				printf( '<a href="%s" target="_blank">
					<span class="fa-stack fa-lg">
					  <i class="fa fa-circle-thin fa-stack-2x"></i>
					  <i class="fa %s fa-stack-1x"></i>
					</span>
					</a>', $instance[$key], $icon );
			}
		endforeach;

		printf('</div>');

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
		$fontsize = ! empty( $instance['font-size'] ) ? $instance['font-size'] : esc_html__( '30', 'text_domain' );

		?>
		<!-- Title -->
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<!-- Social Fields -->
		<?php foreach ($this->socialfields as $variable => $value) : 
			$$variable = !empty( $instance[$variable] ) ? $instance[$variable] : esc_html__( '', 'text_domain' )
		?>
			<p>
			<label for="<?php echo esc_attr( $this->get_field_id( $variable ) ); ?>"><?php esc_attr_e( $value, 'text_domain' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $variable ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $variable ) ); ?>" type="text" value="<?php echo esc_attr( $$variable ); ?>">
			</p>

		<?php endforeach;

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		foreach ($this->socialfields as $key => $value) {
			$instance[$key] = ( ! empty( $new_instance[$key] ) ) ? strip_tags( $new_instance[$key] ) : '';
		}

		return $instance;
	}
} // class Logo_Widget

// register Logo_Widget widget
function register_social_widget() {
    register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );

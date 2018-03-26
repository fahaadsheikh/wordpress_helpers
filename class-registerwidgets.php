<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RegisterWidgets
{

	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'widgets_init', array( $this, 'fss_register_widget' ) );
	}

	/**
	 * Register our Widgets
	 *
	 **/
	function fss_register_widget() {

		register_sidebar( array(
			'name'          => 'Widget Name',
			'id'            => 'widget_id',
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title ">',
			'after_title'   => '</h6>',
		) );
	}

}

$RegisterWidgets = new RegisterWidgets();

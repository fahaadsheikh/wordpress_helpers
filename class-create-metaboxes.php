<?php
/**
* Add Metaboxes to Wordpress Post Types
*/
class Add_Metabox {
	
	function __construct() {
		add_action( 'add_meta_boxes', array( $this , 'register_metabox') );
		$metaboxes = array(
			'metabox-id' => 'Metabox Title'
		);
		$screens = array( 'post', 'page' );
	}
	/**
	 * Register the Metabox
	 *
	 * @param int $post_id
	 */
	public function register_metabox() {
	    foreach ( $this->screens as $screen ) {
	        add_meta_box(
	            'metabox-id',
	            __( 'Metabox Title', 'text_domain' ),
	            'metabox_callback_function',
	            $screen
	        );
	    }
	}
	/**
	 * Fields to display in the post.
	 *
	 * @param int $post_id
	 */
	public function metabox_callback_function( $post ) {
	    // Add a nonce field so we can check for it later.
	    wp_nonce_field( basename( __FILE__ ), 'metabox_nonce' );
	    $metabox_values = get_post_meta( $post->ID, true );
	    foreach ($this->metaboxes as $metabox_id => $metabox_title ) { ?>

			<p>
			<label for="title-class"><?php _e( $metabox_title, 'text_domain' ); ?></label>
			<br />
			<input class="widefat" type="text" class="field-class" name="<?php echo esc_attr( $metabox_id ) ?>" id="<?php echo esc_attr( $metabox_id ) ?>" value="<?php echo esc_attr( $value['metabox_value'] ); ?>" size="30" />
			</p>

	    <? }
	}
	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id
	 */
	public function save_global_notice_meta_box_data( $post_id ) {
	    // Check if our nonce is set.
	    if ( ! isset( $_POST['metabox_nonce'] ) ) {
	        return;
	    }
	    // Verify that the nonce is valid.
	    if ( ! wp_verify_nonce( $_POST['metabox_nonce'], 'metabox_nonce' ) ) {
	        return;
	    }
	    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	        return;
	    }
	    // Check the user's permissions.
	    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	        if ( ! current_user_can( 'edit_page', $post_id ) ) {
	            return;
	        }
	    }
	    else {
	        if ( ! current_user_can( 'edit_post', $post_id ) ) {
	            return;
	        }
	    }
	    /* OK, it's safe for us to save the data now. */
	    // Sanitize user input.
	    foreach ($this->metaboxes as $metabox_id => $metabox_title ) { 
	    	 // Update the meta field in the database.
	    	 update_post_meta( $post_id, $metabox_id, sanitize_text_field( $_POST['metabox_id'] ) );
	    }
	}
}

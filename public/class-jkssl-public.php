<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpmastery.xyz
 * @since      1.0.0
 *
 * @package    Jkssl
 * @subpackage Jkssl/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jkssl
 * @subpackage Jkssl/public
 * @author     Jan Koch <jan@jkoch.me>
 */
class Jkssl_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jkssl_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jkssl_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jkssl-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jkssl_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jkssl_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jkssl-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Load sessions that are currently live.
	 *
	 * @return WP_Query
	 */
	public function load_live_sessions() {
		if ( ! $live_sessions = wp_cache_get( 'jkssl_live_sessions' ) ) { // phpcs:ignore
			$query_args = array(
				'post_type'   => 'sessions',
				'post_status' => 'publish',
			);

			$two_days_ago = date( 'Ymd', strtotime( '-2 days' ) );
			$today        = date( 'Ymd' );

			$query_args['meta_query'] = array(
				'relation'           => 'AND',
				'two_days_ago_query' => array(
					'key'     => 'ess_session_day',
					'value'   => $two_days_ago,
					'compare' => '>',
				),
				'today_query'        => array(
					'key'     => 'ess_session_day',
					'value'   => $today,
					'compare' => '<=',
				),
			);

			$live_sessions = new WP_Query( $query_args );
			if ( $live_sessions->have_posts() ) {
				wp_cache_set( 'jkssl_live_sessions', $live_sessions->posts, '', 86400 );

				return $live_sessions->posts;
			}
		} else {
			return ( wp_cache_get( 'jkssl_live_sessions' ) );
		}
	}

	/**
	 * Shortcode callback to render the live sessions.
	 *
	 * @return void
	 */
	public function render_live_sessions() {
		ob_start();
		$live_sessions = $this->load_live_sessions();
		if ( ! empty( $live_sessions ) ) {
			echo "<div id='summit-sessions-container'>";
			foreach ( $live_sessions as $live_session ) {
				set_query_var( 'session_id', $live_session->ID );
				self::get_template_part( 'jkssl-public-display' );
			}
			echo '</div>';
		}
		echo ob_get_clean();
	}

	public static function get_template_part( $slug, $name = null ) {

		do_action( "jkssl_get_template_part_{$slug}", $slug, $name );

		$templates = array();
		if ( isset( $name ) ) {
			$templates[] = "{$slug}-{$name}.php";
		}

		$templates[] = "{$slug}.php";

		self::get_template_path( $templates, true, false );
	}

	/*
	 Extend locate_template from WP Core
	* Define a location of your plugin file dir to a constant in this case = PLUGIN_DIR_PATH
	* Note: PLUGIN_DIR_PATH - can be any folder/subdirectory within your plugin files
	*/
	public static function get_template_path( $template_names, $load = false, $require_once = true ) {
		$located = '';
		foreach ( (array) $template_names as $template_name ) {
			if ( ! $template_name ) {
				continue;
			}

			/* search file within the PLUGIN_DIR_PATH only */
			if ( file_exists( ABSPATH . 'wp-content/plugins/jkssl/public/partials/' . $template_name ) ) {
				$located = ABSPATH . 'wp-content/plugins/jkssl/public/partials/' . $template_name;
				break;
			}
		}

		if ( $load && '' != $located ) {
			load_template( $located, $require_once );
		}

		return $located;
	}

}

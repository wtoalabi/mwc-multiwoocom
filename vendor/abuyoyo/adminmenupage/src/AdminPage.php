<?php
	/**
	 * AdminPage
	 *
	 * Helper class
	 * Create WordPress admin pages easily
	 *
	 * @author  abuyoyo
	 * @version 0.12
	 *
	 * @todo add 'menu_location' - settings. tools, toplevel etc.
	 * @todo add add_screen_option( 'per_page', $args );
	 * @todo accept WPHelper\PluginCore instance (get title slug etc. from there)
	 * @todo fix is_readable() PHP error when sending callback array
	 */
	
	namespace WPHelper;
	
	use function add_menu_page;
	use function add_options_page;
	use function add_submenu_page;
	
	if ( ! class_exists( 'WPHelper\AdminPage' ) ):
		class AdminPage {
			/**
			 * Title di`splayed on page.
			 *
			 * @var string
			 */
			protected $title;
			
			/**
			 * Title displayed in menu.
			 *
			 * @var string
			 */
			protected $menu_title;
			
			/**
			 * User capabailty required to view page.
			 *
			 * @var string
			 */
			protected $capability;
			
			/**
			 * Menu slug.
			 *
			 * @var string
			 */
			protected $slug;
			
			/**
			 * Path to the admin page templates.
			 *
			 * @var string
			 */
			protected $template;
			
			/**
			 * Parent slug if submenu.
			 *
			 * @var string
			 */
			protected $parent;
			
			/**
			 * Icon to use in menu.
			 *
			 * @var string
			 */
			protected $icon_url;
			
			/**
			 * Position in menu.
			 *
			 * @var int
			 */
			protected $position;
			
			/**
			 * Render callback function.
			 *
			 * @var callable
			 */
			protected $render_cb;
			
			/**
			 * Render template file
			 *
			 * @var string filename
			 */
			protected $render_tpl;
			
			/**
			 * Scripts
			 *
			 * @var array[] arrays of script arguments passed to wp_enqueue_script()
			 */
			protected $scripts;
			
			/**
			 * Styles
			 *
			 * @var array[] arrays of script arguments passed to wp_enqueue_style()
			 */
			protected $styles;
			
			/**
			 * Settings Page
			 *
			 * @var SettingsPage
			 */
			protected $settings_page;
			
			/**
			 * Constructor.
			 *
			 * @param array $options
			 */
			public function __construct( $options ) {
				
				$options = (object) $options;
				
				if ( isset( $options->title ) ) {
					$this->title( $options->title );
				}
				
				if ( ! isset( $options->menu_title ) ) {
					$options->menu_title = $options->title;
				}
				
				if ( isset( $options->menu_title ) ) {
					$this->menu_title( $options->menu_title );
				}
				
				if ( isset( $options->capability ) ) {
					$this->capability( $options->capability );
				}
				
				if ( isset( $options->slug ) ) {
					$this->slug( $options->slug );
				}
				
				if ( isset( $options->render ) ) // dev
				{
					$this->render( $options->render );
				}
				
				if ( isset( $options->render_cb ) ) // dev - deprecate?
				{
					$this->render_cb( $options->render_cb );
				}
				
				if ( isset( $options->render_tpl ) ) // dev - deprecate?
				{
					$this->render_tpl( $options->render_tpl );
				}
				
				if ( true ) {
					$this->render();
				} // render anyway - will use default tpl if render is empty
				
				if ( isset( $options->parent ) ) {
					$this->parent( $options->parent );
				}
				
				if ( isset( $options->icon_url ) ) {
					$this->icon_url( $options->icon_url );
				}
				
				if ( isset( $options->position ) ) {
					$this->position( $options->position );
				}
				
				if ( isset( $options->scripts ) ) {
					$this->scripts( $options->scripts );
				}
				
				if ( isset( $options->styles ) ) {
					$this->styles( $options->styles );
				}
				
				if ( isset( $options->settings ) ) {
					$this->settings( $options->settings );
				}
				
				$this->bootstrap();
			}
			
			function title( $title ) {
				$this->title = $title;
			}
			
			function menu_title( $menu_title ) {
				$this->menu_title = $menu_title;
			}
			
			function capability( $capability ) {
				$this->capability = $capability;
			}
			
			function slug( $slug ) {
				$this->slug = $slug;
			}
			
			function parent( $parent ) {
				$this->parent = $parent;
			}
			
			function icon_url( $icon_url ) {
				$this->icon_url = $icon_url;
			}
			
			function position( $position ) {
				$this->position = $position;
			}
			
			
			function render( $render = null ) {
				if ( 'settings-page' == $render ) {
					$this->render_tpl( __DIR__ . '/tpl/settings_page.php' );
				} else if ( is_callable( $render ) ) {
					$this->render_cb( $render );
				} else if ( is_readable( $render ) ) {
					$this->render_tpl( $render );
				} else {
					$this->render_tpl( __DIR__ . '/tpl/default.php' );
				}
			}
			
			function render_cb( $render_cb ) {
				
				// we already have it
				if ( $this->render_cb ) {
					return;
				}
				
				if ( is_callable( $render_cb ) ) {
					$this->render_cb = $render_cb;
				}
				
			}
			
			function render_tpl( $render_tpl ) {
				
				// we already have it
				if ( $this->render_tpl ) {
					return;
				}
				
				if ( is_readable( $render_tpl ) ) {
					$this->render_tpl = $render_tpl;
				}
				
			}
			
			function scripts( $scripts ) {
				$this->scripts = $scripts;
			}
			
			function styles( $styles ) {
				$this->styles = $styles;
			}
			
			function settings( $settings ) {
				$this->settings_page = new SettingsPage( $this->get_slug(), $settings );
				$this->settings_page->setup();
			}
			
			/**
			 * REGISTER MENU
			 *
			 * This runs for all registers
			 * hook_suffix not defined yet
			 *
			 * inside WPHelper namespace
			 * \get_current_screen() function not defined
			 * \current_action() also????
			 *
			 * @todo deprecate
			 */
			function setup() {
			
			}
			
			/**
			 * Set default user capability if none provided
			 *
			 * @return void
			 */
			function bootstrap() {
				if ( ! $this->capability ) {
					$this->capability = 'manage_options';
				}
				
				add_action( 'admin_menu', [ $this, 'add_menu_page' ], 11 );
				add_action( 'admin_menu', [ $this, '_bootstrap_admin_page' ], 12 );
			}
			
			/**
			 * Add WordPress toplevel or submenu page
			 */
			public function add_menu_page() {
				
				if ( ! $this->parent ) {
					$this->hook_suffix = add_menu_page(
						$this->title,
						$this->menu_title,
						$this->capability,
						$this->slug,
						[ $this, 'render_admin_page' ],
						$this->icon_url,
						$this->position
					);
				} else {
					switch ( $this->parent ) {
						case 'options':
						case 'settings':
							$this->hook_suffix = add_options_page(
								$this->title,
								$this->menu_title,
								$this->capability,
								$this->slug,
								[ $this, 'render_admin_page' ]
							);
							break;
						default:
							$this->hook_suffix = add_submenu_page(
								$this->parent,
								$this->title,
								$this->menu_title,
								$this->capability,
								$this->slug,
								[ $this, 'render_admin_page' ]
							);
							break;
					}
				}
				
			}
			
			/**
			 * REGISTER ADMIN PAGE
			 *
			 * hook_suffix is KNOWN
			 * get_current_screen() is NOT
			 *
			 * Runs for EVERY AdminPage instance
			 * AdminNotice->onPage() works
			 */
			function _bootstrap_admin_page() {
				add_action( 'load-' . $this->hook_suffix, [ $this, '_admin_page_setup' ] );
			}
			
			/**
			 * SHOW ADMIN PAGE
			 *
			 * current_screen IS AVAILABLE
			 *
			 * Only runs on actual screen showing
			 * AdminNotice->onPage() redundant
			 */
			public function _admin_page_setup() {
				
				if ( $this->scripts ) {
					add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
				}
				
				if ( $this->styles ) {
					add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_styles' ] );
				}
			}
			
			public function admin_enqueue_scripts( $hook ) {
				
				// redundant
				// this only gets called on load-{$this->hook_suffix} anyway
				if ( $hook != $this->hook_suffix ) {
					return;
				}
				
				if ( ! $this->scripts ) {
					return;
				}
				
				foreach ( $this->scripts as $script_args ) {
					wp_enqueue_script( ...$script_args );
				}
				
			}
			
			public function admin_enqueue_styles( $hook ) {
				
				// redundant
				// this only gets called on load-{$this->hook_suffix} anyway
				if ( $hook != $this->hook_suffix ) {
					return;
				}
				
				if ( ! $this->styles ) {
					return;
				}
				
				foreach ( $this->styles as $style_args ) {
					wp_enqueue_style( ...$style_args );
				}
				
			}
			
			/**
			 * Get the capability required to view the admin page.
			 *
			 * @return string
			 */
			public function get_capability() {
				return $this->capabailty;
			}
			
			/**
			 * Get the title of the admin page in the WordPress admin menu.
			 *
			 * @return string
			 */
			public function get_menu_title() {
				return $this->menu_title;
			}
			
			/**
			 * Get the title of the admin page.
			 *
			 * @return string
			 */
			public function get_title() {
				return $this->title;
			}
			
			/**
			 * Get the parent slug of the admin page.
			 *
			 * @return string
			 */
			public function get_parent_slug() {
				return $this->parent;
			}
			
			/**
			 * Get the slug used by the admin page.
			 *
			 * @return string
			 */
			public function get_slug() {
				return $this->slug;
			}
			
			
			/**
			 * Render the top section of the plugin's admin page.
			 */
			public function render_admin_page() {
				// @todo if render callback supplied - add shortcircuit hook here
				// execute render callback and return early
				
				if ( $this->render_cb && is_callable( $this->render_cb ) ) {
					call_user_func( $this->render_cb );
					
					return;
				} else if ( $this->render_tpl && is_readable( $this->render_tpl ) ) {
					include $this->render_tpl;
					
					return;
				}
			}
		}
	endif;

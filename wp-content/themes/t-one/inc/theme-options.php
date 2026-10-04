<?php

/**
  ReduxFramework Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('t_one_theme_options_fields')) {

    class t_one_theme_options_fields {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
			}

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections() {
			
			$admin_email = get_bloginfo('admin_email');


           // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(
				'icon' => 'el-icon-globe',
				'title' => __('General', 'redux-framework-demo'),
				'fields' => array(
					array(
                        "id" => "homepage_sections",
                        "type" => "sorter",
                        "title" => "Homepage Layout",
                        "compiler" => 'true',
                        'options' => array(
                            "disabled" => array(
                            ),
                            "enabled" => array(
								"services" => "Services",
								"clients" => "Clients",
								"quotes" => "Quotes",
								"portfolio" => "Portfolio",
								"extra-info" => "Extra-info",
								"about" => "About",
								"blog" => "Blog",
								"contact" => "Contact",
                            ),
                        ),
					),					
					array(
                        'id' => 'footer_text',
                        'type' => 'textarea',
                        'title' => __('Footer Text', 'redux-framework-demo'),
                        'validate' => 'html',
						'default' => 'PAMUKOVIC | 2014, all rights reserved | T-ONE Boostrap creative template 1-123-456-7890
                <br>
                <p>Designed for ThemeForest.net</p>'
                    ), 
					array(
						'id'=>'tracking-code',
						'type' => 'textarea',
						'title' => __('Tracking Code', 'redux-framework-demo'), 
						'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the header.', 'redux-framework-demo'),
						), 
					));
				
			$this->sections[] = array( 
				'icon' => ' el-icon-link', 
				'title' => __('Breadcrumbs', 'redux-framework-demo'), 
				'fields' => array( 
					 array( 
                        'id' => 'show_current', 
                        'type' => 'checkbox', 
                        'title' => __('Show current', 'redux-framework-demo'), 
                        'subtitle' => __('Display current post/page/category title in breadcrumbs.', 'redux-framework-demo'), 
                        'default' => 1, 
                    	),
					array( 
                        'id' => 'show_home_link', 
                        'type' => 'checkbox', 
                        'title' => __('Show home link', 'redux-framework-demo'), 
                        'subtitle' => __('Show the link to the home page.', 'redux-framework-demo'), 
                        'default' => 1, 
                    	),
					array( 
                        'id' => 'show_title', 
                        'type' => 'checkbox', 
                        'title' => __('Show title', 'redux-framework-demo'), 
                        'subtitle' => __('Show the title attribute for links.', 'redux-framework-demo'), 
                        'default' => 1, 
                    	),	
					array( 
						'id'=>'delimiter', 
						'type' => 'text', 
						'title' => __('Delimiter', 'redux-framework-demo'), 
						'subtitle' => __('Delimiter between crumbs.', 'redux-framework-demo'), 
						'default' => '/', 
						'validate' => 'html', 
						), 
					array( 
						'id'=>'home_page_text', 
						'type' => 'text', 
						'title' => __('Home page text', 'redux-framework-demo'), 
						'subtitle' => __('Text for home page link.', 'redux-framework-demo'), 
						'default' => 'Home', 
						'validate' => 'html', 
						), 
					array( 
						'id'=>'cat_page_text', 
						'type' => 'text', 
						'title' => __('Category page text', 'redux-framework-demo'), 
						'subtitle' => __('Text for category page link. Use %s to display category name.', 'redux-framework-demo'), 
						'default' => '%s', 
						'validate' => 'html', 
						),
					array( 
						'id'=>'search_page_text', 
						'type' => 'text', 
						'title' => __('Search page text', 'redux-framework-demo'), 
						'subtitle' => __('Text for home page link. Use %s to display search term.', 'redux-framework-demo'), 
						'default' => 'Search results for: %s', 
						'validate' => 'html', 
						), 
					array( 
						'id'=>'tags_page_text', 
						'type' => 'text', 
						'title' => __('Tags page text', 'redux-framework-demo'), 
						'subtitle' => __('Text for tags page link. Use %s to display tag name.', 'redux-framework-demo'), 
						'default' => 'Tag: %s', 
						'validate' => 'html', 
						),
					array( 
						'id'=>'author_page_text', 
						'type' => 'text', 
						'title' => __('Author page text', 'redux-framework-demo'), 
						'subtitle' => __('Text for author page link. Use %s to display author name.', 'redux-framework-demo'), 
						'default' => '%s\'s articles', 
						'validate' => 'html', 
						),
					array( 
						'id'=>'error_page_text', 
						'type' => 'text', 
						'title' => __('Error page text', 'redux-framework-demo'), 
						'subtitle' => __('Text for error page link.', 'redux-framework-demo'), 
						'default' => 'Error 404', 
						'validate' => 'html', 
						), 			
				));
			
			$this->sections[] = array( 

				'icon' => 'el-icon-user', 

				'title' => __('Media', 'redux-framework-demo'), 

				'fields' => array( 
					array(
						'id'=>'logo_img',
						'type' => 'media', 
						'url'=> true,
						'title' => __('Logo', 'redux-framework-demo'),
						'compiler' => 'true',
						'subtitle' => __('Upload your logo', 'redux-framework-demo'),
						'default'=>array('url'=> ''),
						),
					array(
						'id'=>'favicon_img',
						'type' => 'media', 
						'url'=> true,
						'title' => __('Favicon', 'redux-framework-demo'),
						'compiler' => 'true',
						'subtitle' => __('Ideal dimensions: 32x32 - 64x64', 'redux-framework-demo'),
						'default'=>array('url'=>get_template_directory_uri() . '/images/favicon.png'),
						),
					array(
						'id'=>'iphone_icon_img',
						'type' => 'media', 
						'url'=> true,
						'title' => __('iPhone Icon', 'redux-framework-demo'),
						'compiler' => 'true',
						'subtitle' => __('Ideal dimensions: 57x57', 'redux-framework-demo'),
						'default'=>array('url'=>''),
						),
					array(
						'id'=>'iphone_retina_icon_img',
						'type' => 'media', 
						'url'=> true,
						'title' => __('iPhone Retina Icon', 'redux-framework-demo'),
						'compiler' => 'true',
						'subtitle' => __('Ideal dimensions: 114x114', 'redux-framework-demo'),
						'default'=>array('url'=>''),
						),
					array(
						'id'=>'ipad_icon_img',
						'type' => 'media', 
						'url'=> true,
						'title' => __('iPad Icon', 'redux-framework-demo'),
						'compiler' => 'true',
						'subtitle' => __('Ideal dimensions: 72x72', 'redux-framework-demo'),
						'default'=>array('url'=>''),
						),
					array(
						'id'=>'ipad_retina_icon_img',
						'type' => 'media', 
						'url'=> true,
						'title' => __('iPad Retina Icon', 'redux-framework-demo'),
						'compiler' => 'true',
						'subtitle' => __('Ideal dimensions: 144x144', 'redux-framework-demo'),
						'default'=>array('url'=>''),
						),
					
			));
			$this->sections[] = array(
				'icon' => 'el-icon-brush',
				'title' => __('Styling Options', 'redux-framework-demo'),
				'fields' => array(	
					array(
						'id'=>'body-background',
						'type' => 'color',
						'mode' => 'background',
						'output' => array('body'),
						'title' => __('Body Background', 'redux-framework-demo'),
						'default' => '#fff',
						'validate' => 'color',
						),	
					array(
						'id'=>'primary',
						'type' => 'color',
						'mode' => 'background',
						'output' => array('.btn-dark', '.service-wrap .service-btm a:hover', '#clients', '.project-slide-wrap', '.cta', '#news', '#contact form .btn', '#footer', '.author-box', '.subheader', 'h4.heading'),
						'title' => __('Primary color', 'redux-framework-demo'), 
						'default' =>  '#212127',
						'validate' => 'color',
						),
					array(
						'id'=>'secondary',
                        'type' => 'color',
						'mode' => 'background',
						'output' => array('#portfolio', '#contact'),
						'title' => __('Secondary color', 'redux-framework-demo'), 
						'default' =>  '#f1f1f1',
						'validate' => 'color',
                    ),		
				));
				
				$this->sections[] = array(
				'icon' => 'el-icon-film',
				'title' => __('Slider', 'redux-framework-demo'),
				'fields' => array(
					array(
                        'id'        => 'slider_title',
                        'type'      => 'switch',
                        'title'     => __('Show slide title', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
					array(
                        'id'        => 'slider_mobile_caption',
                        'type'      => 'switch',
                        'title'     => __('Show slider caption on mobile?', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
					array(
						'id'=>'slider_speed',
						'type' => 'slider',
						'title' => __('Animation Speed', 'redux-framework-demo'),
						"default" => "1000",
                        "min" => "0",
                        "step" => "100",
                        "max" => "10000",
						),
					array(
                        'id'        => 'slider_direction_nav',
                        'type'      => 'switch',
                        'title'     => __('Direction Nav', 'redux-framework-demo'),
                        'subtitle'  => __('Show / hide direction nav.', 'redux-framework-demo'),
                        'default'   => 1,
                    ),			
				));
				
				$this->sections[] = array(
				'icon' => 'el-icon-list',
				'title' => __('Services', 'redux-framework-demo'),
				'fields' => array(
					array(
						'id'=>'services_title',
						'type' => 'text',
						'title' => __('Title', 'redux-framework-demo'),
						'validate' => 'html',
						'default' => 'We design digital products.',
						'class' => 'small-text'
						),						
					array(
						'id'=>'services_content',
						'type' => 'textarea',
						'title' => __('Content', 'redux-framework-demo'), 
						'default' => 'Your brand, your product, your big idea...it is worth pursuing. We believe in creating opportunities for elite brands, intrepid startups, and passionate innovators to change the world.',
						),
					array(
                        'id' => 'services_pages',
                        'type' => 'select',
                        'data' => 'pages',
                        'multi' => true,
                        'title' => __('Service Pages', 'redux-framework-demo'),
                        'subtitle' => __('Choose which pages will be displayed in the services', 'redux-framework-demo'),
						),
					),
				);
				
				$this->sections[] = array(
				'icon' => 'el-icon-briefcase',
				'title' => __('Clients', 'redux-framework-demo'),
				'fields' => array(
					array(
                        'id' => 'clients_title',
                        'type' => 'text',
                        'title' => __('Name', 'redux-framework-demo'),
                        'validate' => 'html',
                        'default' => 'We design delightful digital experiences'
                    ),					
					array(
						'id'=>'clients_content',
						'type' => 'textarea',
						'title' => __('Content', 'redux-framework-demo'), 
						'default' => 'We help organisations radically improve their websites and create exciting new digital products.
						We combine a unique lean approach with our knowledge of human behaviour and the principles of user-centred design.',
						), 
					array(
						'id'=>'clients_button_text',
						'type' => 'text',
						'title' => __('Button text', 'redux-framework-demo'),
						'validate' => 'html',
						'default' => 'Contact us',
						'class' => 'small-text'
						),	
					array(
						'id'=>'clients_button_url',
						'type' => 'text',
						'title' => __('Button link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
					array(
                        'id' => 'client1',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 1', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client1_url',
						'type' => 'text',
						'title' => __('Client 1 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),	
					array(
                        'id' => 'client2',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 2', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client2_url',
						'type' => 'text',
						'title' => __('Client 2 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
					array(
                        'id' => 'client3',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 3', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client3_url',
						'type' => 'text',
						'title' => __('Client 3 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
					array(
                        'id' => 'client4',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 4', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client4_url',
						'type' => 'text',
						'title' => __('Client 4 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
					array(
                        'id' => 'client5',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 5', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client5_url',
						'type' => 'text',
						'title' => __('Client 5 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
					array(
                        'id' => 'client6',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 6', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client6_url',
						'type' => 'text',
						'title' => __('Client 6 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
					array(
                        'id' => 'client7',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 7', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client7_url',
						'type' => 'text',
						'title' => __('Client 7 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
					array(
                        'id' => 'client8',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 8', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client8_url',
						'type' => 'text',
						'title' => __('Client 8 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
					array(
                        'id' => 'client9',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Client 9', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
					array(
						'id'=>'client9_url',
						'type' => 'text',
						'title' => __('Client 9 link', 'redux-framework-demo'),
						'validate' => 'url',
						'default' => '',
						'class' => 'small-text'
						),
				
				));
				
				$this->sections[] = array(
				'icon' => 'el-icon-quotes',
				'title' => __('Quotes', 'redux-framework-demo'),
				'fields' => array(
					array(
                        'id' => 'quote_pages',
                        'type' => 'select',
                        'data' => 'pages',
                        'multi' => true,
                        'title' => __('Quote Pages', 'redux-framework-demo'),
                        'subtitle' => __('Choose which pages will be displayed in the quote section', 'redux-framework-demo'),
                    ),	
				));
				
				$this->sections[] = array(
				'icon' => ' el-icon-th-large',
				'title' => __('Portfolio', 'redux-framework-demo'),
				'fields' => array(
					array(
						'id'=>'portfolio_title',
						'type' => 'text',
						'title' => __('Title', 'redux-framework-demo'),
						'validate' => 'html',
						'default' => 'Recent work',
						'class' => 'small-text'
						),
					array(
                        'id'        => 'portfolio_cta',
                        'type'      => 'switch',
                        'title'     => __('Call to action', 'redux-framework-demo'),
                        'subtitle'  => __('Activate for more options', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
					array(
						'id'=>'cta_content',
						'type' => 'textarea',
						'required'  => array('portfolio_cta', '=', '1'),
						'title' => __('Content', 'redux-framework-demo'), 
						'validate' => 'html',
						'default' => 'IF YOU LIKE WHAT WE DO, AND THINK WE COULD WORK TOGETHER, THEN GET IN TOUCH.',
						
						), 
					array(
						'id'=>'cta_button_text',
						'type' => 'text',
						'required'  => array('portfolio_cta', '=', '1'),
						'title' => __('Button text', 'redux-framework-demo'),
						'validate' => 'html',
						'default' => 'Get in touch',
						'class' => 'small-text'
						),	
					array(
						'id'=>'cta_button_url',
						'type' => 'text',
						'required'  => array('portfolio_cta', '=', '1'),
						'title' => __('Button link', 'redux-framework-demo'),
						'validate' => 'url',
						'class' => 'small-text'
						),		
				));
				
				$this->sections[] = array(
				'icon' => 'el-icon-quotes',
				'title' => __('Extra Info', 'redux-framework-demo'),
				'fields' => array(
					array(
						'id'=>'extra_info_title',
						'type' => 'text',
						'title' => __('Title', 'redux-framework-demo'),
						'validate' => 'html',
						'default' => 'We are passionate about solving problems with clarity, simplicity & honesty -',
						'class' => 'small-text'
						),						
					array(
						'id'=>'extra_info_column1',
						'type' => 'textarea',
						'title' => __('Column 1', 'redux-framework-demo'), 
						'default' => '<ul class="list-unstyled info-list">
                    <li>Web Design</li>
                    <li>Photography Theme</li>
                    <li>Personal portfolio</li>
                    <li>Gallery presentation</li>
                </ul>
                <p>Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante.</p>
                <p>Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante.</p>',
						), 	
					array(
						'id'=>'extra_info_column2',
						'type' => 'textarea',
						'title' => __('Column 2', 'redux-framework-demo'), 
						'default' => '<p>In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.</p>
                <p>Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante.</p>
                <p>Dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.</p>',
						), 	
				));
				
				 $this->sections[] = array(
				'icon' => 'el-icon-torso',
				'title' => __('About', 'redux-framework-demo'),
				'fields' => array(			
					array(
						'id'=>'about_title',
						'type' => 'text',
						'title' => __('Title', 'redux-framework-demo'),
						'validate' => 'html',
						'default' => 'Hand craftsmanship, digitally delivered',
						'class' => 'small-text'
						),						
					array(
						'id'=>'about_content',
						'type' => 'textarea',
						'title' => __('Content', 'redux-framework-demo'), 
						'default' => 'Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante.',
						), 
					array(
                        'id'        => 'about_members',
                        'type'      => 'switch',
                        'title'     => __('Members info', 'redux-framework-demo'),
                        'subtitle'  => __('Show team members.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),						
					array(
                        'id' => 'members_pages',
                        'type' => 'select',
                        'data' => 'pages',
						'required'  => array('about_members', '=', '1'),
                        'multi' => true,
                        'title' => __('Members Pages', 'redux-framework-demo'),
                        'subtitle' => __('Choose which pages will be displayed in the team members section', 'redux-framework-demo'),
                    	),
					),
				);
				
				$this->sections[] = array(
				'icon' => 'el-icon-pencil',
				'title' => __('Blog', 'redux-framework-demo'),
				'fields' => array(
					array(
						'id'=>'excerpt_lenght',
						'type' => 'slider',
						'title' => __('Excerpt Lenght', 'redux-framework-demo'),
						'subtitle' => __('Select the number of words to show in the excerpts.', 'redux-framework-demo'),
						"default" => "35",
                        "min" => "0",
                        "step" => "10",
                        "max" => "500",
						),
					array( 
						'id'=>'activate_author', 
						'type' => 'switch',  
						'title' => __('Show author info after post content.', 'redux-framework-demo'), 
						"default" => 1, 
						'on' => 'Show', 
						'off' => 'Hide', 
						),	
					),
				);
				
			$this->sections[] = array(
				'icon' => 'el-icon-flag',
				'title' => __('Contact Form', 'redux-framework-demo'),
				'fields' => array(
					array(
                        'id' => 'contact_title',
                        'type' => 'text',
                        'title' => __('Contact Title', 'redux-framework-demo'),
                        'validate' => 'html',
                        'default' => 'Get In Touch With Us'
                    ),	
					array(
						'id'=>'contact_email',
						'type' => 'text',
						'title' => __('Contact Email', 'redux-framework-demo'),
						'subtitle' => __('Add your email address. All emails from Contact Forms will be sent to this address.', 'redux-framework-demo'),
						'default' => $admin_email,
						'validate' => 'email',
						), 
					array(
                        'id' => 'contact_success',
                        'type' => 'text',
                        'title' => __('Success message', 'redux-framework-demo'),
                        'validate' => 'html',
                        'default' => '<h3>Wohoooo ! Well done </h3><p>Thank you <strong>%s</strong>, your message has been submitted to us.</p>'
                    ),	
					array(
                        'id'        => 'rechapta',
                        'type'      => 'switch',
                        'title'     => __('Rechapta', 'redux-framework-demo'),
						'subtitle' => __('Activate to display Google Rechapta. You will need <a href="//www.google.com/recaptcha/intro/index.html">Google Rechapta API Keys</a>', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
					array(
						'id'=>'rechapta_public_key',
						'type' => 'text',
						'required'  => array('rechapta', '=', '1'),
						'title' => __('Public key', 'redux-framework-demo'),
						'validate' => 'text',
						'class' => 'small-text'
						),
					array(
						'id'=>'rechapta_private_key',
						'type' => 'text',
						'required'  => array('rechapta', '=', '1'),
						'title' => __('Private key', 'redux-framework-demo'),
						'validate' => 'text',
						'class' => 'small-text'
						),
					));
			
			$this->sections[] = array(
				'icon' => 'el-icon-w3c',
				'title' => __('Custom CSS/JS', 'redux-framework-demo'),
				'fields' => array(
			        array(
						'id'=>'css-code',
						'type' => 'ace_editor',
						'title' => __('CSS Code', 'redux-framework-demo'), 
						'subtitle' => __('Add your custom CSS code.', 'redux-framework-demo'),
						'mode' => 'css',
						'validate' => 'css',
			            'theme' => 'chrome',
						),
			        array(
						'id'=>'js-code',
						'type' => 'ace_editor',
						'title' => __('JS Code', 'redux-framework-demo'), 
						'subtitle' => __('Add your custom JS code.', 'redux-framework-demo'),
						'mode' => 'javascript',
						'validate' => 'js',
			            'theme' => 'chrome',
						),						
				)
			);

        }

        public function setHelpTabs() {

          
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 't_one_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'submenu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title' => __('Theme Options', 'redux-framework-demo'),
                'page' => __('Theme Options', 'redux-framework-demo'),
                'google_api_key' => '',
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => false,                    // Show the panel pages on the admin bar
                'global_variable'   => 't_one_opt',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.


                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => 't_one_opt',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
            $this->args['share_icons'][] = array(
                'url' => 'https://github.com/genethic',
                'title' => 'Visit on GitHub',
                'icon' => 'el-icon-github'
                    // 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://twitter.com/WP_Genethic',
                'title' => 'Follow on Twitter',
                'icon' => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.linkedin.com/pub/laura-moreno/91/b20/321',
                'title' => 'Find on LinkedIn',
                'icon' => 'el-icon-linkedin'
            );
            
        }

    }

    new t_one_theme_options_fields();
}
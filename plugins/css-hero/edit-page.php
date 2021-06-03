<?php
$csshero_version="4.20";
$csshero_version_styles="4.20";
$theme_slug=csshero_get_active_theme_slug();
$html_theme_slug = $theme_slug;
$rocket_mode_string="";
if (is_child_theme()) $theme_slug=strtolower(get_template()); //gets the parent if we are using a child

//you can force here to override default configuration being applied to your theme | EXAMPLE: $theme_slug="yourtheme";
if (isset($_GET['override_theme_config'])) $theme_slug=sanitize_title($_GET['override_theme_config']);


setcookie('csshero_is_on', 1, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
global $csshero_public_demo_mode;
if ($csshero_public_demo_mode==TRUE) $ademo="cache_subject=demo&"; else $ademo="";

$site_base_url = site_url().'/';
$plugin_root_url= plugin_dir_url( __FILE__ );
?>

<!DOCTYPE html>
<html data-child-theme-slug="<?php echo $theme_slug; ?>">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title>CSS Hero &mdash; <?php echo $csshero_version; ?></title>
	<link rel="stylesheet" href="<?php echo $plugin_root_url ?>styles/codemirror.css" />
	<link rel="stylesheet" href="<?php echo $plugin_root_url ?>styles/icons.css" />
	<link rel="stylesheet" href="<?php echo $plugin_root_url ?>styles/gotham.css" />
	<link rel="stylesheet" href="<?php echo $plugin_root_url ?>styles/codemirror-colorpicker.css"/>
	<link rel="stylesheet" type="text/css" href="https://p.csshero.org/production-v4/style-versioning/style.php?v=<?php echo $csshero_version_styles; ?>" />
	
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/jquery-3.3.1.min.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/jquery-ui.min.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/jquery.perfect-scrollbar.min.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/csstojson.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror-css.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror-autoclose-brackets.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror-search.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror-searchcursor.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror-dialog.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror.matchbrackets.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror-colorpicker.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/codemirror-simplescrollbars.js"></script>	
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/beautify-css.min.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/is-in-viewport.js"></script>
	<script data-cfasync="false" src="<?php echo $plugin_root_url ?>js/worker.js"></script>
	

	
	<script data-cfasync="false">
		window.HEROWorker = new Worker('<?php echo $plugin_root_url ?>js/worker.js');
		
		window.csshero_plugin_root = '<?php echo $plugin_root_url ?>';
		window.csshero_admin_ajax_url='<?php echo admin_url( 'admin-ajax.php' ) ?>';
		
	</script>
	<?php 
		$herologo = '<svg version="1.1" class="cssherologo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="120px" height="30px" viewBox="0 0 120 30" enable-background="new 0 0 120 30" xml:space="preserve"><g><g><path d="M3.088,15.831c0-4.924,3.815-8.186,8.547-8.186c4.157,0,6.161,2.43,6.821,4.711l-4.135,1.302 c-0.256-1.323-1.385-2.218-2.878-2.218c-2.302,0-3.901,1.961-3.901,4.093c0,1.621,1.237,3.027,3.198,3.027 c1.108,0,2.387-0.724,2.878-1.64l3.368,2.173c-1.77,2.558-4.541,3.261-6.481,3.261C6.434,22.354,3.088,19.839,3.088,15.831z"/><path d="M17.186,19.584l2.558-3.07c0.981,1.279,2.985,2.175,4.903,2.175c0.81,0,1.13-0.363,1.13-0.618 c0-1.194-6.8-1.151-6.8-5.308c0-2.473,2.046-5.094,6.097-5.094c2.323,0,4.647,0.809,6.203,2.366l-2.579,2.984 c-1.172-1.172-2.985-1.727-4.328-1.727c-0.554,0-0.874,0.257-0.874,0.576c0,1.13,6.821,1.194,6.821,5.308 c0,2.984-2.345,5.179-6.011,5.179C21.279,22.354,18.593,21.268,17.186,19.584z"/><path d="M30.26,19.584l2.558-3.07c0.981,1.279,2.985,2.175,4.903,2.175c0.81,0,1.13-0.363,1.13-0.618c0-1.194-6.8-1.151-6.8-5.308 c0-2.473,2.046-5.094,6.097-5.094c2.323,0,4.647,0.809,6.203,2.366l-2.579,2.984c-1.172-1.172-2.985-1.727-4.328-1.727 c-0.554,0-0.874,0.257-0.874,0.576c0,1.13,6.821,1.194,6.821,5.308c0,2.984-2.344,5.179-6.011,5.179 C34.353,22.354,31.667,21.268,30.26,19.584z"/></g><g><path d="M66.582,22.099l1.194-5.436h-5.095l-1.193,5.436h-4.306L60.316,7.88h4.305l-1.108,5.032h5.095l1.108-5.032h4.305 l-3.133,14.219H66.582z"/><path d="M73.2,22.099L76.334,7.88h10.786l-0.831,3.753h-6.479l-0.299,1.406h6.33l-0.831,3.753h-6.33l-0.342,1.555h6.481 l-0.831,3.753H73.2z"/><path d="M93.904,22.099l-0.979-4.476h-1.727l-0.981,4.476h-4.306L89.044,7.88h6.906c2.579,0,4.775,1.685,4.775,4.306 c0,2.515-1.64,4.456-3.496,5.117l1.408,4.796H93.904z M94.65,13.87c0.939,0,1.621-0.404,1.621-1.215 c0-0.595-0.533-1.022-1.194-1.022h-2.558l-0.489,2.237h2.557H94.65z"/><path d="M100.968,15.831c0-4.541,3.602-8.186,8.548-8.186c4.199,0,7.396,2.643,7.396,6.481c0,4.541-3.581,8.227-8.526,8.227 C104.165,22.354,100.968,19.69,100.968,15.831z M112.457,14.467c0-1.748-1.277-3.027-3.197-3.027c-2.26,0-3.836,1.92-3.836,4.093 c0,1.748,1.279,3.027,3.197,3.027C110.881,18.56,112.457,16.642,112.457,14.467z"/></g><g><g><path d="M48.247,22.479c-0.159-0.103,2.623-5.95,2.529-6.208c-0.098-0.255-3.045-1.192-3.192-1.644 c-0.145-0.451,5.825-7.237,5.983-7.105c0.154,0.131-2.602,6.017-2.527,6.208c0.075,0.191,3.098,1.167,3.19,1.645 C54.32,15.855,48.409,22.584,48.247,22.479z"/></g></g></g></svg>'; ?>

	
		<script data-cfasync="false" charset="UTF-8" type="text/javascript" src='https://p.csshero.org/production-v4/heroes-loader-v4.php?<?php echo $ademo ?>version=<?php echo $csshero_version ?>&key=<?php echo  wpcss_check_license() ?>&theme=<?php echo $theme_slug ?>&thv=<?php $my_theme = wp_get_theme(); echo   $my_theme->get( 'Version' ); ?>&plugins=<?php echo csshero_get_active_site_plugins() ?>'></script> 

</head>
<body id="csshero-body" data-admin-url="<?php echo get_admin_url(); ?>" data-js-version="<?php echo $csshero_version;?>" data-css-version="<?php echo $csshero_version_styles; ?>" data-plugin-root="<?php echo $plugin_root_url ?>" data-mq-mode="all" data-site-base-url="<?php echo $site_base_url; ?>" class="show-bottom-navi">
<div id="hero-preload">
	<div>
	<?php echo $herologo; ?>
	<span>Loading...</span>
	</div>
</div>
<div id="hero-editor">
	<div id="hero-splash">
		<svg version="1.1" id="cassio" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"><path fill="#111111" d="M36,10.431h-8.645l-0.329-5.674c0,0-0.018-0.007-0.059-0.022c-0.022-2.102-3.109-4.71-6.933-4.735 C20.022,0.001,20.011,0,20,0c-0.01,0-0.022,0-0.031,0c-3.868,0-6.997,2.634-6.997,4.758l-0.327,5.674H4l5.833,17.355 C8.6,28.411,4.44,30.41,4.44,30.41s4.645,0.573,9.123,3.208c2.422,1.425,4.814,3.455,6.437,6.323 c0.011,0.02,0.023,0.039,0.033,0.058c4.604-8.224,15.527-9.59,15.527-9.59s-4.16-2-5.392-2.624L36,10.431z M10.947,11.064 l-0.205,4.62l1.144,2.164l-1.837,8.596L4.88,11.064H10.947z M18.419,10.069l-3.943-0.313V8.893l3.943,0.45V10.069z M25.524,9.756 l-3.946,0.313V9.343l3.946-0.45V9.756z M35.12,11.064l-5.169,15.38l-1.838-8.596l1.145-2.164l-0.205-4.62H35.12z"></path></svg>
		<div class="welcome">
			<h4>Welcome to CSS Hero <span><?php echo $csshero_version; ?></span></h4>
			<p>Click an <span>element</span> on the page to start editing your theme.</p>
			<hr>
			<p>Need some help getting started?</p>
			<a href="//csshero.org/docs-v3/#h5" target="_blank">Video Tutorials</a>
		</div>
	</div>
	<div id="hero-core"></div>
	<div id="hero-inspector-head">
		
		<span class="inc-dec-fs plus">A+</span>
		<span class="inc-dec-fs minus">A-</span>
		<span class="insp-cog ico">
			<ul>
				<li class="auto-select">Auto Select</li>
				<li class="dw">Code Theme
					<ul>
						<li class="swap-theme cur" data-theme="csshero-theme">Dark</li>
						<li class="swap-theme" data-theme="csshero-theme-light">Light</li>
					</ul>
				</li>
				<li class="show-colors-in-code">Show colors</li>
				<li class="hero-beautify cur">Beautify code</li>
			</ul>
		</span>
	</div>
	<div id="hero-core-cm"></div>
	<div id="hero-inspector-bottom-actions">
		<label>Export:</label>
		<span>CSS</span>
		<span class="exp-mini">Minified CSS</span>
		<span class="exp-less">LESS</span>
	</div>
	<div id="hero-head">
		<span class="csshero-logo">
			<?php echo $herologo ;?>
		</span>
		<span class="inspector-trigger">Inspector</span>
		<span class="hero-detach-editor ico"></span>
	</div>
	<div id="hero-selector-bar">
		<div class="load-line"></div>
		<div id="hero-selectors"></div>
		<div class="hero-status ico"><label><b>State</b><div class="hero-states"></div></label></div>
	</div>
	<div id="hero-wysiwyg" class="scroller" data-mode="wysiwyg"></div>
	<div id="hero-top-actions" data-mode="wysiwyg">
		<span class="hero-toggle-code-editor">Code Editor</span>
		<span class="hero-make-class ico"></span>
		<span class="hero-reset-props ico"></span>
	</div>
	<div id="hero-code-editor" data-mode="wysiwyg">
		<span class="toggle-code-editor"></span>
		<div id="hero-code-editor-selector"></div>
		<div id="hero-code-editor-cm" class="scroller"></div>
		<div id="hero-code-editor-footer">}</div>
		<div id="hero-code-bottom-actions">
			<span class="inc-dec-fs plus">A+</span><span class="inc-dec-fs minus">A-</span>
		</div>
	</div>
	
	<div id="hero-bottom-actions">
		<span id="hero-cancel" class="no-cancel">CANCEL</span>
		<span id="hero-save">SAVE</span>
	</div>
</div>
<div id="csshero-wrap">
	<div id="hero-bar">
		<div id="hero-mqs"></div>
		<ul id="hero-services">
			<li class="navigate" data-tip="Switch to navigation mode. <kbd>CMD/CTRL + H</kbd>" data-tip-orient="s">
				<span class="s">Edit</span>
				<em></em>
				<span class="n">Navigate</span>
			</li>
			<li class="hr"></li>
			<li class="hero-history ico back" data-tip="Undo <kbd>CMD/CTR + Z</kbd>" data-tip-orient="s"></li>
			<li class="hero-history ico forth" data-tip="Redo <kbd>CMD/CTR + X</kbd>" data-tip-orient="s"></li>
			<li class="hero-history ico load" data-service="history"></li>
			<li class="hr"></li>
			<li class="dd">
				CheckPoints
				<ul>
					<li class="open-snapshot-save">Save CheckPoint</li>
					<li data-service="snapshots">Load CheckPoints</li>
				</ul>
			</li>
			<li class="dd">
				Project
				<ul>
					<li class="hero-add-mq">Media Query Manager</li>
					<li data-service="tree">Selectors Tree</li>
					<li data-service="variables">Project Variables</li>
					<li class="hero-project-gfonts">Manage Google Fonts</li>
				</ul>
			</li>
			<li class="dd">
				Tools
				<ul>
					<li class="csshero-view-as-unlogged unlogged-tool" data-switch-class="viewing-as-unlogged" data-param="&csshero_view_as_unlogged=1">View As Unlogged</li>
					<li class="csshero-style-login-page unlogged-tool" data-param="&csshero_style_wp_login_page=1" data-switch-class="viewing-login-page">Style Login Page</li>
					<li class="hero-reset">Reset Theme Edits</li>
				</ul>
			</li>
			<li class="csshero-quit">
				<a href="<?php echo esc_url( add_query_arg( 'csshero_action','shutdown' )); ?>">Quit</a>
			</li>
			
		</ul>
	</div>
	<div class="hero-bottom-bar hero-bottom-bar-nav"></div>
	<div class="hero-bottom-bar hero-bottom-bar-mq">
		<div id="hero-mq-reference">
			<div class="ruler">
				<span>0px</span>
				<span>50px</span>
				<span>100px</span>
				<span>150px</span>
				<span>200px</span>
				<span>250px</span>
				<span>300px</span>
				<span>350px</span>
				<span>400px</span>
				<span>450px</span>
				<span>500px</span>
				<span>550px</span>
				<span>600px</span>
				<span>650px</span>
				<span>700px</span>
				<span>750px</span>
				<span>800px</span>
				<span>850px</span>
				<span>900px</span>
				<span>950px</span>
				<span>1000px</span>
				<span>1050px</span>
				<span>1100px</span>
				<span>1150px</span>
				<span>1200px</span>
				<span>1250px</span>
				<span>1300px</span>
				<span>1350px</span>
				<span>1400px</span>
			</div>
		</div>
	</div>
	<div id="csshero-frame-wrap">
		<div id="csshero-editable-loader"><span></span></div>
		<div id="csshero-inner-frame-wrap">
			<div class="quick-mq-adder hero-add-mq" data-tip="Add Media-Query breakpoint" data-tip-orient="n">+</div>
			<div id="csshero-focus-view"></div>
			<div id="hero-resizer-mask"></div>
			<div class="selector-preview-mask"></div>
			<iframe  src="<?php echo esc_url( remove_query_arg( 'csshero_action' )); ?>" id="csshero-iframe-main-page"   name="csshero-iframe-main-page"></iframe>
		</div>
		<div id="add-selector-box" class="closed">
			<h4>Add Selector</h4>
			<div class="hero-add-selector-input-wrap closed">
				<input type="text" placeholder="Add custom selector" />
				<ul class="scroller">
					
				</ul>
				<span></span>
			</div>
			<span class="add-selector-count">0</span>
			<span class="add-selector-save">Add</span>
			<span class="add-selector-close ico csshero-add-selector-toggle"></span>
		</div>
	</div>
	<div class="hero-service scroller" data-s="variables">
		<div class="service-head">
			<span class="close-service ico"></span>
			<h4>Project Variables</h4>
			<p>Variables can help you controlling commonly used values and make your code easier to maintain by giving you a way to manage those values from a single location</p>
		</div>
		<div id="project-vars"></div>
	</div>
	<div class="hero-service scroller" data-s="tree">
		<div class="service-head">
			<span class="close-service ico"></span>
			<h4>CSS Selectors</h4>
			<p>Browse current page editable elements from here</p>
		</div>
		<div id="hero-tree"></div>
	</div>
	<div class="hero-service scroller" data-s="history">
		<div class="service-head">
			<span class="close-service ico"></span>
			<h4>History</h4>
			<p>Browse all your edits history from here.</p>
		</div>
		<div id="hero-history"></div>
	</div>
	<div class="hero-service scroller" data-s="snapshots">
		<div class="service-head">
			<span class="close-service ico"></span>
			<h4>CheckPoints</h4>
			<p>CheckPoints are stored copies of your work which you can save for further usage without publishing them to your live website.<br />A CheckPoint includes all your edits applied at the moment you save it.</p>
		</div>
		<div id="hero-snapshots"></div>
	</div>
</div>
<div id="csshero-save-data">
	<form> <!-- current state -->
		<textarea hidden name="csshero-data-from-db" id="csshero-data-from-db"><?php echo ((csshero_get_data())); //addslashes ?></textarea>  
	</form>
	<div id="csshero-save-nonce" style="display: none"> <?php wp_nonce_field('csshero_saving_nonce','csshero_saving_nonce_field'); ?></div>
</div>


<form class="csshero-upload-img-form" method="post" enctype="multipart/form-data">
	<input type="file" name="newpicture" size="25">
	<span class="csshero-upload-img-name"></span>
	<input type="submit" name="submit" value="Submit">
</form>


</body>
</html>
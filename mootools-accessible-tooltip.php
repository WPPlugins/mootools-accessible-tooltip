<?php
/*
Plugin Name: MooTools Accessible Tooltip
Plugin URI: http://wordpress.org/extend/plugins/mootools-accessible-tooltip/
Description: WAI-ARIA Enabled Tooltip Plugin for Wordpress
Author: Kontotasiou Dionysia
Version: 3.0
Author URI: http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/

add_action("plugins_loaded", "MooToolsAccessibleTooltip_init");
function MooToolsAccessibleTooltip_init() {
    register_sidebar_widget(__('MooTools Accessible Tooltip'), 'widget_MooToolsAccessibleTooltip');
    register_widget_control(   'MooTools Accessible Tooltip', 'MooToolsAccessibleTooltip_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_MooToolsAccessibleTooltip') ) {

        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('mootools-core', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tooltip/lib/mootools-core.js'));
        wp_enqueue_script('mootools-core');

        wp_register_script('mootools-more', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tooltip/lib/mootools-more.js'));
        wp_enqueue_script('mootools-more');

        wp_register_script('tooltip', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tooltip/lib/tooltip.js'));
        wp_enqueue_script('tooltip');
		
        wp_register_style('MooToolsAccessibleTooltip_css', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tooltip/lib/MooToolsAccessibleTooltip.css'));
        wp_enqueue_style('MooToolsAccessibleTooltip_css');
		
		wp_register_style('main_css', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tooltip/lib/Assets/main.css'));
        wp_enqueue_style('main_css');
    }
}

function widget_MooToolsAccessibleTooltip($args) {
    extract($args);

    $options = get_option("widget_MooToolsAccessibleTooltip");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Tooltip',
            'tooltip' => 'Type what to search for',
            'search' => 'Search'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    MooToolsAccessibleTooltipContent();
    echo $after_widget;
}

function MooToolsAccessibleTooltipContent() {
    $options = get_option("widget_MooToolsAccessibleTooltip");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Tooltip',
            'tooltip' => 'Type what to search for',
            'search' => 'Search'
        );
    }

    echo '
	<form action="" id="searchform" method="get" role="search">
		<div class="widget_search" id="searchformMooToolsAccessibleTooltip">
			<label for="searchtext" class="screen-reader-text">Search for:</label>
			<input type="text" id="searchtext" name="searchtext" value="" >
			<input type="submit" value="Search" id="searchsubmitMooToolsAccessibleTooltip">
		</div>
	</form>
	<script>
		window.addEvent(\'domready\', function(){
			var tooltip1 = new AscTip($(\'searchtext\'), \'' . $options['tooltip'] . '\');
			var tooltip2 = new AscTip($(\'searchsubmitMooToolsAccessibleTooltip\'), \'' . $options['search'] . '\');
		});
	</script>
    ';
}

function MooToolsAccessibleTooltip_control() {
    $options = get_option("widget_MooToolsAccessibleTooltip");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Tooltip',
            'tooltip' => 'Type what to search for',
            'search' => 'Search'
        );
    }

    if ($_POST['MooToolsAccessibleTooltip-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['MooToolsAccessibleTooltip-WidgetTitle']);
        update_option("widget_MooToolsAccessibleTooltip", $options);
    }
    if ($_POST['MooToolsAccessibleTooltip-SubmitTooltip']) {
        $options['tooltip'] = htmlspecialchars($_POST['MooToolsAccessibleTooltip-WidgetTooltip']);
        update_option("widget_MooToolsAccessibleTooltip", $options);
    }
    if ($_POST['MooToolsAccessibleTooltip-SubmitSearch']) {
        $options['search'] = htmlspecialchars($_POST['MooToolsAccessibleTooltip-WidgetSearch']);
        update_option("widget_MooToolsAccessibleTooltip", $options);
    }
    ?>
    <p>
        <label for="MooToolsAccessibleTooltip-WidgetTitle">Widget Title: </label>
        <input type="text" id="MooToolsAccessibleTooltip-WidgetTitle" name="MooToolsAccessibleTooltip-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="MooToolsAccessibleTooltip-SubmitTitle" name="MooToolsAccessibleTooltip-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="MooToolsAccessibleTooltip-WidgetTooltip">Translation for "Type what to search for": </label>
        <input type="text" id="MooToolsAccessibleTooltip-WidgetTooltip" name="MooToolsAccessibleTooltip-WidgetTooltip" value="<?php echo $options['tooltip'];?>" />
        <input type="hidden" id="MooToolsAccessibleTooltip-SubmitTooltip" name="MooToolsAccessibleTooltip-SubmitTooltip" value="1" />
    </p>
    <p>
        <label for="MooToolsAccessibleTooltip-WidgetSearch">Translation for "Search": </label>
        <input type="text" id="MooToolsAccessibleTooltip-WidgetSearch" name="MooToolsAccessibleTooltip-WidgetSearch" value="<?php echo $options['search'];?>" />
        <input type="hidden" id="MooToolsAccessibleTooltip-SubmitSearch" name="MooToolsAccessibleTooltip-SubmitSearch" value="1" />
    </p>
    
    <?php
}

?>

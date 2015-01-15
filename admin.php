<?php
/**
 * @author    Jason Lemahieu and Kevin Graeme (Cooperative Extension Technology Services)
 * @copyright Copyright (c) 2011 - 2015 Jason Lemahieu and Kevin Graeme (Cooperative Extension Technology Services)
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package   CETS\Conditional_Widgets
 */

add_action( 'admin_enqueue_scripts', 'conditional_widgets_enqueue_assets' );

function conditional_widgets_enqueue_assets( $hook ) {

	$pages = apply_filters( 'conditional_widgets_admin_pages', array( 'widgets.php', 'customize.php' ) );

	if ( ! in_array( $hook, $pages ) ) {
		return;
	}

	wp_enqueue_style( 'conditional_widgets_admin_styles', plugins_url( "css/conditional-widgets-admin.css", __FILE__ ), array(), '2.1.0-dev' );
	wp_enqueue_script( 'conditional_widgets_admin_scripts', plugins_url( "js/conditional-widgets-admin.js", __FILE__ ), 'jquery', '2.1.0-dev', true );

} // END conditional_widgets_enqueue_assets()

/**
 * Helper function for outputting the select boxes in the widget's form
 */
function conditional_widgets_form_show_hide_select($name, $value='', $only=false) {
	echo "<select name=$name>";
	echo "<option value='1' ";
	if ($value == 1) {echo "selected='selected'";}
	echo ">Show </option>";
	
	if ($only) {
		echo "<option value='2' ";
		if ($value == 2) {echo "selected='selected'";}
		echo "> Show only</option>";
	}
	
	echo "<option value='0' ";
	if ($value == 0) {echo "selected='selected'";}
	echo ">Hide </option>";
	echo "</select>";
}	

/**
 * Helper function for displaying the list of checkboxes for Pages
 */
function conditional_widgets_page_checkboxes($selected=array()) {
	echo "<ul class='conditional-widget-selection-list'>";
	wp_list_pages( array( 'title_li' => null, 'walker' => new Conditional_Widgets_Walker_Page_Checklist($selected) ) );
	echo "</ul>";
}


function conditional_widgets_term_checkboxes($tax, $type, $selected = array()) {
	echo "<ul class='conditional-widget-selection-list'>";
	$args = array(
			'selected_cats' => $selected,
			'checked_ontop' => false,
			'taxonomy' => $tax,
			'walker' => new Conditional_Widget_Walker_Category_Checklist($type, $tax),

		);
	wp_terms_checklist(0, $args);
	echo "</ul>";
}
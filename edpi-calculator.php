<?php
/**
 * Plugin Name: eDPI Calculator
 * Plugin URI: https://example.com/
 * Description: A plugin that calculates eDPI from user input and displays it on the frontend, with form validation.
 * Version: 1.0.0
 * Author: Anas Ansari
 * Author URI: https://example.com/
 */

// Enqueue the plugin's JavaScript file
function edpi_calculator_enqueue_scripts() {
    wp_enqueue_script( 'edpi-calculator-script', plugins_url( '/js/edpi-calculator.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_localize_script( 'edpi-calculator-script', 'edpi_calculator_vars', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'edpi_calculator_enqueue_scripts' );

// Register the AJAX endpoint
function edpi_calculate_ajax() {
    $mouse_sensitivity = floatval( $_POST['mouse_sensitivity'] );
    $dpi = floatval( $_POST['dpi'] );
    $edpi = $mouse_sensitivity * $dpi;

    echo $edpi;
    wp_die();
}
add_action( 'wp_ajax_edpi_calculate', 'edpi_calculate_ajax' );
add_action( 'wp_ajax_nopriv_edpi_calculate', 'edpi_calculate_ajax' );

// Register the shortcode
function edpi_calculator_shortcode() {
    ob_start();
    ?>
    <form id="edpi-calculator-form">
        <label for="mouse_sensitivity">Mouse Sensitivity:</label>
        <input type="text" name="mouse_sensitivity" id="mouse_sensitivity" required pattern="[0-9]+([\.,][0-9]+)?" title="Enter only Numbers">

        <label for="dpi">DPI:</label>
        <input type="text" name="dpi" id="dpi" required pattern="[0-9]+([\.,][0-9]+)?" title="Enter only Numbers">

        <button type="submit">Calculate</button>
    </form>

    <div id="edpi-result"></div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'edpi_calculator', 'edpi_calculator_shortcode' );
jQuery(document).ready(function($) {

  $('#edpi-calculator-form').submit(function(event) {
    event.preventDefault();

    var mouseSensitivityInput = $('#mouse_sensitivity');
    var dpiInput = $('#dpi');
    var edpiResult = $('#edpi-result');

    // Check if mouse sensitivity and dpi inputs are numbers
    if (!($.isNumeric(mouseSensitivityInput.val())) || !($.isNumeric(dpiInput.val()))) {
      edpiResult.html('<p class="edpi-error">Please enter only numeric values</p>');
      return;
    }

    $.ajax({
      url: edpi_calculator_vars.ajax_url,
      type: 'POST',
      data: {
        action: 'edpi_calculate',
        mouse_sensitivity: mouseSensitivityInput.val(),
        dpi: dpiInput.val(),
      },
      success: function(response) {
        edpiResult.html('<p>Your eDPI is ' + response + '</p>');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  });

});
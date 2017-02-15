/**
 * @author Batch Themes Ltd.
 */
(function() {
    'use strict';

    $(function() {

        var config = $.localStorage.get('config');
        $('body').attr('data-layout', config.layout);
        $('body').attr('data-palette', config.theme);

        $('#date-picker1').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
        });

        $('#date-picker2').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
        });

        $('#date-picker3').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'

        });
        $('#date-picker4').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'

        });

        $('#date-picker5').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
            
        });
        $('#date-picker6').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
            
        });
		$('#date-picker7').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
            
        });
        $('#date-picker8').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
            
        });
        $('#date-picker9').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
            
        });
        $('#date-picker10').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
            
        });
        $('#date-picker11').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
            
        });
        $('#date-picker12').datepicker({
            orientation: 'bottom left',
            format: 'yyyy-mm-dd'
            
        });
        $('.demo1').colorpicker().on('changeColor.colorpicker', function(event) {
            console.log(event.color.toHex());
        });

        $('.demo2').colorpicker().on('changeColor.colorpicker', function(event) {
            console.log(event.color.toRGB());
        });
    });

})();

/**
 * Created by ANKIT on 7/19/2015.
 */

jQuery(document).ready(function($){
    $('#question_type').click(function(){
        $('.question_section').hide();
        $('#' + $(this).val()).show();
    }
    );
});

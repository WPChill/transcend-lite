jQuery(document).ready(function () {

    /* If there are required actions, add an icon with the number of required actions in the About transcend page -> Actions required tab */
    var transcend_nr_actions_required = transcendWelcomeScreenObject.nr_actions_required;

    if ((typeof transcend_nr_actions_required !== 'undefined') && (transcend_nr_actions_required != '0')) {
        jQuery('li.transcend-w-red-tab a').append('<span class="transcend-actions-count">' + transcend_nr_actions_required + '</span>');
    }

    /* Dismiss required actions */
    jQuery(".transcend-dismiss-required-action").click(function () {

        var id = jQuery(this).attr('id');
        jQuery.ajax({
            type: "GET",
            data: {action: 'transcend_dismiss_required_action', dismiss_id: id},
            dataType: "html",
            url: transcendWelcomeScreenObject.ajaxurl,
            beforeSend: function (data, settings) {
                jQuery('.transcend-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + transcendWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success: function (data) {
                location.reload();
                jQuery("#temp_load").remove();
                /* Remove loading gif */
                jQuery('#' + data).parent().slideToggle().remove();
                /* Remove required action box */
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });
});

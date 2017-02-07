jQuery(document).ready(function () {
    var transcend_aboutpage = transcendWelcomeScreenCustomizerObject.aboutpage;
    var transcend_nr_actions_required = transcendWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
    if ((typeof transcend_aboutpage !== 'undefined') && (typeof transcend_nr_actions_required !== 'undefined') && (transcend_nr_actions_required != '0')) {
        jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + transcend_aboutpage + '"><span class="transcend-actions-count">' + transcend_nr_actions_required + '</span></a>');
    }


});

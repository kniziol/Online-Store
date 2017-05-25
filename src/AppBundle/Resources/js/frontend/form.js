/**
 * Handler for the document's "ready" event.
 * Simple and useful improvements for the frontend.
 */
$(document).ready(function() {
    /*
     * Focus 1st text field
     */
    $('input[type="text"], input[type="password"], input[type="email"], textarea', 'form').first().focus();

    /*
     * Disable the submit button
     */
    $('form').submit(function(event) {
        $('[type="submit"]', event.target).attr('disabled', 'disabled');
    });
});

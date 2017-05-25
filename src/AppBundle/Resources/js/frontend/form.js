/**
 * Handler for the document's "ready" event.
 * Simple and useful improvements for the frontend.
 */
$(document).ready(function() {
    handleFormSubmit();
    focusFirstTextField();

    /**
     * Handler for the "submit" event of a form.
     * Disables the submit button after submit of a form.
     */
    function handleFormSubmit() {
        $('form').submit(function(event) {
            $('[type="submit"]', event.target).attr('disabled', 'disabled');
        });
    }

    /**
     * Focuses the 1st text field of a form
     *
     * If a form contains text fields with validation errors, focuses 1st field with error. Otherwise - 1st field
     * from the whole form.
     */
    function focusFirstTextField() {
        var textFieldSelector = 'input[type="text"], input[type="password"], input[type="email"], textarea';
        var parentSelector = 'form .form-group.has-error';

        if ($(textFieldSelector, parentSelector).length === 0) {
            parentSelector = 'form';
        }

        $(textFieldSelector, parentSelector).first().focus();
    }
});

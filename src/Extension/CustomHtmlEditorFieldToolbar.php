<?php

namespace CWP\Core\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\Form;
use SilverStripe\View\Requirements;

/**
 * Adds the CWP JavaScript to the CMS insert media form.
 *
 * This extension carries no feature flag. `HtmlEditorField_Toolbar`, the class _config/extensions.yml
 * applies it to, was removed in CMS 6 along with the `updateMediaForm` hook, so nothing calls this
 * and there is no behaviour for a flag to switch off. Whether it can be ported to the CMS 6 media
 * form is part of the upgrade rather than of feature flagging.
 *
 * @extends Extension<\HtmlEditorField_Toolbar>
 */
class CustomHtmlEditorFieldToolbar extends Extension
{
    /**
     * @param Form $form
     * @return void
     */
    public function updateMediaForm(Form $form)
    {
        Requirements::add_i18n_javascript('cwp/cwp-core:javascript/lang');
        Requirements::javascript('cwp/cwp-core:javascript/CustomHtmlEditorFieldToolbar.js');
    }
}

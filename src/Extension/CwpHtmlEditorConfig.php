<?php

namespace CWP\Core\Extension;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Group;

/**
 * @extends Extension<Group>
 */
class CwpHtmlEditorConfig extends Extension
{
    use Configurable;

    /**
     * Whether groups without an explicit HTML editor configuration fall back to the 'cwp' config
     * rather than the CMS default. Turning it off returns those groups to the CMS default.
     *
     * @config
     * @var bool
     */
    private static $enabled = true;

    /**
     * @return string|null
     *
     * Override the default HtmlEditorConfig from 'cms' to 'cwp' defined in cwp-core/_config.php
     * However if the group has a custom editor configuration set, use that instead.
     */
    public function getHtmlEditorConfig()
    {
        $originalConfig = $this->owner->getField("HtmlEditorConfig");

        if ($originalConfig) {
            return $originalConfig;
        }

        if (!static::config()->get('enabled')) {
            return null;
        }

        return 'cwp';
    }
}

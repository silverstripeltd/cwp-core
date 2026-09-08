<?php

namespace CWP\Core\Config;

/**
 * Runs queued jobs through the Doorman engine, which is the runner the platform's job processing
 * is set up for.
 *
 * Applied in _config/queuedjobs.yml, and only where symbiote/silverstripe-queuedjobs is installed.
 * Disabling leaves the runner on whatever that module configures.
 */
class QueuedJobsConfig
{
    use FeatureToggle;

    /**
     * @config
     */
    private static string $service = 'Symbiote\QueuedJobs\Services\QueuedJobService';

    /**
     * The runner this module configures, and the one symbiote/silverstripe-queuedjobs configures
     * for itself. Disabling puts the module's own runner back: dropping the property outright
     * would leave the service with no runner at all, and job processing would stop.
     *
     * @config
     */
    private static string $runner = '%$Symbiote\QueuedJobs\Tasks\Engines\DoormanRunner';

    /**
     * @config
     */
    private static string $runner_default = '%$Symbiote\QueuedJobs\Tasks\Engines\QueueRunner';

    public static function apply(): void
    {
        if (static::isEnabled()) {
            return;
        }

        static::restoreInjectorProperty(
            static::config()->get('service'),
            'queueRunner',
            static::config()->get('runner'),
            static::config()->get('runner_default')
        );
    }
}

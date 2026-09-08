<?php

namespace CWP\Core\Config;

use SilverStripe\Control\Middleware\CanonicalURLMiddleware;
use SilverStripe\Core\Environment;

/**
 * Redirects the login and API URL patterns to HTTPS on test and live environments, and sends the
 * whole site to HTTPS on test where basic authentication would otherwise pass credentials in the
 * clear. CWP_SECURE_DOMAIN redirects those patterns to a specific domain.
 *
 * Applied in _config/security.yml. Disabling stops this module forcing HTTPS at the application
 * layer; the platform still terminates TLS, but nothing redirects a plain HTTP request.
 */
class SslConfig
{
    use FeatureToggle;

    /**
     * The URL patterns _config/security.yml forces to HTTPS. Set to null on test, where the whole
     * site is forced instead.
     *
     * @config
     */
    private static array $patterns = [
        '/^Security/',
        '/^api/',
    ];

    /**
     * The environments _config/security.yml enables the middleware for.
     *
     * @config
     */
    private static array $enabled_envs = [
        'live',
        'test',
    ];

    public static function apply(): void
    {
        if (static::isEnabled()) {
            return;
        }

        // ForceSSL with no patterns means every URL is redirected, so the patterns can only come
        // off together with ForceSSL itself. Where ForceSSL is not the true this module sets - on
        // dev, or because the project configured it - there is nothing here to switch off, and
        // taking the patterns away on their own would force HTTPS more widely rather than less.
        if (static::injectorValue(CanonicalURLMiddleware::class, ['properties', 'ForceSSL']) !== true) {
            return;
        }

        static::restoreInjectorProperty(CanonicalURLMiddleware::class, 'ForceSSL', true, false);
        static::dropInjectorProperty(
            CanonicalURLMiddleware::class,
            'ForceSSLPatterns',
            static::config()->get('patterns')
        );
        static::dropInjectorProperty(
            CanonicalURLMiddleware::class,
            'EnabledEnvs',
            static::config()->get('enabled_envs')
        );
        static::dropInjectorProperty(
            CanonicalURLMiddleware::class,
            'ForceSSLDomain',
            Environment::getEnv('CWP_SECURE_DOMAIN')
        );
    }
}

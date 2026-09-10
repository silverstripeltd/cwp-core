<?php

/**
 * General CWP configuration
 *
 * More configuration is applied in cwp/_config/config.yml for APIs that use
 * {@link Config} instead of setting statics directly.
 * NOTE: Put your custom site configuration into mysite/_config/config.yml
 * and if absolutely necessary if you can't use the yml file, mysite/_config.php instead.
 */

use CWP\Core\Config\CmsStylesConfig;
use CWP\Core\Config\DocumentConverterConfig;
use CWP\Core\Config\LocaleConfig;
use CWP\Core\Config\LoggingConfig;
use CWP\Core\Config\MemberSecurityConfig;
use CWP\Core\Config\OEmbedConfig;
use CWP\Core\Config\PasswordEncryptionConfig;
use CWP\Core\Config\PasswordFieldConfig;
use CWP\Core\Config\PasswordStrengthConfig;
use CWP\Core\Config\QueuedJobsConfig;
use CWP\Core\Config\SessionConfig;
use CWP\Core\Config\SslConfig;
use CWP\Core\Config\TextExtractionConfig;
use SilverStripe\Core\Environment;
use SilverStripe\HybridSessions\HybridSession;

// default to the binary being in the usual path on Linux
if (!Environment::getEnv('WKHTMLTOPDF_BINARY')) {
    Environment::setEnv('WKHTMLTOPDF_BINARY', '/usr/local/bin/wkhtmltopdf');
}

// Automatically configure session key for activedr with hybridsessions module
if (Environment::getEnv('CWP_INSTANCE_DR_TYPE')
    && Environment::getEnv('CWP_INSTANCE_DR_TYPE') === 'active'
    && Environment::getEnv('SS_SESSION_KEY')
    && class_exists(HybridSession::class)
) {
    HybridSession::init(Environment::getEnv('SS_SESSION_KEY'));
}

/*
 * Each feature this module applies can be switched off with `enabled: false`, listed together in
 * _config/features.yml and documented in the README. Features backed by a class guard themselves;
 * the ones below are plain configuration, so they get a class here that puts the configuration back
 * when its flag is off. This runs after all YAML has loaded, which is the earliest point a flag can
 * be read.
 */
CmsStylesConfig::apply();
DocumentConverterConfig::apply();
LocaleConfig::apply();
LoggingConfig::apply();
MemberSecurityConfig::apply();
OEmbedConfig::apply();
PasswordEncryptionConfig::apply();
PasswordFieldConfig::apply();
PasswordStrengthConfig::apply();
QueuedJobsConfig::apply();
SessionConfig::apply();
SslConfig::apply();
TextExtractionConfig::apply();

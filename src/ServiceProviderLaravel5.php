<?php

namespace Maknz\Slack\Laravel;

use Maknz\Slack\Client as Client;
use GuzzleHttp\Client as Guzzle;

class ServiceProviderLaravel5 extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/config/config.php' => config_path('slack.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'slack');

        $this->app->singleton('maknz.slack', ($app) {
            return new Client(
                $app['config']->get('slack.endpoint'),
                [
                    'channel' => $app['config']->get('slack.channel'),
                    'username' => $app['config']->get('slack.username'),
                    'icon' => $app['config']->get('slack.icon'),
                    'link_names' => $app['config']->get('slack.link_names'),
                    'unfurl_links' => $app['config']->get('slack.unfurl_links'),
                    'unfurl_media' => $app['config']->get('slack.unfurl_media'),
                    'allow_markdown' => $app['config']->get('slack.allow_markdown'),
                    'markdown_in_attachments' => $app['config']->get('slack.markdown_in_attachments'),
                ],
                new Guzzle
            );
        });

        $this->app->bind('Maknz\Slack\Client', 'maknz.slack');
    }
}

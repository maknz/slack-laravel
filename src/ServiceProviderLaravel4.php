<?php

namespace Maknz\Slack\Laravel;

use Maknz\Slack\Client as Client;
use GuzzleHttp\Client as Guzzle;

class ServiceProviderLaravel4 extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('maknz/slack-laravel', null, __DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['maknz.slack'] = $this->app->share(function ($app) {
            $allow_markdown = $app['config']->get('slack::allow_markdown');

            $markdown_in_attachments = $app['config']->get('slack::markdown_in_attachments');

            $unfurl_media = $app['config']->get('slack::unfurl_media');

            return new Client(
                $app['config']->get('slack::endpoint'),
                [
                    'channel' => $app['config']->get('slack::channel'),
                    'username' => $app['config']->get('slack::username'),
                    'icon' => $app['config']->get('slack::icon'),
                    'link_names' => $app['config']->get('slack::link_names'),
                    'unfurl_links' => $app['config']->get('slack::unfurl_links'),
                    'unfurl_media' => is_bool($unfurl_media) ? $unfurl_media : true,
                    'allow_markdown' => is_bool($allow_markdown) ? $allow_markdown : true,
                    'markdown_in_attachments' => is_array($markdown_in_attachments) ? $markdown_in_attachments : [],
                ],
                new Guzzle([
                    'connect_timeout' => $app['config']->get('slack.connection_timeout'),
                    'timeout' => $app['config']->get('slack.request_timeout'),
                ])
            );
        });

        $this->app->bind('Maknz\Slack\Client', 'maknz.slack');
    }
}

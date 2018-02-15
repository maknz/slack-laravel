<?php

namespace Razorpay\Slack\Laravel;

use Razorpay\Slack\Client as Client;
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
        $this->package('razorpay/slack-laravel', null, __DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['slack'] = $this->app->share(function ($app) {
            $allow_markdown = $app['config']->get('slack::defaults::allow_markdown');

            $markdown_in_attachments = $app['config']->get('slack::defaults::markdown_in_attachments');

            $unfurl_media = $app['config']->get('slack::defaults::unfurl_media');

            return new Client(
                $app['config']->get('slack::defaults::endpoint'),
                [
                    'channel' => $app['config']->get('slack::defaults::channel'),
                    'username' => $app['config']->get('slack::defaults::username'),
                    'icon' => $app['config']->get('slack::defaults::icon'),
                    'link_names' => $app['config']->get('slack::defaults::link_names'),
                    'unfurl_links' => $app['config']->get('slack::defaults::unfurl_links'),
                    'unfurl_media' => is_bool($unfurl_media) ? $unfurl_media : true,
                    'allow_markdown' => is_bool($allow_markdown) ? $allow_markdown : true,
                    'markdown_in_attachments' => is_array($markdown_in_attachments) ? $markdown_in_attachments : [],
                ],
                new Guzzle
            );
        });

        $clientConfigs = $this->app['config']->get('slack::clients');

        foreach ($clientConfigs as $name => $config)
        {
            $this->app['slack-'.$name] = $this->app->share(function ($app) use ($config) {
                $defaults = $this->app['config']->get('slack::defaults');
                $config = array_merge($defaults, $config);

                $allow_markdown = $config['allow_markdown'];

                $markdown_in_attachments = $config['markdown_in_attachments'];

                $unfurl_media = $config['unfurl_media'];

                return new Client(
                    $config['endpoint'],
                    [
                        'channel' => $config['channel'],
                        'username' => $config['username'],
                        'icon' => $config['icon'],
                        'link_names' => $config['link_names'],
                        'unfurl_links' => $config['unfurl_links'],
                        'unfurl_media' => is_bool($unfurl_media) ? $unfurl_media : true,
                        'allow_markdown' => is_bool($allow_markdown) ? $allow_markdown : true,
                        'markdown_in_attachments' => is_array($markdown_in_attachments) ? $markdown_in_attachments : [],
                    ],
                    new Guzzle
                );
            });
        }

        $this->app->bind('Razorpay\Slack\Client', 'slack');
    }
}

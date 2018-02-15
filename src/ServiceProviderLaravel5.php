<?php

namespace Razorpay\Slack\Laravel;

use Razorpay\Slack\Client as Client;
use GuzzleHttp\Client as Guzzle;
use Queue;

class ServiceProviderLaravel5 extends \Illuminate\Support\ServiceProvider
{
  /**
   * Bootstrap the application events.
   *
   * @return void
   */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/config.php' => config_path('slack.php')]);
    }

    protected function getEncrypter()
    {
        return $this->app['encrypter'];
    }

    protected function getQueue($queue)
    {
        return $this->app['queue']->connection($queue);
    }

    /**
    * Register the service provider.
    *
    * @return void
    */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'slack');

        $this->app->singleton('slack', function ($app) {
            $slack = new Client(
                $app['config']->get('slack.defaults.endpoint'),
                [
                    'channel'                 => $app['config']->get('slack.defaults.channel'),
                    'username'                => $app['config']->get('slack.defaults.username'),
                    'icon'                    => $app['config']->get('slack.defaults.icon'),
                    'link_names'              => $app['config']->get('slack.defaults.link_names'),
                    'unfurl_links'            => $app['config']->get('slack.defaults.unfurl_links'),
                    'unfurl_media'            => $app['config']->get('slack.defaults.unfurl_media'),
                    'allow_markdown'          => $app['config']->get('slack.defaults.allow_markdown'),
                    'markdown_in_attachments' => $app['config']->get('slack.defaults.markdown_in_attachments'),
                    'is_slack_enabled'        => $app['config']->get('slack.is_slack_enabled'),
                ],
                $this->getQueue($app['config']->get('slack.defaults.queue')),
                new Guzzle
            );

            return $slack;
        });

        $clientConfigs = $this->app['config']['slack']['clients'];

        foreach ($clientConfigs as $name  => $config)
        {
            $this->app->singleton('slack-'.$name, function ($app) use ($name, $config) {
                $defaults = $app['config']->get("slack.defaults");

                $config = array_merge($defaults, $config);

                $slack = new Client(
                    $config['endpoint'],
                    [
                        'channel'                 => $config['channel'],
                        'username'                => $config['username'],
                        'icon'                    => $config['icon'],
                        'link_names'              => $config['link_names'],
                        'unfurl_links'            => $config['unfurl_links'],
                        'unfurl_media'            => $config['unfurl_media'],
                        'allow_markdown'          => $config['allow_markdown'],
                        'markdown_in_attachments' => $config['markdown_in_attachments'],
                        'is_slack_enabled'        => $app['config']->get('slack.is_slack_enabled'),
                    ],
                    $this->getQueue($app['config']->get('slack.defaults.queue')),
                    new Guzzle
                );

                return $slack;
            });

            $this->app->bind('Razorpay\Slack\Client', 'slack-' . $name);
        }

        $this->app->bind('Razorpay\Slack\Client', 'slack');
    }
}

<?php

return [

    /*
    |-------------------------------------------------------------
    | Incoming webhook endpoint
    |-------------------------------------------------------------
    |
    | The endpoint which Slack generates when creating a
    | new incoming webhook. It will look something like
    | https://hooks.slack.com/services/XXXXXXXX/XXXXXXXX/XXXXXXXXXXXXXX
    |
    */
    'endpoint' => env('DEFAULT_SLACK_WEBHOOK_ENDPOINT', ''),

    /*
    |-------------------------------------------------------------
    | Default channel
    |-------------------------------------------------------------
    |
    | The default channel we should post to. The channel can either be a
    | channel like #general, a private #group, or a @username. Set to
    | null to use the default set on the Slack webhook
    |
    */
    'channel' => env('DEFAULT_SLACK_CHANNEL', '#general'),

    /*
    |-------------------------------------------------------------
    | Default username
    |-------------------------------------------------------------
    |
    | The default username we should post as. Set to null to use
    | the default set on the Slack webhook
    |
    */
    'username' => env('DEFAULT_SLACK_USERNAME', 'Robot'),

    /*
    |-------------------------------------------------------------
    | Default icon
    |-------------------------------------------------------------
    |
    | The default icon to use. This can either be a URL to an image or Slack
    | emoji like :ghost: or :heart_eyes:. Set to null to use the default
    | set on the Slack webhook
    |
    */
    'icon' => env('DEFAULT_SLACK_ICON', NULL),

    /*
    |-------------------------------------------------------------
    | Link names
    |-------------------------------------------------------------
    |
    | Whether names like @regan should be converted into links
    | by Slack
    |
    */
    'link_names' => env('DEFAULT_SLACK_LINKNAMES_CONVERTED', FALSE),

    /*
    |-------------------------------------------------------------
    | Unfurl links
    |-------------------------------------------------------------
    |
    | Whether Slack should unfurl links to text-based content
    |
    */
    'unfurl_links' => env('DEFAULT_SLACK_UNFURL_LINKS_STATUS', FALSE),

    /*
    |-------------------------------------------------------------
    | Unfurl media
    |-------------------------------------------------------------
    |
    | Whether Slack should unfurl links to media content such
    | as images and YouTube videos
    |
    */
    'unfurl_media' => env('DEFAULT_SLACK_UNFURL_MEDIA_STATUS', TRUE),

    /*
    |-------------------------------------------------------------
    | Markdown in message text
    |-------------------------------------------------------------
    |
    | Whether message text should be interpreted in Slack's Markdown-like
    | language. For formatting options, see Slack's help article: http://goo.gl/r4fsdO
    |
    */
    'allow_markdown' => env('DEFAULT_SLACK_ALLOW_MARKDOWN', TRUE),

    /*
    |-------------------------------------------------------------
    | Markdown in attachments
    |-------------------------------------------------------------
    |
    | Which attachment fields should be interpreted in Slack's Markdown-like
    | language. By default, Slack assumes that no fields in an attachment
    | should be formatted as Markdown.
    |
    */
    'markdown_in_attachments' => [env('DEFAULT_SLACK_MARKDOWN_FIELDS')],

    // Allow Markdown in just the text and title fields
    // 'markdown_in_attachments' => ['text', 'title']

    // Allow Markdown in all fields
    // 'markdown_in_attachments' => ['pretext', 'text', 'title', 'fields', 'fallback']
];

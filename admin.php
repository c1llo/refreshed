<?php

if (!defined('ABSPATH')) exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Action hook function for plugin settings page
 */
function refreshed_load_settings()
{
    \Carbon_Fields\Carbon_Fields::boot();

    $info = __('
    A better editing & development experience with the Refreshed plugin.<br> 
    This plugin automatically refreshes the browser whenever a page or post is updated.<br>
    No more manually refreshing the page to see your latest changes! <br>
    ');

    Container::make('theme_options', __('Refreshed'))
        ->set_page_parent('tools.php')
        ->set_page_file('refreshed')
        ->add_fields(array(
            Field::make('html', 'crb_html', __('Section Description'))
                ->set_html("<p style='font-size: 1.05rem;'>{$info}</p>"),
            Field::make('checkbox', 'refreshed_enabled', __('Enabled?'))
                ->set_option_value('yes')->set_default_value('yes'),
            Field::make('text', 'refreshed_interval', __('Interval between requests to refresh (milliseconds)'))
                ->set_attribute('type', 'number')
                ->set_default_value(750),
        ));
}
add_action('after_setup_theme', 'refreshed_load_settings');

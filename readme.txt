=== Plugin Name ===
Contributors: johnny5
Donate link: http://urbangiraffe.com/about/support/
Tags: media, image, rename, management
Requires at least: 2.9
Tested up to: 4.1
Stable tag: trunk

Rename underlying media files from the WordPress media management interface

== Description ==

Enhances the WordPress media library by allowing you to rename the underlying media files. Any change to a media item's title will result in the media filename also being changed.

See the screenshot for more details of where to rename media files.

Note that all thumbnails will also be renamed. If you are using a caching plugin, such as WP Super Cache, then you will need to clear your cache so that any references are updated. This plugin does not update existing direct links to files (links inside a WordPress gallery will change).

== Installation ==

The plugin is simple to install:

1. Download `rename-media.zip`
1. Unzip
1. Upload html-purified directory to your `/wp-content/plugins` directory
1. Go to the plugin management page and enable the plugin
1. Rename a media item by changing the title from the WordPress media management interface

You can find full details of installing a plugin on the [plugin installation page](http://urbangiraffe.com/articles/how-to-install-a-wordpress-plugin/).

== Screenshots ==

1. Changing the media title will result in the filename also changing

== Changelog ==

= 0.1.3 =
* Refresh for WP 4

= 0.1.2 =
* Fix PHP warning when no media sizes

= 0.1.1 =
* Store original filename in _original_filename meta data
* Don't redirect after editing if we came from the admin interface

= 0.1 =
* Initial release


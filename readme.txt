=== Fixedly Media Gallery ===
Contributors: kobra12
Donate link: http://www.thechoppr.com/fixedly-media-gallery/donate
Tags: image, images, video, slideshow, gallery, plugin, shortcode, wordpress, post, page
Requires at least: 3.2
Tested up to: 3.4.1
Stable tag: 4.3
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create and integrate, easily and quickly your next video, image or slideshow gallery into your WordPress pages and posts.

== Description ==

Fixedly Media Gallery is WordPress plugin that can help you create and integrate, easily and quickly your next video, image or
slideshow gallery into your pages and posts. Within 3 easy steps you can create and insert a gallery to your next post.
Check out our [Screencast page](http://www.thechoppr.com/fixedly-media-gallery/screencasts/ "Screencast page") to learn more on how to use the plugin.

Be sure that you have `<?php wp_head();?>` function included into your WordPress theme header file otherwise the Fixedly Media Gallery won't work.

= Shortag =

[fixedly-media-gallery]

= Options =

* *id* - the ID of the gallery you want to insert (**required**)
* *template* - the name of your template directory (optional)
* *type* - the type of you gallery (optional) - available values image (default), video, slideshow

= Examples =

`[fixedly-media-gallery id="1"]`

If you would like to overwrite the selected template and type inside your post/page you can use it this way:

`[fixedly-media-gallery id="1" template="image-template-name" type="image"]`
`[fixedly-media-gallery id="2" template="video-template-name" type="video"]`
`[fixedly-media-gallery id="3" template="slideshow-template-name" type="slideshow"]`

= PHP Code =

Here is the code if you want to add the gallery directly into your PHP templates.

`<?php
    if (function_exists("fixedly_media_gallery")) {
        print fixedly_media_gallery(1, "default", "image");
    }
?>`

Another way to add gallery into your PHP templates is by using the `<?php do_shortcode();?>` function.

`<?php print do_shortcode("[fixedly-media-gallery id=1]");?>`

== Installation ==

1. Upload `fixedly` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use shortcode [fixedly-media-gallery id="1"] OR PHP code
    `<?php if (function_exists("fixedly_media_gallery")) { print fixedly_media_gallery(1, "default", "image");}?>` OR
    `<?php print do_shortcode("[fixedly-media-gallery id=1]");?>` in your templates.

Learn more about the plugin installation and usage @ [Fixedly Media Gallery](http://www.thechoppr.com/fixedly-media-gallery/ "Fixedly Media Gallery") website.

== Frequently Asked Questions ==

See Fixedly Media Gallery FAQs [here](http://www.thechoppr.com/fixedly-media-gallery/faqs/ "here").

== Screenshots ==

See Fixedly Media Gallery Screencasts [here](http://www.thechoppr.com/fixedly-media-gallery/screencasts/ "here").

== Changelog ==

= 1.2-beta =
* Reorganized the edit and create template stylesheet
* Updaded fancybox script effects
* Added to be able to edit width and height of video gallery slider thumbnails
* Added default templates during installation for image gallery (2 column) and video gallery layouts

= 1.1.1-beta =
* Added pagination to for 'Media Entries'
* Updated default values for templates
* Fixed 'Update Media Status' column (not working)
* Renamed and reorganized navigation menu and titles

= 1.1-beta =
* Added three different layouts when create new template
* Added a way to overwerite template name and type when using shortcode
* Added option to manage layout styles and able to change effects for your gallery transition
* Added option to be able to display or hide media title, description & navigation
* Added easier way to integrate and manage template
* Fixed typos and renamed and reorganized navigation menu and titles

= 1.0-beta =
* Fixedly Media Gallery 1.0 Released July 7, 2012

== Upgrade Notice ==

= 1.2 =
* Fixedly Media Gallery 1.2 (beta version) - Update to readme.txt #3
* Fixedly Media Gallery 1.2 (beta version) - Update to readme.txt #2
* Fixedly Media Gallery 1.2 (beta version)

= 1.1.1 =
* Fixedly Media Gallery 1.1.1 (beta version) - Update to readme.txt #4
* Fixedly Media Gallery 1.1.1 (beta version) - Update to readme.txt #3
* Fixedly Media Gallery 1.1.1 (beta version) - Update to readme.txt #2
* Fixedly Media Gallery 1.1.1 (beta version)

= 1.1 =
* Fixedly Media Gallery 1.1 (beta version) - Update to readme.txt #3
* Fixedly Media Gallery 1.1 (beta version) - Update to readme.txt #2
* Fixedly Media Gallery 1.1 (beta version)

= 1.0 =
* Fixedly Media Gallery 1.0 (beta version) - Update to readme.txt #2
* Fixedly Media Gallery 1.0 (beta version)

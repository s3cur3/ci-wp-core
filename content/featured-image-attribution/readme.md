Featured Image Attribution, by Conversion Insights
==================================

**Featured Image Attribution is designed to make it easy for you to properly attribute copyleft artwork (such as artwork using a Creative Commons, GPL, or MIT license).**

Features
-----------

- Easily use many millions of free images---all it takes is an attribution!
- No more cludgy attributions! No more need to add attribution in your actual post (or worse, by editing the image itself to add the text).
- Won't slow down your pages. The plugin just adds a tiny bit of text (like this: **Image credit: [John Doe](#). Licensed under [CC-BY-SA 3.0](#)**).
- Instantly preview what your text will look like *before* you hit "Publish."
- Easily stylable. Just add a rule for "p.featured-img-caption" in your CSS, like this:

    p.featured-img-caption {
        font-size: 11px;
        text-align: right;
    }


Installation & Use
-------------

Using the Featured Image Attribution plugin is super simple, so long as you're comfortable modifying your page and category templates in a minimal way.

1. Unzip the featured-image-attribution.zip file into your `wp-content/plugins/` directory. This will give you a new folder there called (creatively) `featured-image-attribution`.
2. Go to the Plugins page of your Wordpress admin menu (probably located at `your-site-here.com/wp-admin/plugins.php` and click the "Activate" link for "Featured Image Attribution, by Conversion Insights."
3. This is the fuzzy step. You need to find the places in your theme's template files where you use the Featured Image (you can probably accomplish this by searching for `get_the_post_thumbnail` and `get post thumbnail` throughout your theme). Then, right after your theme displays the Featured Image in those places, add this bit of code: `<?php featuredImgAttribution(); ?>`.
4. At this point, you'll have a box that looks like this right below your Featured Image box: ![The Featured Image Attribution box]() Fill in that box, and when you hit the **Publish** or **Update** button, you'll see the attirbution text right below the image.

Where to send improvements
------------------------------

If you have improved the Featured Image Attribution tool, we invite you to email us a ZIP file and we'll publish the improvemed version for the whole world. (You can email Tyler at <tyler@conversioninsights.net>.)

Where to get support
----------------------

We created this plugin for our own internal use here at Conversion Insights, so **we are unable to respond to support requests.**

Licensing Information
-----------------

The Featured Image Attribution plugin is released under the [CC0 1.0](http://creativecommons.org/publicdomain/zero/1.0/) license. That means it's public domain---anyone can do anything they like with it.

With that said, if you find the plugin useful, we request that you drop us a line (either by email or in a [comment on the blog](http://conversioninsights.net/featured-image-attribution/ "The Featured Image Attribution plugin at Conversion Insights")) letting us know where you're using it and how you like it.




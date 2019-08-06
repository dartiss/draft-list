=== Draft List ===
Contributors: dartiss
Tags: draft, list, SEO, sidebar, widget, coming soon
Requires at least: 4.6
Tested up to: 5.2.2
Requires PHP: 5.3
Stable tag: 2.3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Manage and promote your drafts and scheduled posts and pages.

== Description ==

Draft List allows you to both manage your draft and scheduled posts more easily but also to promote them by showing them on your site via shortcode or widget - use it to show your visitors what's "coming soon" or as a great SEO tool.

How easy is it display a list of draft posts? Here's an example of how you could use it in a post or page...

`[drafts limit=5 type=post order=ma scheduled=no template='%ul%%draft% %icon%']`

This would display a list of up to 5 draft posts in ascending modified date sequence, with an icon displayed to the right of each if the draft is scheduled.

Key features include...

* Quick links added to admin menu for going straight to your draft posts and pages
* Menu links show the number of drafts you currently have
* Widget/shortcode output is highly configurable - create your own look by using a template, identify scheduled posts with an icon, sequence the results in various ways and even narrow down the results to a specific timeframe
* Click on any of the drafts posts listed to edit them
* Output is cached for streamlined performance
* A meta box in the editor screen allows you to omit individual posts from any list outputs

Options coming soon…

* A dashboard widget to show a summary of draft and scheduled posts and pages
* Quick links to be added to the admin menu for scheduled posts and pages
* Shortcuts to be added to the Admin Bar

Technical specification...

* Licensed under [GPLv2 (or later)](http://wordpress.org/about/gpl/ "GNU General Public License")
* Designed for both single and multi-site installations
* PHP7 compatible
* Fully internationalized, ready for translations. **If you would like to add a translation to this plugin then please head to our [Translating WordPress](https://translate.wordpress.org/projects/wp-plugins/simple-draft-list "Translating WordPress") page**

Please visit the [Github page](https://github.com/dartiss/draft-list "Github") for the latest code development, planned enhancements and known issues.

Icons made by [Freepik](https://www.flaticon.com/authors/freepik "Freepik") from [www.flaticon.co](https://www.flaticon.com/ "Flaticon") is licensed by [CC 3.0 BY](http://creativecommons.org/licenses/by/3.0 "Creative Commons BY 3.0").

== Shortcode Parameters ==

The following shortcode parameters are valid...

* **limit=** : The maximum number of draft items to display. The default is 0, which is unlimited.
* **type=** : This allows you to limit the results to either `post` or `page`. The default is both.
* **order=** : This is the sequence that you'd like to order the results in. It consists of 2 codes - the first is either `t`, `m` or `c` to represent the title, modified date or created date and the second is `a` or `d` for ascending or descending. Therefore `order=td` will display the results in descending title sequence. The default is descending modified date.
* **scheduled=** : If specified as `No` then scheduled posts will not display in the list, only drafts.
* **folder=** : The scheduled icon will be, by default, the one in the plugin folder named `scheduled.png`. However, use this parameter to specify a folder within your theme that you'd prefer the icon to be fetched from.
* **cache=** : How long to cache the output for, in hours. Defaults to half an hour. Set to `No` to not cache at all. Whenever you save a post any cache will be cleared to ensure that any lists are updated.
* **template=** : This is the template which formats the output. See the section below on * *Templates** for further information.
* **date=** : The format of any dates output. This uses the PHP date formatting system - [read here](http://uk3.php.net/manual/en/function.date.php "date") for the formatting codes. Defaults to `F j, Y, g:i a`.

To restrict the posts/pages to a particular timeframe you can use the following 2 parameters. You simply state, in words, how long ago the posts must be dated for e.g. "2 days", "3 months", etc.

* **modified=** : This reflects how long ago the post/page must have been modified last for it to be listed. For example `6 months` would only list drafts that have been modified in the last 6 months.
* **created=** : his reflects how long ago the post/page must have been created for it to be listed. For example `6 months` would only list drafts that were created in the last 6 months.

== Templates ==

The template parameter allows you to format the output by allowing you to specify how each line of output will display. A number of tags can be added, and you can mix these with HTML. The available tags are as follows...

* **%ul%** - Specifies this is an un-ordered list (i.e. bullet point output). This MUST be specified at the beginning of the template if it is to be used.
* **%ol%** - Specifies this is an ordered list (i.e. number output). This MUST be specified at the beginning of the template if it is to be used.
* **%icon%** - This is the icon that indicates a scheduled post.
* **%draft%** - This is the draft post details. This is the only **REQUIRED** tag.
* **%author%** - This is the name of the post author.
* **%author+link%** - This is the name of the post author with, where available, a link to their URL.
* **%words%** - The number of words in the draft post.
* **%chars%** - The number of characters (exc. spaces) in the draft post.
* **%chars+space%** - The number of characters (inc. spaces) in the draft post.
* **%created%** - The date/time the post was created.
* **%modified%** - The date/time the post was last modified.
* **%category%** - Shows the first category assigned to the post.
* **%categories%** - Shows all categories assigned to the post, comma separated.

If %ul% or %ol% are specified then all the appropriate list tags will be added to the output. If neither are used then it's assumed that line output will be controlled by yourself.

== Omitting Posts/Pages from Results ==

If you wish to omit a page or post from the list then you can do this in 3 ways...

1. By giving the post/page a title beginning with an exclamation mark. You can then remove this before publishing the page/post.
2. The post and page editor has a meta box, where you can select to hide the page/post.
3. You can add a custom field to a page/post with a name of 'draft_hide' and a value of 'Yes'

== Edit Link ==

If the current user can edit the draft item being listed then it will be linked to the appropriate edit page. The user then simply needs to click on the draft item to edit it.

There are separate permissions for post and page editing, so an editor with just one permission may find that they can only edit some of the draft items.

Drafts that don't have a title will not be shown on the list UNLESS the current user has edit privileges for the draft - in this case a title of [No Title] will be shown.

== Using a Widget ==

Sidebar widgets can be easily added. In Administration simply click on the `Widgets` option under the `Appearance` menu. `Draft Posts` will be one of the listed widgets. Drag it to the appropriate sidebar on the right hand side and then choose your options.

Save the result and that's it! You can use unlimited widgets, so you can add different lists to different sidebars.

== Installation ==

Draft List can be found and installed via the Plugin menu within WordPress administration (Plugins -> Add New). Alternatively, it can be downloaded from WordPress.org and installed manually...

1. Upload the entire `simple-draft-list` folder to your `wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress administration.

Voila! It's ready to go.

== Screenshots ==

1. An example list of draft posts
2. Draft post information in the Admin menu

== Changelog ==

[Learn more about my version numbering methodology](https://artiss.blog/2016/09/wordpress-plugin-versioning/ "WordPress Plugin Versioning")

= 2.3.3 =

* Maintenance: The README has had a re-write and the image assets have been replaced. Shiny!
* Maintenance: Minimum WordPress requirement for this plugin is now 4.6, which means various version checks and language files have now been removed. New!
* Maintenance: My site moved some time ago but links in the plugin and the README were still directed to the old one. Changed!
* Maintenance: The shortcake code is called whether in admin or frontend because, well, it makes no difference. Plum!
* Bug: Corrected spelling mistake. Sad trombone!

= 2.3.2 =
* Maintenance: Updated branding, inc. adding donation links

= 2.3.1 =
* Enhancement: Draft pages shortcuts only appear if the user can edit pages
* Enhancement: Only show the user's drafts if it's different to the total number (otherwise, if a site has only one author, they will get two links when only one is required)

= 2.3 =
* Enhancement: Quick links added to admin menu for any draft posts. Will show links for both all drafts and drafts for the current user
* Maintenance: Updated branding
* Maintenance: Removed unnecessary `-adl` prefix from file names
* Maintenance: Stopped hardcoding the plugin folder name in includes. Naughty boy
* Maintenance: Replaced `wp_plugin_url` with the nicerer `plugins_url`
* Maintenance: Replaced the deprecated `attribute_escape` with `esc_attr` in the widget code
* Maintenance: Merged the widget code so it's all in one handy file
* Maintenance: Sanitized the data being sloshed about by the meta box option
* Maintenance: Updated the clock icon to a material design version

= 2.2.6 =
* Maintenance: Added a domain path
* Maintenance: Removed deprecated functionality
* Bug: Fixed the categories tag
* Bug: Solved a PHP bug

= 2.2.5 =
* Maintenance: Added a text domain

= 2.2.4 =
* Bug: I've just noticed that if you use the editor box to hide the post from draft list you can't switch it back off again. Untick the box, save and it's ticked again. Doh. Why did nobody notice this before? It's now fixed though.

= 2.2.3 =
* Maintenance: Resolved widget issues with version 4.3 of WordPress

= 2.2.2 =
* Maintenance: Updated support forum link

= 2.2.1 =
* Bug: Removed some debug output

= 2.2 =
* Maintenance: Updated clock icon
* Enhancement: Added `category` and `categories` template tags

= 2.1 =
* Maintenance: Moved default scheduled icon to its own folder
* Enhancement: Added internationalization

= 2.0.2 =
* Maintenance: Removed dashboard widget

= 2.0.1 =
* Bug: Fix caching problem that prevents edit links from working correctly

= 2.0 =
* Maintenance: Renamed plugin and brought program coding standards up-to-date
* Enhancement: Added new template system, allowing better control over output
* Enhancement: Option to display modified and/or created date
* Enhancement: Option to display word and/or character count
* Enhancement: Draft posts/pages with no title are no longer displayed
* Enhancement: Can now sort output by date created as well as the date modified
* Enhancement: Meta box added to editor to allow post/page to be excluded from list
* Enhancement: Output is now cached (and cache times are adjustable)
* Enhancement: User can now limit time period over which drafts will be displayed
* Enhancement: Added validation of the passed parameters
* Enhancement: New widget option added
* Enhancement: Added improved clock image
* Bug: Alternative icon folder option now works

= 1.6 =
* Enhancement: Draft titles now have links to their edit page if the current user is allowed to edit them

= 1.5 =
* Maintenance: Code tidy
* Enhancement: Added option to show post/page author
* Enhancement: Added version details to code output
* Enhancement: Added shortcode option

= 1.4 =
* Enhancement: Added icon for scheduled posts (which can be modified and switched off, if required)

= 1.3 =
* Enhancement: Date order now displays according to date of last modification

= 1.2 =
* Enhancement: Now displays scheduled posts as well
* Enhancement: Added new parameter to suppress scheduled posts, if required
* Bug: Fixed bug in limit default

= 1.1 =
* Maintenance: With the release of WP 3.0 different post types are possible and these can get mixed in with the results (e.g. menu items, etc). Changed the code to restrict output to pages and posts only

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.3.3 =
* A number of maintenance updates
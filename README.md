WP Developers | Tag Deletion
===

Easily and quickly delete uneccessary tags.

---------------

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add the shortcode, [wpdevtags] with optional settings to a page and open the page. Settings options below.

---------------

Optional shortcode attributes:

1. number="#" / Default: 500
Example: [wpdevtags number="500"]

Number of tags to delete on each run.

2. offset="#" / Default: 200
Example: [wpdevtags offset="200"]

Number of tags to leave untouched.

3. auto="1" / Default: 1 (on)
Example: [wpdevtags auto="1"]

Turns on auto-refresh when the function is completed, for hands off tag deletion in batches.

4. optimize="yes" / Default: no
Example: [wpdevtags optimize="yes"]

Optimizes affected wp_terms tables in the database, for a faster running site.
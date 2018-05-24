# page-hits-counter

=== Page Hit and IP Address Counter ===
Contributors: webztechy-plugins
Tags: Page hit counter, IP address counter, unique IP address counter, page and ip plugin for wordpress, page counter, IP visitors
Requires at least: 3.0.1
Tested up to: 4.4
Stable tag: trunk
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html


== Description ==
This Plugin is used to count page hits automatically or by page name and ip address.
  
== Support Wordpress Version ==
Version tested: 3.5 to 4.4
	
== Installation ==
1. Upload the entire webztechy-ip-page-counter folder to the /wp-content/plugins/ directory, or just upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
2. Activate Page Hits & IP Counter from the 'Plugins' page in WordPress


== Instruction ==

Setting Panel:
Dashboard Menu: "Page Hits & IP Counter Setting"

1. IP Counter - List of IP visitors
2. Page Hits Counter - List of pages hits
3. Auto Page Hit & Pagination - Auto Page Hit and List Pagination


Shorcode:
Put shortcode inside page content.

[webztechy_counter] = save curremt page name hit and ip address
[webztechy_counter show_ip_counter="1"] = show total numbers of ip address visited the site
[webztechy_counter show_page_counter="1"] = show current page hits counter

[webztechy_counter page_name="{page-name}"] = save hit for page {page-name}
[webztechy_counter show_page_counter="1" page_name="{page-name}"] = show page {page-name} hits counter



== Changelog ==

= 1.0.0 =
*   First release


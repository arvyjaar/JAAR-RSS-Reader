#JAAR RSS Reader

##Installation

Extract zip archive to web server document root.  
Create database according given **feeds.sql** dump.  
Rename .config.php.example to .config.php and fill your database credentials.  
Feel free to replace Twig template engine with new version (Twig directory) or leave with installed one.


##Usage
###RSS import

**Important notice**  
This script is tested with [**lrytas.lt**](http://www.lrytas.lt/kiti/rss.htm), [**DELFI**](http://www.delfi.lt/apie/?wid=7334), [**Wired**](https://www.wired.com/about/rss_feeds/) RSS feed.  
For demo purposes only. Database feed updates are not supported yet.

From **CLI** run **$** php import.php _url_ _category_   
where _url_: RSS feed full URL address,  
_category_: category string in quotation marks.

##License
No license.
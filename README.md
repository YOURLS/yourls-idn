# YOURLS IDN
```
Plugin Name: YOURLS IDN
Plugin URI:  http://yourls.org/
Description: Host YOURLS on an IDN domain
Version:     1.0
Author:      Ozh - http://ozh.org/
```

This plugin is to have YOURLS hosted on a IDN domain

THIS PLUGIN REQUIRES YOURLS 1.5.2 to **1.7.9** (version above this don't need this)

## Installation

* Create a directory named 'yourls-idn/' into your 'user/plugins/' directory
* Upload all files contained in this archive into that newly created directory
* Head to your YOURLS admin area and the Plugins management page, then activate
  the YOURLS IDN plugin.
    
## Configuration

Before you activate the plugin, you must ensure that your config.php is correct.

The constant YOURLS_SITE must be set to your domain with ACE (Punycode) notation.
It must not contain any UTF8 or other non-ASCII characters.

* For instance, if your YOURLS' URL is:
      `http://héhé.com`
* You must have:
      `define('YOURLS_SITE', 'http://xn--hh-bjab.com');`
	  
To convert from IDN to ACE (or Punycode, the one that starts with xn--), you can
use a tool like [this one from VeriSign](https://www.verisign.com/en_GB/channel-resources/domain-registry-products/idn/idn-conversion-tool/index.xhtml) or [Punnycoder](https://www.punycoder.com/)

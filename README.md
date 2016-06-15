# WordPress Theme Options Panel
This main functiality was taken from [Unyson WordPress Plugin](http://unyson.io)

## Why Bother
Unyson is a great framework and it's obvious that it was made with greate effort,Unyson icludes lot's of other extensions Like Page Builder ,Analytics,Mega Menu etc.... But in my opinion this is the mistake of the Unyson team that they tried and still (trying) to include every thing in it for example
* The page builder Extension of Unyson is powerful but [Visual Composer](https://vc.wpbakery.com/) is more powerful
* Unyson mega menu extension is powerful and smart but [Uber Menu](http://codecanyon.net/item/ubermenu-wordpress-mega-menu-plugin/154703) is more powerful
* and list goes on

## Theme Options Panel
Personally i've seen and used a lot of theme options panel but the one introduced by Unyson is The strongest in addition that you can use it in Post and Taxnomies so i decided to take it out and use seperatly in addition to my favourit other plugins 

## Usage
first just download the repo and include `theme-options-framework.php in your file`
it's recommended to use the code below
```php
function load_theme_options_panel(){
	// if unyson plugin is already loaded and used do not load
	if(!defined('FW')){
		require get_stylesheet_directory().'/theme-options-framework/theme-options-framework.php';
	}
}
add_action('init','load_theme_options_panel',1000);
```

## Updates
I'll try to update this repo each time the main plugin updates any files of the theme options panel

## TODO
* update term options to use the newly created API rather that it's own API
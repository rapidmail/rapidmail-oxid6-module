# ![rapidmail Logo](https://avatars0.githubusercontent.com/u/25850436?v=3&s=50 "rapidmail Logo") rapidmail  OXID eShop connector
> [OXID eShop 6](https://www.oxid-esales.com) module for [rapidmail](https://www.rapidmail.de)

## Requirements

* OXID eShop 6.0 or 6.1 (tested with CE)
* SEO URLs must be enabled and working
* Composer package manager

## Installation 

* Execute composer within your shop project root 
```
composer require rapidmail/rapidmail-oxid6-module:2.*
```

* If you are prompted to overwrite files, always choose no except for this plugin
```
Update operation will overwrite vendor/module files. Do you want to continue? (y/N) N
Update operation will overwrite rapidmail/rapidmail-oxid6-module files. Do you want to continue? (y/N) y
Copying module rapidmail/rapidmail-oxid6-module files...
```

* Modify your .htaccess file to pass on authorization headers properly in certain server environments 
```
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]
``` 

* Navigate to your admin panel and activate the Rapidmail OXID eShop connector module from the module list

* Use an active or create a new user. Map it to the user group "Rapidmail OXID eShop connector" that has been 
created during module activation

## Usage

Check the [rapidmail wiki](https://de.rapidmail.wiki) for additional installation and usage documentation.

## Support

Please check [the rapidmail website](https://www.rapidmail.de/) for contact details. 




	

# koyuCMS

koyuCMS is the content management system powering koyu's personal website.

## Features

* No MySQL needed
* Clean and minimal codebase
* Fediverse comments
* Blogs and RSS support
* Discord widget
* Controllercons
* Font Awesome

## Getting started

If you want to add content to your site you can look for templates in the `templates` folder.

### Using Docker

Just run the following `docker-compose` commands and you should see your content on port 2364.

```
docker-compose build
docker-compose up -d
```

You have to rebuild the image every time you do changes so breaking changes don't interfere with your live site. But once you built once every other build should go faster due to Docker caching build steps.

### Using a webhost

If your hoster supports PHP you can install the dependencies with `composer install` and upload it to your webhost of choice.

## Using the Discord widget

Join the [Lanyard Discord server](https://discord.com/invite/WScAm7vNGF), change the User ID in the `config.php` file and place `<div id="discord"></div>` in your page.

# koyuCMS

koyuCMS is the content management system powering koyu's personal website.

## Getting started

Just run the following `docker-compose` commands and you should see your content on port 2364.

```
docker-compose build
docker-compose up -d
```

You have to rebuild the image every time you do changes so breaking changes don't interfere with your live site. But once you built once every other build should go faster due to Docker caching build steps.

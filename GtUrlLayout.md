# URL Layout #

The often used layout by other frameworks is usually:

```
controller/action/param/param.
```

From the object oriented view of a developer this might be right, but we think the URL is an important hierarchical navigation element for the user of a website. It is like a breadcrumb (also for search engines like Google) and that we decided to design our URL layout.

## Decide yourself. What is more pleasing? ##

Most other frameworks:
```
products/show/cool_funky_product/
```
Morrow framework:
```
products/hard-stuff/funky-stuff/cool-funky-product/
```

You see, Morrows URL layout is able to map a complete hierarchical structure.

## For advanced users ##

It is also possible to use the other layout if you are used to it. Just use [URL Routing](FtUrlRouting.md) and call the action in your global controller by hand.
If you are writing an application rather than creating a website, it makes more sense to have a controller with different methods that are called according to the path.

## URL » Morrow ##

Morrow takes the given URL and creates an internal identifier (Alias). It is the same as the URL but with underscores instead of slashes. So the URL above will get the following identifier: products\_hard-stuff\_funky-stuff\_cool-funky-product
This is also the name of the called controller.
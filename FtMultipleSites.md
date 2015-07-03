# Handle multiple sites with one installation #



## Introduction ##

One Morrow installation can be used for several sites at the same time. Sites in Morrow are called "projects" and are always contained in folders underneath the main installation folder.

You can name the folders however you like, but these names must be communicated to Morrow in the main configuration for the whole framework (FW\_PATH/`_`config/).

```
<?php
 
// the first project will be the default project. The others reachable through the url
$config['projects'] = array('main', 'docs');

```

The project named first will not appear in the URLs of the site. It is the default project.
All other projects will only be reachable by including the project name in the URL path of the site.

| In one installation you cannot have an alias in the default project and a secondary project with the same name. This would result in an URL conflict. |
|:------------------------------------------------------------------------------------------------------------------------------------------------------|

## Separate Domains and Subdomains ##

Since sites can have their own config files, it is of course possible to set the default project individually for different domains or subdomains. Simply create a config file in FW\_PATH/`_`config/ which has the name of the domain, IP or subdomain.

For example, if you wish to create a subdomain for your "docs" project, you could create the file FW\_PATH/`_`config/docs.yourdomain.tld.php with the following contents:

**FW\_PATH/`_`config/docs.yourdomain.tld.php**
```
<?php
 
// the first project will be the default project. The others reachable through the url
$config['projects'] = array('docs');

// routing rules
$config['routing'] = array(
    '/' => 'home/',
);

```

The following would then show identical content:
```
http://mydomain.tld/morrow_docs/
http://docs.mydomain.tld/
```
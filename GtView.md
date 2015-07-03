# View #



## Introduction ##

At the end you want to display data. Morrow provides many so called **view handlers** which let you output your data in different ways: (X)HTML, XML, CSV and some more. Your output is handled via the view class which is automatically loaded.

## Example ##
```
<?php
 
class PageController extends GlobalController {
    public function run() {
        // load the benchmark class
        $this->load('benchmark:bm');
       
        // use the benchmark class
        $this->bm->start('Section 1');
               
        sleep(1);
               
        $this->bm->stop();
        $results = $this->bm->get();
               
        // output the results
        $this->view->setHandler('XML');
        $this->view->setContent($results);
    }
}
```

As you can see, the only thing you have to do is define the handler which should be used for the output, and pass the data you want to display to the view class.

Oh, you want to get the results as JSON data? No problem: Just change  the handler to JSON
```
$this->view->setHandler('Json');
```

and you are done.

Take a look at the other view handlers to see what is possible.

## The Page array ##

One question is still open. In the example for the frame template we used the key page which was not set before. So where does it comes from?
Now, the page array is provided by the framework and gives you many URLs and info we think could be very helpful on generating templates. It is automatically passed to the view handler.

Here is the content of the page array for an example page:

```
Array
(
    [nodes] => Array
        (
            [0] => docs
        )
 
    [base_href] => http://www.domain.com/
    [project_path] => http://www.domain.com/docs/
    [project_relpath] => docs/
    [alias] => docs
    [controller] => .../_controller/manual_general-topics_view.class.php
    [path] => docs/
    [fullpath] => docs/
    [charset] => utf-8
    [mimetype] => text/html
    [content_template] => docs.tpl
    [template] => _index.tpl
)
```

In the controller you have also access to the page array. To dump the contents of the page class in the controller, use the following:

```
<?php
 
class PageController extends GlobalController {
    public function run() {
        // Dump the page class
        dump($this->page->get());
    }
}
```

## Using filters ##

Filters are functions called after the content generation. You could for example build a page spider (there is one integrated in Morrow called "sitesearch"), you could uppercase a company name on all pages with a regular expression and so on.

The following example for example replaces all occurences of "#TIME#" with an actual unix timestamp.

**Controller code:**
```
<?php
 
class PageController extends GlobalController {
    public function run() {
        $this->view->setFilter('generic', array('str_replace', '#TIME#', time(), ':CONTENT') );
 
    }
}
```
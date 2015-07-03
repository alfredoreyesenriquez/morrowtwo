# Controller #



## Introduction ##

The controller is the central point where you do all your work. You have seen in the previous article how the alias is created. But where is the controller Morrow calls? Now, it is possible to handle many projects (different websites) with the framework. All projects are located in subfolders of the root. There is one folder named "main" which is the default project folder. In the further explanations we will assume that we talk about this default project.

As you have seen in the previous article [File structure](GtFileStructure.md) all controllers are located in the folder **`_`controller**. So Morrow will now use the controller file:
```
main/_controller/products_hard-stuff_funky-stuff_cool-funky-product.class.php
```

## The controller inheritance ##

The principle is very simple. Morrow contains a standard controller class named Controller which provides some basic methods.

### The global controller ###

Then a global controller will called named **GlobalController** which extends **Controller**. This global controller is always called and is under full control of the user. The file has to be called **PROJECT\_NAME/`_`controller/`_`globalcontroller.class.php** and there has to be a method **setup()** which is automatically called. So your origin global controller looks like that:

**main/`_`controller/`_`globalcontroller.class.php**
```
<?php
 
class GlobalController extends Controller {
    public function setup() {
    }
}
```

### The page controller ###

At last your URL specific controller gets loaded. It extends the **GlobalController** and has to contain a method **run()** which is automatically called. It looks like this:

**main/`_`controller/products\_hard-stuff\_funky-stuff\_cool-funky-product.class.php**
```
<?php
 
class PageController extends GlobalController {
    public function run() {
    }
}
```

## Using classes in the controller ##

Many classes are provided per default with Morrow. To use them you just have to access them as a member of the controller.

If you want to initialize a class under a different instance name or you want to pass arguments to the constructor of a class you have to use the provided method **load()**.
All classes you load that way are just loaded on demand (see Lazy loading). So it's possible to init the database class in the GlobalController although databse access is not needed in all pages.

### Example ###

**Simple use of the benchmark class**
```
<?php
 
class PageController extends GlobalController {
    public function run() {
        // use the benchmark class
        $this->benchmark->start('Section 1');
        
        sleep(1);
               
        $this->benchmark->stop();
        $results = $this->benchmark->get();
    }
}
```

**The same example but with the use of load()**
```
<?php
 
class PageController extends GlobalController {
    public function run() {
        // load the benchmark class under a different instance name
        $this->load('benchmark:bm');
       
        // use the benchmark class
        $this->bm->start('Section 1');
               
        sleep(1);
               
        $this->bm->stop();
        $results = $this->bm->get();
    }
}
```

## Methods ##

### _$this->load()_ ###
```
void load( string $factory_args [, mixed ... ] )
```
Registers an instance of a specific class under a specific instancename.

**$factory\_args** is a string in the following format:
**"$classname:$instancename:$section"**

**$classname:** The name of the class that should get loaded.

**$instancename** (optional, default = $classname): An alternative instancename.

**$section** (optional, default = 'user'): An alternative section to categorize the instance into.

All other arguments will be passed to the constructor of the loaded class.

### _Factory::load()_ ###

If you are not in controller context (e.g. if you write your own classes) you can use the static method **Factory::load()**. It does nearly the same as **$this->load()** but is always available and returns the object.
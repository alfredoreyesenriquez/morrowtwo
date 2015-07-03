# Benchmark #



## Introduction ##
With this class it is possible to measure the time (real time and processor time) between two markers.

## Example ##
```
<?php
// ... Controller code
 
$this->benchmark->start('Section 1');
 
// ... The code to be benchmarked
 
$this->benchmark->stop();
$benchmarking_results = $this->benchmark->get();
print_r($benchmarking_results);
 
// ... Controller code
?>
```

## Methods ##

### _start()_ ###
```
void start( string $section = 'Unknown section')
```

Starts a new section to be benchmarked with a given name $section. If a section was started before and not stopped so far, it will automatically be stopped.

### _stop()_ ###
```
void stop()
```
Stops benchmarking of the actual section.

### _get()_ ###
```
array get()
```
Returns an array of all so far benchmarked sections with the measured times.
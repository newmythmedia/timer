# myth:Timer

[![Build Status](https://travis-ci.org/newmythmedia/timer.svg)](https://travis-ci.org/newmythmedia/timer)

Timer is a tiny utility class that allows you benchmark execution time and memory usage within your PHP applications.

## Installation

Installation is done through Composer. 

	composer require myth/timer

## Usage

### Recording the Time

To determine the elapsed time that an action took, you must call the Timer `start()` and `stop()` methods at the beginning and end of the action, respectively. The only parameter is a name you want to refer to this timer by. This is required. 

```
$timer = new Myth\Timer\Timer;
$timer->start('my_action');
// Do something here...
$timer->stop('my_action');
```

### Retrieving the Time

You can retrieve the benchmark information either as an array with all of the data, or as a formatted string. 

To get the raw data, use the `get()` method. The only parameter is the name of the timer.

```
	$timer->get('my_action');
	// Returns: 
	array(
		'start_time'	=>
		'stop_time'	=>
		'avg_time'		=>
		'start_memory'	=> 
		'stop_memory'	=> 
		'avg_memory'	=> 
		'peak_memory'	=>
	);
```

To retrieve a performance string, use the `output()` method.

```
$timer->output('my_action');
// Returns: [my_action] 0.0011 seconds, 0.00MB memory (4.50MB peak)
```

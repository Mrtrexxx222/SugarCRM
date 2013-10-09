<?php
/******************************************************************
Projectname:   PHP Time Ago
Version:       1.0
Author:        Radovan Janjic <rade@it-radionica.com>
Last modified: 07 11 2012
Copyright (C): 2012 IT-radionica.com, All Rights Reserved

* GNU General Public License (Version 2, June 1991)
*
* This program is free software; you can redistribute
* it and/or modify it under the terms of the GNU
* General Public License as published by the Free
* Software Foundation; either version 2 of the License,
* or (at your option) any later version.
*
* This program is distributed in the hope that it will
* be useful, but WITHOUT ANY WARRANTY; without even the
* implied warranty of MERCHANTABILITY or FITNESS FOR A
* PARTICULAR PURPOSE. See the GNU General Public License
* for more details.

Description:

PHP Time Ago

This class calculate between two time values and can be used to convert relative time values into language expressions. 

For example:

 - now
 - a secund ago
 - 10 secunds ago
 - a minute ago
 - 3 minutes ago
 - about an hour ago
 - 5 hours ago
 - yesterday
 - on Sunday
 - week ago
 - 2 weeks ago
 - a month ago
 - 7 months ago
 - a year ago
 - 4 years ago

Example:

******************************************************************

$a = new time_ago;

echo "I was born ", $a->ago('1988-04-26'), ".";

******************************************************************/

class time_ago {
	
	// in secunds
	var $minute = 60;
	var $hour 	= 3600;
	var $day 	= 86400;
	var $week 	= 604800;
	var $mounth = 2629800;
	var $year 	= 31557600;
	
	// string words
	var $string = array(
		  "now" => "now",
		  "secund" => "a secund ago",
		  "secunds" => "%d secunds ago",
		  "minute" => "a minute ago",
		  "minutes" => "%d minutes ago",
		  "hour" => "about an hour ago",
		  "hours" => "%d hours ago",
		  "yesterday" => "yesterday",
		  "days" => "%d days ago",
		  "on" => "on %s",
		  "week" => "week ago",
		  "weeks" => "%d weeks ago",
		  "month" => "a month ago",
		  "months" => "%d months ago",
		  "year" => "a year ago",
		  "years" => "%d years ago"
	);
						
	//	0 is Sunday, 6 is Saturday
	var $weekDays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
	
	function ago($time, $calculateFrom = 'now'){
		
		$time = strtotime($time);
		$calculateFrom = strtotime($calculateFrom);
		$elapsed = $calculateFrom - $time;
		
		$this->dayElapsed = date("H", $calculateFrom) * $this->hour + date("i", $calculateFrom) * $this->minute + date("s", $calculateFrom);
		
		if($elapsed < $this->minute){
			if($elapsed == 0) 
				// now
				return  $this->string['now'];
			else
				// secund / secunds
				return $elapsed == 1 ? $this->string['secund'] : sprintf($this->string['secunds'], $elapsed);			
		}elseif($elapsed < $this->hour){ 
			// minutes
			$minutes = intval($elapsed / $this->minute);
			return $minutes == 1 ? $this->string['minute'] : sprintf($this->string['minutes'], $minutes);
		}elseif($elapsed < $this->day){ 
			// today hours
			$hours = intval($elapsed / $this->hour);
			return $hours == 1 ? $this->string['hour'] : sprintf($this->string['hours'], $hours);
		}elseif($elapsed <= $this->day + $this->dayElapsed){ 
			// yesterday
			return $this->string['yesterday'];
		}elseif($elapsed < $this->day * 6 + $this->dayElapsed){ 
			// last week
			return sprintf($this->string['on'], $this->weekDays[date( "w", $time)]);
		}elseif($elapsed < $this->mounth ){  // less then month
			// weeks
			if( $elapsed < $this->week * 2 ){
				// last seven days
				return $this->string['week'];
			}elseif($elapsed < $this->week * 3){
				// 2 weeks
				return sprintf($this->string['weeks'], 2);
			}else{
				// 3 weeks
				return sprintf($this->string['weeks'], 3);
			}
		}elseif($elapsed < $this->year){ // less then year
			if($elapsed < $this->mounth * 2){
				// month
				return $this->string['month'];
			}else{
				// months
				return sprintf($this->string['months'], intval($elapsed / $this->mounth));
			}
		}else{
			if($elapsed >= $this->year && $elapsed < $this->year * 2){
				// year
				return $this->string['year'];
			}else{
				// years
				return sprintf($this->string['years'], intval($elapsed / $this->year));
			}
			
		}
		
	}	
}

<?php

/* #INFO############################################
Author: Igor Feghali
Email: ifeghali@interveritas.net
################################################# */

/* #FILE DESCRIPTION################################
Example for the bar graph
################################################# */

// #INCLUDE#########################################
require("charts.class.php");
// #################################################

// #FUNCTIONS#######################################
function factors($n)
{

	$div = Array(1);

	for ($i=1; $i<= ($n/2); $i++)
		if ($n % $i == 0)
			$div[] = $i;

	$div[] = $n;

	return $div;
}

function hasAconvenientDiv($div)
{
    $divs = Array(8,7,6,5,4);
    foreach ($divs as $k => $v)
	if (in_array($v,$div))
	    return $v;
    return 0;
}
// #################################################

// #INSTANTIATING CLASS#############################
$g = new chart;
// #################################################

// #X ELEMENTS######################################
$elemx = Array();
$elemx[] = "VENDOR A";
$elemx[] = "VENDOR B";
$elemx[] = "VENDOR C";
$elemx[] = "VENDOR D";
$elemx[] = "VENDOR E";
$elemx[] = "VENDOR F";
$elemx[] = "VENDOR G";
// #################################################

// #Y ELEMENTS######################################
$elemy = Array();
$elemy[] = 6.74;
$elemy[] = 9.38;
$elemy[] = 26.69;
$elemy[] = 11.32;
$elemy[] = 54.55;
$elemy[] = 12.80;
$elemy[] = 24.34;
// #################################################

// #BIGGEST Y ELEMENT###############################
$ymax = ceil(max($elemy));
// #################################################

// #FINDING A CONVENIENT SCALE FOR Y AXIS###########
if ($ymax > 8)
{
    do
    {
        $div = factors($ymax);
		$ymax++;
    } while (!($scale = hasAconvenientDiv($div)));

    $ymax--;
}
// #################################################


// #POPULATING GRAPH################################
foreach ($elemy as $k => $v)
{
    $g->xValue[] = $elemx[$k];
    $g->DataValue[] = $v;
}
// #################################################

// #SETTING GRAPH PARAMETERS########################
$g->Title = "Example Bar Graph";
$g->SubTitle = "Subsidiary A";
$g->Width = (count($elemx)*45) + 75;
$g->Height = 300;

$g->xCount = count($elemx);
$g->xCaption = "Sum: ".array_sum($elemy);
$g->xShowValue = TRUE;
$g->xShowGrid = TRUE;

$g->yCount = $scale;
$g->yCaption = "Today Sales (thousands)";
$g->yShowValue = TRUE;
$g->yShowGrid = FALSE;

$g->DataDecimalPlaces = 2;
$g->DataMax = $ymax;
$g->DataMin = 0;
$g->DataShowValue = TRUE;
// #################################################

// #ITS DRAWING TIME################################
$g->MakeBarChart();
// #################################################

?>

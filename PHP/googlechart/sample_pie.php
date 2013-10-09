<?php

include_once 'Google.merge.v_1_0.php';

$o = new Google_Data_Base;

$o->addColumn("0","Task","string");
$o->addColumn("1","Hours per day","number");

$o->addNewRow();
$o->addStringCellToRow("Work");
$o->addNumberCellToRow(400);

$o->addNewRow();
$o->addStringCellToRow("Eat");
$o->addNumberCellToRow(450);

$o->addNewRow();
$o->addStringCellToRow("Commute");
$o->addNumberCellToRow(1122);

$o->addNewRow();
$o->addStringCellToRow("Watch TV");
$o->addNumberCellToRow(900);


$c = new Google_Config("PieChart", "Company Performance");
$c->setProperty("width", 300)->setProperty("height", 200);
$c->setIs3D(true);

$v = new Google_Visualization();
$v->setConfig($c);
$v->setData($o);


?><html>
<head>
<?php
echo $v->render();
?>
</head>
<body>
  <div id="chart"></div>
</body>
</html>

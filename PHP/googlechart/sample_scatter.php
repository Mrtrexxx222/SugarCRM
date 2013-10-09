<?php

include_once 'Google.merge.v_1_0.php';

$o = new Google_Data_Base;

$o->addColumn("0","Age","number");
$o->addColumn("1","Weight","number");

$o->addNewRow();
$o->addNumberCellToRow(1000);
$o->addNumberCellToRow(400);

$o->addNewRow();
$o->addNumberCellToRow(1150);
$o->addNumberCellToRow(450);

$o->addNewRow();
$o->addNumberCellToRow(660);
$o->addNumberCellToRow(1122);

$o->addNewRow();
$o->addNumberCellToRow(855);
$o->addNumberCellToRow(900);

$o->addNewRow();
$o->addNumberCellToRow(545);
$o->addNumberCellToRow(827);


$c = new Google_Config("ScatterChart", "My Title");
$c->setProperty("width", 300)->setProperty("height", 200);
$c->setLegend("none");
$c->setTitleX("Age");
$c->setTitleY("Weight");
$c->setPointSize(8);

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

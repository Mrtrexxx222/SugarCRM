<?php

include_once 'Google.merge.v_1_0.php';

$p = new Google_Package(array("packages"=>array("PieChart","AreaChart"), "language"=>"de_DE"));

//pie chart
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


$pie_config = new Google_Config("PieChart", "");
$pie_config->setProperty("width", 600)->setProperty("height", 300);
$pie_config->setIs3D(true);

$visualization = new Google_Visualization("Base2");
$visualization->setPackage($p); // set package object to visualization
$visualization->setConfig($pie_config);
$visualization->setData($o);


//area chart
$o2 = new Google_Data_Base;

$o2->addColumn("0","year","string");
$o2->addColumn("1","Sales","number");
$o2->addColumn("2","Expenses","string");

$o2->addNewRow();
$o2->addStringCellToRow("2004");
$o2->addNumberCellToRow(1000);
$o2->addNumberCellToRow(400);

$c = new Google_Config("AreaChart", "My Title");
$c->setProperty("width", 300)
  ->setProperty("height", 200)
  ->setProperty("port", "area");
$c->setPointSize(8);
$c->setColors(array("red", "blue"));
$c->setBorderColor("navy");
$c->setLineSize(3);
$c->setAxisBackgroundColor("#f5f5f5");


$visualization2 = new Google_Visualization("Base3");
$visualization2->setConfig($c);
$visualization2->setData($o2);

?><html>
<head>
<?php
echo $visualization->render();
echo $visualization2->render();
?>
</head>
<body>
  <div id="chart"></div>
  <div id="area"></div>
</body>
</html>

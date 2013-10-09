<script type="text/javascript">
var <?php echo "C".substr(md5(serialize($configObject)),0,5) ?>=<?php
if(is_array($configObject)):
  echo '[';
  foreach($configObject as $i => $o):
    if($i>0) echo ",";
    echo $o;
  endforeach;
  echo '];';
?>

function draw(){
  var dataObj=<?php echo $dataObject->getData()?>;
  var data=new google.visualization.DataTable(dataObj, 0.5);
  var eStr='new '+<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[0].provider+'.'+<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[0].scope+'.'+<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[0].type+'(document.getElementById("'+<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[0].port+'"))';
  visualization=eval(eStr);
  visualization.draw(data,<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[0].props);
}
var cPackages=[];
var j=<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.length;
for(var i=0;i<j;i++){cPackages.push(<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[i].type.toLowerCase());}
google.load(<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[0].scope, <?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[0].version,{'packages': cPackages, 'language':<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>[0].language});
google.setOnLoadCallback(draw);
<?php
else:
  echo $configObject.";\n";
?>
function draw(){
  var dataObj=<?php echo $dataObject->getData()?>;
  var data=new google.visualization.DataTable(dataObj, 0.5);
  var eStr='new '+<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.provider+'.'+<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.scope+'.'+<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.type+'(document.getElementById("'+<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.port+'"))';
  visualization=eval(eStr);
  visualization.draw(data,<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.props);
}
google.load(<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.scope, <?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.version,{'packages': [<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.type.toLowerCase()], 'language':<?php echo "C".substr(md5(serialize($configObject)),0,5) ?>.language});
google.setOnLoadCallback(draw);
<?php endif; ?>
</script>

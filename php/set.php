<?php
$d='../data/set.data';
$set=explode(':',file_get_contents($d));
$win=false;
foreach($set as  $key=>$tt)
{
	$tt=explode('-',$tt);
	if($tt[0]==$_POST['setxy'] && $tt[1]=='none')
	{
		$set[$key]=$_POST['setxy'].'-'.$_POST['color'];
		file_put_contents($d,"");
		file_put_contents($d,implode(':',$set));
		break;
	}
}

$x=explode(',',$_POST['setxy'])[0];
$y=explode(',',$_POST['setxy'])[1];
$color=$_POST['color'];

$w=0;
$wnum=0;
while($w<3)
{
	$w++;
	$jm=($x+$w) . ',' . $y . '-' . $color;
	$sm=($x-$w) . ',' . $y . '-' . $color;
	if(in_array($jm,$set))
		$wnum++;
	if(in_array($sm,$set))
		$wnum++;
	
	if($wnum==2)
		$win=true;
}

$w=0;
$wnum=0;
while($w<3)
{
	$w++;
	$jm=$x . ',' . ($y+$w) . '-' . $color;
	$sm=$x . ',' . ($y-$w) . '-' . $color;
	if(in_array($jm,$set))
		$wnum++;
	if(in_array($sm,$set))
		$wnum++;

	if($wnum==2)
		$win=true;
}

$w=0;
$wnum=0;
while($w<3)
{
	$w++;
	$jm=($x+$w) . ',' . ($y+$w) . '-' . $color;
	$sm=($x-$w) . ',' . ($y-$w) . '-' . $color;
	if(in_array($jm,$set))
		$wnum++;
	if(in_array($sm,$set))
		$wnum++;

	if($wnum==2)
		$win=true;
}

$w=0;
$wnum=0;
while($w<3)
{
	$w++;
	$jm=($x-$w) . ',' . ($y+$w) . '-' . $color;
	$sm=($x+$w) . ',' . ($y-$w) . '-' . $color;
	if(in_array($jm,$set))
		$wnum++;
	if(in_array($sm,$set))
		$wnum++;

	if($wnum==2)
		$win=true;
}

if($win)
{
	$wd='../data/win.data';
	file_put_contents($wd,"");
	file_put_contents($wd,$color);
	echo json_encode(array('success'=>1));
}
else
	echo json_encode(array('success'=>0));
?>

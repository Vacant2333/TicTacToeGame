<<<<<<< HEAD
<?php
$d='../data/set.data';
$set=explode(':',file_get_contents($d));
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
/*
POST
setxy
color

1,1-none:1,2-none:1,3-none:2,1-none:2,2-none:2,3-none:3,1-none:3,2-none:3,3-none

*/
?>
=======

>>>>>>> origin/master

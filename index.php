<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>井字棋</title>
	<script src="http://libs.baidu.com/jquery/1.9.1/jquery.js"></script>
<style>
*{margin:0;padding:0;}
#herder{
    height:50px;
    background:green;
}
#main{
    width:100%;
    position:relative;
}
#main .main-left{
    width:20%;
    height:800px;
    background:red;
    position:absolute;
    left:0;
    top:0;
}
#main .main-center{
	width:80%;
    height:800px;
    background:lightgreen;
    margin:0 310px 0 210px;
}
#footer{
    height:50px;
    background:gray;
}
</style>
</head>
<body>
	<div id="herder"><h1><center>[井字棋]</h1></center></div>
	
	<div id="main">
		<div class="main-left">
		<textarea id="msg"  style="font-size:30px; color:#F00; height:180px; width:100%; resize:none;" readonly="readonly">
			请选择颜色
		</textarea>
			<button type="submit" onclick="returnlog()"><h2>重新开始</h2></button>
			<div id="color">你的颜色:未知</div>
		</div>
		
		<div id="CC" class="main-center">
				<button style="height:50%; width:100%; background-color:#2F4F4F;" type="submit" onclick="ChooseColor('black')"><h2>选择黑色</h2></button>
				<button style="height:50%; width:100%; background-color:#F8F8FF;" type="submit" onclick="ChooseColor('white')"><h2>选择白色</h2></button>
		</div>
		
		<div id="Game" style="display: none;"  class="main-center">
			<div style="height:30%; width:100%;" id="line1">
				<button id="1,1" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(1,1)"><h2>下棋</h2></button>
				<button id="1,2" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(1,2)"><h2>下棋</h2></button>
				<button id="1,3" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(1,3)"><h2>下棋</h2></button>
			</div>
			<div style="height:30%; width:100%;" id="line2">
				<button id="2,1" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(2,1)"><h2>下棋</h2></button>
				<button id="2,2" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(2,2)"><h2>下棋</h2></button>
				<button id="2,3" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(2,3)"><h2>下棋</h2></button>
			</div>
			<div style="height:30%; width:100%;" id="line3">
				<button id="3,1" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(3,1)"><h2>下棋</h2></button>
				<button id="3,2" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(3,2)"><h2>下棋</h2></button>
				<button id="3,3" style="height:97%; width:30%; background-color:blue;" type="submit" onclick="set(3,3)"><h2>下棋</h2></button>
			</div>
		</div>
	</div>

	<div id="footer">
		<center>Provide by:Vacant</center>
	</div>
	
</body>
<script>
var $ccc;
var $step;
var $w;

var bw=document.createElement("audio");
bw.preload="auto";
bw.src="wav/bwin.wav";

var ww=document.createElement("audio");
ww.preload="auto";
ww.src="wav/wwin.wav";

function returnlog()
{
	$.ajax({
    type: 'get',
    url: "php/returnlog.php",
    dataType: 'json',
    success:function(data)
	{},
    error : function() 
	{}
	});
	$w=null;
	$step='black';
}

function set($line,$columna)
{
	if($ccc==$step)
	{
		$setxy=$line+","+$columna;
		$.ajax({
					type: 'POST',
					timeout : 2500,
					url: "php/set.php" ,
					data:{
						"setxy" : $setxy,
						"color" : $ccc
					},
					dataType: 'json',
					success:function(data)
					{
						if(data['success'])
						{
							if($ccc=='black')
							{
								bw.play();
								$w="black";
								alert('黑色胜利');
							}
							if($ccc=='white')
							{
								ww.play();
								$w="white";
								alert('白色胜利');
							}
						}
					}
				});
	}
}

function ChooseColor($color)
{
	if($color=='white')
	{
		document.getElementById('color').innerHTML='你的颜色:白色';
		$ccc=$color;
	}
	if($color=='black')
	{
		document.getElementById('color').innerHTML='你的颜色:黑色';
		$ccc=$color;
	}
	document.getElementById("CC").style.display='none';
	document.getElementById("Game").style.display='block';
	setInterval('get()',250);
}

function getData(url,fnSucc,fnFaild)
{
	if(window.XMLHttpRequest)
		var oAjax=new XMLHttpRequest();
	else
		var oAjax=new ActiveXObject("Microsoft.XMLHTTP");
	 oAjax.open('GET',url,true);
	 oAjax.send();
	 oAjax.onreadystatechange=function()
	{
	  if(oAjax.readyState==4)
	  {
			if(oAjax.status==200)
			{ 
					fnSucc(oAjax.responseText);  
			}
			else
			{
				fnFaild(oAjax.status);
			}
		};
	 };
}

function get()
{
	$.ajax({
    type: 'get',
    url: "php/ajaxlog.php",
    dataType: 'json',
    success:function(data)
	{
		$m=data['msg'].split(":");
		getData('data/win.data?datetime=new Date.getTime ',function(str){if(str=='white' || str=='black'){$w=str;}else{$w=null;}},function(){});

		$none=0;
		$m.forEach(function($sm)
		{
			$sm=$sm.split("-");
			if($sm[1]=='white' || $sm[1]=='black')
			{
				document.getElementById($sm[0]).style.backgroundColor=$sm[1];
				document.getElementById($sm[0]).innerHTML='<h2>×</h2>';
			}
			else
			{
				document.getElementById($sm[0]).innerHTML='<h2>下棋</h2>';
				document.getElementById($sm[0]).style.backgroundColor='blue';
				$none++;
			}
		});
		
		if($none==0 || $w!=null)
		{
			document.getElementById('msg').innerHTML='游戏结束';
			$step="over";
		}
		else
		{
			switch($none%2)
			{
			case 0:
				document.getElementById('msg').innerHTML='白方下棋';
				$step="white";
			break;
			case 1:
				document.getElementById('msg').innerHTML='黑方下棋';
				$step="black";
			break;
			}
		}
     },
    error : function() 
	{} 
	});
}
</script>
</html>
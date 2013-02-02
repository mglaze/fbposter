<?php
    include_once "fbaccess.php";
    $limit = 5000;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="fbmodified.css" />
<title>STAGING - MGC-IT.NET | STAGING - MGC Tools</title>

<link  href="http://fonts.googleapis.com/css?family=Aclonica:regular" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<link rel="stylesheet" href="jquery.superbox.css" type="text/css" media="all" />
<script type="text/javascript" src="jquery.superbox-min.js"></script>

<script type="text/javascript">
		$(function(){
			$.superbox.settings = {
				closeTxt: "Close",
				loadTxt: "Loading...",
				nextTxt: "Next",
				prevTxt: "Previous"
			};
			$.superbox();
		});
	</script>

<script>
$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});
</script>

<script language='JavaScript'>
	function checkedAll () {
		var argv = checkedAll.arguments;
		checked = document.getElementById('myform').elements[argv[0]-1].checked;
		for (var i = argv[0]; i < document.getElementById('myform').elements.length && i < argv[1]; i++) {
			document.getElementById('myform').elements[i].checked = checked;
		}
	}
</script>
</head>
<body style="padding-top:70px;" >
<div id="top-bar"> 
	<div id="topbar-inner">
	<center><table style="width:850px;" >
			<tr>
					<td><a href="index.php" ><img style="padding-top:5px; padding-bottom:4px;" src="images/logo.png" /></a>
					<a href="http://mgc-it.net" style="color:#888; margin-top:10px; margin-left:-200px; font-size:14px;">by <span style="color: #336699;">MGC-IT.NET</span></a></td>
					<td><a href="https://www.facebook.com/logout.php?next=http%3A%2F%2Fmgc-it.net/fb-poster%2F&access_token= AAACEdEose0cBAFGM0gDdZCQPF8mN0ZCpZAZClkZCfz77JeGevvdfIFNutbVrC6HdVVu9prBvMId6PXU4WaaEm95o005lk3ZAjMB8FOm5L8gMaLCKG9DSlo">Logout</a></td></tr>
		</table></center>
	</div>
</div>
</br>
<h2><center>Post to Multiple Walls</center></h2>
</br>

<?php if(!$user) { ?><div style="padding-top:150px;" ><a href="<?=$loginUrl?>"><img src="images/f-connect.png" alt="Connect to your Facebook Account"/></a><br/>This website will <b>NOT</b> post anything to your wall or like any page automatically.</div><?php } else {?>

<form id="myform" action="" method="post">
<center><table>
	<tr><td>Message</td><td><textarea class="input" name="message" >New Video!!!! "Heaven 2 Hell" http://preachmusic.com/h2h Leave your comments..Let me know what you think.. 100</textarea></td>
		<td rowspan="6"><input type="image" name="submit" src="images/submitbutton.jpg" ></td></tr>
	<tr><td>Link</td><td><input class="input" type="text" name="link" value="http://preachmusic.com/h2h" /></td></tr>
	<tr><td>Picture</td><td><input class="input" type="text" name="picture" value= "" /></td></tr>
	<tr><td>Name</td><td><input class="input" type="text" name="name" value="Preach - @PREACHMUZAK" /></td></tr>
	<tr><td>Caption</td><td><input class="input" type="text" name="caption" value="www.preachmusic.com Follow @PreachMuzak on Twitter" /></td></tr>
	<tr><td>Description</td><td><textarea class="input" name="description" rows="6" >Check out www.preachmusic.com and Watch his new video "Heaven to Hell" Now!!</textarea></td></tr>
</table></center>

<?php
	if(isset($flag) && $flag==1) { echo "<div style='border:2px solid red;width:610px;background:#f99' >Please select atleast one Page, Group, or Friend</div>"; $flag=0; }
	elseif(isset($flag) && $flag==2) { echo "<div style='border:2px solid red;width:610px;background:#f99' >Please enter a message, Link, or Picture</div>"; $flag=0; }
	elseif(isset($multiPostResponse)) echo "<div style='border:2px solid green;width:300px;background:#cfc' >Successfully posted to the selected walls</div>"; ?>
</br></br>

<center><table>

<?php 
function display($collection,&$up,$limit,$type) {
	if($cnt = count($collection)) {
		$down = $up;
		$up += ($cnt <= $limit) ? $cnt : $limit;
		?>
		<tr><th colspan="2"><?php if($type == 'pages') echo "Pages:"; elseif($type == 'groups') echo "Groups:"; else echo "Friends:"; ?></th><td><input type='checkbox' name='checkall' onclick='checkedAll(<?php echo $down.','.$up++; ?>);'>Select All</td></tr>
		<tr><td><br/></td></tr>
		<?php $i=1;
		foreach($collection as $page) {
			$name = $page['name'];
			$id = $page['id'];
			if(!($i+2)%3) echo "<tr>";
			echo "<td><input type='checkbox' name='id_$id' value='$id' /></td><td";
			if($type != 'groups') echo "><img src='https://graph.facebook.com/$id/picture' /></td><td ";			
			else echo " colspan='2' ";
			echo "width='200' ><p>$name</p></td>";
			
			if(!($i%3)) echo "</tr>";
			if($i++ == $limit) break;			
		}
	} ?>
	<tr><td><br/><br/></td></tr>
	<?php
}

$up=7;
display($pages['data'],$up,$limit,'pages');
display($groups['data'],$up,$limit,'groups');
display($friends_list['data'],$up,$limit,'friends');
?>

</table></center>
</form>
<br/><br/><br/>
<?php } ?>
</body>
</html>
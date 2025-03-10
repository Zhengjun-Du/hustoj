<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $MSG_STATUS;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="row" style="margin: 3% 8% 5% 8%">
            <div class="col-md-9">
            <div class="card">
  <div class="card-body">
    <h4><?php echo $MSG_STATUS;?></h4>
    <?php if (isset($cid) && $cid) { ?>
    
    <ul class="pagination">
    <li class="page-item"><a class="page-link" href='contest.php?cid=<?php echo $view_cid?>'><?php echo $MSG_CONTEST;?>C<?php echo $cid;?></a></li>
    <li class="page-item"><a class="page-link" href='status.php?cid=<?php echo $view_cid?>'><?php echo $MSG_STATUS;?></a></li>
    <li class="page-item"><a class="page-link" href='contestrank.php?cid=<?php echo $view_cid?>'><?php echo $MSG_STANDING;?></a></li>
    <li class="page-item"><a class="page-link" href='contestrank-oi.php?cid=<?php echo $view_cid?>'>OI-<?php echo $MSG_STANDING;?></a></li>
    <li class="page-item"><a class="page-link" href='conteststatistics.php?cid=<?php echo $view_cid?>'><?php echo $MSG_STATISTICS;?></a></li>
    </ul><?php } ?>
    <table id="result-tab" class="table table-hover" style="width:100%">
    <thead>
						<tr class='toprow'>
							<th>
								#
							</th>
							<th>
								<?php echo $MSG_USER?>
							</th>
						<th>
							<?php echo $MSG_NICK?>
						</th>
							<th>
								<?php echo $MSG_PROBLEM?>
							</th>
							<th width=20%>
								<?php echo $MSG_RESULT?>
							</th>
							<th class='hidden-xs'>
								<?php echo $MSG_MEMORY?>
							</th>
							<th class='hidden-xs'>
								<?php echo $MSG_TIME?>
							</th>
							<th> 
								<?php echo $MSG_LANG?>
							</th>
							<th class='hidden-xs'>
								<?php echo $MSG_CODE_LENGTH?>
							</th>
							<th>
								<?php echo $MSG_SUBMIT_TIME?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$cnt = 0;
						foreach ( $view_status as $row ) {
							echo "<tr>";
							$i = 0;
							foreach ( $row as $table_cell ) {
								if ($i > 9)
									continue;
								if ( $i > 3 && $i != 8 && $i!=6)
									echo "<td class='hidden-xs'>";
								else
									echo "<td>";
								echo $table_cell;
								echo "</td>";
								$i++;
							}
							echo "</tr>\n";
							$cnt = 1 - $cnt;
						}
						?>
					</tbody>
</table>
<ul class="pagination">
  <li class="page-item"><a class="page-link" href=<?php echo "status.php?".$str2;?>>顶页</a></li>
 <?php  if (isset($_GET['prevtop'])) { ?>
  <li class="page-item"><a class="page-link" href="<?php echo "status.php?".$str2."&top=".intval($_GET['prevtop']);?>">上一页</a></li>
  <?php }else{ ?>
  <li class="page-item"><a class="page-link" href="<?php echo "status.php?".$str2."&top=".($top+20);?>">上一页</a></li>
  <?php }?>
  <li class="page-item"><a class="page-link" href="<?php echo "status.php?".$str2."&top=".$bottom."&prevtop=".$top;?>">下一页</a></li>
</ul>
    </div>
    </div>
    </div>
    <div class=col-md-3>
        <div class="card">
            <div class="card-body">
                
    <form id=simform action="status.php" method="get">
					<?php echo $MSG_PROBLEM_ID?>:<input class="form-control" type=text size=4 name=problem_id value='<?php echo  htmlspecialchars($problem_id, ENT_QUOTES) ?>'>
					<?php echo $MSG_USER?>:<input class="form-control" type=text size=4 name=user_id value='<?php echo  htmlspecialchars($user_id, ENT_QUOTES) ?>'>
					<?php if (isset($cid)) echo "<input type='hidden' name='cid' value='$cid'>";?>
					<?php echo $MSG_LANG?>:
					<select class="form-control custom-select" size="1" name="language">
						<option value="-1">All</option>
						<?php
						if ( isset( $_GET[ 'language' ] ) ) {
							$selectedLang = intval( $_GET[ 'language' ] );
						} else {
							$selectedLang = -1;
						}
						$lang_count = count( $language_ext );
						$langmask = $OJ_LANGMASK;
						$lang = ( ~( ( int )$langmask ) ) & ( ( 1 << ( $lang_count ) ) - 1 );
						for ( $i = 0; $i < $lang_count; $i++ ) {
							if ( $lang & ( 1 << $i ) )
								echo "<option value=$i " . ( $selectedLang == $i ? "selected" : "" ) . ">
		" . $language_name[ $i ] . "
		</option>";
						}
						?>
					</select>
					<?php echo $MSG_RESULT?>:
					<select class="form-control custom-select" size="1" name="jresult">
						<?php if (isset($_GET['jresult'])) $jresult_get=intval($_GET['jresult']);
else $jresult_get=-1;
if ($jresult_get>=12||$jresult_get<0) $jresult_get=-1;
/*if ($jresult_get!=-1){
$sql=$sql."AND `result`='".strval($jresult_get)."' ";
$str2=$str2."&jresult=".strval($jresult_get);
}*/
if ($jresult_get==-1) echo "<option value='-1' selected>All</option>";
else echo "<option value='-1'>All</option>";
for ($j=0;$j<12;$j++){
$i=($j+4)%12;
if ($i==$jresult_get) echo "<option value='".strval($jresult_get)."' selected>".$jresult[$i]."</option>";
else echo "<option value='".strval($i)."'>".$jresult[$i]."</option>";
}
echo "</select>";
?>
					</select>
					<?php if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'source_browser'])){
if(isset($_GET['showsim']))
$showsim=intval($_GET['showsim']);
else
$showsim=0;
echo "SIM:
<select id=\"appendedInputButton\" class=\"form-control custom-select\" name=showsim onchange=\"document.getElementById('simform').submit();\">
<option value=0 ".($showsim==0?'selected':'').">All</option>
<option value=50 ".($showsim==50?'selected':'').">50</option>
<option value=60 ".($showsim==60?'selected':'').">60</option>
<option value=70 ".($showsim==70?'selected':'').">70</option>
<option value=80 ".($showsim==80?'selected':'').">80</option>
<option value=90 ".($showsim==90?'selected':'').">90</option>
<option value=100 ".($showsim==100?'selected':'').">100</option>
</select>";
/* if (isset($_GET['cid']))
echo "<input type=hidden name=cid value='".$_GET['cid']."'>";
if (isset($_GET['language']))
echo "<input type=hidden name=language value='".$_GET['language']."'>";
if (isset($_GET['user_id']))
echo "<input type=hidden name=user_id value='".$_GET['user_id']."'>";
if (isset($_GET['problem_id']))
echo "<input type=hidden name=problem_id value='".$_GET['problem_id']."'>";
//echo "<input type=submit>";
*/
}
echo "<input type=submit class='form-control btn btn-info' value='$MSG_SEARCH'></form>";
?>
            </div>
        </div>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
<script>
	var i = 0;
	var judge_result = [<?php
	foreach ($judge_result as $result) {
		echo "'$result',";
	} ?>
	''];

	var judge_color = [<?php
	foreach ($judge_color as $result) {
		echo "'$result',";
	} ?>
	''];
</script>
<script src="<?php echo $OJ_CDN_URL?>template/bs3/auto_refresh.js"></script>
</html>

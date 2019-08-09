<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
require_once("mysql.php");
$sltv=0; 
	$sql_query = "SELECT * FROM caidat WHERE id='1'";
	$caidattmp = $conn->query($sql_query); 
	$caidat = $caidattmp->fetch_assoc();
	
	
	$chophepview = "{$caidat['viewrank']}";
	if ($chophepview==1)
		{
			if (isset($_SESSION['user_id'] ))
				{
					$user_id = intval($_SESSION['user_id']);
					$sql_query = "SELECT * FROM members WHERE id='{$user_id}'";
					$member1 = $conn->query($sql_query); 
					$member = $member1->fetch_assoc();
					if ($member['admin'] == "0"){
						if ($chophepview == 0)
							{
								echo "<font color='red'><b>Admin đã tắt chức năng xem bảng điểm, vui lòng liên hệ admin để được trợ giúp!</b>";
								exit;
							}
					
					}


				} 
			else
				{
					echo "<div class = container><font color = red>"."Hãy đăng nhập để được xem bảng xếp hạng"."</font></div>";
					exit;
				}
		}
		
		
$result = $conn->query("SELECT username FROM members");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$sltv=$sltv+1;
     	$tentv[$sltv]=$row["username"];
    }
}
//$conn->close();
?>
<div class="container">
<h2>Bảng điểm tổng quát</h2>
<p>Danh sách sẽ được cập nhật liên tục</p>	
<table  class="table table-bordered table-hover" > <thead><td><b><center>Rank</center></b></td><td><b>Tên thí sinh</b></td>
<?php	
// so luong bai tap
$slbt = 0;
$directorydb = 'debai/';
$it1 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorydb));

while($it1->valid()) {
    if (!$it1->isDot()) {	
		$Tenbai= $it1->getSubPathName();
		$Tenbai = str_replace(".PDF","",strtoupper($Tenbai));
		$Tenbai = str_replace(".DOC","",strtoupper($Tenbai));
		if ($dd[$Tenbai]!="true")
			{
				$slbt=$slbt+1;
				$nameb[$slbt]=$Tenbai;
				$DD[$Tenbai]="true";
				echo "<td><a target='_blank' href='"."http://".$_SERVER['HTTP_HOST']."/themis/".$directorydb.$it1->getSubPathName()."'>".$Tenbai."</a></td>";
			}
    }
    $it1->next();
}
$chuanop="∄ chưa nộp";
for ($i = 1; $i <= $sltv; $i++)
		{
			for ($j = 1; $j <= $slbt; $j++)
			{
					$point[$tentv[$i]][$nameb[$j]]=$chuanop; //echo 1;
			}
		}
		
$directory = 'nopbai/Logs/';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

while($it->valid()) {

    if (!$it->isDot()) {	
		$datainfo= $it->getSubPathName();		
		$r = explode(']', $datainfo);
		$user = trim($r[0], '[');
		$bai = strtoupper(trim($r[1], '['));
		$link = $directory. $it->getSubPathName();
		$fi = fopen($link, "r");
		$data = fgets($fi);
		fclose($fi);
		preg_match ('#: (.+?)\n#s',$data,$res);
		// Lấy thông tin của username đã nhập trong table members
		$sql_query = "SELECT id, username FROM members WHERE username='{$user}'";
		$member1 = $conn->query($sql_query); 
		$member = $member1->fetch_assoc();
		$point[$user][$bai]=$res[1];						
    }
    $it->next();
}
?><td><b>Tổng điểm</b></td></thead>
<?php
$sumpoint[0]=0;
for ($i = 1; $i <= $sltv; $i++)
		{
			$sql_query1 = "SELECT name FROM members WHERE username='{$tentv[$i]}'";
			$member112 = $conn->query($sql_query1); 
			$member12 = $member112->fetch_assoc(); 
			
			$s=0;
			for ($j = 1; $j <= $slbt; $j++)
			{	
						$point[$tentv[$i]][$nameb[$j]]=str_replace(",",".",$point[$tentv[$i]][$nameb[$j]]);
						$s=$s+$point[$tentv[$i]][$nameb[$j]];
			}
			$arr_name[$i]=$member12['name'];
			$sumpoint[$i]=$s;
		}
// sort
for ($i = 1; $i <= $sltv; $i++) $pos[$i]=$i;
for ($i = 1; $i < $sltv; $i++)
	{
        $max = $i;
        for ($j = $i + 1; $j <= $sltv; $j++){
            if (
			($sumpoint[$pos[$j]] > $sumpoint[$pos[$max]]) || 
				(
					($sumpoint[$pos[$j]] == $sumpoint[$pos[$max]]) && 
					($tentv[$pos[$j]] < $tentv[$pos[$max]])
				)			
			)			
			{
                $max = $j;
            }
        }
			$z=$pos[$i];
			$pos[$i]=$pos[$max];
			$pos[$max]=$z;	
	}

for ($i = 1; $i <= $sltv; $i++)
		{
			echo "<tr><td><center><b>".$i."</b></td></center>";
			//$sql_query1 = @mysql_query("SELECT name FROM members WHERE username='{$tentv[$i]}'");
			echo "<td>".$arr_name[$pos[$i]]."</td>";
			for ($j = 1; $j <= $slbt; $j++)
			{	
				if ($point[$tentv[$pos[$i]]][$nameb[$j]] > 0)
					echo "<td><font color = blue>".$point[$tentv[$pos[$i]]][$nameb[$j]]."</font></td>";
				else if ($point[$tentv[$pos[$i]]][$nameb[$j]] == "∄ chưa nộp")
					echo "<td>".$point[$tentv[$pos[$i]]][$nameb[$j]]."</td>";	
				else
					echo "<td><font color = red>".$point[$tentv[$pos[$i]]][$nameb[$j]]."</font></td>";
			}
			if ($sumpoint[$pos[$i]] == 0)
				echo "<td><font color = red>".$sumpoint[$pos[$i]]."</font></td></tr>";
			else
				echo "<td><font color = blue>".$sumpoint[$pos[$i]]."</font></td></tr>";
		}
?>
</table>
</div>
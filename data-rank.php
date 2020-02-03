<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
require_once "mysql.php";
require_once "sort_dir.php";
$sltv      = 0;
$sql_query = "SELECT * FROM caidat WHERE id='1'";
$caidattmp = $conn->query($sql_query);
$caidat    = $caidattmp->fetch_assoc();

$chophepview = "{$caidat['viewrank']}";

if (isset($_SESSION['user_id'])) {
    $user_id   = intval($_SESSION['user_id']);
    $sql_query = "SELECT * FROM members WHERE id='{$user_id}'";
    $member1   = $conn->query($sql_query);
    $member    = $member1->fetch_assoc();

    if ($member['admin'] == "0") {
        if ($chophepview == 0) {
            echo "<font color='red'><b>Admin đã tắt chức năng xem bảng điểm, vui lòng liên hệ admin để được trợ giúp!</b>";
            exit;
        }

    }

} else {
    echo "<div class = container><font color = red>" . "Please login to view the ranks" . "</font></div>";
    exit;
}

$result = $conn->query("SELECT username FROM members");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sltv         = $sltv + 1;
        $tentv[$sltv] = $row["username"];
    }
}
//$conn->close();
?>

<div class="container">
<div class="col-md-3 text-left no-pad">
    <h4>Start</h4>
    <?php echo $begin; ?>
</div>
<div class="col-md-6 text-center">
    <h2 class="title"><?php echo $cname; ?></h2>
</div>
<div class="col-md-3 text-right no-pad">
    <h4>End</h4>
    <?php echo $date; ?>
</div>
</div>
<div class="container">
<!-- progress bar -->
<div class="progress progress-striped active">
<?php if ($progress < 100) {?>
    <div class="progress-bar progress-bar-success" style="width: <?php echo $progress; ?>%"><?php echo (int)$progress; ?>%</div>
<?php } else { ?>
    <div class="progress-bar progress-bar-success" style="width: 100%">Hết thời gian làm bài</div>;
<?php
}
?>
</div>
<div class="legend-strip">
    <div class="table-legend">
        <div>
        <span class="legend-solvedfirst legend-status"></span>
        <p class="legend-label"> First Solved problem</p></div>
        <div>
        <div>
        <span class="legend-solved legend-status"></span>
        <p class="legend-label"> Solved problem</p></div>
        <div>
        <span class="legend-attempted legend-status"></span>
        <p class="legend-label"> Attempted problem</p>
        </div>
        <div>
        <span class="legend-pending legend-status"></span>
        <p class="legend-label"> Pending judgement</p>
        </div>
    </div>
</div>
<br>
<br>
<table  class="table table-bordered table-hover" > <tr class='active'><td><b><center>Rank</center></b></td><td><b>Name</b></td><td><b>SLV.</b></td><td><b>TIME</b></td>
<?php
// so luong bai tap
$slbt        = 0;
$directorydb = 'debai/';
$it1         = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorydb));

while ($it1->valid()) {
    if (!$it1->isDot()) {
        $Tenbai = $it1->getSubPathName()[0];
        $Tenduoi = substr($it1->getSubPathName(), -4);
        $Tenchitiet = substr($it1->getSubPathName(), 2, -4);
        if ($dd[$Tenbai] != "true") {
            $slbt         = $slbt + 1;
            $nameb[$slbt] = $Tenbai;
            $dd[$Tenbai]  = "true";
            echo "<td><a target='_blank' href='" . "http://" . $_SERVER['HTTP_HOST'] . "/themis/" . $directorydb . $it1->getSubPathName() . "' title='".$Tenchitiet."'>" . $Tenbai . "</a></td>";
        }
    }
    $it1->next();
}
$chuanop = "∄ chưa nộp";
for ($i = 1; $i <= $sltv; $i++) {
    $total_solved[$tentv[$i]] = 0;
    for ($j = 1; $j <= $slbt; $j++) {
        $total_tried_bai[$nameb[$j]] = 0;
        $total_solved_bai[$nameb[$j]] = 0;
        $first[$nameb[$j]] == false;
        $point[$tentv[$i]][$nameb[$j]] = $chuanop; //echo 1;
        $first_solve[$tentv[$i]][$nameb[$j]] = false;
        $check_solved[$tentv[$i]][$nameb[$j]] = false;
        $pen[$tentv[$i]][$nameb[$j]] = 0;
    }
}

$directory = 'nopbai/Logs/';
$files_array = better_scandir($directory);

foreach($files_array as $file) {
    $datainfo = $file;
    $r        = explode(']', $datainfo);
    $frozen   = trim($r[0], '[');
    $time     = trim($r[1], '[');
    $user     = trim($r[2], '[');
    $bai      = strtoupper(trim($r[3], '['));
    $link     = $directory . $file;
    $fi       = fopen($link, "r");
    $data     = fgets($fi);
    
    // echo $link."<br>";
    preg_match('#: (.+?)\n#s', $data, $res);
    // check max point
    if(!$check_solved[$user][$bai]) {
        if ($res[1] == MAX_POINT && $frozen != "frozen" ) {
            $check_solved[$user][$bai] = true;
            // add time
            $thoigian[$user][$bai] = $time+720*$pen[$user][$bai];
            $total_solved[$user] += $pen[$user][$bai]+1;
        }
        
        // check pending
        if ($frozen == "frozen") {
            $point[$user][$bai] = "frozen";
            $pen[$user][$bai]-=1;
            $total_tried_bai[$bai] -= 1;
        } else { 

            if ($res[1]<MAX_POINT) $res[1]=0;

            $point[$user][$bai] = $res[1];
            // Check first solve
            if(!$first[$bai] && $point[$user][$bai] == MAX_POINT) {
                $first[$bai] = true;
                $first_solve[$user][$bai] = true;
            }   
        }
        // add more penalty
        $pen[$user][$bai] += 1; 
        // total tried
        $total_tried_bai[$bai] += 1;
    }
    fclose($fi);
}
?></tr>
<?php
$sumpoint[0] = 0;
for ($i = 1; $i <= $sltv; $i++) {
    $sql_query1 = "SELECT name FROM members WHERE username='{$tentv[$i]}'";
    $member112  = $conn->query($sql_query1);
    $member12   = $member112->fetch_assoc();

    $s = 0;
    $s1 = 0;
    for ($j = 1; $j <= $slbt; $j++) {
        $point[$tentv[$i]][$nameb[$j]] = str_replace(",", ".", $point[$tentv[$i]][$nameb[$j]]);
        $s                             = $s + $point[$tentv[$i]][$nameb[$j]];
        $s1 = $s1 + $thoigian[$tentv[$i]][$nameb[$j]];
    }
    $arr_name[$i] = $member12['name'];
    $sumpoint[$i] = $s;
    $tongthoigian[$i] = $s1;
}
// sort
for ($i = 1; $i <= $sltv; $i++) {
    $pos[$i] = $i;
}

for ($i = 1; $i < $sltv; $i++) {
    $max = $i;
    for ($j = $i + 1; $j <= $sltv; $j++) {
        if (
            ($sumpoint[$pos[$j]] > $sumpoint[$pos[$max]]) ||
            (
                ($sumpoint[$pos[$j]] == $sumpoint[$pos[$max]]) &&
                ($tongthoigian[$pos[$j]] < $tongthoigian[$pos[$max]])
            )
        ) {
            $max = $j;
        }
    }
    $z         = $pos[$i];
    $pos[$i]   = $pos[$max];
    $pos[$max] = $z;
}

for ($i = 1; $i <= $sltv; $i++) {
    // Col rank
    if ($i==1) {
        echo "<tr><td width='5%'><img src='./img/1st.png' height='30' width='33'></td>";
    } elseif ($i == 2) {
        echo "<tr><td width='5%'><img src='./img/2nd.png' height='30' width='33'></td>";
    } elseif ($i == 3) {
        echo "<tr><td width='5%'><img src='./img/3rd.png' height='30' width='33'></td>";
    } else {
        echo "<tr><td width='5%'><center><b>" . $i . "</b></td></center>";
    }
    // Total minutes
    $total_mins = round($tongthoigian[$pos[$i]]/60);
    // Col name
    echo "<td style='text-align: left;' height='50px'>" . $arr_name[$pos[$i]] . "</td>";
    // Col total solved
    echo "<td width='5%'>".$total_solved[$tentv[$pos[$i]]]."</td>";
    // Col total time
    if ($sumpoint[$pos[$i]] == 0) {
        echo "<td width='5%'><font color = red></font><br>"."</td>";
    } else {
        echo "<td width='5%'>".$total_mins."</td>";
        
    }
    // Col point
    for ($j = 1; $j <= $slbt; $j++) {
        // minutes of problems
        $mins = round($thoigian[$tentv[$pos[$i]]][$nameb[$j]]/60);
        // Check aceppted
        if ($point[$tentv[$pos[$i]]][$nameb[$j]] == MAX_POINT) {
            if ($first_solve[$tentv[$pos[$i]]][$nameb[$j]]) { // Check first solved
                echo "<td class='solvedfirst' width='5%'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."<br>".$mins."</td>";
            } else {
                echo "<td class='solved' width='5%'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."<br>".$mins."</td>";
            }
            // total solved
            $total_solved_bai[$nameb[$j]] += $pen[$tentv[$pos[$i]]][$nameb[$j]];
        } else if ($point[$tentv[$pos[$i]]][$nameb[$j]] == "∄ chưa nộp") { 
            echo "<td bgcolor='' width='5%'></td>"; // Not solved
        } else if ($point[$tentv[$pos[$i]]][$nameb[$j]] == "frozen") {  
            echo "<td class='frozen' width='5%'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."</td>"; // Pending
        } else {
            echo "<td class='attempted' width='5%'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."<br>--</td>"; // Wrong ans
        } 

    }
    echo "</tr>";

}

?>

<tr>
<th colspan="4">Solved / Tries</th>
<?php
    for ($i = 1; $i <= $slbt; $i++) {
        $x = $total_solved_bai[$nameb[$i]];
        $y = $total_tried_bai[$nameb[$i]];
        if ($y==0) {
            echo "<td><span><sup>".$x."</sup>/<sub>".$y."</sub><br>(0%)</span></td>";
        }
        else {
            echo "<td><span><sup>".$x."</sup>/<sub>".$y."</sub><br>(".(int)($x/$y*100)."%)</span></td>";
        }
    }
?>
</tr>
</table>
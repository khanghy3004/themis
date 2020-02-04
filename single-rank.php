<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
require_once "mysql.php";
require_once "sort_dir.php";
$sltv      = 0;
$result = $conn->query("SELECT username FROM members WHERE id='{$user_id}'");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sltv         = $sltv + 1;
        $tentv[$sltv] = $row["username"];
    }
}
//$conn->close();
?>

<h3>Your point</h3>
<table  class="table table-bordered table-hover" > <tr class="active"><td><b>Name</b></td><td width="5%"><b>SLV.</b></td><td width="5%"><b>TIME</b></td>
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
            echo "<td  width='6%'><a target='_blank' href='" . "http://" . $_SERVER['HTTP_HOST'] . "/themis/" . $directorydb . $it1->getSubPathName() . "' data-title='".$Tenchitiet."'>" . $Tenbai . "</a></td>";
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
        $pen[$tentv[$i]][$nameb[$j]] = 0;
    }
}

$directory = 'nopbai/Logs/';
$it        = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$files_array = better_scandir($directory);

foreach($files_array as $file) {
    $datainfo = $file;
    $r        = explode(']', $datainfo);
    $frozen   = trim($r[2], '[');
    $time     = trim($r[1], '[');
    $user     = trim($r[2], '[');
    $bai      = strtoupper(trim($r[3], '['));
    $link     = $directory . $file;
    $fi       = fopen($link, "r");
    $data     = fgets($fi);
    $time_limit="Chạy quá thời gian";
    $check_time_limit = false;
    $run_time="Chạy sinh lỗi";
    $check_run_time = false;
    $wrong_ans = "Kết quả KHÁC đáp án!";
    $check_wrong_ans = false;
    $compile_err = "ℱ Dịch lỗi";
    $check_compile_err = false;
    $accepted = "Kết quả khớp đáp án!";

    $hours = (int)($time/3600);
    $mins = (int)($time/60)%60;
    preg_match('#: (.+?)\n#s', $data, $res);
    if ($user == $tentv[1]) {
        if (strpos($res[1], $compile_err) !== false) {
            $check_compile_err = true;
            echo "<font color='red'><b>".$hours.":".$mins." ".$bai." Compile Error</b></font><br>";
        }

        while (($buffer = fgets($fi)) !== false) {
            if (strpos($buffer, $time_limit) !== false) {
                $check_time_limit = true;
                echo "<font color='red'><b>".$hours.":".$mins." ".$bai." Time Limit Exceeded</b></font><br>";
                break;
            }
            if (strpos($buffer, $run_time) !== false) {
                $check_run_time = true;
                echo "<font color='red'><b>".$hours.":".$mins." ".$bai." Run Time Error</b></font><br>";
                break;
            }
            if (strpos($buffer, $wrong_ans) !== false) {
                $check_wrong_ans = true;
                echo "<font color='red'><b>".$hours.":".$mins." ".$bai." Wrong Answer</b></font><br>";
                break;
            }
            
        }
        if ($user == $tentv[1] && !$check_time_limit && !$check_run_time && !$check_wrong_ans && !$check_compile_err) {
            echo "<font color='green'><b>".$hours.":".$mins." ".$bai." Accepted</b></font><br>";
        }
    }
    if(!$check_solved[$user][$bai]) {
        if ($res[1] == MAX_POINT) {
            $check_solved[$user][$bai] = true;
            // add time
            $thoigian[$user][$bai] = $time+720*$pen[$user][$bai];
            $total_solved[$user] += $pen[$user][$bai]+1;
        }
        
        // Lấy thông tin của username đã nhập trong table members
        $sql_query          = "SELECT id, username FROM members WHERE username='{$user}'";
        $member1            = $conn->query($sql_query);
        $member             = $member1->fetch_assoc();
        if ($res[1]<MAX_POINT) $res[1]=0;
        

        $point[$user][$bai] = $res[1];
        // Check first solve
        if(!$first[$bai] && $point[$user][$bai] == MAX_POINT) {
            $first[$bai] = true;
            $first_solve[$user][$bai] = true;
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
    // Total minutes
    $total_mins = round($tongthoigian[$pos[$i]]/60);
    // Col name
    echo "<td>" . $arr_name[$pos[$i]] . "</td>";
    // Col total solved
    echo "<td>".$total_solved[$tentv[$pos[$i]]]."</td>";
    // Col total time
    if ($sumpoint[$pos[$i]] == 0) {
        echo "<td><font color = red></font><br>"."</td>";
    } else {
        echo "<td>".$total_mins."</td>";
        
    }
    for ($j = 1; $j <= $slbt; $j++) {
        // minutes of problems
        $mins = round($thoigian[$tentv[$pos[$i]]][$nameb[$j]]/60);
        // Check aceppted
        if ($point[$tentv[$pos[$i]]][$nameb[$j]] == MAX_POINT) {
            if ($first_solve[$tentv[$pos[$i]]][$nameb[$j]]) {
                echo "<td class='solvedfirst'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."<br>".$mins."</td>";
            } else {
                echo "<td class='solved'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."<br>".$mins."</td>";
            }
            // total solved
            $total_solved_bai[$nameb[$j]] += $pen[$tentv[$pos[$i]]][$nameb[$j]];
        } else if ($point[$tentv[$pos[$i]]][$nameb[$j]] == "∄ chưa nộp") {
            echo "<td bgcolor=''></td>";
        } else {
            echo "<td class='attempted'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."<br>--</td>";
        } 

    }
    echo "</tr>";

}
?>

<tr>
<th colspan="3">Solved / Tries</th>
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


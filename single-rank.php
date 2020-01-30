<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
require_once "mysql.php";
$sltv      = 0;
define("MAX_POINT", 10, true);
$result = $conn->query("SELECT username FROM members WHERE id='{$user_id}'");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sltv         = $sltv + 1;
        $tentv[$sltv] = $row["username"];
    }
}
//$conn->close();
?>
<div class="container">
<h3>Điểm hiện tại</h3>
<table  class="table table-bordered table-hover" > <thead><td><b>Name</b></td>
<?php
// so luong bai tap
$slbt        = 0;
$directorydb = 'debai/';
$it1         = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorydb));

while ($it1->valid()) {
    if (!$it1->isDot()) {
        $Tenbai = $it1->getSubPathName();
        $Tenbai = str_replace(".PDF", "", strtoupper($Tenbai));
        $Tenbai = str_replace(".DOC", "", strtoupper($Tenbai));
        if ($dd[$Tenbai] != "true") {
            $slbt         = $slbt + 1;
            $nameb[$slbt] = $Tenbai;
            $dd[$Tenbai]  = "true";
            echo "<td><a target='_blank' href='" . "http://" . $_SERVER['HTTP_HOST'] . "/themis/" . $directorydb . $it1->getSubPathName() . "'>" . $Tenbai . "</a></td>";
        }
    }
    $it1->next();
}
$chuanop = "∄ chưa nộp";
for ($i = 1; $i <= $sltv; $i++) {
    for ($j = 1; $j <= $slbt; $j++) {
        $point[$tentv[$i]][$nameb[$j]] = $chuanop; //echo 1;
        $first_solve[$tentv[$i]][$nameb[$j]] = false;
        $pen[$tentv[$i]][$nameb[$j]] = 0;
    }
}
for ($i = 1; $i <= $slbt; $i++) {
    $first[$nameb[$i]] == false;
}

$directory = 'nopbai/Logs/';
$it        = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

while ($it->valid()) {

    if (!$it->isDot()) {
        $datainfo = $it->getSubPathName();
        $r        = explode(']', $datainfo);
        $frozen   = trim($r[1], '[');
        $time     = trim($r[2], '[');
        $user     = trim($r[3], '[');
        $bai      = strtoupper(trim($r[4], '['));
        $link     = $directory . $it->getSubPathName();
        $fi       = fopen($link, "r");
        $data     = fgets($fi);
        fclose($fi);
        preg_match('#: (.+?)\n#s', $data, $res);
        if(!$check_solved[$user][$bai]) {
            if ($res[1] == MAX_POINT) {
                $check_solved[$user][$bai] = true;
                // add time
                $thoigian[$user][$bai] = $time+720*$pen[$user][$bai];
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
  
        }
    }
    $it->next();
}
?><td><b>TIME</b></td></thead>
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
    echo "<td>" . $arr_name[$pos[$i]] . "</td>";
    for ($j = 1; $j <= $slbt; $j++) {
        if ($point[$tentv[$pos[$i]]][$nameb[$j]] == MAX_POINT) {
            if ($first_solve[$tentv[$pos[$i]]][$nameb[$j]]) {
                echo "<td class='solvedfirst'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."<br>".(int)($thoigian[$tentv[$pos[$i]]][$nameb[$j]]/60).":".($thoigian[$tentv[$pos[$i]]][$nameb[$j]]%60)."</td>";
            } else {
                echo "<td class='solved'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."<br>".(int)($thoigian[$tentv[$pos[$i]]][$nameb[$j]]/60).":".($thoigian[$tentv[$pos[$i]]][$nameb[$j]]%60)."</td>";
            }
        } else if ($point[$tentv[$pos[$i]]][$nameb[$j]] == "∄ chưa nộp") {
            echo "<td bgcolor=''>" . $point[$tentv[$pos[$i]]][$nameb[$j]] . "</td>";
        } else {
            echo "<td class='attempted'>".$pen[$tentv[$pos[$i]]][$nameb[$j]]."</td>";
        } 

    }
    if ($sumpoint[$pos[$i]] == 0) {
        echo "<td><font color = red></font><br>"."</td></tr>";
    } else {
        echo "<td>".(int)($tongthoigian[$pos[$i]]/60).":".($tongthoigian[$pos[$i]]%60)."</td></tr>";
    }

}
?>


</table>
</div>

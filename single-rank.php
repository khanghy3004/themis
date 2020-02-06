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

<h3>Submissions</h3>
<table  class="table table-bordered table-hover text-center" > <thead class="thead-light"><tr><th width="1"><b>SUBMISSION</b></th><th ><b>TIME</b></th><th ><b>PROBLEM</b></th><th ><b>STATUS</b></th></thead>
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
            $namechitiet[$nameb[$slbt]] = $Tenchitiet;
            $dd[$Tenbai]  = "true";
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

$directory    = 'nopbai/Logs/';
$directory2   = 'thumucbailam/'.$tentv[1].'/';
$it           = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$files_array  = array_reverse(better_scandir($directory));
$search_array = array_reverse(search_file($directory2));

?>


<?php

$fileid = 0;
foreach($files_array as $file) {
    $datainfo = $file;
    $r        = explode(']', $datainfo);
    $frozen   = trim($r[2], '[');
    $time     = trim($r[1], '[');
    $user     = trim($r[2], '[');
    $bai      = strtoupper(trim($r[3], '['));
    $ngonngu  = ".".explode('.', $datainfo)[1];
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
    $secs = (int)($time%60);
    preg_match('#: (.+?)\n#s', $data, $res);
    if ($user == $tentv[1]) {
        if (strpos($res[1], $compile_err) !== false) {
            $check_compile_err = true;
            echo "<tr><td><a href='?CBHT=submit&fileid=".$fileid."'>".$bai.$ngonngu."</a></td><td>".$hours.":".$mins.":".$secs."</td><td>".$namechitiet[$bai]."</td><td><font color='red'><b>Compile Error</b></font></td></tr>";
        }

        while (($buffer = fgets($fi)) !== false) {
            if (strpos($buffer, $time_limit) !== false) {
                $check_time_limit = true;
                echo "<tr><td><a href='?CBHT=submit&fileid=".$fileid."'>".$bai.$ngonngu."</a></td><td>".$hours.":".$mins.":".$secs."</td><td>".$namechitiet[$bai]."</td><td><font color='red'><b>Time Limit Exceeded</b></font></td></tr>";
                break;
            }
            if (strpos($buffer, $run_time) !== false) {
                $check_run_time = true;
                echo "<tr><td><a href='?CBHT=submit&fileid=".$fileid."'>".$bai.$ngonngu."</a></td><td>".$hours.":".$mins.":".$secs."</td><td>".$namechitiet[$bai]."</td><td><font color='red'><b>Run Time Error</b></font></td></tr>";
                break;
            }
            if (strpos($buffer, $wrong_ans) !== false) {
                $check_wrong_ans = true;
                echo "<tr><td><a href='?CBHT=submit&fileid=".$fileid."'>".$bai.$ngonngu."</a></td><td>".$hours.":".$mins.":".$secs."</td><td>".$namechitiet[$bai]."</td><td><font color='red'><b>Wrong Answer</b></font></td></tr>";
                break;
            }
            
        }
        if ($user == $tentv[1] && !$check_time_limit && !$check_run_time && !$check_wrong_ans && !$check_compile_err) {
            echo "<tr><td><a href='?CBHT=submit&fileid=".$fileid."'>".$bai.$ngonngu."</a></td><td>".$hours.":".$mins.":".$secs."</td><td>".$namechitiet[$bai]."</td><td><font color='green'><b>Accepted</b></font></td></tr>";
        }
        $fileid++;
        if (isset($_GET['fileid'])) {
            $file = $search_array[$_GET['fileid']];
            ?>
            <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">File detail <?php $namebai=explode('/', $file); echo end($namebai); ?></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="editor1"><?php 
                    echo htmlspecialchars(file_get_contents($file));
                    ?></div>
                    <script type="text/javascript">
                    var editor1 = ace.edit("editor1");
                    editor1.setTheme("ace/theme/");
                    editor1.getSession().setMode("ace/mode/c_cpp");
                    document.getElementById('editor1').style.fontSize = '15px';
                    </script>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
              </div>
            </div>
          </div>
            
            <?php
        }
    }
    
    fclose($fi);

}
?>

</table>


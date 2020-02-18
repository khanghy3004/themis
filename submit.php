<?php
include_once "dulieu/header.php";
//start: fix  Undefined index
if (!isset($_GET["CBHT"])) {
    $_GET["CBHT"] = '';
}
//end: fix  Undefined index
?>

    <div class=container>
        <div id="demo"></div>
        <br>
        <?php
include_once "viewtime.php";
?>
                <?php 
// Hẹn giờ làm bài
date_default_timezone_set('Asia/Ho_Chi_Minh');
$time_2 = date('H:i:s'); //current time
$days1 = (strtotime($time_2) - strtotime($begin));
$days2   = (strtotime($date) - strtotime($time_2));
//Nếu $days>0 cho phép submit
if ($days1 > 0 && $days2 > 0) {
                if ($_GET['error']) {
                    echo "
                    <div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      Submit error!
                    </div>
                    ";
                } 
                if ($_GET['success']) {
                    echo "
                    <div class='alert alert-success alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      Submit successfully!
                    </div>
                    ";
                }
                ?>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">Submit file</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">Editor</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <br>
                        <form action="?CBHT=submit&act=do" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Problem ID</label>
                                <select class="form-control" name="tenbai">
                                    <option selected="" selected disabled hidden>Select a problem</option>
                                    <option>A</option>
                                    <option>B</option>
                                    <option>C</option>
                                    <option>D</option>
                                    <option>E</option>
                                    <option>F</option>
                                    <option>G</option>
                                    <option>H</option>
                                    <option>I</option>
                                </select>
                            </div>
                            <p>The system only allows file types *.pas, *.pp, *.cpp, *.java, *.c, *.py</p>
                            <p>
                                <input type="file" name="fileToUpload" id="fileToUpload">
                            </p>
                            <input type="submit" class="btn btn-success" value="Submit" name="submit">
                        </form>

                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <form action="?CBHT=submit&act=do1" method="post" enctype="multipart/form-data">
                            <br>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Problem ID</label>
                                <select class="form-control" name="tenbai1">
                                    <option selected="" selected disabled hidden>Select a problem</option>
                                    <option>A</option>
                                    <option>B</option>
                                    <option>C</option>
                                    <option>D</option>
                                    <option>E</option>
                                    <option>F</option>
                                    <option>G</option>
                                    <option>H</option>
                                    <option>I</option>
                                </select>
                                <label for="exampleFormControlSelect1">Language</label>
                                <select class="form-control" name="ngonngu" id="ngonngu">
                                  <option>C</option>
                                  <option>C++</option>
                                  <option>Python 3</option>
                                  <option>Pascal</option>
                                  <option>Java</option>
                                </select>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Editor</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="editor"></div>
                                    <input type="hidden" name="content" id="content">
                                    <script type="text/javascript">
                                        $('#ngonngu').change(function() {
                                            var category = $(this).val();
                                            arr = {'C': 'c_cpp', 'C++': 'c_cpp', 'Python 3': 'python', 'Pascal': 'pascal', 'Java': 'java'};
                                            console.log(arr[category]);
                                            editor.getSession().setMode("ace/mode/"+arr[category]);
                                        });   

                                       var input = $('#content');
                                       var editor = ace.edit("editor");
                                       document.getElementById('editor').style.fontSize = '15px';
                                       // editor.setTheme("ace/theme/twilight");
                                       

                                       editor.getSession().on('change', function () {
                                           input.val(editor.getSession().getValue());
                                       });

                                       input.val(editor.getSession().getValue());
                                    </script>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-success" value="Submit" name="submit">
                        </form>
                    </div>
                </div>
                <br>
            <?php
            include_once "single-rank.php";


    if (isset($_SESSION['user_id'])) {

        //check xem co duoc sub hay ko?
        $sql_query  = "SELECT * FROM caidat WHERE id='1'";
        $caidat1    = $conn->query($sql_query);
        $caidat     = $caidat1->fetch_assoc();
        $chophepsub = "{$caidat['submiton']}";
        $user_id    = intval($_SESSION['user_id']);
        $sql_query  = "SELECT * FROM members WHERE id='{$user_id}'";
        $member1    = $conn->query($sql_query);
        $member     = $member1->fetch_assoc();

        if ($member['admin'] == "0") {
            if ($chophepsub == 0) {
                echo "<font color='red'><b>Admin đã tắt chức năng nộp bài, vui lòng liên hệ admin để được trợ giúp!</b>";
                exit;
            }
        }

        if (isset($_GET['act']) && $_GET['act'] == "do1") {

            $loaifile = array("C" => "c", "C++" => "cpp", "Python 3" => "py", "Pascal" => "pas", "Java" => "java");

            $tenfile = $_POST['tenbai1']."].".$loaifile[$_POST['ngonngu']];

            $thoigianlambai = (strtotime($time_2) - strtotime($begin));

            $namefile = "[$thoigianlambai][{$member['username']}][" . $tenfile;

            if ($days2 <= 1080) {$target_dir = "nopbai/[frozen]";}
            else {$target_dir = "nopbai/[ok]";}

            $target_file = $target_dir . $namefile;
            if ($_POST['content'] != "") {
                file_put_contents($target_file, $_POST['content']);
                echo "<script>window.location.href='./?CBHT=submit&success=1';</script>";
                echo "<font color=green><b>Tài khoản {$member['username']} đã nộp bài " . basename($_FILES["fileToUpload"]["name"]) . " thành công.</b></font><br>";
                print "<meta http-equiv='refresh' content='0; ?CBHT=submit'>";
            } else {
                echo "<script>window.location.href='./?CBHT=submit&error=1';</script>";
                echo "<font color=red><b>Submit Error!</b></font><br>";
            }
            
        }
        if (isset($_GET['act']) && $_GET['act'] == "do") //fix  Undefined index
        {
            $tenfile = basename($_FILES["fileToUpload"]["name"]);

            $ngonngu = explode('.', $_FILES["fileToUpload"]["name"])[1];

            $tenfile = $_POST['tenbai']."].".$ngonngu;

            $thoigianlambai = (strtotime($time_2) - strtotime($begin));

            $namefile = "[$thoigianlambai][{$member['username']}][" . $tenfile;

            if ($days2 <= 1080) {$target_dir = "nopbai/[frozen]";}
            else {$target_dir = "nopbai/[ok]";}

            $target_file = $target_dir . $namefile;

            $uploadOk = 1;

            $ngonngubailam = strtoupper(pathinfo($target_file, PATHINFO_EXTENSION));

            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Your file size is too big.<br>";
                $uploadOk = 0;
            }

            if ($ngonngubailam != "PAS" && $ngonngubailam != "PP" && $ngonngubailam != "CPP"
                && $ngonngubailam != "JAVA" && $ngonngubailam != "C" && $ngonngubailam != "PY") {
                echo "The system only allows file types *.pas, *.pp, *.cpp, *.java, *.c, *.py<br>";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<script>window.location.href='./?CBHT=submit&error=1';</script>";
                echo "<font color=red><b>Submit Error!</b></font><br>";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {           
                    echo "<script>window.location.href='./?CBHT=submit&success=1';</script>";
                    echo "<font color=green><b>Tài khoản {$member['username']} đã nộp bài " . basename($_FILES["fileToUpload"]["name"]) . " thành công.</b></font><br>";
                    print "<meta http-equiv='refresh' content='0; ?CBHT=submit'>";
                    //print "<meta http-equiv='refresh' content='0; /?CBHT=rank'>";
                } else {
                    echo "<font color=red><b>Xin lỗi, có lỗi phát sinh trong quá trình tải.</b></font><br>";
                }
            }
        } 
    } else {
        echo "Please login to continue!";
    }

}

?>
    </div>
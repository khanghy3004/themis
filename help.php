<?php
include_once "dulieu/header.php";
//start: fix  Undefined index
if (!isset($_GET["CBHT"])) {
    $_GET["CBHT"] = '';
}
//end: fix  Undefined index
?>

    <div class=container>

<?php

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
        $sql_query  = "SELECT * FROM cauhoi";
        $cauhoi1    = $conn->query($sql_query);
        $arr = array();
        while ($cauhoi     = mysqli_fetch_row($cauhoi1)) {
            array_push($arr, $cauhoi);
        }

        if (!isset($_GET['act']) && $_GET['act'] != "do1" && $_GET['act'] != "do") {
                    ?>
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#home">Danh sách câu hỏi</a></li>
                  <li><a data-toggle="tab" href="#menu1">Gửi câu hỏi</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <br>        
                        <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th><center>Người gửi</center></th>
                            <th><center>Mã bài</center></th>
                            <th><center>Câu hỏi</center></th>
                            <th><center>Trả lời</center></th>
                            <th><center>Trạng thái</center></th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i=0; $i<sizeof($arr); $i++) {
                                if ($arr[$i][5]) {
                                    $arr[$i][5] = "Đã xử lí";
                                } else {
                                    $arr[$i][5] = "Chưa xử lí";
                                }
                            ?>
                                <tr>
                                <td><?php echo $arr[$i][1] ?></td>
                                <td><?php echo $arr[$i][2] ?></td>
                                <td><a href="?CBHT=help&dataid=<?php echo $i;?>"><?php echo $arr[$i][3] ?></a></td>
                                <td><div class="a"><?php echo $arr[$i][4] ?></div></td>
                                <td><?php echo $arr[$i][5] ?></td>
                                </tr>
                               
                            <?php
                            }
                            ?>
                        </tbody>
                        </table>
                        <?php 
                            if (isset($_GET['dataid'])) {
                                $data = $arr[$_GET['dataid']];
                                ?>
                                <div class="modal show" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button onclick = "$('.modal').removeClass('show').addClass('fade');" type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Chi tiết câu hỏi bài <?php echo $data[2]; ?> </h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php 
                                        echo "<b>Người gửi: </b>";
                                        echo $data[1];
                                        echo "<br><b>Câu hỏi</b><br>".$data[3];
                                        echo "<form action='' id='usrform' method='post'>";
                                        echo "<input type='hidden' name='id' value=".$data[0].">";
                                        echo"<div class='form-group'><label>Trả lời:</label><textarea class='form-control' rows='5' id='answer' name='answer' form='usrform'>".$data[4]."</textarea></div>";
                                        if ($member['admin'] == 1) {
                                            echo "<br><input type='submit' class='btn btn-success' value='Cập nhật câu trả lời' name='submit'>";
                                            echo "</form>";
                                        }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                      <button onclick = "$('.modal').removeClass('show').addClass('fade');" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>                    
                                </div>
                              </div>
                                <?php
                            }
                            // Cập nhật câu trả lời
                            if(isset($_POST['id']) && isset($_POST['answer'])){
                                $sql = "UPDATE cauhoi SET answer='".$_POST['answer']."', status=1 WHERE id=".$_POST['id'];
                                if ($conn->query($sql) === TRUE) {
                                    echo "<SCRIPT LANGUAGE='JavaScript'>alert('Cập nhật thành công');</script>";
                                    print "<meta http-equiv='refresh' content='0; ./?CBHT=help'>";
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                                $conn->close();
                            }
                        ?>
                          

                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <form action="" method="post" enctype="multipart/form-data">
                            <br>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Chọn tên bài</label>
                                <select class="form-control" name="tenbai">
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
                            <div class="form-group">
                              <label>Câu hỏi:</label>
                              <textarea class="form-control" rows="5" id="question" name="question"></textarea>
                            </div>
                            <input type="submit" class="btn btn-success" value="Submit" name="submit">
                        </form>
                    </div>
                </div>
                <?php 
                     // Cập nhật câu hỏi
                    if(isset($_POST['tenbai']) && isset($_POST['question'])){
                        $sql = "INSERT INTO cauhoi(username,mabai,question) VALUES ('".$member['username']."','".$_POST['tenbai']."','".$_POST['question']."')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<SCRIPT LANGUAGE='JavaScript'>alert('Gửi câu hỏi thành công');</script>";
                            print "<meta http-equiv='refresh' content='0; ./?CBHT=help'>";
                        } else {
                            echo "Error updating record: " . $conn->error;
                        }
                        $conn->close();
                    }
                ?>
                <?php

        }
        if (isset($_GET['act']) && $_GET['act'] == "do") {

            $loaifile = array("C" => "c", "C++" => "cpp", "Python 3" => "py", "Pascal" => "pas", "Java" => "java");

            $tenfile = $_POST['tenbai']."].".$loaifile[$_POST['ngonngu']];

            $thoigianlambai = (strtotime($time_2) - strtotime($begin));

            $namefile = "[$thoigianlambai][{$member['username']}][" . $tenfile;

            if ($days2 <= 1080) {$target_dir = "nopbai/[frozen]";}
            else {$target_dir = "nopbai/[ok]";}

            $target_file = $target_dir . $namefile;

            file_put_contents($target_file, $_POST['content']);
            echo "<SCRIPT LANGUAGE='JavaScript'>alert('Bạn đã nộp bài thành công');</script>";
            echo "<font color=green><b>Tài khoản {$member['username']} đã nộp bài " . basename($_FILES["fileToUpload"]["name"]) . " thành công.</b></font><br>";
            print "<meta http-equiv='refresh' content='0; ?CBHT=submit'>";
        }
       
    } else {
        echo "Bạn chưa đăng nhập, vui lòng đăng nhập để tiếp tục";
    }

?>
    </div>
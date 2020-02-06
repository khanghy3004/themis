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
                    <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">Question List</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">Send a question</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <br>        
                        <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                          <tr>
                            <th><center>Sender</center></th>
                            <th><center>Problem</center></th>
                            <th><center>Question</center></th>
                            <th><center>Answer</center></th>
                            <th><center>Status</center></th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i=0; $i<sizeof($arr); $i++) {
                                if ($arr[$i][5]) {
                                    $arr[$i][5] = "Solved";
                                } else {
                                    $arr[$i][5] = "Not Solved";
                                }
                            ?>
                                <tr>
                                <td><?php echo $arr[$i][1] ?></td>
                                <td><?php echo $arr[$i][2] ?></td>
                                <td><div class="a"><a href="?CBHT=help&dataid=<?php echo $i;?>"><?php echo $arr[$i][3] ?></a></div></td>
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
                                <div class="modal fade" id="myModal">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Question detail problem <?php echo $data[2]; ?> </h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <?php 
                                        echo "<b>Sender: </b>";
                                        echo $data[1];
                                        echo "<br><b>Question:</b><br>".$data[3];
                                        echo "<form action='' id='usrform' method='post'>";
                                        echo "<input type='hidden' name='id' value=".$data[0].">";
                                        
                                        if ($member['admin'] == 1) {
                                            echo"<div class='form-group'><label>Answer:</label><textarea class='form-control' rows='5' id='answer' name='answer' form='usrform' required>".$data[4]."</textarea></div>
                                            <input type='submit' class='btn btn-success' value='Edit answer' name='submit'></form>";
                                        } else {
                                            echo"<div class='form-group'><label>Answer:</label><textarea readonly class='form-control' rows='5' id='answer' name='answer' form='usrform'>".$data[4]."</textarea></div></form>";
                                        }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                                <label for="exampleFormControlSelect1">Problem</label>
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
                              <label>Question:</label>
                              <textarea class="form-control" rows="5" id="question" name="question" required></textarea>
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
        echo "Please login to continue!";
    }

?>
    </div>
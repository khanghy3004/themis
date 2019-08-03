<?php
//start: fix  Undefined index
if(!isset($_GET["CBHT"])){
	$_GET["CBHT"]='';
}
//end: fix  Undefined index

include_once("dulieu/header.php");
?> 

<div class="container">
<h4>Bước 1:</h4>
	<p>1.1 Chọn đăng nhập.</p>
	<img class="img-responsive" src="img/buoc1-1.jpg" alt="Themis">
	<p>1.2 Nhập tên tài khoản và mật khẩu đã được cấp sẵn.</p>
	<img class="img-responsive" src="img/buoc1-2.jpg" alt="Themis">
<h4>Bước 2:</h4>
	<p>2.1 Chọn nộp bài</p>
	<img class="img-responsive" src="img/buoc2-1.jpg" alt="Themis">
	<p>Lưu ý: Tên file, input và ouput phải giống mã đề bài.</p>
	<div class="panel panel-success">
      <div class="panel-heading">Code Example</div>
      <div class="panel-body">
      	<font face="Consolas">
	      	<p><font color="green">#include &lt;stdio.h&gt;</font></p>
	      	<font color="blue">int</font> main<font color="red">() {</font><br>
	      	&nbsp;&nbsp;&nbsp;&nbsp;freopen <font color="red">(</font><font color="blue">"BCVTAB.inp"</font><font color="red">, </font><font color="blue">"r"</font><font color="red">, </font>stdin<font color="red">);</font><br>
	      	&nbsp;&nbsp;&nbsp;&nbsp;freopen <font color="red">(</font><font color="blue">"BCVTAB.out"</font><font color="red">, </font><font color="blue">"w"</font><font color="red">, </font>stdout<font color="red">);</font><br>
	      	&nbsp;&nbsp;&nbsp;&nbsp;<font color="grey">// Code here</font><br>
	      	&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">return </font><font color="red">0;</font><br>
	      	<font color="red">}</font>
      	</font>
      </div>
    </div>
	<p>2.2 Chọn file để nộp. Hệ thống chỉ cho phép nộp các file *.pas, *.pp, *.cpp, *.java, *.c.</p>
	<img class="img-responsive" src="img/buoc2-2.jpg" alt="Themis">
<h4>Bước 3:</h4>
	<p>Chọn bảng xếp hạng.</p>
	<p>Điểm sẽ được cập nhật ngay lập tức khi bạn nộp bài.</p>
	<img class="img-responsive" src="img/buoc3.jpg" alt="Themis"><br><br><br>
</div>



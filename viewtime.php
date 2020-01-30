<script>
  var countUpDate = <?php
  echo strtotime("$begin") ?> * 1000;
  var countDownDate = <?php
  echo strtotime("$date") ?> * 1000;
  var now = <?php echo time() ?> * 1000;
  countDownDate = countDownDate - 21600000;
  countUpDate = countUpDate - 21600000;
  // Update the count down every 1 second
  var x = setInterval(function() {
    now = now + 1000;
    // Find the distance between now an the count down date
    var distance = countUpDate - now;
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = "<b><p>Bài thi bắt đầu sau</p></b>"+ "<font color=red><b><p>"+days + "d " + hours + "h " +
    minutes + "m " + seconds + "s </p></b></font>";
    // If the count down is over, write some text
    if (distance < 0) {
      clearInterval(x);
      document.getElementById("demo").innerHTML = "Bắt đầu làm bài";
        var y = setInterval(function() {
          now = now + 1000;
          // Find the distance between now an the count down date
          var distance = countDownDate - now;
          // Time calculations for days, hours, minutes and seconds
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);
          // Output the result in an element with id="demo"
          document.getElementById("demo").innerHTML = "<b><p>Thời gian làm bài</p></b>"+ "<font color=red><b><p>"+days + "d " + hours + "h " +
          minutes + "m " + seconds + "s </p></b></font>";
          // If the count down is over, write some text
          if (distance < 0) {
            clearInterval(y);
            document.getElementById("demo").innerHTML = "<font color=red><b><p>Hết thời gian làm bài</p></b></font>";
            return;
          }

      }, 1000);
    }

  }, 1000);

</script>
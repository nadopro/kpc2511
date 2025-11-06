<div class="row" id="display">
    차트가 그려지는 부분
</div>

<script>
  var counter = 0;

  function ajaxMonitor()
  {
    counter ++;
    var param = "id=test&counter=" + counter;
    $.ajax ({
      url: "ajaxMonitor.php",
      type: "POST",
      cache: false,
      data: param,
      success: function(data)
      {
        //alert(data);
        $("#display").html(data);
      }
    });
  }

   ajaxMonitor();

    setInterval(function() {
       ajaxMonitor();
    }, 3000); // 3초 대기

</script>
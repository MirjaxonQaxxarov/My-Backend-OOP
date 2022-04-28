<?php
    session_start();
    
    if(empty($_SESSION['keyuser'])){
        $keyuser=rand(1000,9999);
        $_SESSION['keyuser']=$keyuser;
    }

    $_SESSION['_csrf'] = md5(time());
    $keyuser=$_SESSION['keyuser'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding Example</title>
</head>
<body>
    <form" id="form">
        <input type="text" name="<?=str_rot13("key1")?>" >
        <input type="text" name="<?=str_rot13("key2")?>" >
        <input type="file" name="<?=str_rot13("key3")?>" >
        <input type="hidden" name="_csrf" value="<?=$_SESSION['_csrf']?>" id="_csrf"> <br>
        <button id="submit">Submit</button>
    </form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    
  let submitBtn = document.getElementById('submit');
    submitBtn.addEventListener("click", function submit(e) {
      e.preventDefault();
      $.ajax({
        url: "core/edit?table=<?=str_rot13("table_name")?>&number=<?=$num_inputs*$keyuser?>",
        type: 'POST',
        processData: false,
        contentType: false,
        data: new FormData($("#form")[0]),
        success: function (data) {
          console.log(data);
            var obj = jQuery.parseJSON(data);
          if (obj.errors==0) {
            alert(obj.message);
          } else {
            $('#_csrf').val(obj._csrf);           
             alert(obj.message);
          }
        },
        error: function () {
            alert("Connection error");
        },
      });
    });

</script>
</html>
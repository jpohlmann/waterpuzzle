<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Soup Measurement Assistant</title>
<script src="./js/jquery.min.js"></script>
<script src="./js/app.js"></script>
<style type="text/css">
    @import url("./css/style.css");
</style>
</head>
<body>
<div id="title">Soup Measurement Assistant
</div>
<div id="bucketForm">
<form id="validateForm">
    <span class="bFormField">Target:<br /><input type="text" id="target" name="target"/></span>
    <span id="formBuckets">
    <span id="bucketSpan1" class="bFormField">Bucket 1:<br /><input type="text" id="bucket1" name="bucket1"/></span>
    <span id="bucketSpan2" class="bFormField">Bucket 2:<br /><input type="text" id="bucket2" name="bucket2"/></span>
    </span>
    <input type="hidden" id="bucketNum" name="bucketNum" value="2" />
    <input type="button" id="addBucket" value="Add" />
    <input type="button" id="removeBucket" value="Remove" />
    <input type="submit" value="Submit" />
    <span id="errorSpan"></span>
</form>
    <div id="instructions">Enter your target amount of water, and the size of the buckets you have.  Click submit to see the solution.</div>
    <div id="emailSection">
    <form id="emailForm">
        Email:<br /><input type="text" name="email" value="<?php echo array_key_exists('user_email', $_SESSION) ? $_SESSION['user_email'] : "";?>"><br />
        Api User:<br /><input type="text" name="api_user" value="<?php echo array_key_exists('api_user', $_SESSION) ? $_SESSION['api_user'] : "";?>"><br />
        Api Key:<br /><input type="password" name="api_key" value="<?php echo array_key_exists('api_key', $_SESSION) ? $_SESSION['api_key'] : "";?>"><br />
        <input type="hidden" name="solution" id="solutionList">
        <input type="submit" value="Send Solution">
    </form>
    </div>
    <div id="emailResponse">
    </div>
</div>
<div id="bucketContainers">
</div>
<script>
$("#addBucket").click(function() {
    var bucketNum = parseInt($("#bucketNum").val())+1;
    $("#bucketNum").val(bucketNum);
    var newBucket = '<span id="bucketSpan'+bucketNum
        +'" class="bFormField">Bucket '+bucketNum
        +': <input type="text" id="bucket'+bucketNum
        +'" name="bucket'+bucketNum+'"/></span>';
    $("#formBuckets").append(newBucket);
});
$("#removeBucket").click(function() {
    var bucketNum = parseInt($("#bucketNum").val());
    if (bucketNum > 2) {
        $("#bucketSpan"+bucketNum).remove();
        $("#bucketNum").val(bucketNum-1);
    } else {
        alert('We need at least 2 buckets.');
    }
});
$("#validateForm").submit(function() {
    clearResponses();
    var values = {};
    $.each($('#validateForm').serializeArray(), function(i, field) {
        values[field.name] = field.value;
    });
    $.ajax({type: "POST",
        url: './ajax/solve.php',
        data:values,
        success: function(response){
            $('#solutionList').val(response);
            var responseObj = $.parseJSON(response);
            if (responseObj.success == true) {
                $("#bucketContainers").empty();
                for (var x=1; x<=$("#bucketNum").val(); x++) {
                    initBucket(x, $("#bucket"+x).val());
                }
                displayResult(responseObj.solution);
            } else {
                alert(responseObj.error);
            }
        }
    });
    return false;
});
$("#emailForm").submit(function() {
    var values = {};
    $.each($('#emailForm').serializeArray(), function(i, field) {
        values[field.name] = field.value;
    });
    $.ajax({type: "POST",
        url: './ajax/email.php',
        data:values,
        success: function(response){
            var responseObj = $.parseJSON(response);
            if (responseObj.message == 'error') {
                alert(responseObj.errors[0]);
            } else {
                alert(responseObj.message);
                $("#emailSection").css("visibility","hidden");
            }
        }
      });
  return false;
});

</script>
</body>
</html>

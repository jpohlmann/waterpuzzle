<?php
$ch = curl_init("sendgrid.com/api/mail.send.json?"
    ."to=".$_POST['email']."&"
    ."from=jpohlmann%40gmail.com&"
    ."subject=Soup%20Solution&"
    ."text=".urlencode($_POST['solution'])."&"
    ."api_user=".$_POST['api_user']."&"
    ."api_key=".$_POST['api_key']
);
$_SESSION['user_email'] = $_POST['email'];
$_SESSION['api_user'] = $_POST['api_user'];
$_SESSION['api_key'] = $_POST['api_key'];
curl_exec($ch);
curl_close($ch);
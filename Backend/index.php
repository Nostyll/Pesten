<?php
if ($_SERVER['REMOTE_ADDR'] == "77.250.63.29"){

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/jquery.emojipicker.css">
    <script type="text/javascript" src="js/jquery.emojipicker.js"></script>

    <script src="http://cdn.jsdelivr.net/emojione/1.4.1/lib/js/emojione.min.js"></script>
    <!-- Emoji Data -->
    <link rel="stylesheet" type="text/css" href="css/jquery.emojipicker.a.css">
    <script type="text/javascript" src="js/jquery.emojipicker.a.js"></script>


    <link rel="stylesheet" href="http://cdn.jsdelivr.net/emojione/1.4.1/assets/css/emojione.min.css"/>

    <script type="text/javascript">


        $(document).ready(function(){
            $('.txt_message').emojiPicker({
                height: '300px',
                width: '450px'
            });
        });

        function convert(input) {
            var output = emojione.toShort(input);
           return output
        }

        function sendPushNotification(id){
            var formObj = {};
            var inputs = $('form#'+id).serializeArray();
            $.each(inputs, function (i, input) {
                formObj[input.name] = input.value;
            });

            var minput = convert(formObj.message);
            var data = {message:minput, regId: formObj.regId}

            $('form#'+id).unbind('submit');
            $.ajax({
                url: "send_message.php",
                type: 'GET',
                data: data,
                beforeSend: function() {

                },
                success: function(data, textStatus, xhr) {
                    $('.txt_message').val("");
                },
                error: function(xhr, textStatus, errorThrown) {

                }
            });
            return false;
        }
    </script>
    <style type="text/css">
        .container{
            width: 950px;
            margin: 0 auto;
            padding: 0;
        }
        h1{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 24px;
            color: #777;
        }
        div.clear{
            clear: both;
        }
        ul.devices{
            margin: 0;
            padding: 0;
        }
        ul.devices li{
            float: left;
            list-style: none;
            border: 1px solid #dedede;
            padding: 10px;
            margin: 0 15px 25px 0;
            border-radius: 3px;
            -webkit-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            -moz-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #555;
        }
        ul.devices li label, ul.devices li span{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-variant: normal;
            font-weight: bold;
            color: #393939;
            display: block;
            float: left;
        }
        ul.devices li label{
            height: 25px;
            width: 50px;
        }
        ul.devices li textarea{
            float: left;
            resize: none;
        }
        ul.devices li .send_btn{
            background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -webkit-linear-gradient(0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -moz-linear-gradient(center top, #0096FF, #005DFF);
            background: linear-gradient(#0096FF, #005DFF);
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
            border-radius: 3px;
            color: #fff;
        }
    </style>
</head>
<body>
<?php
include_once 'db_functions.php';
$db = new DB_Functions();
$users = $db->getAllUsers();

if ($users != false)
    $no_of_users = mysqli_num_rows($users);
else
    $no_of_users = 0;
?>
<div class="container">
    <h1>No of Devices Registered: <?php echo $no_of_users; ?></h1>
    <hr/>
    <ul class="devices">
        <?php
        if ($no_of_users > 0) {
            ?>
            <?php
            while ($row = mysqli_fetch_array($users)) {
                ?>
                <li>
                    <form id="<?php echo $row["id"] ?>" name="" method="post" onsubmit="return sendPushNotification('<?php echo $row["id"] ?>')">
                        <label>Name: </label> <span><?php echo $row["name"] ?></span>
                        <div class="clear"></div>
                        <div class="clear"></div>
                        <div class="send_container">
                            <textarea rows="5" name="message" cols="40" class="txt_message" placeholder="Type message here"></textarea>
                            <input type="hidden" name="regId" value="<?php echo $row["gcm_regid"] ?>"/>
                            <input type="submit" class="send_btn" value="Send" onclick=""/>
                        </div>
                    </form>
                </li>
            <?php }
        } else { ?>
            <li>
                No Users Registered Yet!
            </li>
        <?php } ?>
    </ul>
</div>


</body>
</html>
<?PHP
}else{
}
?>
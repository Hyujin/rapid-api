<?php
session_start();

function sendResult () {

$db_host = "localhost";
$db_user = "root";
$db_pass = "db-password";
$db_name = "db-name";

mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


if (!$con) { die('Error: ' . mysql_error()); }

$sql = "SELECT * from calls_temp";

$result = $con->query($sql) or die($con->error);

  
if ($result->num_rows > 0) {
    // output data of each row
   /* var_dump($result->fetch_assoc());*/

    while($row = $result->fetch_assoc())  {

        echo "number of rows: " . $result->num_rows;
        echo "<br>";


            $post_params = array(
               // Credentials
                'cc_name' => 'api-name-here',    //replace with cc_name of your account
                'cc_api_key' => 'api-key-here', //replace with api_key of your account
                
                // api method to call
                'method' => 'add_inbound_data',
                
                // Call data
                /*'call_id'                   => $row["call_id"],*/
                'call_date'                 => $row["call_date"],
                'talk_time'                 => $row["talk_time"],
                'customer_phone_number'     => $row["cx_phone"],
                'zip_code'                  => '12345',
                'country'                   => 'US',
                'account_id'                => $row["acct_id"],
                'answer_time'               => $row["answer_time"],
                'hold_time'                 => '0',
                'status_of_call'            => 'answered',
                'order_status'              => 'n/a',
                'agent_name'                => $row["agent_name"],
                'drop_time'                 => '0',
                'wrapup_time'               => '0',
                
            );

            var_dump($post_params);

            /*$ch = curl_init('https://api-url-here');*/ 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_params));
            $this_result = curl_exec($ch);

            echo "<pre>";
            $return = var_dump($this_result);
            print_r(json_decode($this_result, true));
            echo "</pre>";
            //header("Location: clear_temp.php");
    }

    if($this_result == false){
        echo "failed";
        header("Location: index.php?status=failed");
    }
    else
    {
        echo("Sent");
        header("Location: index.php?status=sent");
    }

  $_SESSION['$result'] = $return;
  //header("Location: clear_temp.php");
}
else
{
  echo "0 results";
  header("Location: index.php?status=err");
}




$con->close();


}

sendResult();

//$_SESSION['$result'] = $return;
//header("Location: index.php?status=sent");
//header("Location: clear_temp.php");
/*header("Location: test.php?success=Successfully sent");*/


?>

<!-- 


    'call_id' => '123',
    'call_date' => '2019-08-10 17:16:18',
    'talk_time' => '325',
    'customer_phone_number' => '1234567890',
    'zip_code' => '12345',
    'country' => 'US',
    'account_id' => '543',
    'answer_time' => '8',
    'hold_time' => '101',
    'status_of_call' => 'answered',
    'order_status' => 'sales',
    'agent_name' => 'John Connor',
    'drop_time' => 25,
    'wrapup_time' => 250,

     -->

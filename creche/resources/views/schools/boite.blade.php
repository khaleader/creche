<?php
session_start();


?>

@extends('layouts.default')
@section('content')

<?php

if(isset($_REQUEST['logout']))
{
unset($_SESSION['access_token']);
}

if(isset($_GET['code']))
{
$client->authenticate($_GET['code']);
$_SESSION['access_token'] = $client->getAccessToken();


//  $url = $client->createAuthUrl();
$url = 'http://laravel.dev:8000/schools/boite';
header('Location: '.filter_var($url,FILTER_VALIDATE_URL));
}



if(isset($_SESSION['access_token']))
{
$client->setAccessToken($_SESSION['access_token']);

try{
$pageToken = null;
$optParams = [];
$opt_param['pageToken'] = $pageToken;
$optParams['maxResults'] = 10; // Return Only 5 Messages
$optParams['labelIds'] = 'INBOX'; // Only show messages in Inbox
$optParams['q'] = 'category:primary';
$messages = $service->users_messages->listUsersMessages('me',$optParams);
     $page_token =  $messages->getNextPageToken();

  // $sizeEstimate = $messages->getResultSizeEstimate();

$loop = json_decode($_SESSION['access_token'],true);
        $access_token ='';
foreach($loop as $k => $v)
{
    if($k == 'access_token')
    {
        $k = $v;
        $access_token = $k;
       // echo $access_token;
        break;
    }


}

     //   echo $page_token.'<br>'.$sizeEstimate;
       echo "<a href='"."https://www.googleapis.com/gmail/v1/users/me/messages?maxResults=8&pageToken=$page_token&access_token=$access_token"."'>ok</a>";

        $labels = [];
$labelsResponse = $service->users_labels->listUsersLabels('me');
    echo 'Email : '.'<strong>'.$service->users->getProfile('me')->emailAddress.'</strong><br>';
    echo 'Total :' .$service->users->getProfile('me')->getMessagesTotal().'<br>';
    echo "Messages Non Lus :<strong>" .$service->users_labels->get('me','UNREAD')->getMessagesUnread()."</strong><br>";

    echo "Boite de Reception :".$service->users_labels->get('me','INBOX')->getMessagesTotal().'<br>';


if ($labelsResponse->getLabels()) {
    $labels = array_merge($labels, $labelsResponse->getLabels());
}

foreach ($labels as $label) {

  //  var_dump($labels);
 //print 'Label with ID: ' . $label->getId(). '<br/>';
  //  echo  'Messages Unread: ' . $label->. '<br/>';

}
    /*function to delete message*/
function deleteMessage($service, $userId, $messageId) {
    try {
        $service->users_messages->delete($userId, $messageId);
        print 'Message with ID: ' . $messageId . ' successfully deleted.';
    } catch (Exception $e) {
        print 'An error occurred: ' . $e->getMessage();
    }
}
      /*function to delete message*/




$list = $messages->getMessages();


//  $messageId = $list[1]->getId(); // Grab first Message
?>


    <?php
    foreach($list as $l) {
    //  echo '<pre>'.print_r($l).'</pre>';
    $optParamsGet = [];
    $optParamsGet['format'] = 'full'; // Display message in payload
    $message = $service->users_messages->get('me', $l->id, $optParamsGet);
    $messagePayload = $message->getPayload();
    $headers = $messagePayload->getHeaders();
    $all = [];
foreach($headers as $single) {
      //  var_dump($headers->getName());

            if ($single->getName() == 'Subject'){
                $message_subject = $single->getValue();
                $all['subject'] = $message_subject;
             //  echo html_entity_decode($message_subject);
            }
             elseif($single->getName() == 'Date')
             {
                 $message_date = $single->getValue();
                 $message_date = date('M jS Y h:i A', strtotime($message_date));
                 $all['date'] = $message_date;
                // echo '<i> '.$message_date .'</i>';
             }
            else if ($single->getName() == 'From') {

                $message_sender = $single->getValue();
                $all['from'] = $message_sender;
                //  echo  $message_sender = str_replace('"', '', $message_sender);
            }

        $parts = $messagePayload->getParts();
        $body =  $messagePayload->getBody();
        $rawData = $body->data;
        $sanitizedData = strtr($rawData, '-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if(!$decodedMessage)
        {
        $body = $parts[1]['body'];
        $rawData = $body->data;
        $sanitizedData = strtr($rawData,'-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
         $all['decoded'] = $decodedMessage;
        }else{
            $all['decoded'] = $decodedMessage;
        }

}
        ?>
   <div class="accordion" class="panel panel-title">

    <div class=" panel-heading">
        <div class="row">
        <div class="col-md-3">
        <strong style="display: inline-block;line-height: 56px;">{{ \Illuminate\Support\Str::limit($all['from'],15) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
        </div>
        <div class="col-md-6">
            <h3 style="display: inline-block;"> {{   $all['subject']  }} </h3> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="col-md-3">
        <i style="display: inline-block;line-height: 56px;">{{  $all['date'] }} </i>
            </div>
        </div>
        </div>
       <div class="panel-body">
         {!! $all['decoded'] !!}
       </div>
    </div>
     <?php


}

     /*if ($list->getNextPageToken() != null) {
         $pageToken = $list->getNextPageToken();
         $list = $gmail->users_messages->listUsersMessages('me', ['pageToken' => $pageToken, 'maxResults' => 10]);
     } else {
         break;
     }*/

}



catch(Google_Auth_Exception $google){
    $loginurl = $client->createAuthUrl();
    echo 'look like your access has been expired <a href="'.$loginurl.'">click here </a> to log In';
}
}else{
    $loginurl = $client->createAuthUrl();
    echo '<a href="'.$loginurl.'">cliquer ici</a> pour se connecter';
}
?>
@stop




@section('jquery')
    <script>


        $(document).ready(function(){
            $('.accordion').hide();
            $('.accordion').delay(2000).fadeIn();


            $('.accordion .panel-body').hide();
             $('.accordion > .panel-heading ').click(function(){
                $(this).next('div.panel-body').toggle();
            });
            var i = 0;
            $('body').on('click','.again',function(){
                  $(this).attr('valeur','khalid');
                alert($(this).attr('valeur'));


            });


        });
    </script>


 @stop





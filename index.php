<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
And Modified by Farzain - zFz ( Faraaz )
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'cXqMLYM/XPK2nRFQgHw2UnT3KJGWUSHbA17EdnirXd4u7m4pM+tOZBgfn4AjLQftVOMvdm7R03S/BJ6vvsQRWgXfoJSdMyEn5X2Ba0Kw9FLE32Wy8PHwi620IEelX74uMVNE8K8RVpYwOEB+ivBqDQdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = '82b2de988f39d3bbc2bc6b952f61339b';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Terima Kasih Stikernya kakak @'.$profil->displayName.'.'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'b6fa9668-64cc-426d-a582-6989923eeeb3'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Ngomong apaan si loh @'.$profil->displayName.' AUTIS Yah?.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf @'.$profil->displayName.' VNCBot Lagi pusing kak ngak bisa chat dulu.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);

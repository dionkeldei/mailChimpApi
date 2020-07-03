<?php
namespace dionkeldei\mailChimpApi;

class mailChimpApi{

	function __construct(){
    $this->list_id = <list-id>;
}


function insert($mail,$name,$lastname){
	   $url = 'https://<your-data-center>.api.mailchimp.com/3.0/lists/'.$this->list_id.'/members/';
       $username = 'qwerty';
       $password = '<your-api-key>';
       $jsonPost = [
          'email_address' => $mail,
          'status' => 'subscribed',
          'merge_fields' => [
                'FNAME' => $name,
                'LNAME' => $lastname
          ]
       ];
       
       $jsonPost = json_encode($jsonPost);

            $options = array(

            CURLOPT_CUSTOMREQUEST  =>"POST",        //set request type post or get
            CURLOPT_POST           =>true,        //set to GET
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_USERPWD        => $username . ":" . $password, // user : password
            CURLOPT_POSTFIELDS     => $jsonPost, //Message
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        
        $header['content'] = json_decode($header['content']);
        $header = (object) $header;
        if($header->content->status == 'subscribed'){
        	return true;
        }else{
        	return false;
        }
}


function exist($mail){
       $url = 'https://us1.api.mailchimp.com/3.0/lists/'.$this->list_id.'/members/'.md5($mail);
       $username = 'qwerty';
       $password = '<your-api-key>';
       $jsonPost = '{}';
       

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_USERPWD        => $username . ":" . $password, // user : password
            CURLOPT_POSTFIELDS     => $jsonPost, //Message
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        
        $header['content'] = json_decode($header['content']);
        $header = (object) $header;
        if($header->content->status == 404){
           $status = false;
           $message = '';
        }else{
           $status = true;
           $message = 'El e-mail ya esta en la lista';
        }
        $array = [
          'success' => $status,
          'Message' => $message
        ];

        return (object) $array;	
        
}

}

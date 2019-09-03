<?php

    // API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'ENTER_YOUR_API_ACCESS_KEY_HERE' );
    
    $registration_ids = array( $_GET['id'] );

    // prep the bundle
    $message = [   
	        'message' 	=> 'ENTER MESSAGE',
	        'title'		=> 'ENTER TITLE',
	        'subtitle'	=> 'ENTER SUBTITBLE',
	        'tickerText'	=> 'ENTER TICKER TEXT',
	        'vibrate'	=> 1,
	        'sound'		=> 1,
	        'largeIcon'	=> 'LARGE ICON HERE',
	        'smallIcon'	=> 'SMALL ICON HERE'
    ];
        
    $fields = [
	       'registration_ids'   => $registration_ids,
	       'data'   => $message
    ];
        
    $headers = [
	       'Authorization: key=' . API_ACCESS_KEY,
	       'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    
    $result = curl_exec($ch );
    
    curl_close( $ch );
    
    echo $result;

?>
<?
session_start();

/*Example Usage:
$uri = 'giv-car.uni-muenster.de:8080/stable/rest/users/website';

echo get_request($uri, true);
echo '<br>';
echo get_request('giv-car.uni-muenster.de:8080/stable/rest/users/', false);
*/
function get_request($uri, $isAuthRequired){
    $ch = curl_init($uri);
    if($isAuthRequired){
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER  => array('X-User: website', 'X-Token: website'),  //TODO: exchange with credentials from $_SESSION
            CURLOPT_RETURNTRANSFER  =>true,
            CURLOPT_VERBOSE     => 1
        ));
    }else{
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER  =>true,
            CURLOPT_VERBOSE     => 1
        ));
    }
    
    $out = curl_exec($ch);
    curl_close($ch);
    // echo response output
    return $out;
}

//Method to execute a post request
function post_request($url, $data, $referer='') {
 
    // Convert the data array into URL Parameters like a=b&foo=bar etc.
    $data = http_build_query($data);
 
    // parse the given URL
    $url = parse_url($url);
 
    if ($url['scheme'] != 'http') { 
        die('Error: Only HTTP request are supported !');
    }
 
    // extract host and path:
    $host = $url['host'];
    $path = $url['path'];
 
    // open a socket connection on port 80 - timeout: 30 sec
    $fp = fsockopen($host, 80, $errno, $errstr, 30);
 
    if ($fp){
 
        // send the request headers:
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
 
        if ($referer != '')
            fputs($fp, "Referer: $referer\r\n");
 
        //fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");  //todo: application/json (test!)
        fputs($fp, "Content-type: application/json\r\n");  //todo: application/json (test!)
        fputs($fp, "Content-length: ". strlen($data) ."\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);
 
        $result = ''; 
        while(!feof($fp)) {
            // receive the results of the request
            $result .= fgets($fp, 128);
        }
    }
    else { 
        return array(
            'status' => 'err', 
            'error' => "$errstr ($errno)"
        );
    }
 
    // close the socket connection:
    fclose($fp);
 
    // split the result header from the content
    $result = explode("\r\n\r\n", $result, 2);
 
    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';
 
    // return as structured array:
    return array(
        'status' => 'ok',
        'header' => $header,
        'content' => $content
    );
}




?>
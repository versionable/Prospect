<?php

namespace Versionable\Http\Adapter;

use Versionable\Http\Request\RequestInterface;
use Versionable\Http\Response\ResponseInterface;

class Socket extends AdapterAbstract implements AdapterInterface
{
  
  
  public function __construct() {
  }

  public function initalize() {
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_set_nonblock($sock);
    
    $this->setOption('Content-Type', 'application/x-www-form-urlencoded');
  }

  public function call(RequestInterface $request, ResponseInterface $response)
  {
    $this->initalize();

    $handle = \fsockopen($request->getUrl()->getHostname(), $request->getPort());
    
    if(!$handle) {
      throw new \RuntimeException("Erroring connecting");
    }
    
    $header = '';
    $resp = '';
    
    //echo $request. "+++++++++++++++\n";
    
    if ($handle) {
      fputs($handle, $request);
      do 
      { 
        $resp .= fgets ($handle, 4096); 
      } while (strpos ($resp, "\r\n\r\n") === false); 

      $headers = $this->parseHeader($resp);
      
      while (!feof($handle))
      {
        $resp .= fgets($handle, 128);
      }
      
      $body = $this->parseBody($headers, $resp);
    }
    
    fclose($handle);    
    
    $response->setCode($headers['status']);
    $response->setContent($body);

    return $response;
  }
  
  protected function parseHeader($response) {
    $part = preg_split ("/\r?\n/", $response, -1, PREG_SPLIT_NO_EMPTY); 

    $headers = array (); 

    for ($h = 0; $h < sizeof ($part); $h++) 
    { 
      if ($h != 0) 
      { 
        $pos = strpos ($part[$h], ':'); 
        $k = strtolower (str_replace (' ', '', substr ($part[$h], 0, $pos))); 
        $v = trim (substr ($part[$h], ($pos + 1))); 
      } 
      else 
      { 
        $k = 'status'; 
        $v = explode(' ', $part[$h]); 
        $v = $v[1]; 
      } 

      if ($k == 'set-cookie') 
      { 
        $headers['cookies'][] = $v; 
      } 
      elseif ($k == 'content-type') 
      { 
        if (($cs = strpos($v, ';')) !== false) 
        { 
          $headers[$k] = substr ($v, 0, $cs); 
        } 
        else 
        { 
          $headers[$k] = $v; 
        } 
      } 
      else 
      { 
        $headers[$k] = $v; 
      } 
    } 

    return $headers; 
  }
  protected function parseBody($headers, $response, $eol="'\r\n") {
    $tmp = $response; 
    $add = strlen($eol); 
    $response = ''; 
    
    
    if (isset ($headers['transfer-encoding']) && $headers['transfer-encoding'] == 'chunked') 
    { 
      do 
      { 
        $tmp = ltrim($tmp); 
        $pos = strpos($tmp, $eol); 
        $len = hexdec(substr ($tmp, 0, $pos)); 
        if (isset($headers['content-encoding'])) { 
          $response .= gzinflate(substr($tmp, ($pos + $add + 10), $len)); 
        } else { 
          $response .= substr($tmp, ($pos + $add), $len); 
        } 

        $tmp = substr($tmp,($len + $pos + $add)); 
        
        $check = trim($tmp); 
      } 
      while (!empty($check)); 
    } 
    elseif(isset($headers['content-encoding'])) 
    { 
      $response = gzinflate(substr($tmp, 10)); 
    } else { 
      $response = $tmp; 
    } 
    
    return substr($response, (strpos($response, "\r\n\r\n")+4));
  }
}

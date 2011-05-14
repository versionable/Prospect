<?php

namespace Versionable\Prospect\Adapter;

use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;
use Versionable\Prospect\Request\StringBuilder;

class Socket extends AdapterAbstract implements AdapterInterface
{
  protected $socket = null;

  public function initalize() {
    $this->setOption('Content-Type', 'application/x-www-form-urlencoded');
  }

  public function call(RequestInterface $request, ResponseInterface $response)
  {
    $handle = \fsockopen($request->getUrl()->getHostname(), $request->getPort(), $errno, $errstr, 30);
    
    if(!$handle)
    {
      throw new \RuntimeException('Error connecting to host: ' . $request->getUrl()->getHostname());
    }

    $string = '';

    if ($handle)
    {
      $builder = new StringBuilder();
      $builder->setRequest($request);
      fputs($handle, $builder->toString());

      while (false === feof($handle))
      {
        $string .= fgets($handle, 1024);
      }
    }

    $response->parse($string);
    
    fclose($handle);
    if ($response->getCode() == 301)
    {
      $response->getHeaders()->get('Location')->getValue();
      
      $request->getUrl()->setUrl($response->getHeaders()->get('Location')->getValue());
      $request->setCookies($response->getCookies());
      
      $class = \get_class($response);
      
      $response = $this->call($request, new $class());
    }

    return $response;
  }

  protected function parseHeader($response)
  {
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

  protected function parseBody($headers, $response, $eol="'\r\n")
  {
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
        if (isset($headers['content-encoding']))
        {
          $response .= gzinflate(substr($tmp, ($pos + $add + 10), $len));
        }
        else
        {
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

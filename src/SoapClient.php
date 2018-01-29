<?php

namespace heshanh\GoFax;

class SoapClient
{
    private $api_url;
    private $api_key;
    private $client;



    public function __construct($client, $token)
    {

        $this->setAPIKey($token);
        $this->setUrl($client);

        $this->client =  new \SoapClient($this->getUrl());

        return $this;
    }

    public function getFunctions()
    {
        return $this->client->__getFunctions();
    }

    public function getClient()
    {
       return $this->client;

    }

    public function setUrl($url)
    {
        $this->api_url = $url;
        return $this;
    }

    public function setAPIKey($key)
    {
        $this->api_key = $key;

        return $this;
    }

    public function getAPIKey()
    {
        return $this->api_key;
    }

    public function getUrl()
    {
        return $this->api_url;
    }

    function getParams($args = array())
    {
        $vars = new \stdClass();
        $vars->token = $this->getAPIKey();

        foreach ($args as $k => $v) {
            $vars->$k = $v;
        }

        return $vars;
    }

    public function getReceivedFaxes()
    {
        try
        {
            return $this->client->ReceivedFaxes($this->getParams())->ReceivedFaxesResult->ClientReceivedFax;
      /*      return $this->client->__soapCall('ReceivedFaxes',
                [
                    'token' => $this->getAPIKey()
                ]);*/
        }
        catch(\Exception $e)
        {
            throw new Exceptions\UnexpectedException((string) $e->getMessage());
        }
    }

    public function getFaxDataFromId($id)
    {
        $args['receiveFaxID'] = $id;

        try
        {
//            return $this->client->ReceiveFaxData($this->soapClient->getArgs($args))->ReceiveFaxDataResult;
            return $this->client->__soapCall('ReceiveFaxData');
        }
        catch(\Exception $e)
        {
            throw new Exceptions\UnexpectedException((string) $e->getResponse()->getBody(), $e->getResponse()->getStatusCode());
        }
    }


}
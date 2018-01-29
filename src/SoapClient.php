<?php

namespace heshanh\GoFax;

class SoapClient
{
    private $api_url;
    private $api_key;
    private $client;


    /**
     * SoapClient constructor.
     * @param $client
     * @param $token
     */
    public function __construct($client, $token)
    {
        $this->setAPIKey($token);
        $this->setUrl($client);

        $this->client = new \SoapClient($this->getUrl());

        return $this;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return $this->client->__getFunctions();
    }

    /**
     * @return \SoapClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->api_url = $url;
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function setAPIKey($key)
    {
        $this->api_key = $key;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAPIKey()
    {
        return $this->api_key;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->api_url;
    }

    /**
     * @param array $args
     * @return \stdClass
     */
    function getParams($args = array())
    {
        $vars = new \stdClass();
        $vars->token = $this->getAPIKey();

        foreach ($args as $k => $v) {
            $vars->$k = $v;
        }

        return $vars;
    }

    /**
     * @return mixed
     * @throws Exceptions\UnexpectedException
     */
    public function getReceivedFaxes()
    {
        try {
            return $this->client->ReceivedFaxes($this->getParams())->ReceivedFaxesResult->ClientReceivedFax;
        } catch (\Exception $e) {
            throw new Exceptions\UnexpectedException((string)$e->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exceptions\UnexpectedException
     */
    public function getFaxDataFromId($id)
    {
        $args['receiveFaxID'] = $id;

        try {
            return $this->client->ReceiveFaxData($this->getParams($args))->ReceiveFaxDataResult;
        } catch (\Exception $e) {
            throw new Exceptions\UnexpectedException((string)$e->getMessage());
        }
    }


}
<?php
namespace common\components;

class Request extends \yii\base\Object
{

	private $_method = 'GET';

	private $_data;

	private $_url;

	private $_header = '';

	public function setMethod($method)
	{
		$this->_method = strtoupper($method);
	}

	public function setUrl($url)
	{
		$this->_url = $url;
		return $this;
	}

	public function setHeader($header)
	{
		$this->_header = (array) $header;
	}

	public function setData($data = [])
	{
		$this->_data = $data;
	}

	public function send()
	{
		$ret = '';
		switch ($this->_method) {
			case 'GET':
				$ret = $this->sendGet();
				break;
			case 'POST':
				$ret = $this->sendPost();
				break;
		}

		return $ret;
	}

	private function sendGet()
	{
	    $content = is_array($this->_data) ? http_build_query($this->_data) : $this->_data;

	    $ch = curl_init();
	    $url = $this->_url;
	    $url .= false === strpos($this->_url, '?') ? '?'.$content : $content;

	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    if (!empty($this->_header)) {
	    	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_header);
	    }

	    $ret = curl_exec($ch);

	    log_info("curl-get:$url, ret:".json_encode($ret));

	    return $ret;
	}

	private function sendPost()
	{
		$content = is_array($this->_data) ? http_build_query($this->_data) : $this->_data;
		$url = $this->_url;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (!empty($this->_header)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_header);
		}
		$ret = curl_exec($ch);
	    log_info("curl-get:$url, data:$content, ret:".json_encode($ret));

		return $ret;
	}
}

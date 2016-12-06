<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Curl Class
 *
 *
 * @package        	PHP, CodeIgniter
 * @subpackage    	Class, Libraries
 * @category    	Class, Libraries
 * @author        	Achmad Rozikin
 */
class Curl {

	
	/**
	* Declare the private variable for curl option
	*/
	private $url;
	private $postdata;
	private $getdata;
	private $userAgent;
	private $referer;
	private $additionalOpt;

	/**
	* Defining the default value of variable
	*/
	public function __construct(){
		$this->clear();
	}
	/**
	* Defining all the default data for all the variable
	*/
	public function clear(){
		$this->url = '';
		$this->postdata = [];
		$this->getdata = [];
		$this->userAgent = '';
		$this->referer = '';
		$this->additionalOpt = [];
	}
	/**
	*
	* MAIN METHOD OF SET
	*
	*/
	/**
	* Set the additional option of curl
	*/
	public function setOption($opt, $value = 0){
		if(is_array($opt)){
			foreach($opt as $dataName => $dataValue){
				$this->additionalOpt[$dataName] = $dataValue;
			}
		}else{
			$this->additionalOpt[$opt] = $value;
		}
	}
	/**
	* Set url of curl
	*/
	public function setUrl($urlInput){
		$this->url = $urlInput;
	}
	/**
	* Set useragentname of curl
	*/
	public function setUserAgent($userAgentInput){
        $this->userAgent= $useragentInput;
    }
    /**
    * Set referer of curl
    */
    public function setReferer($refererInput){
        $this->referer = $refererInput;
	}
	/**
	* Set postdata of curl to send
	*/
	public function setPostData($name, $value = 0){
		if(is_array($name)){
			foreach($name as $dataName => $dataValue):
				$this->postdata[$dataName] = $dataValue;
			endforeach;
		}else{
			$this->postdata[$name] = $value;
		}
	}
	/**
	* Set getdata of curl to send
	*/
	public function setGetData($name, $value = 0){
		if(is_array($name)){
			foreach($name as $dataName => $dataValue):
				$this->getdata[$dataName] = $dataValue;
			endforeach;
		}else{
			$this->getdata[$name] = $value;
		}
	}
	
	/**
	*
	* MAIN METHOD OF GET
	*
	*/
	/**
	* Get the response of curl from given option
	*/
	public function getResponse(){		
		$curl = curl_init();
		curl_setopt_array($curl, $this->getOptionValue());
		$response_curl = curl_exec($curl);
		if($response_curl === false){
			$response_curl = $this->curlShowError($curl);
		}
		curl_close($curl);
		return $response_curl;
	}
	
	/**
	*
	* PRIVATE METHOD TO HANDLE THE OPTIONS VALUES
	*
	*/
	/**
	* Get the curl option value
	*/
	private function getOptionValue(){		
		$options = $this->additionalOpt;
		
		$options[CURLOPT_RETURNTRANSFER] = 1;
		$options[CURLOPT_URL] = $this->url.$this->collectGetData();
		
		if(!empty($this->userAgent)){
			$options[CURLOPT_USERAGENT] = $this->userAgent;
		}
        if(!empty($this->referer)){
            $options[CURLOPT_REFERER] = $this->referer;
        }

		$postData = $this->collectPostData();
		if(!empty($postData)){
			$options[CURLOPT_POST] = 1;
			$options[CURLOPT_POSTFIELDS] = $postData;
		}
		
		return $options;
	}
	/**
	* Get the post data
	*/
	private function collectPostData(){
		$return_data = '';
		if(!empty($this->postdata)){
			$return_data = $this->postdata;
		}
		return $return_data;
	}
	/**
	* Get the get data
	*/
	private function collectGetData(){
		$return_data = '';
		if(!empty($this->getdata)){
			$stringGet = '?';
			$stringGet .= http_build_query($this->getdata);
			$return_data = $stringGet;
		}
		return $return_data;
	}
	/**
	* Get the curl error
	*/
	private function curlShowError($curl){
		return 'Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl);
	}
}
?>


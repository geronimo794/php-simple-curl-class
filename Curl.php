<?php
/**
 * CodeIgniter Curl Class
 *
 *
 * @package        	PHP, Phalcon
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
    private $body;
    private $headerdata;
	private $userAgent;
	private $referer;
    private $additionalOpt;
    private $requse_method;
    private $multi_init_curl;

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
        $this->body = null;
        $this->headerdata = [];
		$this->userAgent = '';
		$this->referer = '';
        $this->additionalOpt = [];
        $this->request_method = '';
        $this->multi_init_curl = null;
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
     * Set header data of curl request
     */
    public function setHeaderData($name, $value = 0){
		if(is_array($name)){
			foreach($name as $dataName => $dataValue):
				$this->headerdata[] = $dataName.': '.$dataValue ;
			endforeach;
		}else{
            $this->headerdata[] = $name.': '.$value ;
		}
    }
    /**
     * Set the body data without fields array
     */
    public function setBody($inp_body){
        $this->body = $inp_body;
    }
    /**
     * Set the request method of the curl request
     */
    public function setRequestMethod($inp_method){
        $this->request_method = $inp_method;
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
     * The the instansce of the curl to make it as 
     */
	public function getInstance(){
        $curl = curl_init();
		curl_setopt_array($curl, $this->getOptionValue());
        return $curl;
    }
    /**
     * Curl multi init add curl instance
     */
    public function getResponseMultiInit($inp_curl = []){
        $multi_init_curl = curl_multi_init();
        foreach($inp_curl as $per_curl){
            curl_multi_add_handle($multi_init_curl, $per_curl);
        }
        $active = null;
        // Execute the handles
        do{
            $mrc = curl_multi_exec($multi_init_curl, $active);
        }while($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($multi_init_curl) == -1) {
                usleep(100);
            }
            do {
                $mrc = curl_multi_exec($multi_init_curl, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
        // Close the handles
        foreach($inp_curl as $per_curl){
            curl_multi_remove_handle($multi_init_curl, $per_curl);
        }
        curl_multi_close($multi_init_curl);
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
        if(!empty($this->headerdata)){
            $options[CURLOPT_HTTPHEADER] = $this->headerdata;           
        }
		$postData = $this->collectPostData();
		if(!empty($postData)){
			$options[CURLOPT_POST] = 1;
			$options[CURLOPT_POSTFIELDS] = $postData;
        }
        if(!empty($this->body)){
            $options[CURLOPT_POSTFIELDS] = $this->body;
        }
        if(!empty($this->request_method)){
            $options[CURLOPT_CUSTOMREQUEST] = $this->request_method;
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


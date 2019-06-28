<?php
namespace PaymentBundle\Aide;
 use Symfony\Component\Config\Definition\Exception\Exception;

class Stripe 
{





private $api_key;

 


	public function __construct($api_key)
	{
		$this->api_key=$api_key;
	}


	public function api($endpoint,$data)
	{
		$ch=curl_init();





	curl_setopt_array($ch,[
      CURLOPT_URL=>'https://api.stripe.com/v1/'.$endpoint,
     CURLOPT_RETURNTRANSFER=>true,
      CURLOPT_USERPWD=>$this->api_key,
     CURLOPT_HTTPAUTH=>CURLAUTH_BASIC,
      CURLOPT_POSTFIELDS=>http_build_query($data)
	]);
	$response=json_decode(curl_exec($ch));
	curl_close($ch);
    if(property_exists($response, 'error'))
    {
    	throw new Exception($response->error->message);
    	
    }




	return $response;
	}
}














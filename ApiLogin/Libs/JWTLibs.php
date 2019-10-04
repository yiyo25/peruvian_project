<?php 


	use \Firebase\JWT\JWT;
	class JWTLibs
	{
		
		const SECRECT_KEY = 'a%bsd&165aWEpom?sQPW#@4=!@*+,mXqzQ';
	    public static $ENCRYPT_TYPE = array('HS256');
	    const AUD = null;

	    public static function SignIn($data) {
	        $time = time();
	        $token = array(
	            'exp' => $time + (60*60),
	            'aud' => self::Aud(),
	            'data' => $data
	        );
	        return JWT::encode($token,self::SECRECT_KEY);
	    }

	    

	    public static function Check($token) {
	        if(empty($token)) {
	            throw new Exception("Invalid token supplied.");
	        }
	        $decode = JWT::decode(
	            $token,
	            self::SECRECT_KEY,
	            self::$ENCRYPT_TYPE
	        );

	        if($decode->aud !== self::Aud()) {
	            throw new Exception("Invalid user logged in.");
	        }
	    }

	    public static function GetData($token) {
	        if(!$token || empty($token)) return NULL;
	        return JWT::decode(
	            $token,
	            self::SECRECT_KEY,
	            self::$ENCRYPT_TYPE
	        )->data;
	    }

	    private static function Aud() {
	        $aud = '';
	        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	            $aud = $_SERVER['HTTP_CLIENT_IP'];
	        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
	        } else {
	            $aud = $_SERVER['REMOTE_ADDR'];
	        }

	        $aud .= @$_SERVER['HTTP_USER_AGENT'];
	        $aud .= gethostname();

	        return sha1($aud);
	    }
	}




 ?>
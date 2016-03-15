<?php
class Password {
	private static function getHash($user) {
		//some code to lookup user in database
		//make sure you escape $user
		
		
		//for testing purposes return hash that matches 	12345678
		return '$2y$10$sldSbwqEeyMzcE0wYeCeT.FHZtrcELP/IY4DTU4ePz3.sUv7cEIYu';	//return users hash or false if not in database
	}
	private static function setHash($user,$hash) {
		
		//testing purposes only
		echo $user . " hash is: " .$hash;
		
		
		
		//some routine to store the hash in the database
		//make sure you escape $user
		return true;  //you can add code to return false if it fails
	}
	
	private static function validateBadHash($user,$pass) {
		return false;	//delete this line if you where using a bad hashing algorithm
	
		/*				MD5
		$databaseHash=self::getHash($user);
		return ($databaseHash==md5($pass));
		*/
		
		/*				SHA1
		$databaseHash=self::getHash($user);
		return ($databaseHash==sha1($pass));
		*/	
		
		/*				BASE64		
			$databaseHash=self::getHash($user);
			return ($databaseHash==base64_encode($pass));
			
			//your site is really bad.  forget using this function and use the bellow instead.
			//you need to create the array $allUsers
			//foreach ($allUsers as $user) {
			//	$pass=base64_decode(self::getHash($user);
			//	self::savePass($user,$pass);
			//}
		*/
	}
	
	
	
	
	public static function checkPass($user,$pass) {
		//remove extra white space from username and password to prevent user agrovation from accidently including a space before or after
		$user=trim($user);
		$pass=trim($pass);
		//get users stored hash
		$hash=self::getHash($user);
		
		//see if possible bad hash
		if (substr($hash,0,1)!='$') {
			if (self::validateBadHash($user,$pass)) {
				//authenticated under old bad hash.  rehash to make users password safe
				self::savePass($user,$pass);
				return true;
			}
		}
		
		//check if password matches
		if (!password_verify($pass,$hash)) {
			return false;
		}
				
		//check if old hash method and if so rehash
		if (password_needs_rehash($hash,PASSWORD_DEFAULT)) {
			self::savePass($user,$pass);
		}
		
		//user has been authenticated
		return true;		
	}
	
	public static function savePass($user,$pass) {
		//remove extra white space from username and password to prevent user agrovation from accidently including a space before or after
		$user=trim($user);
		$pass=trim($pass);
		
		//get hash of password
		$hash=password_hash($pass,PASSWORD_DEFAULT);
		
		//store results
		return self::setHash($user,$hash);
	}
}
//        Usages
echo "Is password 12345678 Correct:" . (Password::checkPass('','12345678')?'true':'false') . '<br/>';
Password::savePass('test','12345678');	//notice hash will be different each time.  this is a security feature.

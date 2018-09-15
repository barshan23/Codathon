<?php 
class User{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isloggedIn;
	
	public function __construct($user=null){
		$this-> _db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		
		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				if($this->find($user)){
					$this->_isloggedIn = true;
				}
			}
		}
		else {
			$this->find($user);
				
		}
		
	}
	
	////////////////////////////////////////////////////////
	public function getScore(){

		return $this->data()->score;
	}

	public function setScore($score){
		if(!$this->_db->update('users',$this->data()->id,array('score'=> $score))){
			return false;
		}
		$sql = "UPDATE `leaderboard` SET `score`=".$score." WHERE `unique_id` = '".$this->data()->unique_id."'";
		$error = $this->_db->query($sql, array());
		$this->_db->setAll('leaderboard');
		return true;
	}

	public function getSolved(){

		return $this->data()->solved;
	}

	public function setSolved($solved){
		if(!$this->_db->update('users',$this->data()->id,array('solved'=> $solved))){
			return false;
		}
	}

	public function setTime(){
		$time = time();
		if(!$this->_db->update('users',$this->data()->id,array('time'=> $time))){
			return false;
		}
	}

	public function getTimeRemaining(){
		return ($this->data()->time + 5940 - time());
	}

	public function setStarted(){
		if(!$this->_db->update('users',$this->data()->id,array('started'=> 1))){
			return false;
		}
		return true;
	}

	//////////////////////////////////////////////////////


	public function update($fields = array(),$id = null){
		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		
		if(!$this->_db->update('users', $id, $fields)){
			throw new Exception("There was a problem updating details.");
		}
	}
	
	public function create($fields=array()){
		if(!$this->_db-> insert('users',$fields)){
			throw new Exception('There was a problem creating an account.');
		}
		// Add the user to the leaderboard table also
		if(!$this->_db->insert('leaderboard', array('unique_id' => $fields['unique_id'],
			'name' => $fields['name'],))){
			throw new Exception("There was a problem creating account");
		}
	}
	
	public function find($user = null){
		if(isset($user)){
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field,'=',$user));
			if($data->count()){							//if any row has the value then return true
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
			
	}

	////////////////////////////////////////////////
	public function findMail($mail){
		if(isset($mail)){
			$data = $this->_db->get('users',array('email','=',$mail));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	///////////////////////////////////////////
		
	public function login($email = null ,$password = null,$remember = false){	
		if(!$email && !$password && $this->exists()){
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->findMail($email);
			if($user){
				if(($this->data()->password === Hash::make($password,$this->data()->salt))&&($this->data()->email === $email)){
					Session::put($this->_sessionName,$this->_data->id);
					
					if($remember){
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
						
						if(!$hashCheck->count()){
							$this->_db->insert('users_session',array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}
						
						Cookie::put($this->_cookieName, $hash,Config::get('remember/cookie_expiry'));
					}
					
					return true;
				}
			}
		}
		return false;
	}
	
/*		
	public function login($username = null, $password = null,$remember = false){	
		if(!$username && !$password && $this->exists()){
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->find($username);
			if($user){
				if($this->data()->password === Hash::make($password,$this->data()->salt)){
					Session::put($this->_sessionName,$this->_data->id);
					
					if($remember){
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
						
						if(!$hashCheck->count()){
							$this->_db->insert('users_session',array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}
						
						Cookie::put($this->_cookieName, $hash,Config::get('remember/cookie_expiry'));
					}
					
					return true;
				}
			}
		}
		
		return false;
	}
*/

	
	public function hasPermission($key){
		$group = $this->_db->get('groups', array('id', '=' , $this->data()->groups));
		
		if($group->count()){
			$permissions = json_decode($group->first()->permission,true);//this decodes the json object and return true
			
			if($permissions[$key]==true){
				return true;
			}
		}
		return false;
		
	}
	
	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	//this is added by Avishek for securing profile viewing
	public function checkid($id){
		$uniqueid = $this->data()->unique_id;
		if($id == $uniqueid){
			return true;
		} else {
			return false;
		}
	}
	
	public function logout(){
		
		$this->_db->delete('users_session', array('user_id','=', $this->data()->id));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	
	public function data(){
		return $this->_data;
	}
	
	public function isLoggedIn(){
		return $this->_isloggedIn;
	}
}
?>
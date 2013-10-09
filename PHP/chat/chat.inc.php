<?php

	class Chat
	{
		var $room;
		var $filename;
		
		function Chat($roomName="",$maxuser=2)
		{
			$this->filename=$roomName;
			if(empty($roomName))
			{
				$this->filename=time();
				$roomName=$this->filename;
			}
			$this->addRoom($roomName,$maxuser);
		}
		
		function putMessage($msg,$userName="")
		{
			$this->room->putMessage($msg,$userName);
			$this->_savechat();
		}
		
		function getMessage($fromline=0,$asArray=false)
		{
			return $this->room->getMessage($fromline,$asArray);
		}
		
		function getMessageForUser($userName,$asArray=false)
		{
			$message = $this->room->getMessageForUser($userName,$asArray);	
			$this->_savechat();
			return $message; 
		}
		
		function getRoomName()
		{
			return $this->filename;
		}
		
		function addRoom($roomName,$maxuser=2)
		{
			if(!$this->_is_room_exists($roomName))
			{
				$this->room=new ChatRoom($roomName,$maxuser);
				$this->_savechat();
			}
			else
				$this->room=$this->_getroom();
		}
		
		function addUser($userName)
		{
			if($ret=$this->room->addUser($userName)===false)
				return false;
			$this->_savechat();
		}
		
		function delUser($userName)
		{
			$this->room->delUser($userName);
			if($this->room->isRoomEmpty())
				$this->_removechat();
			else
				$this->_savechat();
		}
		
		function getUsers()
		{
			return $this->room->getUsers();
		}
		
		function close()
		{
			unset($this);
		}
		
		/* functions for internal uses */ 
		
		function _savechat()
		{
			$fp=@fopen($this->filename,'w');
			@fwrite($fp,serialize($this->room));
			@fclose($fp);
		}
		
		function _getroom()
		{
			return unserialize(file_get_contents($this->filename));
		}
		
		function _is_room_exists($room)
		{
			return is_file($room);
		}
		
		function _removechat()
		{
			@unlink($this->filename);
		}
	}
?>

<?php
	
	class ChatRoom
	{
		var $name;
		var $maxuser;
		var $users;
		var $error;
		var $message;
		var $maxline;
		var $remlines;
		var $onefromip;
		var $mymessages;
		
		function ChatRoom($name="",$maxuser=2)
		{
			$this->name=$name;
			$this->maxuser=$maxuser;
			$this->maxline=2000;
			$this->remlines=1;
			$this->onefromip=false;
		}
		
		function OnlyOneUserFromIP($onefromip=false)
		{
			$this->onefromip=$onefromip;
		}
		
		function expandRoom($len)
		{
			$this->maxuser+=$len;
		}

		function shrinkRoom($len)
		{
			$this->maxuser-=$len;
		}
		
		function setWelcomeMessage($msg)
		{
			$this->mymessages['welcome']=$msg;
		}

		function setByeMessage($msg)
		{
			$this->mymessages['bye']=$msg;
		}

		function setMaxUser($maxuser)
		{
			$this->maxuser=$maxuser;
		}
		
		function setMaxMessageLine($lines=2000)
		{
			$this->maxline=$lines;
		}
		
		function setRemLine($lines=1)
		{
			$this->remlines=$lines;
		}
		
		function addUser($userName)
		{
			if(empty($userName))
			{
				$this->error="Can't add user without having name!";
				return false;
			}
			elseif(count($this->users) == $this->maxuser && $this->maxuser>0)
			{
				$this->error="Unable to add more users. Room have its maximum users.";
				return false;
			}
			elseif(@array_key_exists($userName,$this->users))
			{
				$this->error=$userName." is already in room.";
				return false;
			}
			elseif($this->onefromip)
			{
				$user=$this->getUserByIP($_SERVER['REMOTE_ADDR']);
				if($user!=false)
				{
					$this->error=$user." is already in room from this IP address.";
					return false;
				}
			}
			$user=new User($userName);
			$this->users[$userName]=$user;
			if(!empty($this->mymessages['welcome']))
				$this->putMessage($this->mymessages['welcome']);
		}
				
		function delUser($userName)
		{
			$user=$this->users[$userName];
			$idx=@array_search($userName,@array_keys($this->users));
			@array_splice($this->users,$idx,1);
			if(!empty($this->mymessages['bye']))
				$this->putMessage($this->mymessages['bye']);
			 
		}
		
		function isRoomEmpty()
		{
			return empty($this->users);
		}

		function putMessage($msg,$userName="")
		{
			if(count($this->message) > $this->maxline && $this->maxline>0)
			{
				for($i=1;$i<=$this->remlines;$i++)
				{
					@array_shift($this->message);
				}
				foreach($this->users as $user)
				{
					$user->lastline-=$this->remlines;
					if($user->lastline<0)
						$user->lastline=0;
				}
			}
			
			if(!empty($userName) && !empty($msg))
				$this->message[]="<b>".$userName.": </b>".$msg;
			elseif(!empty($msg))
				$this->message[]=$msg;
			
			/*$user=&$this->users[$userName];
			$user->lastline++;*/
		}
		
		function getMessageForUser($userName,$asArray=false)
		{
			$user=&$this->users[$userName];
			$messages=$this->getMessage($user->lastline,$asArray);
 			$user->lastline=count($this->message);
 			return $messages; 
		}
		
		function getMessage($fromline=0,$asArray=false)
		{
			$return="";
			for($i=$fromline;$i<count($this->message);$i++)
			{
				if($asArray)
					$return[]=$this->message[$i];
				else
					$return.=$this->message[$i]."<br>";
			}
			return $return;
		}
		
		function getError()
		{
			return $this->error;
		}
		
		function resetRoom()
		{
			$this->makeEmpty();	
			$this->name="";
			$this->maxuser=2;
			$this->maxline=2000;
			$this->remlines=1;
		}
		
		function setRoomName($name)
		{
			$this->name=name;
		}
		
		function getRoomName()
		{
			return $this->name;
		}
		
		function getUsers($asArray=false)
		{
			if($asArray)
				return @array_keys($this->users);
			else
				return @implode("<br>",@array_keys($this->users));
		}
		
		function getUser($userName)
		{
			return $this->users[$userName];
		}
		
		function getUserByIP($ip,$onlyName=false)
		{
			if(!is_array($this->users))
			{
				$this->error="No user is exists into room.";
				return false;
			}
			
			foreach($this->users as $user)
			{
				if($user->ip==$ip)
				{
					if($onlyName)
						return $user->name;
					else
						return $user;
				}
			}
			
			$this->error="No user found with this IP (".$ip.")";
			return false;
		}
		
		function makeEmpty()
		{
			unset($this->users);
			unset($this->message);
		}
	}
?>

<?php
	
	/* defining the diffrent status */
	
	define("OFFLINE",0); 
	define("ONLINE",1); 

	class User
	{
		var $name;
		var $ip;
		var $status;
		var $lastline;
		
		function User($user='')
		{
			$this->setUser($user);
			$this->ip = $_SERVER['REMOTE_ADDR'];
			$this->status = ONLINE;
			$this->lastline=0;
		}
		
		function setUser($name)
		{
			$this->name=$name;	
		} 
		
		function setStatus($status)
		{
			$this->status=$status;
		}
		
		function getUser()
		{
			return $this->name;
		}
		
		function getStatus()
		{
			return $this->status;
		}
		
		function getIP()
		{
			return $this->ip;
		}
	}
?>
// JavaScript Document
// class: most_little_chat 
// Create a little Chat without mySQL or files
// Dixán Santiesteban Feria, CUBA
// email: dixan_sant@yahoo.es

most_little_chat = function(ouser,blogin,ouserlist,omessages,ob_themess,ob_send2){
	
	var onwrite = omessages;
	var ob_themess1=ob_themess;
	var userlist1=ouserlist;
	var messages1=omessages;
	var user1=ouser;
	var self=this;
	var ping=null;
	
	$(document.body).append('<input type="hidden" name="user" id="user"><input type="hidden" name="last" id="last">');
	
	
	$(ob_send2).click(function(){
		self.clicksend();						   
	})
	
	$(blogin).click(function(){
		self.send({	action	: 'login',
					user	: $(user1).val()
					});							 
	})
	
	
	this.send = function (data){
		$.post('mostlc.php',data, function(recdata){
			eval(recdata);
		})
	}
	

	
	this.start = function (selfnick,userslist){
		
		$(ob_themess1).val('').attr('disabled',false).focus();
		var str='';
		$('#user').val(selfnick);
		var users=userslist.split(',');
		for(var t=0; t<users.length; ++t){
			str+='<a id="u_'+users[t]+'"><b>&#9679;</b> '; 
			str+=users[t]+"</a>";
		}
		$(userlist1).html(str);
		ping=setTimeout(function(){self.sendmessage()},5000);
	
	}
	
	this.clicksend = function (){
		var msg=$.trim($(ob_themess1).val());
		if (msg!='') this.sendmessage(msg);
		$(ob_themess1).val('').focus();
		
	}
	
	this.sendmessage = function (msg){
		clearTimeout(ping);
		this.send({	action	: 'ping',
				user	: $('#user').val(),
				last	: $('#last').val(),
				message	: msg
			});
		ping=setTimeout(function(){self.sendmessage()},5000);	
	}
	
	this.enter = function (user){
		this.writemess('*** entra: <b>'+user+'</b>');
		var str='<a id="u_'+user+'"><b>&#9679;</b> '; 
		str+=user+"</a>";
		$(userlist1).append(str);
	}
	
	this.remove = function (user){
		$('#u_'+user).remove();
		this.writemess('*** sale: <b>'+user+'</b>');
	}
	
	this.writemess = function (txt){
		$(onwrite).children().first().before("<p>"+txt+"</p>");
	}
	
	this.message = function (user,message){
		this.writemess('<b>'+user+': </b>'+message);
	}

}

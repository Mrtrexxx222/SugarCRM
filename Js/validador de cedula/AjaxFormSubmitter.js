/**
 * @classDescription the class will get the field names and values 
 * under any html element and send it asynchronously to a specfic url
 * Documentation : http://mohammed-magdy.blogspot.com/2010/10/ajaxformsubmitter.html
 * Created By Mohammed Diab @2010
 * @param {string} ContainerID
 */
function AjaxFormSubmitter (ContainerID)
{

	/**
	 * Container ID , can be form , 
	 * div , or any html element that has child nodes
	 * @type string
	 * @private
	 */
	var _strContainerID; 
	
	/**
	 * POST or GET
	 * @type string"POST|GET"
	 * @private
	 */
	var _strMethod;
	 
	/**
	 * a url to the page that is supposed to handle the data 
	 * @type string
	 * @private
	 */
	var _strURL; 
	
	/**
	 * Object that will contain all the field names and values 
	 * @type object
	 * @private
	 */
	var _objData;
	
	
	/**
	 * After the Ajax request completed  successfully , 
	 * this function will be called 
	 * @type function 
	 * @private
	 */
	var _fnOnSuccess=null;
	
	
	/**
	 * If the Ajax Request failed , this function will be called 
	 * @type function 
	 * @private
	 */
	var _fnOnFailure=null; 
	
	/**
	 * this function will be called when the Ajax is 
	 */
	var _fnOnLoad=null; 

	

	this.SetContainerID = function (ContainerID)
	{
		_strContainerID=ContainerID; 
	} 
	
	this.GetContainerID = function () 
	{
		return _strContainerID; 
	}	 
	
	this.SetMethod = function (Method)
	{
		switch (Method.toUpperCase())
		{
			case "POST": 
				_strMethod="POST"; 
				break; 
			case "GET":
				_strMethod="GET"; 
				break; 
			default:
				_strMethod="POST"; 
		}
	}
	
	this.GetMethod = function () 
	{
		return _strMethod; 
	}
	
	this.SetURL = function (URL)
	{
		_strURL=URL ;
	}
	
	this.GetURL = function () 
	{
		return _strURL ; 
	}
	
	this.SetData = function(Data)
	{
		_objData=Data;
	}
	
	this.GetData = function () 
	{
		return _objData; 
	}
	
	this.SetOnSuccess = function (OnSuccessFunction)
	{
		_fnOnSuccess=OnSuccessFunction; 
	}
	
	this.CallOnSuccess = function (Data) 
	{
		if( _fnOnSuccess!=null)
			_fnOnSuccess(Data); 
	}
	
	this.SetOnFailure = function (OnFailure)
	{
		
		_fnOnFailure= OnFailure; 
	}
	
	this.CallOnFailure = function (XMLHTTPObject) 
	{
		if(_fnOnFailure!=null)
			_fnOnFailure(XMLHTTPObject); 
	}
	
	this.SetOnLoading = function (OnLoading)
	{
		_fnOnLoad= OnLoading; 
	}
	
	this.CallOnLoading = function () 
	{
		if(_fnOnLoad!=null)
			_fnOnLoad(); 
	}
	
	this.SetContainerID(ContainerID); 
}

AjaxFormSubmitter.prototype.FetchData = function ()
{
	var ContainerID= this.GetContainerID() ; 
	var RefrenceToThis = this; 
	var Data = {}; 
	$("#"+ContainerID+" input , select , textarea")
		.each (
			function (){
				
				var TagName = this.tagName; 
				
				
				switch (TagName)
				{
					case "INPUT": 
							var Type= $(this).attr("type"); 
							switch (Type){
								case "text":
								case "password":
								case "hidden":
									Data[$(this).attr("id")]=$(this).attr("value");
									break; 
								case "checkbox":
									if ($(this).attr("checked")){
										Data[$(this).attr("id")]=1;
									}
									else {
										Data[$(this).attr("id")]=0;
									}
									
									break; 
									
								case "radio": 
									if ($(this).is(":checked"))
									{
										Data[$(this).attr("name")]=$(this).attr("value"); 
									}
							} 
						break; 
					case "SELECT":
							var Options = new Array ();  
							var OptionIndex= 0 ; 
							$(this).find("option").each (
								function () 
								{
									if ($(this).attr("selected")) 
									{
										Options[OptionIndex++]=$(this).html();
									}
									Data[$(this).parent().attr("id")]= Options.join(",");
								}
							);
						break; 
					case "TEXTAREA":
							Data[$(this).attr("id")]= $(this).val(); 
						break; 
				}
				
				
					
			}
		) ;
		
	this.SetData(Data); 
}
AjaxFormSubmitter.prototype.Submit = function ()
{
	var RefrenceToThis = this; 
	this.FetchData(); 
	$.ajax (
		{
			url: this.GetURL() , 
			type : this.GetMethod(), 
			data : this.GetData() , 
			success: function(data){
				RefrenceToThis.CallOnSuccess(data);
			}, 
			error : function (xmlhttpobject){
				RefrenceToThis.CallOnFailure(xmlhttpobject);
			},  
			beforeSend :this.CallOnLoading()
		}
	
	);	
}

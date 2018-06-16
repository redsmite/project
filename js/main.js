//sideMenu
function openSlideMenu(){
	document.getElementById('side-menu').style.width='90px';
	document.getElementById('side-menu').marginleft='90px';
	document.getElementById('sidebarmodal').style.display='block';
}

function closeSlideMenu(){
	document.getElementById('side-menu').style.width='0';
	document.getElementById('side-menu').marginleft='0';
	document.getElementById('sidebarmodal').style.display='none';
}

// Create modal
function modal(){
	// Get modal element
	var modal = document.getElementById('simpleModal');
	// Get open modal button
	var modalBtn = document.getElementById('modalBtn');
	//Get close Button
	var closeBtn = document.getElementById('closeBtn');

	// Listen for open click
	modalBtn.addEventListener('click',openModal);

	// Listen for close click
	closeBtn.addEventListener('click',closeModal);

	// Listen for outside click
	window/addEventListener('click',outsideClick);


	//function to open modal
	function openModal(){
		modal.style.display = 'block';
	}

	//function to close modal
	function closeModal(){
		modal.style.display = 'none';
	}

	function outsideClick(e){
		if(e.target==modal){
		modal.style.display = 'none';
		}
	}
}

//No display if count is zero
var y = document.getElementById("notifnum");
var z = document.getElementById("pmnum");

if(y.innerText!=0){
	y.style.display="inline";
}
if(z.innerText!=0){
	z.style.display="inline";
}

function toggleNotif(){
	  var x = document.getElementById("notifdrop");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }

	var myRequest = new XMLHttpRequest();
	var url = 'edituserprocess.php';
	var checked = "1";
	
	var formData = "checked="+checked;
	
	myRequest.open('POST', url ,true);
	myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	myRequest.onload = function(){
		var response= this.responseText;
		console.log(response);
		if(response){
			
		}
	}
	myRequest.send(formData);


}

function searchdropdown(){
	var src = document.getElementById('search-dropdown');
	var input = document.getElementById('search-text');
	var modal =document.querySelector('.modal2');

	modal.addEventListener('click',hidesearch);

	if(input.value!=null){
		modal.style.display='block';
		src.style.display='block';

		var myRequest = new XMLHttpRequest();
		var url = 'searchprocess.php';
		var search = document.getElementById('search-text').value;
		
		var formData = "search="+search;
		
		myRequest.open('POST', url ,true);
		myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

		myRequest.onload = function(){
			console.log(this.responseText);
			var dataArray= this.responseText.split('||');
				var output='';
				for(i=0;i<dataArray.length-1;i++){
					var itemArray = dataArray[i].split('|');
					output+='<ul class="drop-ul"><li><a href="profile.php?name='+itemArray[0]+'"><div class="drop-tn"><img src="'+itemArray[1]+'"></div><p>'+itemArray[0]+'</a></p><small>Joined: '+itemArray[2]+'</small><li></ul>';
				}
			document.getElementById('search-dropdown').innerHTML = output;
			
			
		}
		myRequest.send(formData);		
	}

	function hidesearch(){
		modal.style.display='none';
		src.style.display='none';
	}
}

function friendprocess(){
	var fr=document.getElementById("fr-btn");
	fr.innerHTML='<i class="fas fa-user-plus"></i>Pending Request...';

	var myRequest = new XMLHttpRequest();
	var url = 'friendprocess.php';
	var fr =  fr.getAttribute('value');

	var formData = "fr="+fr;
	
	myRequest.open('POST', url ,true);
	myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	myRequest.onload = function(){
		var response= JSON.parse(this.responseText);
		console.warn(response);
		if(response){
			console.log('oke-oke-okay');

		}
	}
	myRequest.send(formData);
}

function friendyes(){
	var nid = document.querySelector(".fr-yes").getAttribute('value');
	var nid2='fr-'+nid;
	var fr= document.getElementById(nid2);
	fr.innerHTML="Request Accepted";

	var myRequest = new XMLHttpRequest();
	var url = 'friendprocess.php';
	var fryes =  nid;

	var formData = "fryes="+fryes;
	
	myRequest.open('POST', url ,true);
	myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	myRequest.onload = function(){
		var response= JSON.parse(this.responseText);
		console.warn(response);
		if(response){
			console.log('oke-oke-okay');

		}
	}
	myRequest.send(formData);
}


function friendno(){
	var nid = document.querySelector(".fr-no").getAttribute('value');
	var nid2='fr-'+nid;
	var fr= document.getElementById(nid2);
	fr.innerHTML="Request Denied";

	var myRequest = new XMLHttpRequest();
	var url = 'friendprocess.php';
	var frno =  nid;

	var formData = "frno="+frno;
	
	myRequest.open('POST', url ,true);
	myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	myRequest.onload = function(){
		var response= JSON.parse(this.responseText);
		console.warn(response);
		if(response){
			console.log('oke-oke-okay');

		}
	}
	myRequest.send(formData);
}

function friendremove(){
	var rmv=document.getElementById('rmv-fr');

	rmv.innerText='Removing friend...';

	var fid = rmv.getAttribute('value');

	console.log(fid);

	var myRequest = new XMLHttpRequest();
	var url = 'friendprocess.php';
	var rmv =  fid;

	var formData = "rmv="+rmv;
	
	myRequest.open('POST', url ,true);
	myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	myRequest.onload = function(){
		var response= JSON.parse(this.responseText);
		console.warn(response);
		if(response){
			console.log('oke-oke-okay');

		}
	}
	myRequest.send(formData);
}

//Login AJAX
function ajaxLogin(){
	document.getElementById('log-form').addEventListener('submit', postName);

		function postName(e){
			e.preventDefault();

			addSpinners();

			var myRequest = new XMLHttpRequest();
			var url = 'loginprocess.php';

			//form data variables
			var username = document.getElementById('log-user').value;
			var password = document.getElementById('log-pass').value;
			var remember = document.getElementById('log-remember');

			if(remember.checked==true){
				remember=1;
			}else{
				remember=0;
			}

			var formData = "username="+username+"&password="+password+"&remember="+remember;
			
			myRequest.open('POST', url ,true);
			myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

			myRequest.onload = function(){
				var response= JSON.parse(this.responseText);
				console.log(response);
				
				if(response[0]==0){
					
					window.location.href = "loginsuccess.html";
				
				} else {
					removeSpinners();
					document.getElementById('error-message').innerHTML=response[1];
				}
			}
			myRequest.send(formData);
		}
}

// Register AJAX
function ajaxRegister(){
	document.getElementById('reg-form').addEventListener('submit', regName);

	function regName(e){
		e.preventDefault();

		addSpinners();
			

		var myRequest = new XMLHttpRequest();
		var url = 'registerprocess.php';

		//form data variables
		var username = document.getElementById('reg-name').value;
		var password = document.getElementById('reg-password').value;
		var retype = document.getElementById('reg-retype').value;
		var email = document.getElementById('reg-email').value;
		
		var formData = "username="+username+"&password="+password+"&retype="+retype+"&email="+email;
		
		myRequest.open('POST', url ,true);
		myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

		myRequest.onload = function(){
			var response= JSON.parse(this.responseText);
			console.warn(response);
			if(response=="success"){

				window.location.href = 'thankyou.html';
			} else {
				var output='';
					for(var i in response){
					output += '<ul>'+
						'<li>'+response[i]+'</li>'+
						'</ul>';
					}
				document.getElementById('error-message2').innerHTML = output;
				removeSpinners();
			}
		}
		myRequest.send(formData);
	}
}

function AjaxEditUser(){
	document.getElementById('edit-username').addEventListener('submit', editName);

	function editName(e){
		e.preventDefault();

		addSpinners();
			

		var myRequest = new XMLHttpRequest();
		var url = 'edituserprocess.php';

		//form data variables
		var username = document.getElementById('edit-name').value;
		var update = document.getElementById('hidden').value;
		var time = document.getElementById('hidden2').value;

		var formData = "username="+username+"&update="+update+"&time="+time;
		
		myRequest.open('POST', url ,true);
		myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

		myRequest.onload = function(){
			var response= JSON.parse(this.responseText);
			console.warn(response);
			if(response=="success"){

				window.location.href = 'changesuccess.html';
			} else {
				var output='';
					for(var i in response){
					output += '<ul>'+
						'<li>'+response[i]+'</li>'+
						'</ul>';
					}
				document.getElementById('error-message2').innerHTML = output;
				removeSpinners();
			}
		}
		myRequest.send(formData);
	}
}

function AjaxEditEmail(){
	document.getElementById('edit-email').addEventListener('submit', editEmail);

	function editEmail(e){
		e.preventDefault();

		addSpinners();
			

		var myRequest = new XMLHttpRequest();
		var url = 'edituserprocess.php';

		//form data variables
		var email = document.getElementById('editemail').value;

		var formData = "email="+email;
		
		myRequest.open('POST', url ,true);
		myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

		myRequest.onload = function(){
			var response= JSON.parse(this.responseText);
			console.warn(response);
			if(response=="success"){

				window.location.href = 'changeesuccess.html';
			} else {
				var output='';
					for(var i in response){
					output += '<ul>'+
						'<li>'+response[i]+'</li>'+
						'</ul>';
					}
				document.getElementById('error-message4').innerHTML = output;
				removeSpinners();
			}
		}
		myRequest.send(formData);
	}
}

function AjaxEditPass(){
	document.getElementById('edit-password').addEventListener('submit', editPass);

	function editPass(e){
		e.preventDefault();

		addSpinners();
			

		var myRequest = new XMLHttpRequest();
		var url = 'edituserprocess.php';

		//form data variables
		var oldpass = document.getElementById('edit-oldpassword').value;
		var newpass = document.getElementById('edit-newpassword').value;
		var retype = document.getElementById('edit-retype').value;
		var truepass = document.getElementById('hidden3').value;

		var formData = "oldpass="+oldpass+"&newpass="+newpass+"&retype="+retype+"&truepass="+truepass;
		
		myRequest.open('POST', url ,true);
		myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

		myRequest.onload = function(){
			var response= JSON.parse(this.responseText);
			console.warn(response);
			if(response=="success"){

				window.location.href = 'changepsuccess.html';
			} else {
				var output='';
					for(var i in response){
					output += '<ul>'+
						'<li>'+response[i]+'</li>'+
						'</ul>';
					}
				document.getElementById('error-message3').innerHTML = output;
				removeSpinners();
			}
		}
		myRequest.send(formData);
	}
}

//Redirect Page
function redirectPage(){
	document.getElementById('redirectlink').addEventListener('click',historyback);

	function historyback(){
		window.location.replace("index.php");
	}
	setTimeout(function () {
		   
		window.location.replace("index.php");
	
	}, 3000);
}

function redirectProfile(){
	
	var myRequest = new XMLHttpRequest();
	var url = 'edituserprocess.php';
	var session = "$_SESSION['name']";
	
	var formData = "session="+session;
	
	myRequest.open('POST', url ,true);
	myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	myRequest.onload = function(){
		var response= JSON.parse(this.responseText);
		console.warn(response);
		if(response){
			document.getElementById('redirectlink').addEventListener('click',historyback);

					
			function historyback(){
				window.location.replace("profile.php?name="+response);
			}
			setTimeout(function () {
				   
				window.location.replace("profile.php?name="+response);
			
			}, 3000);

		}
	}
	myRequest.send(formData);

}

function activepage(thispage){
	document.querySelector(thispage).style.color='var(--contrast)';
}

// Spinners
function pageReload(){
	document.querySelector('.main-container').style.opacity='0.7';
	document.querySelector('body').classList.add('spinner');

	setTimeout(()=>{
		document.querySelector('body').classList.remove('spinner');
		document.querySelector('.main-container').style.opacity='1';
		
	}, 2000)
}

function addSpinners(){
	document.querySelector('.main-container').style.opacity='0.7';
	document.querySelector('body').classList.add('spinner');
}

function removeSpinners(){
	document.querySelector('body').classList.remove('spinner');
	document.querySelector('.main-container').style.opacity='1';
}


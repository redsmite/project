// Get Company Name
function changeCompanyName(firstText,secondText){	
	var companyName= firstText+" "+secondText;
	document.getElementById("first-text").innerHTML = firstText;
	document.getElementById("second-text").innerHTML = secondText;
	document.getElementById("company").innerHTML = companyName;
	document.title= companyName;
}

//sideMenu
function openSlideMenu(){
	document.getElementById('side-menu').style.width='90px';
	document.getElementById('side-menu').marginleft='90px';
}

function closeSlideMenu(){
	document.getElementById('side-menu').style.width='0';
	document.getElementById('side-menu').marginleft='0';
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
		var firstname = document.getElementById('reg-first').value;
		var middlename = document.getElementById('reg-middle').value;
		var lastname = document.getElementById('reg-last').value;
		var birthday = document.getElementById('reg-birthday').value;
		var email = document.getElementById('reg-email').value;
		var phoneno = document.getElementById('reg-phone').value;
		var address = document.getElementById('reg-address').value;

		var formData = "username="+username+"&password="+password+"&retype="+retype+"&firstname="+firstname+"&middlename="+middlename+"&lastname="+lastname+"&birthday="+birthday+"&email="+email+"&phoneno="+phoneno+"&address="+address;
		
		myRequest.open('POST', url ,true);
		myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

		myRequest.onload = function(){
			var response= this.responseText;
			
			if(response=="success"){

				window.location.href = 'thankyou.html';
			} else {
				removeSpinners();
				document.getElementById('error-message2').innerHTML=response;
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
	
	}, 2000);
}

// Spinners
function pageReload(){
	document.querySelector('.main-container').style.opacity='0.7';
	document.querySelector('body').classList.add('spinner');

	// Mimic server req
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

changeCompanyName('This','Company');

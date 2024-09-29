'use strict';

/* ===== Enable Bootstrap Popover (on element  ====== */
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

/* ==== Enable Bootstrap Alert ====== */
//var alertList = document.querySelectorAll('.alert')
//alertList.forEach(function (alert) {
//  new bootstrap.Alert(alert)
//});

const alertList = document.querySelectorAll('.alert')
const alerts = [...alertList].map(element => new bootstrap.Alert(element))


/* ===== Responsive Sidepanel ====== */
const sidePanelToggler = document.getElementById('sidepanel-toggler'); 
const sidePanel = document.getElementById('app-sidepanel');  
const sidePanelDrop = document.getElementById('sidepanel-drop'); 
const sidePanelClose = document.getElementById('sidepanel-close'); 

window.addEventListener('load', function(){
	responsiveSidePanel(); 
});

window.addEventListener('resize', function(){
	responsiveSidePanel(); 
});


function responsiveSidePanel() {
    let w = window.innerWidth;
	if(w >= 1200) {
	    // if larger 
	    //console.log('larger');
		sidePanel.classList.remove('sidepanel-hidden');
		sidePanel.classList.add('sidepanel-visible');
		
	} else {
	    // if smaller
	    //console.log('smaller');
	    sidePanel.classList.remove('sidepanel-visible');
		sidePanel.classList.add('sidepanel-hidden');
	}
};

sidePanelToggler.addEventListener('click', () => {
	if (sidePanel.classList.contains('sidepanel-visible')) {
		console.log('visible');
		sidePanel.classList.remove('sidepanel-visible');
		sidePanel.classList.add('sidepanel-hidden');
		
	} else {
		console.log('hidden');
		sidePanel.classList.remove('sidepanel-hidden');
		sidePanel.classList.add('sidepanel-visible');
	}
});



sidePanelClose.addEventListener('click', (e) => {
	e.preventDefault();
	sidePanelToggler.click();
});

sidePanelDrop.addEventListener('click', (e) => {
	sidePanelToggler.click();
});



/* ====== Mobile search ======= */
const searchMobileTrigger = document.querySelector('.search-mobile-trigger');
const searchBox = document.querySelector('.app-search-box');

searchMobileTrigger.addEventListener('click', () => {

	searchBox.classList.toggle('is-visible');
	
	let searchMobileTriggerIcon = document.querySelector('.search-mobile-trigger-icon');
	
	if(searchMobileTriggerIcon.classList.contains('fa-magnifying-glass')) {
		searchMobileTriggerIcon.classList.remove('fa-magnifying-glass');
		searchMobileTriggerIcon.classList.add('fa-xmark');
	} else {
		searchMobileTriggerIcon.classList.remove('fa-xmark');
		searchMobileTriggerIcon.classList.add('fa-magnifying-glass');
	}
	
		
	
});


function previewImage(event) {
	const file = event.target.files[0];
	const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
	const maxSize = 2 * 1024 * 1024; // 2MB

	const imageError = document.getElementById('image-error');
	imageError.style.display = 'none';

	if (file) {
		if (!allowedTypes.includes(file.type)) {
			imageError.textContent = 'Please upload a valid image (JPEG, JPG, or PNG).';
			imageError.style.display = 'block';
			document.getElementById('modal-profile-picture').src = 'https://via.placeholder.com/150'; // Reset to default
			return;
		}

		if (file.size > maxSize) {
			imageError.textContent = 'File size must be less than 2MB.';
			imageError.style.display = 'block';
			document.getElementById('modal-profile-picture').src = 'https://via.placeholder.com/150'; // Reset to default
			return;
		}

		const reader = new FileReader();
		reader.onload = function(e) {
			document.getElementById('modal-profile-picture').src = e.target.result;
		};
		reader.readAsDataURL(file);
	}
}

function validateForm() {
	const form = document.getElementById('createStaffForm');
	if (form.checkValidity() === false) {
		// Trigger validation UI
		Array.from(form.elements).forEach(element => {
			if (!element.checkValidity()) {
				element.classList.add('is-invalid');
			} else {
				element.classList.remove('is-invalid');
			}
		});
		form.reportValidity(); // Show validation messages
	} else {
		form.submit(); // Submit the form if valid
	}
}



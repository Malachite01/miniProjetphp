//*MENU 
function menuMobile(nav) {
    navLinks = document.querySelector("." + nav);
    navLinks.classList.toggle('mobile-menu');
}

function popup(popup) {
    var popupFen = document.querySelector('.' + popup);
    var elements = document.querySelectorAll( "body > *:not(.validationPopup):not(.erreurPopup):not(.supprPopup)" );
    Array.from( elements ).forEach( s => s.style.filter = "grayscale(60%)");
    popupFen.style.display = 'block';
}

function erasePopup(popup) {
    var popupFen = document.querySelector('.' + popup);
    popupFen.style.display = 'none';
}

function refreshImageSelector(nomIdChamp,idImage) {
    const [file] = document.getElementById(nomIdChamp).files
    if (file) {
        document.getElementById(idImage).src = URL.createObjectURL(file);
    } 
}

function afficherMDP(nomIdChamp, nomIdOeil) {
    var champ = document.getElementById(nomIdChamp);
    var icone = document.getElementById(nomIdOeil);
    if (champ.type === "password") {
        champ.type = "text";
        icone.src = "images/oeil.png";
    } else {
        champ.type = "password";
        icone.src = "images/oeilFermé.png";
    }
}

function limitKeypress(event, value, maxLength) {
    if (value != undefined && value.toString().length >= maxLength) {
        event.preventDefault();
    }
}

function scoreMatch (value) {
    if (value.toString().length >= 2 && value.toString().length < 3) {
        value = value +"-";
    }
    if(value.split('-').length === 3) {
        value = value.slice(0, -1);
    }
    if (value.toString().length >= 5) {
        value = value.substring(0, 5);
    }
    return value;
}

function fenOpen(aCacher) {
    aCacher1 = document.querySelector("." + aCacher);
    aCacher1.style.display = "block";
    aCacher1.classList.toggle('fenButtonOn');
    aCacher1.classList.remove('fenButtonOff');
    var elements = document.querySelectorAll( "body > *:not(.validationPopup):not(.erreurPopup):not(.supprPopup):not(.editPopup):not(.aCacher)" );
    Array.from( elements ).forEach( s => s.style.filter = "grayscale(100%) blur(3px)");
}

function fenClose(aCacher) {
    aCacher1 = document.querySelector("." + aCacher);
    aCacher1.classList.toggle('fenButtonOn');
    aCacher1.classList.add('fenButtonOff');
    var elements = document.querySelectorAll( "body > *:not(.validationPopup):not(.erreurPopup):not(.supprPopup):not(.editPopup):not(.aCacher)" );
    Array.from( elements ).forEach( s => s.style.filter = "grayscale(0%)  blur(0px)");
    setTimeout(function(){
        aCacher1.style.display = "none";
    }, 600);
}

function deCache(div) {
    aCacher = document.querySelector("." + div);
    if(aCacher.classList.contains('transparent')) {
        aCacher.classList.remove('transparent');
    } 
}

function ajouterSelection(bouton) {
    let form = document.getElementById("formAjoutFeuille");
    let hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("name", "valeurJoueur");
    hiddenInput.setAttribute("id", "valeurJoueur");
    hiddenInput.setAttribute("value", "true");
    hiddenInput.value = bouton.value;
    form.appendChild(hiddenInput);
}

function deleteSelection() {
    document.getElementById("valeurJoueur").remove();
}


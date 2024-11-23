const lien = document.querySelector(".lien");
const logo = document.querySelector(".logo");
const menu = document.querySelector(".menu");
const account = document.querySelector(".account");
const gestionCompte = document.querySelector(".gestion-compte");

let affichage = false;

logo.addEventListener("click", () => {
  if(window.innerWidth <= 1300){
    if (!affichage){
      menu.classList.add("visible");
      affichage = true;
    } else {
      menu.classList.remove("visible");
      affichage = false;
    }
  }
});

window.addEventListener("resize", ()=>{
  if(affichage === true && window.innerWidth >= 1300){
    menu.classList.remove("visible");
    affichage = false;
  }
})

let affichageCompte = false;
account.addEventListener("click", ()=>{

  if(!affichageCompte){
    gestionCompte.classList.add("visible");
    affichageCompte = true;
  } else {
    gestionCompte.classList.remove("visible");
    affichageCompte = false;
  }
})


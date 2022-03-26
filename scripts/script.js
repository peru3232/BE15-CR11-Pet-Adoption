"use strict";

// to animate the footer with mouse usage 
const footer = document.getElementsByTagName("footer")[0];
const body = document.getElementsByTagName("body")[0];
footer.addEventListener("mouseenter", function () { footerSlide(true); });
footer.addEventListener("mouseleave", function () { footerSlide(false); });
//slide out only with mouse in window
body.addEventListener("mouseenter", function () { footerSlide(false); });
function footerSlide(over) {
    const toggle = document.getElementsByClassName("toggle")[0];
    if (over) {
        toggle.classList.remove("animate__slideOutDown");
        toggle.classList.add("animate__slideInUp");
    }
    else {
        toggle.classList.remove("animate__slideInUp");
        toggle.classList.add("animate__slideOutDown");
    }
}

//======================================= D A T A ===============================================
const arrAnimals = [];
new Animal("Uschi", "female", 1, "small", "images/Bacon.jpg", true, arrAnimals);
new Dog("Gaffgaff", "male", 5, "large", "images/belloloino.webp", false, "mix", true, arrAnimals);
new Cat("Puschl", "female", 13, "xxlarge", "images/Puschl.jpg", true, "Lion", "Blond", "www.lions.com", arrAnimals);
new Cat("Schnurrli", "female", 7, "small", "images/Mietzi.jpg", false, "American Shorthair", "Tabby", "www.shcats.com", arrAnimals);
new Animal("Hermann", "male", 4, "small", "images/Ready.jpg", false, arrAnimals);
new Dog("Bellolino", "male", 3, "medium", "images/Gaff-gaff.webp", true, "Shepper", true, arrAnimals);
//===============================================================================================


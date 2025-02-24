const btnStart = document.querySelector(".startbtn"),
  section1 = document.querySelector(".section1"),
  back = document.querySelector(".back"),
  section2 = document.querySelector(".section2");

const btnMenudeop = document.querySelector(".menuDrop"),
  closeMenu = document.querySelector(".closeMenu"),
  menu = document.querySelector(".menu");

btnMenudeop.addEventListener("click", () => {
  menu.classList.toggle("active");
});

closeMenu.addEventListener("click", () => {
  menu.classList.remove("active");
});

const btnLightMode = document.querySelector(".btnlightmood"),
  mdlight = document.querySelector(".mdlight moon"),
  mdlight2 = document.querySelector(".mdlight sun"),
  btnLightMode2 = document.querySelector(".btnlightmood2");
const body = document.body;

btnLightMode.addEventListener("click", () => {
  // Toggle the light-mode class on the body
  body.classList.toggle("mood");
});

btnLightMode2.addEventListener("click", () => {
  // Toggle the light-mode class on the body
  body.classList.toggle("mood");
});

const btnMore = document.querySelector(".btnMore"),
  displayMore = document.querySelector(".morePr"),
  namebtn = document.querySelector(".namebtn");

btnMore.addEventListener("click", () => {
  displayMore.classList.toggle("active");

  if (displayMore.classList.contains("active")) {
    namebtn.textContent = "Hide";
  } else {
    namebtn.textContent = "More";
  }
});

const formFollow = document.querySelector(".formFollow"),
  closeFormFpllow = document.querySelector(".closeFormFpllow"),
  btnFollow = document.querySelector(".btnFollow"),
  btnformmessage = document.querySelector(".btnMessage"),
  closeFormMessage = document.querySelector(".closeFormMessage"),
  formMessage = document.querySelector(".formmessage");

btnFollow.addEventListener("click", () => {
  formFollow.classList.toggle("active");
});

closeFormFpllow.addEventListener("click", () => {
  formFollow.classList.remove("active");
});

btnformmessage.addEventListener("click", () => {
  formMessage.classList.toggle("active");
});

closeFormMessage.addEventListener("click", () => {
  formMessage.classList.remove("active");
});

//srolling settings ........
//scroll btn about me
const scrollabout = document.querySelector(".scrollabout"),
  scrollaboutnav = document.querySelector(".scrollaboutnav");

//scroll btn skills
const scrollskills = document.querySelector(".scrollskills"),
  scrollskillsnav = document.querySelector(".scrollskillsnav");

//scroll btn pro
const scrollpro = document.querySelector(".scrollpro"),
  scrollpronav = document.querySelector(".scrollpronav");

//scroll btn contact
const scrollcontact = document.querySelector(".scrollcontact"),
  scrollcontactnav = document.querySelector(".scrollcontactnav");
window.addEventListener("scroll", () => {
  console.log(window.scrollY);
});

//scroll about
scrollabout.addEventListener("click", () => {
  if (window.screenY < 756) {
    window.scrollTo({
      top: 756,
      behavior: "smooth",
    });
  }

  if (menu.classList.contains("active")) {
    menu.classList.remove("active");
  }
});

scrollaboutnav.addEventListener("click", () => {
  if (window.screenY < 769) {
    window.scrollTo({
      top: 769,
      behavior: "smooth",
    });
  }
});

//scroll skills

scrollskills.addEventListener("click", () => {
  if (window.screenY < 1373) {
    window.scrollTo({
      top: 1373,
      behavior: "smooth",
    });
  }

  if (menu.classList.contains("active")) {
    menu.classList.remove("active");
  }
});

scrollskillsnav.addEventListener("click", () => {
  if (window.screenY < 1620) {
    window.scrollTo({
      top: 1620,
      behavior: "smooth",
    });
  }
});

//scroll project

scrollpro.addEventListener("click", () => {
  if (window.screenY < 2112) {
    window.scrollTo({
      top: 2112,
      behavior: "smooth",
    });
  }

  if (menu.classList.contains("active")) {
    menu.classList.remove("active");
  }
});

scrollpronav.addEventListener("click", () => {
  if (window.screenY < 2420) {
    window.scrollTo({
      top: 2420,
      behavior: "smooth",
    });
  }
});

//scroll contact

scrollcontact.addEventListener("click", () => {
  if (window.screenY < 4384) {
    window.scrollTo({
      top: 4384,
      behavior: "smooth",
    });
  }

  if (menu.classList.contains("active")) {
    menu.classList.remove("active");
  }
});

scrollcontactnav.addEventListener("click", () => {
  if (window.screenY < 4571) {
    window.scrollTo({
      top: 4000,
      behavior: "smooth",
    });
  }
});

//scroll first

const buttonscrollA0 = document.querySelector(".buttonscrollA0"),
  btn0scroll = document.querySelector(".btn0scroll");
buttonscrollA0.addEventListener("click", () => {
  if (window.screenY < 700) {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  }
});
window.addEventListener("scroll", () => {
  if (window.scrollY < 700) {
    btn0scroll.style.display = "none";
  } else {
    btn0scroll.style.display = "block";
  }
});

// scroll animations
const sections = document.querySelectorAll(
  ".section2, .section3, .titlepro,.ProjectTitle, .section5, .section6,.morePr,#scrollft1,.bartitle,.titleSk,.prSkills,.titleContact"
);
const projects = document.querySelectorAll(
  "#pro1, #pro3, #pro2, #pro4, #pro5, #pro6 ,#imgCoantactScroll, #forminformationUserScroll,#copyrightScroll,#menuft2Scroll,.textBoutMe,.imgAbout"
);

window.addEventListener("scroll", () => {
  sections.forEach((section) => {
    const sectionTop = section.getBoundingClientRect().top;
    const windowHeight = window.innerHeight;

    if (sectionTop < windowHeight - 120) {
      section.classList.add("visible");
    } else {
      section.classList.remove("visible");
    }
  });

  projects.forEach((pro) => {
    const projectTop = pro.getBoundingClientRect().top;
    const projectHeigt = window.innerHeight;

    if (projectTop < projectHeigt - 100) {
      pro.classList.add("visible");
    } else {
      pro.classList.remove("visible");
    }
  });
});


document.addEventListener('DOMContentLoaded',()=>{
  const firstPage = document.querySelector('.section1');

  setTimeout(() => {
    firstPage.classList.add('visible')
    firstPage.scrollIntoView({behavior :'smooth'})
  }, 400);
})


document.addEventListener("DOMContentLoaded", () => {
  const skillScroll = document.querySelectorAll("#skillScroll, skillScroll2");

  setTimeout(() => {
    skillScroll.classList.add("visible");
    skillScroll.scrollIntoView({ behavior: "smooth" });
  }, 400);
});
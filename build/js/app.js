function darkMode(){const e=window.matchMedia("prefers-color-scheme:dark"),o=document.querySelector(".dark-mode-boton");e.matches?document.body.classList.add("dark-mode"):document.body.classList.remove("dark-mode"),o.addEventListener("click",(function(){document.body.classList.toggle("dark-mode")}))}function listeners(){document.querySelector(".mobile-menu").addEventListener("click",navegacionResponsive)}function navegacionResponsive(){const e=document.querySelector("navegacion");e.classList.contains("mostrar")?e.classList.remove("mostrar"):e.classList.add("mostrar")}document.addEventListener("DOMContentLoaded",(function(){console.log("nada"),listeners(),darkMode()}));
//# sourceMappingURL=app.js.map

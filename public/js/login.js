"use strict";

{
  const tabs = document.querySelectorAll(".tabs li a");
  const contents = document.querySelectorAll(".content");
  tabs.forEach((tab) => {
    tab.addEventListener("click", (e) => {
      e.preventDefault();
      tabs.forEach((tab) => {
        tab.classList.remove("active");
      });
      tab.classList.add("active");

      contents.forEach((content) => {
        content.classList.remove("active");
      });
      document.querySelector(`#${tab.dataset.id}`).classList.add("active");
    });
  });
}

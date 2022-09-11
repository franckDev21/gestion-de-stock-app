import React from 'react';
import ReactDOM, { createRoot } from "react-dom/client";
import "../css/app.scss";
import "./bootstrap";
import Alpine from "alpinejs";
import Commande from "./Page/Commande";


// window.Alpine = Alpine;

Alpine.start();

// change type input
Array.from(document.querySelectorAll(".eye-input")).forEach((parentInput) => {
    parentInput.querySelector("i")?.addEventListener("click", (e: any) => {
        if (parentInput.querySelector("input")?.type === "text") {
            (parentInput.querySelector("input") as HTMLInputElement).type = "password";
            e.target.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            (parentInput.querySelector("input") as HTMLInputElement).type = "text";
            e.target.classList.replace("fa-eye", "fa-eye-slash");
        }
    });
});

if (document.getElementById('commande')) { 
  createRoot(document.getElementById('commande') as HTMLElement).render(<Commande />)
}

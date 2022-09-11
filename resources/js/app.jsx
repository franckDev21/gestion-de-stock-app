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
    parentInput.querySelector("i")?.addEventListener("click", (e) => {
        if (parentInput.querySelector("input")?.type === "text") {
            parentInput.querySelector("input").type = "password";
            e.target.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            parentInput.querySelector("input").type = "text";
            e.target.classList.replace("fa-eye", "fa-eye-slash");
        }
    });
});

if (document.getElementById('commande')) { 
    const user_id = document.getElementById('commande').dataset.user
    createRoot(document.getElementById('commande')).render(<Commande user_id={user_id} />)
}

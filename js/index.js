const themes = [
    {
        background: "#1A1A2E",
        color: "#FFFFFF",
        primaryColor: "#0F3460"
    },
    {
        background: "#461220",
        color: "#FFFFFF",
        primaryColor: "#E94560"
    },
    {
        background: "#192A51",
        color: "#FFFFFF",
        primaryColor: "#967AA1"
    },
    {
        background: "#F7B267",
        color: "#000000",
        primaryColor: "#F4845F"
    },
    {
        background: "#F25F5C",
        color: "#000000",
        primaryColor: "#642B36"
    },
    {
        background: "#231F20",
        color: "#FFF",
        primaryColor: "#BB4430"
    }
];

const setTheme = (theme) => {
    const root = document.querySelector(":root");
    root.style.setProperty("--background", theme.background);
    root.style.setProperty("--color", theme.color);
    root.style.setProperty("--primary-color", theme.primaryColor);
};

const displayThemeButtons = () => {
    const btnContainer = document.querySelector(".theme-btn-container");
    themes.forEach((theme) => {
        const div = document.createElement("div");
        div.className = "theme-btn";
        div.style.cssText = `background: ${theme.background}; width: 25px; height: 25px`;
        btnContainer.appendChild(div);
        div.addEventListener("click", () => setTheme(theme));
    });
};

displayThemeButtons();

// ✅ Fix tracking logic
const form = document.getElementById("track-form");
const modal = document.getElementById("parcel-modal"); // ID matches HTML now
const closeBtn = document.getElementById("close-modal");
const codeDisplay = document.getElementById("parcel-code");
const trackSection = document.getElementById("track-section");

form.addEventListener("submit", function (e) {
    e.preventDefault();
    const codeInput = document.getElementById("track-code").value.trim();
    if (codeInput) {
        codeDisplay.textContent = codeInput.toUpperCase();
        modal.classList.remove("hidden");
        trackSection.style.display = "none"; // hide form
    }
});

closeBtn.addEventListener("click", () => {
    modal.classList.add("hidden");
    trackSection.style.display = "flex"; // bring back form
});

window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        modal.classList.add("hidden");
        trackSection.style.display = "flex";
    }
});

const closeFormBtn = document.getElementById("close-form-btn");

closeFormBtn.addEventListener("click", () => {
  modal.classList.add("hidden");
  trackSection.style.display = "flex";
});

const printBtn = document.getElementById("print-form-btn");

printBtn.addEventListener("click", () => {
  // Temporarily hide the tracking form section to print only the modal
  trackSection.style.display = "none";

  // Add a print class to modal to ensure proper formatting
  modal.classList.add("print-mode");

  window.print();

  // Restore visibility after print
  setTimeout(() => {
    modal.classList.remove("print-mode");
    trackSection.style.display = "none"; // keep it hidden after print
  }, 1000);
});


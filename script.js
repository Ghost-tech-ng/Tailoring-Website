document.addEventListener('DOMContentLoaded', function () {
    // Hamburger menu functionality
    const nav = document.querySelector(".navbar"),
        navOpenBtn = document.querySelector("#bar-open"),
        navCloseBtn = document.querySelector("#x-closed");

    if (navOpenBtn) {
        navOpenBtn.addEventListener("click", () => {
            nav.classList.add("openNav");
        });
    }

    if (navCloseBtn) {
        navCloseBtn.addEventListener("click", () => {
            nav.classList.remove("openNav");
        });
    }

    // Theme toggle functionality
    const themeToggle = document.querySelector('#theme-toggle');
    const themeIcon = document.querySelector('#theme-icon');
    const body = document.body;

    themeToggle.addEventListener('click', () => {
        if (body.classList.contains('dark-mode')) {
            body.classList.remove('dark-mode');
            body.classList.add('light-mode');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        } else {
            body.classList.remove('light-mode');
            body.classList.add('dark-mode');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
    });

});


document.addEventListener('DOMContentLoaded', function () {
    const factItems = document.querySelectorAll('.fact-item');

    const countUp = (element, countTo) => {
        let count = 0;
        const interval = setInterval(() => {
            if (count < countTo) {
                count++;
                element.innerText = `${count}+`; // Add plus icon
            } else {
                clearInterval(interval);
            }
        }, 15); // Adjust speed here
    };

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const factItem = entry.target;
                const numberElement = factItem.querySelector('.fact-number');
                const countTo = parseInt(factItem.getAttribute('data-count'), 10);
                countUp(numberElement, countTo);
                observer.unobserve(factItem);
            }
        });
    }, { threshold: 0.5 });

    factItems.forEach(item => {
        observer.observe(item);
    });
});


// JavaScript to handle popup opening and closing
document.addEventListener('DOMContentLoaded', function () {
    var openPopup = document.getElementById('open-appointment-popup');
    var closePopup = document.getElementById('close-appointment-popup');
    var popup = document.getElementById('appointment-popup');

    openPopup.onclick = function (event) {
        event.preventDefault(); // Prevent the default link behavior
        popup.style.display = 'block';
    }

    closePopup.onclick = function () {
        popup.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    }
});



document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        item.addEventListener('click', function () {
            // Toggle the active class to show/hide the answer
            const isActive = this.classList.contains('active');
            faqItems.forEach(i => i.classList.remove('active'));
            if (!isActive) {
                this.classList.add('active');
            }
        });
    });
});


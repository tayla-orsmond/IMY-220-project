<!-- Tayla Orsmond u21467456 -->
<!-- Footer component
    Basic footer with copyright and social media links
     -->
<?php
echo '
    <footer class="bg-dark p-5 w-100">
        <div class="container d-flex justify-content-center">
            <a href="#"><i class="fa-brands fa-instagram fa-xl mx-2"></i></a>
            <a href="#"><i class="fa-brands fa-twitter fa-xl mx-2"></i></a>
            <a href="#"><i class="fa-brands fa-youtube fa-xl mx-2"></i></a>
            <a href="#"><i class="fa-brands fa-facebook fa-xl mx-2"></i></a>
        </div>
        <div class="container mt-2">
            <p class="text-center small">Copyright &copy; ' . date('Y') . ' artfolio. All rights reserved.</p>
        </div>
        <div class="d-flex gap-2 justify-content-end align-items-center">
            <i class="fa-solid fa-lightbulb text-light"></i>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="dark_light">
                <label class="form-check-label d-none" for="dark_light">Toggle Theme</label>
            </div>
            <i class="fa-solid fa-moon text-light"></i>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="js/config.js"></script>
    <script>
        $(() => {
            //set dark mode
            const dark = () => {
                $("body").addClass("dark");
                $("#dark_light").prop("checked", true);
                $("#dark_light").attr("checked", "checked");
            }

            //set light mode
            const light = () => {
                $("body").removeClass("dark");
                $("body").addClass("light");
                $("#dark_light").prop("checked", false);
                $("#dark_light").attr("checked", "");
            }

            // Check if the user has a theme preference (use local storage over device pref for demo purposes)
            if (localStorage.getItem("theme") == "dark") {
                dark();
            } else if (localStorage.getItem("theme") == "light") {
                light();
            } else if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
                dark();
            } else {
                light();
            }

            // Toggle the theme
            $("#dark_light").on("change", () => {
                if ($("#dark_light").prop("checked")) {
                    dark();
                    localStorage.setItem("theme", "dark");
                } else {
                    light();
                    localStorage.setItem("theme", "light");
                }
            });

        });
    </script>';
require_once 'modals.php';

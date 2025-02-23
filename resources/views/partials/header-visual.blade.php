<div class="loader-container" id="loader-container">
    <div class="loader"></div>
    <div class="text-loader">AIPT-UINSU</div>
</div>

<header id="header-wrap">
    <!-- Navbar Start -->
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="#">
                    <img src="/img/logo.png" alt="">
                </a>
            </div>
            <i class="bx bx-menu menu-icon"></i>
            <div class="nav-links">

                <ul class="links">
                    <li><a class="link" href="/">Beranda</a></li>
                    @auth
                        @if (Auth::user()->is_admin)
                            <li><a class="link" href="/admin">Admin</a></li>
                        @else
                            <li><a class="link" href="/logout">Logout</a></li>
                        @endif
                    @endauth
                </ul>
            </div>

        </div>
    </nav>
    <!-- Navbar End -->
</header>


<script>
    const menuIcon = document.querySelector(".bx-menu");
    const navLinks = document.querySelector(".nav-links");
    const links = document.querySelectorAll(".links li");

    menuIcon.addEventListener("click", function() {
        navLinks.classList.toggle("active");
        links.forEach(link => link.nextElementSibling.style.display = navLinks.classList.contains("active") ?
            "block" : "none");
    });

    window.addEventListener("scroll", function() {
        var header_navbar = document.querySelector(".navbar");
        var sticky = header_navbar.offsetTop;

        if (window.pageYOffset > sticky) {
            header_navbar.classList.add("sticky");
        } else {
            header_navbar.classList.remove("sticky");
        }
    });


    window.addEventListener("DOMContentLoaded", function() {
        const loaderContainer = document.getElementById("loader-container");
        loaderContainer.classList.add("show");
        setTimeout(function() {
            loaderContainer.classList.remove("show");
            loaderContainer.style.display = "none";
        }, 2000);
    });

    window.addEventListener("load", function() {
        setTimeout(function() {
            const loaderContainer = document.getElementById("loader-container");
            loaderContainer.classList.remove("show");
            loaderContainer.style.display = "none";
        }, 2000);
    });


</script>

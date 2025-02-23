<div class="loader-container" id="loader-container">
    <div class="loader"></div>
    <div class="text-loader">AIPT-UINSU</div>
</div>


<header id="header-wrap">
    <!-- Navbar Start -->
    <nav class="nav">
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
                    <li><a class="link" href="/daftar-dokumen">Dokumen</a></li>
                    @if (Auth::user()->role == 'admin')
                        <li><a class="link" href="/admin">Admin</a></li>
                    @elseif (Auth::user()->role == 'superadmin')
                        <li><a class="link" href="/superadmin">Superadmin</a></li>
                    @endif
                    <li><a class="link" href="/logout">Logout</a></li>
                    
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
    });

    window.addEventListener("load", function() {
        const loaderContainer = document.getElementById("loader-container");
        loaderContainer.classList.remove("show");
        loaderContainer.style.display = "none";
    });
</script>

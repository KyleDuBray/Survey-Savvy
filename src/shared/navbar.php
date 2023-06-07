<?php

// get root of URL since navbar among multiple different pages/paths
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';

$base = $httpProtocol . '://' . $_SERVER['HTTP_HOST'] . '/';

$publicNav = " <nav class='navbar'>
    <a href=" . $base . "public/home.php>" . "
    <img class='logo' src='../img/logo-name.svg' alt='logo with name'></a>
    <div class='nav-links'>" .
    formatLink("./login.php", "login") .
    formatLink("./register.php", "register") . "</div></nav>" .
    "</div>
        <input class='checkbox' type='checkbox' name='' id='' />
        <div class='hamburger-lines'>
          <span class='line line1'></span>
          <span class='line line2'></span>
          <span class='line line3'></span>
        </div>  
        <div class='menu-items'>
        " .
    formatMenuItem("./login.php", "login") .
    formatMenuItem("./register.php", "register") .
    " </div> 
    </nav>";

$privateNav = " <nav class='navbar'>
        <a href=" . $base . "private/home.php>" . "
        <img src='../img/logo-name.svg' alt='logo with name'></a>
        <div class='nav-links'>" .
    formatLink("./browsesurveys.php", "browse") .
    formatLink("./mysurveys.php", "my surveys") .
    formatLink("./creationForm.php", "create") .
    formatLink("./profile.php", "profile") .
    formatLink("../includes/logout.inc.php", "logout") .
    "</div>
        <input class='checkbox' type='checkbox' name='' id='' />
        <div class='hamburger-lines'>
          <span class='line line1'></span>
          <span class='line line2'></span>
          <span class='line line3'></span>
        </div>  
        <div class='menu-items'>
        " .
    formatMenuItem("./browsesurveys.php", "browse") .
    formatMenuItem("./mysurveys.php", "my surveys") .
    formatMenuItem("./creationForm.php", "create") .
    formatMenuItem("./profile.php", "profile") .
    formatMenuItem("../includes/logout.inc.php", "logout") .
    "
        </div>
    </nav>
    ";


if (!isset($_SESSION['loggedin'])) {
    echo $publicNav;
} else {
    echo $privateNav;
}

function formatLink($href, $text)
{
    return "<a class='link' href='" . $href . "'>" .
        $text . "</a>";
}

function formatMenuItem($href, $text)
{
    return "<a class='menu-item' href='" . $href . "'>" .
        $text . "</a>";
}
?>
<style>
    .checkbox {
        position: fixed;
        right: 10px;
        display: block;
        height: 32px;
        width: 32px;
        top: 20px;
        z-index: 5;
        opacity: 0;
        cursor: pointer;
    }

    .hamburger-lines {
        position: fixed;
        right: 10px;
        top: 20px;
        display: none;
        height: 26px;
        width: 32px;
        z-index: 2;
        flex-direction: column;
        justify-content: space-between;
    }

    .hamburger-lines .line {
        display: block;
        height: 4px;
        width: 100%;
        border-radius: 10px;
        background: #0e2431;
    }

    .hamburger-lines .line1 {
        transform-origin: 0% 0%;
        transition: transform 0.4s ease-in-out;
    }

    .hamburger-lines .line2 {
        transition: transform 0.2s ease-in-out;
    }

    .hamburger-lines .line3 {
        transform-origin: 0% 100%;
        transition: transform 0.4s ease-in-out;
    }

    .menu-items {
        background-color: aliceblue;
        padding-top: 25%;
        position: absolute;
        box-shadow: inset 0 0 2000px rgba(255, 255, 255, .5);
        height: 99vh;
        width: 99vw;
        transform: translate(-150%);
        display: none;
        flex-direction: column;
        margin-left: -40px;
        transition: transform 0.5s ease-in-out;
        text-align: center;
    }

    .menu-item {
        margin: 10px auto;
        width: 50%;
        text-decoration: none;
        color: inherit;
        font-size: 20px;
        padding-bottom: 2px;
    }

    input[type="checkbox"]:checked~.menu-items {
        transform: translate(32px, -17px);
    }

    input[type="checkbox"]:checked~.hamburger-lines .line1 {
        transform: rotate(45deg);
    }

    input[type="checkbox"]:checked~.hamburger-lines .line2 {
        transform: scaleY(0);
    }

    input[type="checkbox"]:checked~.hamburger-lines .line3 {
        transform: rotate(-45deg);
    }

    input[type="checkbox"]:checked~.logo {
        display: none;
    }

    @media screen and (max-width: 925px) {
        nav {
            padding: 0 10px;
        }

        .nav-links {
            display: none;
        }

        .hamburger-lines {
            display: flex;
        }

        .menu-items {
            display: flex;
        }
    }
</style>
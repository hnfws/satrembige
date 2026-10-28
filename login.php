<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sate Rembige - Cyber Access</title>

    <link href="css/all-stylesheets.css" rel="stylesheet">

    <style>
    /* Tipografi & Dasar */
    @import url("https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,900,900italic,700italic,700");
    @import url("https://fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic,900,900italic");

    body {
        background: #ffff;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-family: 'Lato', sans-serif;
        height: 100vh;
    }

    /* Container Utama */
    .main-wrapper {
        position: relative;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        /* Gradient ganti ke nuansa bara api (dark red to black) */
        background: radial-gradient(circle at center, #2b0505 0%, #000 100%);
    }

    /* =========================================
               H1 / Header Futuristic 
        ========================================= */
    h1 {
        animation: text-glow 2s ease-out infinite alternate;
        font-family: 'Playfair Display', serif;
        color: #f53700;
        /* Warna Merah Cabai Rembige */
        font-size: 3rem;
        font-weight: bold;
        letter-spacing: 5px;
        margin-bottom: 5px;
        text-transform: uppercase;
        z-index: 10;
    }

    .subtitle {
        font-family: 'Playfair Display', serif;
        color: #ffff;
        /* Warna Lemak/Bumbu Kuning */
        font-size: 0.9rem;
        letter-spacing: 3px;
        margin-bottom: 40px;
        z-index: 10;
        opacity: 0.8;
    }

    /* =========================================
               Stark Login Form (Cyber Rembige)
        ========================================= */
    .stark-login {
        position: relative;
        z-index: 5;
    }

    .stark-login form {
        background: rgba(15, 0, 0, 0.85);
        /* Dark Red Tint */
        border: 2px solid #f53700;
        /* Border Merah Cabai */
        box-shadow: 0 0 25px rgba(245, 55, 0, 0.4), inset 0 0 15px rgba(245, 55, 0, 0.2);
        border-radius: 15px;
        padding: 40px;
        width: 450px;
        backdrop-filter: blur(8px);
        transition: 0.5s all;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Scanline effect ala Cyberpunk */
    .stark-login form::before {
        content: " ";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(245, 55, 0, 0.1) 50%),
            linear-gradient(90deg, rgba(255, 0, 0, 0.05), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.05));
        background-size: 100% 2px, 3px 100%;
        pointer-events: none;
        z-index: 2;
    }

    .stark-login form:hover {
        box-shadow: 0 0 50px rgba(245, 55, 0, 0.6);
        border-color: #ffff;
        /* Aksen Kuning saat hover */
    }

    .stark-login input {
        background: rgba(0, 0, 0, 0.7);
        border: 1px solid #f53700;
        border-radius: 4px;
        color: #fff;
        display: block;
        font-size: 1.2rem;
        height: 50px;
        margin: 15px auto;
        padding: 0 15px;
        width: 100%;
        transition: 0.3s;
        font-family: 'Lato', sans-serif;
    }

    .stark-login input:focus {
        outline: none;
        border-color: #ffff;
        box-shadow: 0 0 15px rgba(255, 204, 0, 0.3);
        background: rgba(40, 0, 0, 0.6);
    }

    .stark-login button {
        background: #f53700;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        font-family: 'Lato', sans-serif;
        font-size: 1.1rem;
        font-weight: bold;
        height: 50px;
        margin-top: 25px;
        text-transform: uppercase;
        width: 100%;
        transition: 0.4s;
        letter-spacing: 2px;
        position: relative;
    }

    .stark-login button:hover {
        background: #ffff;
        color: #000;
        box-shadow: 0 0 25px #ffff;
    }

    /* =========================================
               Background Spinner & HUD
        ========================================= */
    #circle1 {
        animation: rotate-circle 15s linear infinite;
        border-radius: 50%;
        border: 2px dashed #f53700;
        height: 650px;
        width: 650px;
        position: absolute;
        opacity: 0.15;
        z-index: 1;
    }

    /* Tambahan elemen bara api melayang */
    .embers {
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: url('https://www.transparenttextures.com/patterns/asfalt-dark.png');
        opacity: 0.3;
        pointer-events: none;
    }

    @keyframes rotate-circle {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes text-glow {
        0% {
            text-shadow: 0 0 10px #f53700;
        }

        100% {
            text-shadow: 0 0 25px #f53700, 0 0 10px #ffff;
        }
    }

    footer {
        background: #000;
        width: 100%;
        z-index: 10;
        border-top: 1px solid #2b0505;
    }

    .dark-texture-02 {
        background: #080202;
        padding: 20px 0;
    }
    </style>
</head>

<body>
    <div id="preloader">
        <div id="status">
            <div class="logo"><img src="./images/logos/logoputih.png" alt="Logo"></div>
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="embers"></div>
        <div id="circle1"></div>

        <h1>SATE-REMBIGE</h1>
        <div class="subtitle">AUTHENTIC SPICY PROTOCOL </div>

        <section class="stark-login">
            <form action="home.php" method="POST">
                <div id="fade-box">
                    <input type="text" name="username" placeholder="USER_ID">
                    <input type="password" name="password" placeholder="BUMBU_KEY">
                    <button type="submit">Sign In</button>
                </div>
                <div style="margin-top: 20px;">
                    <a href="#"
                        style="color: #f53700; font-size: 11px; text-decoration: none; opacity: 0.7; font-family: 'Lato', sans-serif;">Reset
                        Security Passphrase?</a>
                </div>
            </form>
        </section>
    </div>

    <footer>
        <div class="container-fluid">
            <div class="row row1" style="padding: 40px 0; background: rgba(10,0,0,0.5);">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <div class="logo">
                        <img src="./images/logos/logoputih.png" class="img-responsive center-block" alt=""
                            style="max-width: 120px; filter: drop-shadow(0 0 10px #f53700);">
                    </div>
                    <ul class="social-icons"
                        style="margin-top: 25px; list-style: none; display: flex; justify-content: center; gap: 30px; padding: 0;">
                        <li><a href="#" style="color: #fff; transition: 0.3s;"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" style="color: #fff; transition: 0.3s;"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" style="color: #fff; transition: 0.3s;"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="dark-texture-02">
            <div class="container">
                <div class="row row2">
                    <div class="col-lg-6 col-md-6">
                        <ul class="links"
                            style="list-style: none; padding: 0; display: flex; gap: 20px; font-family: 'Lato', sans-serif; font-size: 10px;">
                            <li><a href="" style="color: #555; text-decoration: none; letter-spacing: 1px;">TERMINAL</a>
                            </li>
                            <li><a href=""
                                    style="color: #555; text-decoration: none; letter-spacing: 1px;">ENCRYPTION</a></li>
                            <li><a href=""
                                    style="color: #555; text-decoration: none; letter-spacing: 1px;">KITCHEN_OS</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 text-right">
                        <div class="copyright" style="color: #444; font-family: 'Lato', sans-serif; font-size: 10px;">
                            EST 2026 // SYSTEM BY <a href="" style="color: #f53700; text-decoration: none;">MUHANA
                                FAWWAS SAUSAN</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery-1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom/custom.js"></script>
</body>

</html>
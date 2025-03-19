<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lilyrose Hotel</title>
    <link rel="stylesheet" href="lily.css">
</head>
<body>

<header>
    <h1>Lilyrose Hotel</h1>
    <div class="header-icons">
        <a href="profile.php"><img src="profile-icon.png" alt="👤 Profile"></a>
    </div>
</header>

<nav>
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#gallery">Gallery</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</nav>

<main id="home">
    <h2>Welcome to Lilyrose Hotel</h2>
    <p>Experience luxury and comfort with our top-tier services.</p>
</main>

<section id="services">
    <h2>Our Services</h2>
    <div id="services-container"></div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("fetch_services.php")
            .then(response => response.text())
            .then(data => {
                document.getElementById("services-container").innerHTML = data;
            })
            .catch(error => console.error("Error loading services:", error));
    });
</script>

<section id="gallery">
    <h2>Gallery</h2>
    <div id="gallery-container"></div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("fetch_gallery.php")
            .then(response => response.text())
            .then(data => {
                document.getElementById("gallery-container").innerHTML = data;
            })
            .catch(error => console.error("Error loading gallery:", error));
    });
</script>

<main>
  <section id="contact">
      <h2>Contact Us</h2>
      <p>📞 Call: <a href="tel:+254114128916">+254114128916</a></p>
      <p>📩 SMS: <a href="sms:+254114128916">+254114128916</a></p>
      <p>📧 Email: <a href="mailto:ndungibenmburu009@gmail.com">ndungibenmburu009@gmail.com</a></p>
      <p>💬 WhatsApp: <a href="https://wa.me/254114128916">+254114128916</a></p>
      <p>🔵 Facebook: <a href="https://facebook.com/KenyanArgon">Kenyan Argon</a></p>
      <p>📸 Instagram: <a href="https://instagram.com/KenyanArgon">Kenyan Argon</a></p>
      <p>🐦 Twitter: <a href="https://twitter.com/KenyanArgon">Kenyan Argon</a></p>
  </section>
</main>

<footer>
    <p>&copy; 2025 Lilyrose Hotel | All Rights Reserved</p>
    <a href="cart.html" id="cart-icon"><span>🛒</span></a>
</footer>

<script src="lily.js"></script>
</body>
</html>

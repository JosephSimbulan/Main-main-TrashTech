<?php
// contact.php
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - TrashTech</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #512da8;
            color: white;
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .nav-menu {
            display: flex;
            gap: 20px;
        }
        .header .nav-menu a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .header .cta-button {
            font-size: 18px;
            text-decoration: none;
            color: white;
            background-color: #333;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .contact-info {
            margin-top: 20px;
        }
        .contact-info p {
            margin: 5px 0;
        }
        .contact-form {
            margin-top: 20px;
        }
        .contact-form input, .contact-form textarea, .contact-form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .contact-form button {
            font-size: 18px;
            text-decoration: none;
            color: white;
            background-color: #512da8;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .map {
            margin-top: 20px;
        }
        .faq {
            margin-top: 40px;
        }
        .faq h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .faq p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .footer {
            background-color: #333;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
        }
        .footer .social-media, .footer .nav-links, .footer .utility-pages {
            display: flex;
            flex-direction: column;
        }
        .footer a {
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">TrashTech</div>
        <div class="nav-menu">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="services.php">Services</a>
            <a href="contact.php">Contact</a>
            <a href="pages.php">Pages</a>
        </div>
        <a href="contact.php" class="cta-button">Get in touch</a>
    </div>
    <div class="container">
        <h1>Get in touch</h1>
        <p>We'd love to hear from you. Reach out to TrashTech for any inquiries or support.</p>
        <div class="contact-form">
            <form action="submit_contact.php" method="post">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="phone" placeholder="Your Phone Number" required>
                <select name="subject" required>
                    <option value="" disabled selected>Select Subject</option>
                    <option value="general">General Inquiry</option>
                    <option value="support">Support</option>
                    <option value="feedback">Feedback</option>
                </select>
                <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
        <div class="contact-info">
            <p><strong>Address:</strong> 123 TrashTech Street, Tech City, TX 12345</p>
            <p><strong>Phone:</strong> +123 456 7890</p>
            <p><strong>Email:</strong> <a href="mailto:TrashTech@gmail.com">TrashTech@gmail.com</a></p>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537353153167!3d-37.81627927975195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d1f9f3b0f1e!2sTrashTech!5e0!3m2!1sen!2sus!4v1614311234567!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="faq">
            <h2>Have any questions?</h2>
            <p><strong>How to Update My Profile Information?</strong></p>
            <p>To update your profile information, go to the profile settings page and make the necessary changes.</p>
            <p><strong>How to Change My Password?</strong></p>
            <p>To change your password, go to the account settings page and follow the instructions to reset your password.</p>
            <p><strong>How to Modify My Subscription Plan with TrashTech?</strong></p>
            <p>To modify your subscription plan, visit the subscription management page and select the plan that best suits your needs.</p>
        </div>
    </div>
    <div class="footer">
        <div class="social-media">
            <a href="https://www.facebook.com/yourpage" target="_blank">Facebook</a>
            <a href="https://www.twitter.com/yourpage" target="_blank">Twitter</a>
            <a href="https://www.linkedin.com/yourpage" target="_blank">LinkedIn</a>
            <a href="https://www.instagram.com/yourpage" target="_blank">Instagram</a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
        </div>
        <div class="utility-pages">
            <a href="404.php">404 Page</a>
            <a href="terms.php">Terms of Service</a>
        </div>
    </div>
</body>
</html>
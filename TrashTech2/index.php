<!DOCTYPE html>
<html>
<head>
    <title>TrashTech</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Set uniform background color */
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: linear-gradient(to right, #760b9a, #78139a, #924fa8, #d1c4e9);
            color: white;
}
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .login-button {
            font-size: 18px;
            text-decoration: none;
            color: white;
            background-color: #333;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 40px; /* Adjust padding to align with header */
            min-height: 100vh;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }
        .left-section, .right-section {
            width: 50%;
            padding: 20px;
            box-sizing: border-box;
        }
        .left-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-right: 40px; /* Align text with header */
        }
        .left-section h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .left-section h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .left-section p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .left-section .cta-button {
            font-size: 18px;
            text-decoration: none;
            color: white;
            background: linear-gradient(to right, #760b9a, #760b9a);
            padding: 15px 30px;
            border-radius: 5px;
            text-align: center;
            width: 200px;
        }
        .right-section {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .right-section img {
            width: 600px;
            height: 400px;
            object-fit: cover;
            background-color: #e0e0e0;
        }
        .section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 40px; /* Adjust padding to align with header and container */
            background-color: #f4f4f4;
        }
        .section-content {
            width: 50%;
            padding-left: 40px; /* Align text with above sections */
            box-sizing: border-box;
        }
        .section h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .section p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .section img {
            width: 600px;
            height: 400px;
            object-fit: cover;
        }
        .message-section {
            text-align: center;
            padding: 50px 40px;
            background-color: #f4f4f4;
        }
        .message-section p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">TrashTech</div>
        <a href="login.php" class="login-button">Login</a>
    </div>
    <div class="container">
        <div class="left-section">
            <h1>Welcome to TrashTech</h1>
            <h2>Where your waste is in our hands.</h2>
            <p>Empowering Tomorrow’s Environment Today: Let TrashTech Handle Your Waste.</p>
            <a href="register_company.php" class="cta-button">Register Your Company Here!</a>
        </div>
        <div class="right-section">
            <img src="images/index_2.jpg">
        </div>
    </div>
    <div class="section">
        <div class="section-content">
            <h2>Your Seamless Path to Sustainable Solutions</h2>
            <p>At TrashTech, we're committed to making sustainability effortless for everyone. With our user-friendly platform, even the most complex waste management tasks become simple and straightforward. Join us in paving the way towards a cleaner, greener future, where sustainable solutions are as easy to use as they are impactful. Welcome to TrashTech, where sustainability is simplified for you.</p>
        </div>
        <div class="right-section">
            <img src="images/index_2.png">
        </div>
    </div>
    <div class="section">
        <div class="right-section">
            <img src="images/revol pic 1.png">
        </div>
        <div class="section-content">
            <h2>Revolutionary Waste Sorting</h2>
            <p>TrashTech introduces a futuristic approach to waste management, utilizing state-of-the-art Arduino and IoT technology to streamline sorting processes. Say goodbye to manual sorting hassles and hello to a hassle-free, efficient solution that delights our customers.</p>
        </div>
    </div>
    <div class="section">
        <div class="right-section">
            <img src="images/byte pics 1.png">
        </div>
        <div class="section-content">
            <h2>Environmental Heroism in Every Byte</h2>
            <p>TrashTech isn't just a waste management tool; it's an environmental superhero in disguise. With its innovative technology and cutting-edge approach, TrashTech champions the cause of sustainability. By revolutionizing waste management practices, we're not just cleaning up messes; we're paving the way for a brighter, greener tomorrow. Join us in the adventure of environmental heroism with TrashTech, where every data byte is a step towards a cleaner, greener future.</p>
        </div>
    </div>
    <div class="section">
        <div class="right-section">
            <img src="images/solutions pic 1.png">
        </div>
        <div class="section-content">
            <h2>Smart Solutions for Sustainable Impact</h2>
            <p>TrashTech doesn't just collect data; it empowers you with actionable insights. Our real-time analytics provide a deeper understanding of waste composition and trends, giving you the power to make informed decisions that positively impact the environment. Join us in shaping a cleaner, greener future with TrashTech.</p>
        </div>
    </div>
    <div class="message-section">
        <h2>A Message from TrashTech:</h2>
        <p>Join us in revolutionizing waste management with TrashTech! Our mission is clear: to transform how we handle waste by leveraging cutting-edge technology. With our automated waste segregation systems, we're not just reducing pollution and promoting sustainability – we're paving the way for a cleaner, greener future. Imagine a world where every recyclable material is sorted with precision and efficiency, where waste is no longer seen as a problem but as a valuable resource. TrashTech isn't just a solution; it's a vision of a better tomorrow. Together, let's embrace innovation, empower our communities, and build a world where environmental stewardship is the norm. Choose TrashTech and be part of the solution!</p>
    </div>
    <div class="footer">
        <p>©2024 TrashTech</p>
    </div>
</body>
</html>

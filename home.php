<?php
session_start();
require 'config.php';

// FIRST: Protect Page
if(!isset($_SESSION['name'])){
  $_SESSION['error_msg'] = "You must login first!";
  header("Location: login.php");
  exit();
}

// SECOND: Fetch Flash Messages
$success_msg = $_SESSION['success_msg'] ?? "";
$error_msg   = $_SESSION['error_msg'] ?? "";

// THIRD: Clear Flash Messages
unset($_SESSION['success_msg']);
unset($_SESSION['error_msg']);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>food web</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/regular.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css"
    />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- custom css -->
    <link rel="stylesheet" href="main.css" />
    
  </head>
  <body>
    <!-- ALERT MESSAGES -->
    <div class="container mt-3">
        <?php if ($error_msg): ?>
            <div class="alert alert-danger"><?= $error_msg ?></div>
        <?php endif; ?>

        <?php if ($success_msg): ?>
            <div class="alert alert-success"><?= $success_msg ?></div>
        <?php endif; ?>
    </div>
    <header>
      <div class="navbar">
        <div class="container">
          <nav>
            <div class="navbar_brand">
              <a href="#">Binge <span>Bites</span></a>
            </div>
            <div class="toggler" id="toggler">
              <span><i class="fa-solid fa-bars"></i></span>
            </div>
            <div class="nav_items">
              <ul class="navlist" id="navlist">
                <li>
                  <a href="#" class="active"><span>Home</span></a>
                </li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="#stats">Stats</a></li>
                <li><a href="#feedback">Feedback</a></li>
                <li><a href="#contact_us">Contact Us</a></li>

                <li><a href="#" class="text-warning log-p">User:<?= $_SESSION['name']; ?></a></li>
                <li><a href="logout.php" class="text-dark log-p btn btn-warning w-100 w-md-auto fw-bold">Logout</a></li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>

    <main>
      <section class="banner">
        <div class="container">
          <div class="content">
            <h1>YOUR CRAVINGS END HERE!</h1>
            <p>Best Continental & Indian Cuisines</p>
            <a href="order.php?cat=All" class="button btn_white">Explore More</a>
          </div>
        </div>
      </section>

      <section class="about section_padding" id="about">
        <div class="container">
          <div class="section_content">
            <h2 class="section_heading">About</h2>
            <p class="section_text">
              We’re passionate determined about bringing you the best in
              food—from mouthwatering recipes and cooking tips to the latest in
              culinary trends.
            </p>
          </div>

          <div class="about_text_img">
            <figure>
              <img src="./imageCss/food about img.jpg" alt="about" />
            </figure>

            <div class="about_text">
              <ul>
                <li type="disc">
                  We’re passionate about bringing you the best in food—from
                  mouthwatering recipes and cooking tips to the latest in
                  culinary trends.
                </li>
                <li type="disc">
                  Whether you're a home cook, a foodie, or just looking for your
                  next favorite meal, we’re here to inspire and guide you. Our
                  mission is to make cooking enjoyable, accessible, and
                  delicious for everyone.
                </li>
                <li type="disc">
                  Join us on a flavorful journey where every dish tells a story.
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <section class="services" id="services">
        <div class="section_padding">
          <div class="container">
            <div class="section_content">
              <h2 class="section_heading">Our Services</h2>
              <p class="section_text">
                Made with love. Served with passion
              </p>
            </div>

            <div class="service_blocks">
              <div class="service_item first">
                <div class="service_item_text">
                  <h4>Breakfast</h4>
                  <p>
                    <i>Fresh bites to kick-start your day</i>
                  </p>
                </div>
                <figure>
                  <img src="./imageCss/breakfast.jpg" alt="breakfast" />
                </figure>
                <div class="overlay2">
                  <a href="order.php?cat=breakfast"><span>Order Now</span></a> 
                </div>
              </div>

              <div class="service_item second">
                <div class="service_item_text">
                  <h4>Lunch</h4>
                  <p>
                    <i>Your perfect lunch break starts here</i>
                  </p>
                </div>
                <figure>
                  <img src="./imageCss/lunch.jpg" alt="lunch" />
                </figure>
                <div class="overlay2">
                 <a href="order.php?cat=lunch"><span>Order Now</span></a> 
                </div>
                
              </div>

              <div class="service_item third">
                <div class="service_item_text">
                  <h4>Dinner</h4>
                  <p>
                    <i>End your day with a delightful dinner</i>
                  </p>
                </div>
                <figure>
                  <img src="./imageCss/dinner.jpg" alt="dinner" />
                </figure>
                <div class="overlay2">
                  <a href="order.php?cat=dinner"><span>Order Now</span></a> 
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="gallery" id="gallery">
        <div class="section_padding">
          <div class="container">
            <div class="section_content">
              <h2 class="section_heading">Gallery</h2>
              <p class="section_text">
                <i>Explore the flavors through our gallery</i>
              </p>
            </div>

            <div class="gallery_menu">
              <button class="menu active2">All Flavours At A Glance</button>
              
            </div>

            <div class="gallery_images">
              <div class="gallery_blocks">
                <figure>
                  <img src="./imageCss/food1.jpg" alt="car1" />
                </figure>
                <div class="overlay">
                  <a href="order.php?cat=All"><span>Order Now</span></a>
                </div>
              </div>
              <div class="gallery_blocks">
                <figure>
                  <img src="./imageCss/food2.jpg" alt="car2" />
                </figure>
                <div class="overlay">
                  <a href="order.php?cat=All"><span>Order Now</span></a>
                </div>
              </div>
              <div class="gallery_blocks">
                <figure>
                  <img src="./imageCss/food3.jpg" alt="car3" />
                </figure>
                <div class="overlay">
                  <a href="order.php?cat=All"><span>Order Now</span></a>
                </div>
              </div>
              <div class="gallery_blocks">
                <figure>
                  <img src="./imageCss/food4.jpg" alt="car4" />
                </figure>
                <div class="overlay">
                 <a href="order.php?cat=All"><span>Order Now</span></a>
                </div>
              </div>
              <div class="gallery_blocks">
                <figure>
                  <img src="./imageCss/food5.jpg" alt="car5" />
                </figure>
                <div class="overlay">
                  <a href="order.php?cat=All"><span>Order Now</span></a>
                </div>
              </div>
              <div class="gallery_blocks">
                <figure>
                  <img src="./imageCss/food6.jpg" alt="car6" />
                </figure>
                <div class="overlay">
                  <a href="order.php?cat=All"><span>Order Now</span></a>
                </div>
              </div>
              <div class="gallery_blocks">
                <figure>
                  <img src="./imageCss/food7.jpg" alt="car7" />
                </figure>
                <div class="overlay">
                  <a href="order.php?cat=All"><span>Order Now</span></a>
                </div>
              </div>
              <div class="gallery_blocks">
                <figure>
                  <img src="./imageCss/food8.jpg" alt="car8" />
                </figure>

                <div class="overlay">
                  <a href="order.php?cat=All"><span>Order Now</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="stats" id="stats">
        <div class="section_padding">
          <div class="container">
            <div class="section_content">
              <h2 class="section_heading">Stats</h2>
              <p class="section_text">
                <i>Our numbers reflect our passion for quality food and exceptional service. From satisfied customers to freshly prepared meals, every statistic tells the story of trust, taste, and consistency we deliver every day.</i>
              </p>
            </div>

            <div class="numbers">
              <div>
                <h3>100,000+</h3>
                <p>Margins</p>
              </div>
              <div>
                <h3>34201+</h3>
                <p>Completed</p>
              </div>
              <div>
                <h3>152+</h3>
                <p>Projects</p>
              </div>
              <div>
                <h3>56500+</h3>
                <p>Customers</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="feedback" id="feedback">
        <div class="section_padding">
          <div class="container">
            <div class="section_content">
              <h2 class="section_heading">Customer Feedback</h2>
              <div class="testimonial">
                <p class="quote">
                  "Absolutely loved the food! Every dish was fresh, flavorful, and beautifully prepared. The service was quick, and the staff were incredibly polite. I’ve tried many places, but this one truly stands out. Highly recommended — I’ll definitely order again!"
                </p>
                <div class="author">
                  <div>
                    <img
                      src="./imageCss/testimonial image 1.jpg"
                      alt="Kristen"
                    />
                  </div>

                  <div class="author_details">
                    <strong class="author_name">Lina Mars</strong>
                    <br />
                    <br />
                    <p>Commercial Director</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="contact_us" id="contact_us">
        <div class="section_padding">
          <div class="container">
            <div class="section_content">
              <h2 class="section_heading">Contact Us</h2>
              <p class="section_text">
                We love feedback. Fill out the form below and we'll get back to
                you as soon as possible.
              </p>
              <div class="contact_container">
                <form class="contact_form">
                  <div class="name_email">
                    <input
                      type="text"
                      name="text"
                      id="text"
                      placeholder="Full Name"
                      required
                    />
                    <input
                      type="email"
                      name="email"
                      id="email"
                      placeholder="Email"
                      required
                    />
                  </div>
                  <div>
                    <textarea
                      name="message"
                      id="message"
                      placeholder="Message"
                      rows="11"
                      cols="10"
                    ></textarea>
                    <input type="submit" value="Send Your Message" />
                  </div>
                </form>
              </div>
            </div>

            <div>
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d95780.47786834063!2d2.0577873532569804!3d41.392767343529755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a49816718e30e5%3A0x44b0fb3d4f47660a!2sBarcelona%2C%20Spain!5e0!3m2!1sen!2sin!4v1748005133095!5m2!1sen!2sin"
                width="600"
                height="450"
                style="border: 0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="map">
              </iframe>
            </div>
          </div>
        </div>
      </section>
    </main>
    <script src="home.js"></script>

    <footer class="footer">
      <div class="footer_text">
        <p>
          <a href="#">Binge <span>Bites</span></a>
        </p>
        <p class="copyright">
          &copy; All Rights Reserved to <a>Binge Bites</a> pvt ltd
        </p>
      </div>

      <div class="social">
        <ul class="social_links">
          <li>
            <a href="#" class="navicons"
              ><i class="fa-brands fa-facebook-f icon4"></i
            ></a>
          </li>
          <li>
            <a href="#" class="navicons"
              ><i class="fa-brands fa-instagram icon4"></i
            ></a>
          </li>
          <li>
            <a href="#" class="navicons"
              ><i class="fa-brands fa-twitter icon4"></i
            ></a>
          </li>
          <li>
            <a href="#" class="navicons"
              ><i class="fa-solid fa-basketball icon4"></i
            ></a>
          </li>
        </ul>
      </div>
    </footer>
  </body>
</html>
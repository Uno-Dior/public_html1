<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ResiHive</title>
	<link rel="icon" type="image/x-icon" href="../data_image/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="https://kit.fontawesome.com/4d86b94a8a.js" crossorigin="anonymous"></script>
</head>

<body>
	<header>
		<div class="navigation_bar"></div>
		<div class="navbar_container" id="navbar">
			<div>
				<a href="index.php"><img src="..\data_image\LOGO.png" class="logo" alt="logo"></a>
			</div>
			<div class="toggle_btn">
				<a><img src="../data_image/Settings Button.png" class="btn_setting" alt="btn_logo"></a>
			</div>
			<div class="container">
				<ul class="navbar_links">
					<li><a href="#home" class="active">Home</a></li>
					<li><a href="#features">Rentals</a></li>
					<li><a href="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
					<li><a href="#landowner">Landowners</a></li>
				</ul>
			</div>
			<button class="btn-profile"><a href="../data_page/login_page.php" style="color: white;">Login</a></button>
		</div>
		<div class="dropdown_menu">
			<li><a href="#home">Home</a></li>
			<li><a href="#features">Rentals</a></li>
			<li><a href="#about">About</a></li>
			<li><a href="#contact">Contact</a></li>
			<li><a href="#landowner">Landowners</a></li>
			<br>
			<li>
				<p style="font-weight: 300;">Login As:</p>
			</li>
			<li><a href="../data_page/renters_login.php">Renter</a></li>
			<li><a href="../data_page/landowners_login.php">Landowner</a></li>
		</div>
	</header>
	<div class="full-wrapper">
		<!-- Background Image/Shapes -->
		<div class="hive_icon"></div>
		<div class="hexagon_icon"></div>
		<div class="sphere_icon"></div>
		<div class="comb_icon"></div>
		<!-- End of Background Image/Shapes -->

		<!-- Home Section -->
		<section id="home" class="home" src="">
			<div class="btn_container">
				<div class="body_texts"> <img src="../data_image/RESIHIVE SYMBOL.png" alt="resihive_symbol">
					<br>
					<br>
					<h1>We Find Dorms and Apartments</h1><br>
					<h4>Will Help You To Find Affordable Shared-living Experience</h4><br><br>
                    <h6>Don't have an account?</h6>
				</div>
				<div class="inner_btn_container">
					<a href="../data_page/signup_page.php" type="button" class="btn_1"> <img src="../data_image/Renters.png" alt="icon_forrenters">
						<p style="font-size:20px">Create an Account</p>
					</a>
				</div>
			</div>
		</section>
		<!-- End of Home Section -->

		<!-- Featured Items -->
		<section id="features" class="features">
			<div class="featured-items">
				<div class="next">
					<button><i class="fa-solid fa-chevron-left"></i></button>
				</div>
				<?php
                // Include the database.php file
                require_once 'mysql/conn.php';

                $mydb = new Database();

                // Fetch distinct landowner_userid values
                $landownerQuery = "SELECT DISTINCT landowner_userid FROM house_rentals";
                $landownerResult = $mydb->getConnection()->query($landownerQuery);

                // Display one item per landowner
                while ($landowner = $landownerResult->fetch_assoc()) {
                    // Fetch one rental item for each landowner
                    $fetchQuery = "SELECT * FROM house_rentals WHERE landowner_userid = ? LIMIT 1";
                    $stmt = $mydb->getConnection()->prepare($fetchQuery);
                    $stmt->bind_param('s', $landowner['landowner_userid']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are rows returned
                    if ($result->num_rows > 0) {
                        $rental = $result->fetch_assoc();
                        echo "<a href='../data_page/item_profile.php?id={$rental['house_id']}' class='items'>";
                            echo "<div class='posted-rental' data-house-type='{$rental['house_type']}'>";
                                echo "<img src='{$rental['house_image']}' alt='{$rental['house_name']}' class='house-image'><br>";
                                echo "<h1 style='margin: 0 0 3px 20px'>{$rental['house_name']}</h1>";
                                echo "<label class='item-loc' style='margin: 0 0 0 20px'>{$rental['location']}</label><br>";
                                echo "<div class='item-bottom_cont'>";
                                    echo "<div class='item-price'>Price Starts At";
                                        echo "<label for='price'>";
                                            echo "<p>&#8369;{$rental['rent_amount']}</p>";
                                        echo "</label>";
                                    echo "</div>";
                                    echo "<div class='item-features'>Available Space/s:";
                                        echo "<label for='keyfeat'>";
                                            echo "<p>{$rental['number_of_beds']}</p>";
                                        echo "</label>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</a>";
                    } else {
                        echo "<p>No rentals available.</p>";
                    }
                }
                ?>
					<div class="back">
						<button><i class="fa-solid fa-chevron-right"></i></button>
					</div>
			</div>
		</section>
		<!-- End of Feature -->

		<!-- About Section-->
		<section id="about" class="about">
			<div class="title" style="text-align: center;">
				<h2 style="color: #000038; font-size: 34px;">ABOUT US</h2> </div>
			<div class="body_text">
				<div style="width: 100%; text-align: center;">
					<h1>To Provide a Digitalized platform of finding a shared-living experience</h1>
					<p style="font-size:20px">Will Help You To Find Affordable Shared-living Experience</p>
				</div>
				<div style="width: 100%;">
					<p style="font-size:20px; padding:50px 0 20px 0; text-align: justify;">ResiHive is an innovative and reliable marketplace specifically designed to cater to the rental needs of individuals in Sta. Cruz, Laguna. This platform serves as a centralized hub for verified rental spaces, offering a diverse range of options such as dormitories, condos, and apartments. By leveraging ResiHive, users can easily discover and secure suitable accommodations in close proximity to their desired location.</p>
					<p style="font-size:20px; padding:20px 0 20px 0; text-align: justify;">The platform prioritizes the assurance of quality and legitimacy by implementing a thorough verification process for all listed rental spaces. This ensures that users can trust the accuracy of the information provided and make informed decisions when choosing their ideal living arrangement.</p>
				</div>
			</div>
		</section>
		<!-- End of About Section -->

		<!-- Contact Section -->
		<section id="contact" class="contact">
			<div class="title" style="text-align: center;">
				<h2 style="color: #000038; font-size: 34px;">CONTACT US</h2> </div>
			<div class="container" data-aos="fade-up">
				<div class="section-letter">
					<p>"Your feedback is crucial! Contact us to help enhance our website and provide you with an even better service. We value your input in making improvements for an improved user experience."</p>
				</div>
				<div class="contact_table">
					<div class="contact_location">
						<div class="info">
							<div class="a01"> <i class="fa-solid fa-location-dot"></i>
								<div class="b01">
									<h4>Location:</h4>
									<p>Bubukal, Santa Cruz, Laguna, Phlippines </p>
								</div>
							</div>
							<div class="a01"> <i class="fa-solid fa-envelope"></i>
								<div class="b01">
									<h4>Email:</h4>
									<p>resihive@resihive.tech</p>
								</div>
							</div>
							<div class="a01"> <i class="fa-solid fa-phone"></i>
								<div class="b01">
									<h4>Call:</h4>
									<p>+639197355256</p>
								</div>
							</div>
							<iframe src="https://maps.google.com/maps?width=100%25&amp;height=290&amp;hl=en&amp;q=Bubukal,%20Santa%20Cruz,%20Laguna,%20Philippines+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
						</div>
					</div>
					<div class="contact_form">
						<form id="contact_form" action="mail.php" method="post" class="email-form">
							<div class="row_name">
								<div class="form-group">
									<label for="name">Your Name</label>
									<input type="text" name="name" class="form-control" id="name" required> </div>
								<div class="form-group">
									<label for="name">Your Email</label>
									<input type="email" class="form-control" name="email" id="email" required> </div>
							</div>
							<div class="form-group">
								<label for="name">Subject</label>
								<input type="text" class="form-control" name="subject" id="subject" required> </div>
							<div class="form-group">
								<label for="name">Message</label>
								<textarea class="form-control" name="message" rows="9" required></textarea>
							</div>
							<div class="my-3">
								<div class="loading">Loading</div>
								<div class="error-message"></div>
								<div class="sent-message">Your message has been sent. Thank you!</div>
							</div>
							<div class="text-center">
								<button type="submit" name="send" id="contact-submit">Send Message</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End Contact Section -->
		</section>
		<!-- End of Contact Section -->

		<!-- Landowner Section -->
		<section id="landowner" class="landowner">
			<div class="title" style="text-align: center;">
				<h2 style="color: #000038; font-size: 34px;">LANDOWNERS</h2> </div>
			<div class="body_text">
				<div style="width: 100%; text-align: center;">
					<h1>We Can Help You to Connect with Tenants <br>platform of finding a <br>shared-living experience</h1>
					<p style="font-size:20px">To provide a digitalized platform for finding a shared-living experience.</p>
				</div>
				<div style="width: 100%;" class="landman"> <img src="../data_image/landowner.png" alt="landman"> </div>
			</div>
		</section>
		<!-- End of Landowner Section -->

		<!-- Footer -->
		<div class="footer">
			<div class="bg_footer"></div>
			<div class="footer_container">
				<div class="left_footer"> <img src="..\data_image\RESIHIVE SYMBOL2.png" alt="resihive_symbol">
					<br>
					<br>
					<div class="footer_socials"> <a href="#"><i class="fa-brands fa-facebook"></i></a> <a href="#"><i class="fa-brands fa-instagram"></i></a> </div>
					<div class="footer_contacts">
						<ul>
							<li><a><i class="fa-solid fa-phone"></i>(+63) 919 7355 256</a></li>
							<li><a><i class="fa-solid fa-envelope"></i>ResiHive@gmail.com</a></li>
						</ul>
					</div>
				</div>
				<div class="right_footer">
					<div class="center_column">
						<h3>Navigate</h3>
						<ul class="box">
							<li><a href="#home" class="active">Home</a></li>
							<li><a href="#about">About</a></li>
							<li><a href="#contact">Contact</a></li>
							<li><a href="#landowner">Landowners</a></li>
						</ul>
					</div>
					<div class="right_column">
						<h3>Legal and Policies</h3>
						<ul class="box">
							<li><a href="#">Terms of Services</a></li>
							<li><a href="#">Privacy</a></li>
							<li><a href="#">Cookie Policy</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="watermark">
				<p>by &copy;ResiHive 2023</p>
			</div>
		</div>
		<!-- End of Footer -->
	</div>

	<!-- Messenger Chat Plugin Code -->
	<div id="fb-root"></div>
	<!-- Your Chat Plugin code -->
	<div id="fb-customer-chat" class="fb-customerchat"> </div>
	<script>
	var chatbox = document.getElementById('fb-customer-chat');
	chatbox.setAttribute("page_id", "192946063894077");
	chatbox.setAttribute("attribution", "biz_inbox");
	</script>
	<!-- Your SDK code -->

	<script>
	window.fbAsyncInit = function() {
		FB.init({
			xfbml: true,
			version: 'v18.0'
		});
	};
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if(d.getElementById(id)) return;
		js = d.createElement(s);
		js.id = id;
		js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>

	<script>
	/* When the user clicks on the button, 
	toggle between hiding and showing the dropdown content */
	function myFunction() {
		document.getElementById("myDropdown").classList.toggle("show");
	}
	// Close the dropdown if the user clicks outside of it
	window.onclick = function(event) {
		if(!event.target.matches('.btn-profile')) {
			var dropdowns = document.getElementsByClassName("dropdown-content");
			var i;
			for(i = 0; i < dropdowns.length; i++) {
				var openDropdown = dropdowns[i];
				if(openDropdown.classList.contains('show')) {
					openDropdown.classList.remove('show');
				}
			}
		}
	}
	</script>

	<script>
	// Function to scroll to a specific section, considering navbar height
	function scrollToSection(sectionId) {
		var section = document.getElementById(sectionId);
		var navbarHeight = document.querySelector('.navbar_container').offsetHeight; // Adjust this line based on your actual navbar class or ID
		var offset = section.getBoundingClientRect().top - navbarHeight;
		window.scrollBy({
			top: offset,
			behavior: 'smooth'
		});
	}
	// Attach click event listeners to the navigation links
	document.querySelectorAll('.navbar_links a').forEach(link => {
		link.addEventListener('click', function(e) {
			e.preventDefault(); // Prevent default link behavior
			var sectionId = this.getAttribute('href').substring(1); // Get the section ID from the href attribute
			scrollToSection(sectionId); // Scroll to the target section
			// Remove "active" class from all links
			document.querySelectorAll('.navbar_links a').forEach(link => {
				link.classList.remove('active');
			});
			// Add "active" class to the clicked link
			this.classList.add('active');
		});
	});
	// Close the dropdown menu when a link is clicked
	document.querySelectorAll('.dropdown_menu a').forEach(link => {
		link.addEventListener('click', function() {
			document.querySelector('.dropdown_menu').classList.remove('open');
		});
	});
	const toggleBtn = document.querySelector('.toggle_btn');
	const dropDownMenu = document.querySelector('.dropdown_menu');
	toggleBtn.onclick = function() {
		dropDownMenu.classList.toggle('open');
	};
	</script>

	<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Check if there is a success parameter in the URL
		const urlParams = new URLSearchParams(window.location.search);
		const successParam = urlParams.get('success');
		// If the success parameter is true, show the success message and scroll to #contact
		if(successParam === 'true') {
			document.querySelector(".sent-message").style.display = "block";
			// Optional: Scroll to the #contact section after a short delay (adjust the delay as needed)
			setTimeout(function() {
				const contactSection = document.getElementById('contact');
				if(contactSection) {
					contactSection.scrollIntoView({
						behavior: 'smooth'
					});
				}
				// Remove the success parameter from the URL
				history.replaceState(null, document.title, window.location.pathname);
			}, 0); // 3000 milliseconds (3 seconds), you can adjust this value
		}
	});
	</script>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		const featuredItems = document.querySelector('.featured-items');
		const nextButton = document.querySelector('.featured-items .next button');
		const backButton = document.querySelector('.featured-items .back button');
		let currentPosition = 0;
		nextButton.addEventListener('click', function() {
			currentPosition += 100; // Adjust this value based on your item width
			updatePosition();
		});
		backButton.addEventListener('click', function() {
			currentPosition -= 100; // Adjust this value based on your item width
			updatePosition();
		});

		function updatePosition() {
			const maxPosition = (featuredItems.children.length - 1) * 100;
			currentPosition = Math.max(0, Math.min(currentPosition, maxPosition));
			const items = document.querySelectorAll('.featured-items .items');
			items.forEach(item => {
				item.style.transition = 'all .9s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
				item.style.left = `-${currentPosition}%`;
			});
			// Remove the transition class after the animation completes
			setTimeout(() => {
				items.forEach(item => {
					item.style.transition = '';
				});
			}, 1000);
		}
	});
	</script>

</body>

</html>
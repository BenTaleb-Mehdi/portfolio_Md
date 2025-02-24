<?php
include 'connectionDb.php';
session_start();



$id_address = $_SERVER['REMOTE_ADDR'];
$stmt = $conn->prepare('INSERT INTO `visiters` (count) values (?)');
$stmt->bind_param('i', $id_address);
$stmt->execute();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // التحقق مما إذا كان النموذج الأول قد تم إرساله
    if (isset($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['phone'], $_POST['message'])) {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $message = trim($_POST['message']);
        $date = date('Y-m-d'); 

        $message_error = "";

        // التحقق من أن جميع الحقول مملوءة
        if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($message)) {
            $message_error = "Enter all information, please.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message_error = "Invalid email format.";
        } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
            $message_error = "Invalid phone number format.";
        } else {
            $stmt = $conn->prepare('INSERT INTO `messages` (`first_name`, `last_name`, `Email`, `phone`, `message`, `date`) VALUES (?, ?, ?, ?, ?, ?)');
            if ($stmt) {
                $stmt->bind_param('ssssss', $fname, $lname, $email, $phone, $message, $date);
                $stmt->execute();
                $stmt->close();
                $_SESSION['message_success'] = "Message sent successfully."; 
                header('Location: portfolio.php');
                exit;
            }
        }
    }

    // التحقق مما إذا كان نموذج المتابعين قد تم إرساله
    if (isset($_POST['emailf'])) {
        $emailf = trim($_POST['emailf']);
        $fullname = trim($_POST['fullname']);

        if (!empty($emailf) && filter_var($emailf, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->prepare('INSERT INTO `followrs`(`email`,`fullname`) VALUES (?,?)');
            if ($stmt) {
                $stmt->bind_param('ss', $emailf,$fullname);
                $stmt->execute();
                $stmt->close();
                $_SESSION['follow_success'] = "Successfully followed.";
                header('Location: portfolio.php');
                exit;
            }
        } else {
            $_SESSION['follow_error'] = "Invalid email format.";
        }
    }
}


$count = $conn->prepare('SELECT COUNT(*) AS TOTAL_FOLLOWERS FROM `followrs`');
$count->execute();
$FOLLOWERS = $count->get_result();
if($count){
  $row_followers = $FOLLOWERS->fetch_assoc();
  $TOTAL_FOLLOWERS = $row_followers['TOTAL_FOLLOWERS'];

}
$count->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="portfolio.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
      integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mehdi Ben Taleb</title>
  </head>
  <body>
     
    <div class="btn0scroll">
      <button class="buttonscrollA0"><i class="bx bxs-chevron-up"></i></button>
    </div>
    <div class="formFollow">
      <div class="titleFollow">
        <h2>Follow Mehdi BenTaleb</h2>
        <div class="closeFormFpllow">
          <i class="bx bx-x"></i>
        </div>
      </div>

      <div class="follow">
        <div class="contentSoacial">
          <div class="emilcontent">
            <div class="logoemail">
              <i class="bx bx-mail-send"></i>
            </div>
            <div class="emillink">
              <h2>Send me an email</h2>
              <a href="">mehdibentaleb548@gmail.com</a>
            </div>
          </div>
          <div class="MysocialMedia">
            <a href=""> <i class="bx bxl-instagram"></i></a>
            <a href=""> <i class="bx bxl-facebook"></i></a>
            <a href=""> <i class="bx bxl-linkedin"></i></a>
            <a href=""><i class="bx bxl-github"></i></a>
          </div>
        </div>

        <form method="POST" class="followbyEmail">
          <h2>Enter your email address to receive the latest updates.</h2>
          <label>Enter a full name :</label>
          <input type="text" placeholder="Enter a full name ..." name="fullname">
          <label>Enter a E-Mail :</label>
          <input type="email" placeholder="Enter a Email ..." name="emailf" id="" />
          <button type="submit" class="btnEmailing">Follow</button>
        </form>
      </div>
    </div>

    <div class="formmessage">
      <div class="titleFollow">
        <h2>Contact Mehdi BenTaleb</h2>
        <div class="closeFormMessage">
          <i class="bx bx-x"></i>
        </div>
      </div>

      <div class="follow">
        <div class="contentformMesaage">
          <div class="emilcontent">
            <div class="logoemail">
              <i class="bx bx-message-dots"></i>
            </div>
            <div class="emillink">
              <h2>Send me an email</h2>
              <a href="">mehdibentaleb548@gmail.com</a>
            </div>
          </div>
          <div class="MysocialMedia">
            <a href=""> <i class="bx bxl-instagram"></i></a>
            <a href=""> <i class="bx bxl-facebook"></i></a>
            <a href=""> <i class="bx bxl-linkedin"></i></a>
            <a href=""><i class="bx bxl-github"></i></a>
          </div>
        </div>

        <form method="POST" action="portfolio.php"  class="messageform">
         
          <h2>Enter Your information</h2>
          <label>Enter a First name :</label>
          <input
            type="text"
            placeholder="Enter a first name ..."
            name="fname"
            id=""
          />
          <label>Enter a Last name :</label>
          <input
            type="text"
            placeholder="Enter a last name ..."
            name="lname"
            id=""
          />
          <label>Enter a E-Mail :</label>
          <input type="email" placeholder="Enter a Email ..." name="email" id="" />
          <label>Enter a Phone number :</label>
          <input
            type="text"
            placeholder="Enter a phone number ..."
            name="phone"
            id=""
          />
          <label>Enter your message :</label>
          <textarea name="message" id="" class="message" placeholder="Enter a your message ..."></textarea>
          <button type="submit" class="btnEmailing">Send</button>
        </form>
      </div>
    </div>

    <div class="menu">
      <div class="navDrop">
        <div class="profileNavDrop">
          <h2>M.BenTaleb</h2>
        </div>

        <div class="closeMenu">
          <i class="bx bx-x"></i>
        </div>
      </div>
      <div class="linksMenu">
        <button>Home</button>
        <button class="scrollabout">About Me</button>
        <button class="scrollskills">Skills</button>
        <button class="scrollpro">Projects</button>
        <button class="scrollcontact">Contact</button>
      </div>
    </div>

    <div class="section1">
      <div class="navbar">
        <div class="links">
          <button>Home</button>
          <button class="scrollaboutnav">About Me</button>
          <button class="scrollskillsnav">Skills</button>
          <button class="scrollpronav">Projects</button>
          <button class="scrollcontactnav">Contact</button>
          <button class="btnlightmood">
            <div class="mdlight">
              <i class="bx bx-moon moon"></i>
              <i class="bx bxs-sun sun"></i>
            </div>
          </button>
        </div>
        <div class="profileNav">
          <h2>M.BenTaleb</h2>
        </div>
        <div class="menuDrop">
          <i class="bx bx-menu-alt-right"></i>
        </div>
      </div>

      <div class="infoPerson">
        <div class="profile">
          <img src="imgMd.png" alt="" />
        </div>

        <div class="titlePr">
          <h2>Mehdi Ben Talebe</h2>
          <h3>Full-stack Developer</h3>
        </div>
        <div class="statistique">
          <div class="st1">
            <h3>Projects</h3>
            <span>6</span>
          </div>

          <div class="st1">
            <h3>Follower</h3>
            <span><?php echo $TOTAL_FOLLOWERS; ?></span>
          </div>

          <div class="st1">
            <h3>Experince</h3>
            <span>2 years</span>
          </div>
        </div>
        <div class="btnStart">
          <button class="btnMessage">Message</button>
          <button class="btnFollow">Follow</button>
          <button class="btnlightmood2">
            <div class="mdlight">
              <i class="bx bx-moon moon"></i><i class="bx bxs-sun sun"></i>
            </div>
          </button>
        </div>
      </div>

      <div class="contactSocial">
        <div class="link">
          <div class="linkicon">
            <i class="bx bxl-github"></i>
          </div>
          <div class="titleLink">
            <h2>Github</h2>
            <h3>
              <a href="https://github.com/BenTaleb-Mehdi">@BenTaleb-Mehdi</a>
              <i class="bx bx-right-top-arrow-circle"></i>
            </h3>
          </div>
        </div>

        <div class="link">
          <div class="linkicon">
            <i class="bx bx-mail-send"></i>
          </div>
          <div class="titleLink">
            <h2>E-mail</h2>
            <h3>
              <a href="mehdibentaleb548@gmail.com">@mehdibentaleb</a>
              <i class="bx bx-right-top-arrow-circle"></i>
            </h3>
          </div>
        </div>

        <div class="link">
          <div class="linkicon">
            <i class="bx bxl-linkedin"></i>
          </div>
          <div class="titleLink">
            <h2>LinkedIn</h2>
            <h3>
              <a href="https://www.linkedin.com/in/mehdi-bentaleb-b0b866336/"
                >@mehdibentaleb</a
              >
              <i class="bx bx-right-top-arrow-circle"></i>
            </h3>
          </div>
        </div>
      </div>
    </div>

    <div class="section2">
      <div class="bartitle">
        <h2>About Me</h2>
        <i class="bx bx-chevron-down"></i>
      </div>

      <div class="about">
        <div class="textBoutMe">
          <div class="welcome">
            <h2>Hi!</h2>
          </div>
          <div class="pr">
            <p>I am proud to share my achievements</p>
          </div>

          <div class="pr">
            <p>
              Innovative <span>Full-Stack Developer</span> with a passion for
              crafting responsive and dynamic web experiences.
            </p>
          </div>

          <div class="pr">
            <p>
              Skilled in <span>CSS</span>, <span>JavaScript</span>,
              <span>PHP</span>, and <span>MySQL</span>, I specialize in creating
              seamless, interactive, and responsive websites tailored to meet
              user needs and industry standards.
            </p>
          </div>

          <div class="pr">
            <p>
              Passionate about delivering user-friendly websites, I focus on
              combining functionality, <span>clean design</span>, and
              <span>efficient code</span> to solve complex development
              challenges and provide exceptional digital solutions.
            </p>
          </div>

          <div class="pr">
            <p>
              Always learning, adapting, and pushing boundaries in the world of
              web development.
            </p>
          </div>

          <div class="btnabout">
            <a href="MYRESUME.pdf" download="MYRESUME.pdf" class="aboutbtn">
              My Resume
              <i class="bx bx-download"></i>
            </a>
          </div>
        </div>

        <div class="imgAbout">
          <img src="Frame.png" alt="" />
        </div>
      </div>
    </div>

    <div class="section3">
      <div class="titleSk">
        <h2>Skills</h2>
        <i class="bx bx-chevron-down"></i>
      </div>

      <div class="aboutMyskills">
        <div class="prSkills">
          <h3>Some of the techs I like to <br /><span>work with</span></h3>
        </div>

        <div class="packMySkils">
          <div class="titlePack">
            <h2>Skils for Front-End</h2>
          </div>
          <div class="skills" id="skillScroll">
            <div class="skill">
              <i class="bx bxl-html5" style="color: #db2501"></i>
              <h3>Html</h3>
            </div>

            <div class="skill">
              <i class="bx bxl-css3" style="color: #0013c1"></i>
              <h3>Css</h3>
            </div>

            <div class="skill">
              <i class="bx bxl-javascript" style="color: #d6e105"></i>
              <h3>Jvascript</h3>
            </div>

            <div class="skill">
              <i class="bx bxl-react" style="color: #06c1f4"></i>
              <h3>React Js</h3>
            </div>

            <div class="skill">
              <i class="bx bxl-tailwind-css" style="color: #0180a3"></i>
              <h3>Tailwind css</h3>
            </div>
          </div>
        </div>

        <div class="packMySkils">
          <div class="titlePack">
            <h2>Skils for Back-End</h2>
          </div>
          <div class="skills" id="skillScroll2">
            <div class="skill">
              <i class="bx bxl-php" style="color: #2008ac"></i>
              <h3>Php</h3>
            </div>

            <div class="skill">
              <i class="bx bxl-java" style="color: #cb9b16"></i>
              <h3>Java</h3>
            </div>

            <div class="skill">
              <i class="fa-brands fa-node" style="color: #009002"></i>
              <h3>Node js</h3>
            </div>

            <div class="skill">
              <i class="fab fa-laravel" style="color: #f75f0e"></i>
              <h3>Laravel</h3>
            </div>

            <div class="skill">
              <i class="bx bxs-data" style="color: #ffffff39"></i>
              <h3>My Sql</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section4">
      <div class="titlepro">
        <h2>Project</h2>
        <i class="bx bx-chevron-down"></i>
      </div>

      <div class="projects">
        <div class="ProjectTitle">
          <h3>A collection of <br /><span>My best projects</span></h3>
        </div>

        <div class="project">
          <div class="pro" id="pro1">
            <div class="imgproject">
              <img src="pro1.png" alt="" />
            </div>

            <div class="SmlltitleProject">
              <h3>
                <span>Project</span> <i class="bx bx-world"></i> E-commerce
              </h3>
            </div>

            <div class="titleProject">
              <h1>Website Nike Clothing Commercial</h1>
            </div>

            <div class="languageForDev">
              <h2>Html</h2>
              <h2>Css</h2>
              <h2>Javascript</h2>
              <h2>Fontawesome</h2>
              <h2>Swiper.js</h2>
            </div>

            <div class="displayWebsite">
              <a href="https://bentaleb-mehdi.github.io/Nike-Project/">
                <h3>look</h3>
                <i class="bx bx-right-top-arrow-circle"></i>
              </a>
            </div>
          </div>

          <div class="pro" id="pro2">
            <div class="imgproject">
              <img src="websiteecompeoject.png" alt="" />
            </div>

            <div class="SmlltitleProject">
              <h3>
                <span>Project</span> <i class="bx bx-world"></i> E-commerce
              </h3>
            </div>

            <div class="titleProject">
              <h1>Website Apple Store Commercial</h1>
            </div>

            <div class="languageForDev">
              <h2>Html</h2>
              <h2>Css</h2>
              <h2>Javascript</h2>
              <h2>Fontawesome</h2>
              <h2>Swiper.js</h2>
            </div>

            <div class="displayWebsite">
              <a href="https://bentaleb-mehdi.github.io/ProjectSiteweb_Ecom/">
                <h3>look</h3>
                <i class="bx bx-right-top-arrow-circle"></i>
              </a>
            </div>
          </div>

          <div class="pro" id="pro3">
            <div class="imgproject">
              <img src="managmentSchoolProject.png" alt="" />
            </div>

            <div class="SmlltitleProject">
              <h3><span>Project</span> <i class="bx bx-world"></i> School</h3>
            </div>

            <div class="titleProject">
              <h1>Dashboard Mangment school</h1>
            </div>

            <div class="languageForDev">
              <h2>Html</h2>
              <h2>Css</h2>
              <h2>Javascript</h2>
              <h2>Fontawesome</h2>
              <h2>Chart.js</h2>
              <h2>Php</h2>
              <h2>My sql</h2>
            </div>

            <div class="displayWebsite">
              <a href="">
                <h3>look</h3>
                <i class="bx bx-right-top-arrow-circle"></i>
              </a>
            </div>
          </div>

          <div class="pro" id="pro4">
            <div class="imgproject">
              <img src="managmentProductProject.png" alt="" />
            </div>

            <div class="SmlltitleProject">
              <h3>
                <span>Project</span> <i class="bx bx-world"></i> E-commerce
              </h3>
            </div>

            <div class="titleProject">
              <h1>Dachboard Managment Apple Store</h1>
            </div>

            <div class="languageForDev">
              <h2>Html</h2>
              <h2>Css</h2>
              <h2>Javascript</h2>
              <h2>Fontawesome</h2>
              <h2>Chart.js</h2>
              <h2>Php</h2>
              <h2>My sql</h2>
            </div>

            <div class="displayWebsite">
              <a href="">
                <h3>look</h3>
                <i class="bx bx-right-top-arrow-circle"></i>
              </a>
            </div>
          </div>

          <div class="morePr">
            <div class="pro" id="pro5">
              <div class="imgproject">
                <img src="projectcoffe.png" alt="" />
              </div>

              <div class="SmlltitleProject">
                <h3>
                  <span>Project</span> <i class="bx bx-world"></i> E-commerce
                </h3>
              </div>

              <div class="titleProject">
                <h1>Website Coffee Store Commercial</h1>
              </div>

              <div class="languageForDev">
                <h2>Html</h2>
                <h2>Css</h2>
                <h2>Javascript</h2>
                <h2>Fontawesome</h2>
                <h2>Swiper.js</h2>
              </div>

              <div class="displayWebsite">
                <a href="">
                  <h3>look</h3>
                  <i class="bx bx-right-top-arrow-circle"></i>
                </a>
              </div>
            </div>

            <div class="pro" id="pro6">
              <div class="imgproject">
                <img src="pro1.png" alt="" />
              </div>

              <div class="SmlltitleProject">
                <h3>
                  <span>Project</span> <i class="bx bx-world"></i> E-commerce
                </h3>
              </div>

              <div class="titleProject">
                <h1>Website Nike Clothing Commercial</h1>
              </div>

              <div class="languageForDev">
                <h2>Html</h2>
                <h2>Css</h2>
                <h2>Javascript</h2>
                <h2>Fontawesome</h2>
                <h2>Swiper.js</h2>
              </div>

              <div class="displayWebsite">
                <a href="">
                  <h3>look</h3>
                  <i class="bx bx-right-top-arrow-circle"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="btnMore">
          <button><span class="namebtn">More</span></button>
        </div>
      </div>
    </div>

    <div class="section5">
      <div class="titlefooter">
        <div class="tContact">
          <h2>Contact Us</h2>
          <i class="bx bx-chevron-down"></i>
        </div>
        <h2 class="titleContact">
          Do you want to talk<br />
          about a <span>project</span>?
        </h2>
      </div>
      <div class="footerContact">
        <div class="imgContact" id="imgCoantactScroll">
          <img src="messagingImg.png" alt="" />
        </div>

        <form method="POST" class="forminformationUsers" id="forminformationUserScroll" >
          <h2>Send me message for work</h2>
          <label>First name (*)</label>
          <input type="text" name="" placeholder="Enter a first name ..." />

          <label>Last name (*)</label>
          <input type="text" name="" placeholder="Enter a last name ..." />

          <label>Email (*)</label>
          <input type="text" name="" placeholder="Enter a Email Address ..." />

          <label>Phone Number (*)</label>
          <input type="text" name="" placeholder="Enter a Phone number ..." />

         
          <label>Whrite me a message :</label>
          <textarea name="" class="messageTxt" placeholder="Whrite me a message ..."></textarea>

          <button type="submit">Send</button>
        </form>
      </div>
    </div>

    <div class="section6">
      <div class="ft1" id="scrollft1">
        <div class="titleft1">
          <h1>Mehdi Bnetaleb</h1>
          <p>Full-Stack Developer</p>
        </div>

        <div class="ft1descteption">
          <p>
            Innovative <span>Full-Stack Developer</span> with a passion for
            crafting responsive and dynamic web experiences.
          </p>
        </div>

        <div class="ft1Socialmedia">
          <a href=""> <i class="bx bxl-instagram"></i></a>
          <a href=""> <i class="bx bxl-facebook"></i></a>
          <a href=""> <i class="bx bxl-linkedin"></i></a>
          <a href=""><i class="bx bxl-github"></i></a>
        </div>
      </div>

      <div class="ft2">
        <div class="copyright" id="copyrightScroll">
          <p>copyright &copy; <a href="#">Mehdi BenTaleb</a></p>
        </div>

        <div class="menuft2" id="menuft2Scroll">
          <button>Home</button>
          <button>About me</button>
          <button>Projects</button>
          <button>Coantact me</button>
          <button>Help</button>
        </div>
      </div>
    </div>

    <script src="portfolio.js?v=1"></script>
  </body>
</html>

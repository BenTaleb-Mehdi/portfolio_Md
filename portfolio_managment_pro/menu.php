



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="menu.css?v=3" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>menu</title>
  </head>
  <body>
    <div class="navbar">
      <div class="drop">
        <button><i class="bx bx-menu"></i></button>
      </div>

      <div class="profile">
        <div class="img">
          <img src="imgMd.png" alt="" />
        </div>
        <div class="info">
          <h2>Mehdi bentaleb</h2>
          <p>fullstack developer admin</p>
        </div>
      </div>
    </div>
    <div class="menu">
      <div class="profile">
        <div class="imgProfile">
          <img src="imgMd.png" />
        </div>
        <div class="infoProfile">
          <h2>Mehdi BenTaleb</h2>
          <div class="typeJobe">
            <p>Full-stack developer</p>
            <a href="portfolio.php"><i class="bx bx-right-top-arrow-circle"></i></a>
          </div>
        </div>
        <div class="dropmenuclose">
          <i class="bx bx-x"></i>
        </div>
      </div>

      <div class="menustantard">
        <a href="dashboard.php" class="dashboardHome">
          <i class="bx bxs-dashboard"></i><span>Dashbord</span>
        </a>
        <button class="btnUser">
          <div class="uconNamebtn">
            <i class="bx bxs-user-pin"></i>
            <span> Clients</span>
          </div>
          <div class="icondrop">
            <i class="bx bx-chevron-down"></i>
          </div>
        </button>
        <div class="clinetListebtn">
          <a href="users.php" class="addUsers"
            ><i class="bx bxs-circle"></i> Users</a
          >
          <a href="invoices.php" class="invoiceUser">
            <i class="bx bxs-circle"></i> Invoice User
          </a>

           <a href="inbox.php" class="invoiceUser">
            <i class="bx bxs-circle"></i> Inbox
          </a>
        </div>
        <a href="AnalyeseUsers.php" class="AnalyeseUsers">
          <i class="bx bxs-bar-chart-alt-2"></i><span>Analyses</span>
        </a>
        <a href="balance.php" class="btnBalanceAnalayses">
          <i class="bx bx-money-withdraw"></i><span>Balance Analyses</span>
        </a>
        <a href="todo.php" class="btncontentTodoliste">
          <i class="bx bxs-notepad"></i><span>To do liste</span>
        </a>

        <a href="Goals_Years.php" class="btncontentTodoliste">
        <i class='bx bxs-hourglass'></i><span>Long term goals</span>
        </a>
      </div>

      <div class="footermenu">
        <a href="#"><i class="bx bxs-cog"></i><span>Setting</span></a>
        <a href="logout.php"><i class="bx bxs-exit"></i><span>Logout</span></a>
      </div>
    </div>

    <script>
      const btnUserListe = document.querySelector(".clinetListebtn"),
        btnUser = document.querySelector(".btnUser");

     if(btnUserListe && btnUser){
       btnUser.addEventListener("click", () => {
        btnUserListe.classList.toggle("showbtn");
      });
     };

      const menudropclose = document.querySelector(".dropmenuclose"),
        drop = document.querySelector(".drop"),
        menu = document.querySelector('.menu')

      menudropclose.addEventListener("click", () => {
        menu.classList.remove("show");
      });
       drop.addEventListener("click", () => {
        menu.classList.add("show");
      });
    </script>
  </body>
</html>

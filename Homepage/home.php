<!DOCTYPE html>
<html>
  <head>
    <title>User Option</title>
    <link rel="stylesheet" href="style2.css" />
    <link rel="stylesheet" href="light-mode2.css" />
  </head>
  <body>
    <header>
      <h1>How would you 
      </h1>
      <h1>
      like to browse?</h1>
    </header>
    <div class="main-container">
      <main>
        <form id="UserOp1" action="index.html" method="post">
          <button type="button" id="ingredSearch" class="btn">Search by ingredients</button>
        </form>
      </main>
      <main>
        <form id="UserOp2" action="index.html" method="post">
          <button type="button" id="dishSearch" class="btn">Search dish by name</button>
        </form>
      </main>
    </div>
    <br>
    <button type="button" id="lightModeToggle" class="btn">Light Mode</button>
    <a href="../LoginPage/logout.php">Logout</a>
    <script src="script2.js"></script>
  </body>
</html>

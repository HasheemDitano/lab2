<!DOCTYPE HTML>
<html>

<head>
  <style>
    body {
      height: 100dvh;
      background: linear-gradient(280deg, #edaef9, #81b1fa);
    }

    .form-container {
      width: max-content;
      margin: 2rem auto 3rem;
      background-color: hsl(0, 0%, 100%);
      padding: 2rem 3rem;
      border-radius: 1rem;
    }

    .label {
      margin-bottom: 0.5rem;
    }

    .form-container h2 {
      margin: 0 0 1rem;
    }

    .button-container {
      display: flex;
      justify-content: flex-end;
    }

    .form-container input[type="submit"] {
      margin-top: 1rem;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      background-color: hsl(0, 0%, 50%);
      color: hsl(0, 0%, 100%);
      border: none;
      cursor: pointer;
    }

    .error {
      color: #FF0000;
    }
  </style>
</head>

<body>

  <?php
  // define variables and set to empty values
  $nameErr = $emailErr = $genderErr = $websiteErr = "";
  $name = $email = $gender = $comment = $website = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $nameErr = "Name is required";
    } else {
      $name = test_input($_POST["name"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
      }
    }

    if (empty($_POST["email"])) {
      $emailErr = "Email is required";
    } else {
      $email = test_input($_POST["email"]);
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
      }
    }

    if (empty($_POST["website"])) {
      $website = "";
    } else {
      $website = test_input($_POST["website"]);
      // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
      if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
        $websiteErr = "Invalid URL";
      }
    }

    if (empty($_POST["comment"])) {
      $comment = "";
    } else {
      $comment = test_input($_POST["comment"]);
    }

    if (empty($_POST["gender"])) {
      $genderErr = "Gender is required";
    } else {
      $gender = test_input($_POST["gender"]);
    }
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>

  <div class="form-container">

    <h2>Form</h2>
    <form method="post" action="send_data.php">
      <div class="label">
        Name
        <span class="error">*</span>
      </div>
      <div>
        <input type="text" name="name" value="<?php echo $name; ?>">
      </div>
      <span class="error">
        <?php echo $nameErr; ?>
      </span>
      <br><br>
      <div class="label">
        E-mail
        <span class="error">*</span>
      </div>
      <div>
        <input type="text" name="email" value="<?php echo $email; ?>">
      </div>
      <span class="error">
        <?php echo $emailErr; ?>
      </span>
      <br><br>
      <div class="label">
        Website
      </div>
      <div>
        <input type="text" name="website" value="<?php echo $website; ?>">
      </div>
      <span class="error">
        <?php echo $websiteErr; ?>
      </span>
      <br><br>
      <div class="label">
        Comment
      </div>

      <div><textarea name="comment" rows="5" cols="40"><?php echo $comment; ?></textarea></div>
      <br><br>
      <div class="label">
        Gender
        <span class="error">*</span>
      </div>

      <div>
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "female")
          echo "checked"; ?>
          value="female">Female
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male")
          echo "checked"; ?>
          value="male">Male
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "other")
          echo "checked"; ?>
          value="other">Other
      </div>
      <span class="error">
        <?php echo $genderErr; ?>
      </span>
      <br><br>
      <div class="button-container">
        <input type="submit" name="submit" value="Submit">
      </div>
    </form>
  </div>

</body>

</html>
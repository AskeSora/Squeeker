<main>
    <div class="content">
        <div class="gridcontainer2">
            <div class="griditem">
                <img src="assets/MouseWithCheese.png" alt="Mouse with cheese">
            </div>
            <div class="griditem">
                <h2>Join Squeeker</h2>
                <div class="signin">
                    <form action="code/Signup.php" method="POST" class="loginform">
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" required><br><br>
                        <label for="password">Password:</label><br>
                        <input type="password" id="password" name="password" required><br><br>
                        <label for='confirm_password'>Confirm Password:</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                        <label for="name">Name:</label><br>
                        <input type="text" id="name" name="name" required><br><br>
                        <button type="submit" class="loginbtn">Register</button>
                    </form>
                <br>                
                <span>Already a user? </span><a href='index.php?page=login'> Login here ➤</a> 
                </div>
            </div>
        </div>
        <div class="push"></div>
    </div>
</main>
   


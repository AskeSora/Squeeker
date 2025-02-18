<main>
    <div class="content">
        <div class="gridcontainer2">
            <div class="griditem">
                <img src="assets/MouseWithCheese.png" alt="Mouse with cheese">
            </div>
            <div class="griditem">
                <h2>Login to Squeeker</h2>
                <div class="signin">
                   <form action="code/Signin.php" method="POST" class="loginform">
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" required><br><br>
                        <label for="password">Password:</label><br>
                        <input type="password" id="password" name="password" required><br><br>
                        <button type="submit" class="loginbtn">Login</button>
                    </form>
                    <br>                
                    <span>Not a user yet? </span><a href='index.php?page=register'> Register here ➤</a> 
                </div>
            </div>
        </div>
        <div class="push"></div>
    </div>
    
</main>
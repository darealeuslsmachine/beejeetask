<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="web/css/bootstrap.min.css">
    <link rel="stylesheet" href="web/css/font-awesome.min.css">
    <link rel="stylesheet" href="web/css/style.css">
</head>
<body>
    <header></header>
    <div id="content">
        <div class="container table-block">
            <div class="row table-cell-block">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">Sign in to continue as an administrator</h1>
                    <div class="account-wall">
                        <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                             alt="">
                        <form class="form-signin" id="form-signin" method="post">
                            <?php if(!empty($pageData['error'])) :?>
                                <p><?php echo $pageData['error']; ?></p>
                            <?php endif; ?>
                            <input type="text" class="form-control" name="login" id="login" placeholder="Login" required autofocus>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                Sign in</button>
                        </form>
                    </div>
                    <a href="home" class="text-center     go-home">Home </a>
                </div>
            </div>
        </div>
    </div>
    <footer>
    </footer>
    <script src="web/js/jquery.min.js"></script>
    <script src="web/js/bootstrap.min.js"></script>
    <script src="web/js/angular.min.js"></script>
    <script src="web/js/script.js"></script>
</body>
</html>


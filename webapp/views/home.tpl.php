<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="web/css/font-awesome.min.css">
    <link rel="stylesheet" href="web/css/style.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
    <header></header>

    <!--------- Modal window for add task ------------------------------------------------------------------------>

    <form action='/webapp/home/newtask' method='post'>
        <div class="modal fade" id="addnewtask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">User:</label>
                                <input type="text" name="addusername" id="addusernameid" class="form-control" oninvalid = "" required placeholder="Ivan228">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" id="emaillabel" class="col-form-label">Email:</label>
                                <label for="recipient-name" id="incorrectemail" class="col-form-label" style="color: #da4245"></label>
                                <input type="text" name="addemail" id="addemailid" class="form-control" oninvalid = "" required placeholder="Ivan228@gmail.com">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Task:</label>
                                <input type="text" name="addtext" id="addtaskid" class="form-control" oninvalid = "" required placeholder="Find a job">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <label for="recipient-name" id="successfuladdition" class="col-form-label" style="color: #4ada20"></label>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="return incorrectemail();">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--------- Head -------------------------------------------------------------------------------------------------->

    <div id="content">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <div class="blog-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 sidebar blog-left">
                        <div class="widget widget-search">
                            <form id="rt" method="post" accept-charset="utf-8">
                                <input type="text" name="searchstr" placeholder="Search">
                                <?php if(!isset($_SESSION['user'])) {?>
                                    <a href="/webapp/" class="signin-logout-link" style="color:#000000">Sign in</a>
                                <?php };?>
                                <?php if(isset($_SESSION['user'])) {?>
                                    <a href="home/logout/" class="signin-logout-link" style="color:#000000">Log out</a>
                                <?php };?>
                                    <a href="#addnewtask" data-toggle="modal" class="signin-logout-link" style="color:#000000">Add task</a>
                            </form>
                        </div>
                        <form method="GET">
                            <div>
                                <select name="sortparam1" class="custom-select col-md-2">
                                    <option name="usermanesort" value="Username">Username</option>
                                    <option name="emailsort" value="Email">Email</option>
                                    <option name="statussort" value="Status">Status</option>
                                </select>
                                <select name="sortparam2" class="custom-select col-md-2">
                                    <option name="ascendingsort" value="Ascending">Ascending</option>
                                    <option name="descedingsort" value="Descending">Descending</option>
                                </select>
                                    <input type="submit" name="btnSort" value="Sort" class="btn"/>
                            </div>
                        </form>

<!--------- Modal window ---------------------------------------------------------------------------------------------->

                    <div class="col-md-9 blog-left">
                        <?php foreach ($pageData['tasksOnPage'] as $key => $value) {?>
                            <form action='/webapp/home/save' method='post'>
                                <div class="modal fade" id="<?php echo $value['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update task</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">User:</label>
                                                        <?php echo $value['username'];?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Email:</label>
                                                        <?php echo $value['email'];?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Task:</label>
                                                        <input type="text" name="<?php echo "changetext".$value['id'];?>"  value="<?php $text = str_replace($pageData['unwantedcharacters'], "", $value['text']); echo $text?>" class="form-control" oninvalid = "" required>
                                                    </div>
                                                        <p>Status: <input type="checkbox" name="<?php echo "checkbox".$value['id'];?>" value="on" <?php if ($value['status'] == 'DONE') {echo 'checked';} else { echo '';}?>></p>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

<!--------- Task ------------------------------------------------------------------------------------------------------>

                            <article class="blog-post">
                                <div class="featured-post">
                                </div>
                                <div class="divider25"></div>
                                <div class="content">
                                    <h3 class="title">
                                        <a><?php echo $value['username'];?></a>
                                        <a style="color: #3e8f3e"><?php echo $value['status'];?></a>
                                        <a style="color: #0056b3"><?php echo $value['updatewadmin'];?></a>
                                    </h3>
                                    <ul class="meta-post">
                                        <li class="comment">
                                            <a href="#">
                                                <?php echo $value['email'];?>
                                            </a>
                                        </li>
                                        <li class="date">
                                            <a href="#">

                                            </a>
                                        </li>
                                    </ul>
                                    <div class="entry-post">
                                        <p><?php $text = str_replace($pageData['unwantedcharacters'], "", $value['text']); echo $text?></p>
                                        <?php  if(isset($_SESSION['user'])) {?>
                                            <div class="more-link">
                                                <a href="#<?php echo $value['id'];?>" data-toggle="modal" class="read-more-btn">Update</a>
                                            </div>
                                        <?php };?>
                                    </div>
                                </div>
                            </article>
                        <?php };?>
                        <div class="blog-pagination">
                            <?php echo $pageData['pagination'];?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        function incorrectemail(){

            idinput = document.getElementById('addemailid').value;
            emailinput = document.getElementById('addemailid').value;
            textinput = document.getElementById('addtaskid').value;

            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

            if ((reg.test(emailinput) === false) && (emailinput !== "")) {

                document.getElementById("incorrectemail").innerHTML = "invalid email!";
                return false;

           } else if ((idinput !== "") && (emailinput !== "") && (textinput !== "")) {

                document.getElementById("successfuladdition").innerHTML = "Successful addition!";
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    $sqlTopBar = "SELECT a.profilepic, b.USER_NAME
    FROM systemuser a
    JOIN jengka.user b ON b.USER_ID = a.user_user_id
    WHERE idsystemuser = '".$_SESSION['userid']."'";
    
    $rTopBar = mysqli_fetch_assoc(mysqli_query($dbconn, $sqlTopBar));
    $profPic = $rTopBar['profilepic'];
    $username = $rTopBar['USER_NAME'];
    if($profPic == null || $profPic == ''){
        $profPic = "./uploads/img-profile/default-image.jpg";
    }
?>
<style>
    #imgSelector{
        display: none;
    }
    #dispImageT{
        max-width: 40px;
        min-width: 40px;
        min-height: 40px;
        max-height: 40px;
        border-radius: 50%;
        object-fit: cover;
        
    }
    #topbar{
        margin-right:30px; 
        margin-left:30px; 
        margin-top:15px;
        z-index: 99;
        border-radius: 5px;
        min-width: 240;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="topbar">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn">
            <i class="fas fa-bars"></i><span></span>
        </button>
        <button class="btn btn-light d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-caret-down"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php" style="background:none;">
                        <img src="<?php echo $profPic?>" alt="profileImg" id="dispImageT" srcset="">
                        <?php echo $username;?>
                    </a>
                    <!--<a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> HOME</a>-->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="background:none;margin: 5px" href="logout.php" ><i class="fas fa-sign-out-alt" ></i> LOGOUT</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

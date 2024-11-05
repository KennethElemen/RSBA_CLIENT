<header class="app-header fixed-top">	   	            
    <div class="app-header-inner">  
        <div class="container-fluid py-2">
            <div class="app-header-content"> 
                <div class="row justify-content-between align-items-center">
                
                <div class="col-auto">
                    <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>Menu</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
                    </a>
                </div><!--//col-->
               
                
                <div class="app-utilities col-auto">
                    
              
                    <div class="app-utility-item app-user-dropdown dropdown">
                        <div data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="user profile">
                        </div>
                    </div><!--//app-user-dropdown-->

                </div><!--//app-utilities-->
            </div><!--//row-->
            </div><!--//app-header-content-->
        </div><!--//container-fluid-->
    </div><!--//app-header-inner-->
    <div id="app-sidepanel" class="app-sidepanel"> 
        <div id="sidepanel-drop" class="sidepanel-drop"></div>
        <div class="sidepanel-inner d-flex flex-column">
            <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
            <div class="app-branding">
                <a class="app-logo" href="index.php"><img class="logo-icon me-2" src="../assets/finallogo.jpg" alt="logo"><span class="logo-text">Agriland</span></a>

            </div><!--//app-branding-->  
        
            <?php include 'navbar.php'; ?>
        </div><!--//sidepanel-inner-->
    </div><!--//app-sidepanel-->
</header><!--//app-header-->
<!DOCTYPE html>
<html lang="en"> 
<?php include 'components/head.php'; ?>
<body class="app">   	
<?php include 'components/header.php'; ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            
		<h1 class="app-page-title">Overview</h1>
            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
                <div class="inner">
                    <div class="app-card-body p-3 p-lg-4">
                        <h3 class="mb-3">Welcome, <?php echo htmlspecialchars($first_name); ?></h3>
                        <div class="row gx-5 gy-3">
                            <div class="col-12 col-lg-9">
                                <!-- Add content here if needed -->
                            </div><!--//col-->
                            <div class="col-12 col-lg-3">
                                <!-- Add content here if needed -->
                            </div><!--//col-->
                        </div><!--//row-->
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div><!--//app-card-body-->
                </div><!--//inner-->
            </div><!--//app-card-->
            
            <!-- Weather Widget -->
            <a class="weatherwidget-io mb-4 d-block" href="https://forecast7.com/en/15d32120d83/san-antonio/" data-label_1="SAN ANTONIO" data-label_2="WEATHER" data-theme="pure">SAN ANTONIO WEATHER</a>
            <script>
                !function(d,s,id){
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if(!d.getElementById(id)){
                        js = d.createElement(s);
                        js.id = id;
                        js.src = 'https://weatherwidget.io/js/widget.min.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'weatherwidget-io-js');
            </script>

            <!-- Clock Section -->
            <div class="row">
                <div class="col-6 col-lg-3 mb-4">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4 text-center">
                            <h4 class="app-card-title">Clock</h4>
                            <div class="stats-figure" id="clock" style="font-size: 30px; font-weight: bold; color: green;"></div>
                        </div><!--//app-card-body-->
                        <a class="app-card-link-mask" href="#"></a>
                    </div><!--//app-card-->
                </div><!--//col-->

           <!-- Latest Announcement Card Section -->
			<div class="col-12 col-lg-4 mb-4">
				<div class="app-card app-card-announcement shadow-sm h-100">
					<div class="app-card-body p-3 p-lg-4">
						<h4 class="app-card-title text-center mb-3">📢 Latest Announcement</h4>
						<div class="announcement-content text-center" style="font-size: 15px; color: #555;">
							<?php echo htmlspecialchars(mb_strimwidth($announcement_text, 0, 80, "...")); ?>
						</div>
						<div class="text-center mt-2">
							<a href="annoucement.php"  style="font-size: 13px; text-decoration: underline;">
								Read full announcement
							</a>
						</div>
					</div><!--//app-card-body-->
				</div><!--//app-card-->
			</div><!--//col-->




            <?php include 'components/footer.php' ?>
        </div><!--//container-xl-->
    </div><!--//app-content-->
</div><!--//app-wrapper-->

   					

	<script>
    // Clock Script
    function updateTime() {
        const clockElement = document.getElementById('clock');
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        clockElement.innerText = timeString;
    }

    // Update the time every second
    setInterval(updateTime, 1000);
    updateTime(); // Initial call
	

</script>

	<?php include 'components/script.php'; ?>


</body>
</html> 


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8">  
    <link rel="stylesheet" type="text/css" media="screen" href="css/reset.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="css/grid.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="css/superfish.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="css/slider.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="css/tabs-min.css"/>
    
    <script src="js/jquery-1.6.4.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/superfish.js"></script>
    <script src="js/jquery.hoverIntent.minified.js"></script>
    <script src="js/tms-0.4.1.js"></script>
    <script src="js/jquery.tabs.min.js"></script>
    <script src="js/search.js"></script>
    <script>
      $(document).ready(function(){
          $('.slider')._TMS({
              show:0,
              pauseOnHover:false,
              prevBu:'.prev',
              nextBu:'.next',
              playBu:false,
              duration:1000,
              preset:'diagonalExpand', 
              pagination:true,//'.pagination',true,'<ul></ul>'
              pagNums:false,
              slideshow:8000,
              numStatus:false,
              banners:'fade',
		      waitBannerAnimation:false,
			  progressBar:false
          })		
      })
  </script>
    <!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
    <!--[if lt IE 9]>
   		<script type="text/javascript" src="js/html5.js"></script>
    	<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
	<![endif]-->
</head>
<body>
<!--==============================header=================================-->
<div class="main">
     <div class="head">	     
         <header>
         <div class="over-header">
              <span>New User?</span> <a href="#">Register</a> <a href="#">Sign In</a> <a href="#">Help</a>
         </div>
           <div class="nav-logo">
               <div class="logo-search-form">
                     <h1><a href="index.html"></a></h1>
                     <div class="div-search">
                        <form id="search" action="search.php" method="GET" accept-charset="utf-8">
                           <input type="text" name="s" />
                           <a onClick="document.getElementById('search').submit()"  class="search_button"></a>
                        </form>
			        </div>
                    <div class="clear"></div>
               </div>
	           <nav> 
	             <ul class="sf-menu">
	                 <li class="current" id="first-li"><a href="index.html">HOME</a>
	                    <ul>
	                      <li><a href="#">Labore et dolore</a></li>
	                      <li><a href="#">Magna aliqua</a></li>
	                      <li><a href="#">Ut enim ad minim</a></li>
	                      <li><a href="#">Veniam</a></li>
                          <li><a href="#">Quis nostrud</a></li>
                          <li><a href="#">Exercitation ullamco</a></li>
	                    </ul>
	                  </li>
	                  <li id="id-2"><a href="index-1.html">SCORES</a></li>
	                  <li id="id-3"><a href="index-2.html">STANDINGS</a> </li>
	                  <li id="id-4"><a href="index-3.html">STATS</a></li>
	                  <li id="id-5"><a href="index-4.html">TEAMS</a></li> 
                      <li id="id-6"><a href="index-5.html">PLAYERS</a></li> 
	              </ul>
	              <div class="clear"></div>
	            </nav>
          <div class="clear"></div>
        </div>
      </header>
      <div class="slider-tabs">
	      <div id="slide">
			 <div class="slider">
				<ul class="items">
				   <li><img src="images/slide.png" alt="" />
                       
					   <div class="banner">
                       <span>JUL 18, 2012</span>
                       <strong>Lorem ipsum dolor sit amet conse ctetur</strong>
                       <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                       <a href="#" class="button-banner">Read more <span></span></a>
                       <div class="clear"></div>
                       </div>
                       
				   </li>
				   <li><img src="images/slide-1.png" alt="" />
					   <div class="banner">
                       <span>JUL 19, 2012</span>
                       <strong>Praesent vestibulum molestie lacus. </strong>
                       <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                       <a href="#" class="button-banner">Read more <span></span></a>
                       <div class="clear"></div>
                       </div>
				   </li>
                   <li><img src="images/slide-2.png" alt="" />
						<div class="banner">
                       <span>JUL 20, 2012</span>
                       <strong>Fusce feugiat malesuada odio.</strong>
                       <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                       <a href="#" class="button-banner">Read more <span></span></a>
                       <div class="clear"></div>
                       </div>
				   </li>
                   <li><img src="images/slide-3.png" alt="" />
					   <div class="banner">
                       <span>JUL 21, 2012</span>
                       <strong>Cusce suscipit varius mi.</strong>
                       <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                       <a href="#" class="button-banner">Read more <span></span></a>
                       <div class="clear"></div>
                       </div>
				   </li>
				</ul>
                <div class="banner-bg"></div>
			  </div>
		   </div><!--the end of slider-->
           <div class="tabs">
              <ul class="nav">
                   <li class="selected" id="first-li-tabs"><a href="#tab-1">Headlines</a></li>
                   <li id="last-li-tabs"><a href="#tab-2">Full Schedule</a></li>
              </ul>
              <div  id="tab-1" class="tab-content">
                  <div class="box-tabs" id="box-tabs-1">
                     <span></span><a href="#">Amet conse ctetur adipisicing</a>
                     <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</p>
                  </div>
                  <div class="box-tabs">
                     <span></span><a href="#">Exercitation ullamco </a>
                     <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</p>
                  </div>
                  <div class="box-tabs">
                     <span></span><a href="#">Laboris xcepteur </a>
                     <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</p>
                  </div>
                  <div class="box-tabs last-bot-padd">
                     <span></span><a href="#">Sint occaecat cupidatat </a>
                     <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</p>
                  </div>
                  <p><a href="#">See all <strong></strong></a></p>
              </div>
              <div  id="tab-2" class="tab-content">
                  <div class="box-tabs"  id="box-tabs-2">
                     <span></span><a href="#">Exercitation ullamco </a>
                     <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</p>
                  </div>
                  <div class="box-tabs">
                     <span></span><a href="#">Laboris xcepteur </a>
                     <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</p>
                  </div>
                  <div class="box-tabs">
                     <span></span><a href="#">Amet conse ctetur adipisicing</a>
                     <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</p>
                  </div>
                  <div class="box-tabs last-bot-padd">
                     <span></span><a href="#">Sint occaecat cupidatat </a>
                     <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</p>
                  </div>
                  <p><a href="#">See all <strong></strong></a></p>
              </div>
           </div><!--the end of tabs-->
           <div class="clear"></div>
       </div>
   </div><!--the end of head-->
		<!--==============================content================================-->
<section id="content" class="top">         
    <div class="wrapper">
	  <div class="main-block-left">
          <h2 class="padd-h2"><strong>LATEST</strong> TOPICS</h2>
          <div class="box">
             <div class="wrapper-extra">
                <img src="images/page-img.jpg" alt="" class="fleft">
             <div class="extra-wrap">
                 <strong>JUL 18, 2010</strong>
                 <span>Dolor sit amet conse ctetur adipisicing elit  fugiat nulla pariatur</span>
                 <p class="line-h-18">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                 <em class="comment">12</em><a href="#" class="button">Read more</a>
                 <div class="clear"></div>
             </div>
            </div>
          </div>
          <div class="box">
             <div class="wrapper-extra">
                <img src="images/page-img-1.jpg" alt="" class="fleft">
             <div class="extra-wrap">
                 <strong>JUL 18, 2010</strong>
                 <span>Lorem ipsum dolor sit amet conse ctetur adipisicing elit</span>
                 <p class="line-h-18">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                 <em class="comment">12</em><a href="#" class="button">Read more</a>
                 <div class="clear"></div>
             </div>
            </div>
          </div>
          <div class="box">
             <div class="wrapper-extra">
                <img src="images/page-img-2.jpg" alt="" class="fleft">
             <div class="extra-wrap">
                 <strong>JUL 18, 2010</strong>
                 <span>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</span>
                 <p class="line-h-18">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                 <em class="comment">12</em><a href="#" class="button">Read more</a>
                 <div class="clear"></div>
             </div>
            </div>
          </div>
          <div class="box last-bot">
             <div class="wrapper-extra">
                <img src="images/page-img-3.jpg" alt="" class="fleft">
             <div class="extra-wrap">
                 <strong>JUL 18, 2010</strong>
                 <span>Fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,</span>
                 <p class="line-h-18">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                 <em class="comment">12</em><a href="#" class="button">Read more</a>
                 <div class="clear"></div>
             </div>
            </div>
          </div>
          
      </div>  
      <div class="main-block-right">
          <div class="inner bord-rad-right bot-1">
              <h2 class="padd-h2-1"><strong>LATEST</strong> News</h2>
              <img src="images/page-img-4.jpg" alt="" class="top-1 bot">
              <a href="#" class="font-13 col-1 hov-1">Exercitation ullamco laboris nisi ut aliquip ex ea commod.</a>
              <span class="col-2 dis-block bold top-2">JUL 18, 2010</span>
              <img src="images/page-img-5.jpg" alt="" class="top-3 bot">
              <a href="#" class="font-13 col-1 hov-1">Lorem ipsum dolor sit amet conse ctetur adipisicing elit</a>
              <span class="col-2 dis-block bold top-2">JUL 18, 2010</span>
              <a href="#" class="link">See all <strong></strong></a>
          </div>
          <div class="inner-1">
              <h2 class="padd-h2-2 bord-bot-1"><strong>TOp</strong> <span>PLAYERS</span></h2>
              <div class="wrapper-extra block-1">
                <img src="images/page-img-6.jpg" alt="" class="fleft top-1 left right">
                <div class="extra-wrap">
                   <a href="#" class="col hov bold dis-inblock top-1-1">Adipisicing Elit</a>
                   <p class="line-h-18 top-1-2">Lorem ipsum dolor sit amet conse ctetur adipisicing elit.</p>
                </div>
              </div>
              <div class="wrapper-extra block-1">
                <img src="images/page-img-7.jpg" alt="" class="fleft top-1 left right">
                <div class="extra-wrap">
                   <a href="#" class="col hov bold dis-inblock top-1-1">Excepteur sint</a>
                   <p class="line-h-18 top-1-2">Lorem ipsum dolor sit amet conse ctetur adipisicing elit.</p>
                </div>
              </div>
              <div class="wrapper-extra block-1 last-bot">
                <img src="images/page-img-8.jpg" alt="" class="fleft top-1 left right">
                <div class="extra-wrap">
                   <a href="#" class="col hov bold dis-inblock top-1-1">cupidatat non proid</a>
                   <p class="line-h-18 top-1-2">Lorem ipsum dolor sit amet conse ctetur adipisicing elit.</p>
                </div>
              </div>
              <a href="#" class="link-1">See all <strong></strong></a>
          </div>
      </div>  
      <div class="clear"></div> 
      <aside>
         <div class="container_12">
             <div class="grid_3">
                <h3 class="padd">Informative</h3>
                <ul class="list">
	             	<li><a href="#">Headlines</a></li>
	             	<li><a href="#">History</a></li>
	             	<li><a href="#">Columns</a></li>
	             	<li><a href="#">Interviews</a></li>
	             	<li><a href="#">Almanac</a></li>
	             	<li><a href="#">Schedule</a></li>
	             	<li><a href="#">Mixed Martial Arts</a></li>
                </ul>
             </div>
             <div class="grid_3">
                <h3 class="padd">Interactive</h3>
                <ul class="list">
	             	<li><a href="#">Interactive</a></li>
	             	<li><a href="#">Biofiles</a></li>
	             	<li><a href="#">Odds</a></li>
	             	<li><a href="#">Store</a></li>
	             	<li><a href="#">Videos</a></li>
	             	<li><a href="#">Book Reviews</a></li>
	             	<li><a href="#">Links</a></li>
                </ul>
             </div>
             <div class="grid_3">
                <h3 class="padd">Interact With Us</h3>
                <ul class="list">
	             	<li><a href="#">Facebook</a></li>
	             	<li><a href="#">Twitter</a></li>
	             	<li><a href="#">Flickr</a></li>
	             	<li><a href="#">RSS Feed</a></li>
	             	<li><a href="#">Contact Us</a></li>
                </ul>
             </div>
             <div class="grid_3">
                <h3 class="padd">Baseball In Depth</h3>
                <ul class="list">
	             	<li><a href="#">Labore et dolore</a></li>
	             	<li><a href="#">Magna aliqua</a></li>
	             	<li><a href="#">Ut enim ad minim</a></li>
	             	<li><a href="#">Veniam</a></li>
	             	<li><a href="#">Quis nostrud</a></li>
	             	<li><a href="#">Exercitation ullamco</a></li>
                </ul>
             </div>
             <div class="clear"></div>
         </div> 
      </aside>
    </div><!--the end of wrapper-->
	<!--==============================footer=================================-->		
	<footer>
		<div class="container_12">
	  	        <div class="grid_12">
                     <p>Baseball &copy; 2012 <a href="index-6.html">Privacy Policy</a> <br><!--{%FOOTER_LINK} --></p>
                </div>
                <div class="clear"></div>
        </div>
	</footer>
</section>
</div>	
</body>
</html>
<?php
$cakeDescription = __d('cake_dev','Ahaguru - IIT JEE CBSE Class for Physics, Maths, Chemistry. Interactive Online Video Courses. Science and Math Foundation Classes. Science Experiment Books. Science Made Easy and Fun.');
?>
<!doctype html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>
	</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <meta name="description" content="AhaGuru makes Science and Math really easy. AhaGuru’s Online Courses, Interactice Video Lessons, Direct CBSE and IIT Classes, Books, Practice Tests, and Tablet Apps deepens students Physics, Math and Chemistry understanding.">
		<meta name="keywords" content="IIT, JEE, CBSE, IIT JEE, IITJEE, Physics, Math, Maths, Chemistry, Science, IIT Coaching, Ahaguru, Online Course, Interactive Video, Video Class, Balaji Sampath, IIT Online Class, IIT Physics Class, Direct Classroom Program for IIT, IIT Coaching in Chennai, IIT Online Class, Physics Online Class, Math Online Class, Maths Online Class, Online Video Course, Video Course, Concept Lesson, Books, Workbooks, Learning Apps, Tablet Apps, Mobile Apps, TabLab, Chemistry Class, Math Class, Physics Excellence, Science Foundation, Maths Foundation, Math Foundation, IIT Foundation, IIT Class, Balaji Sampath Physics, Balaji Sampath Physics Class, Balaji Physics Class, Balaji Physics, IIT Class in Chennai, IIT Maths Class, IIT Math Class, CBSE Physics Class, CBSE Online Class, CBSE Maths Class, Learn at Home, Learn Online, Learning is Fun, Science Experiment, Science Experiments, Math Puzzle, Math Puzzles, Fun Science, Learning by Doing, Experiment Kit, Experiment Kits, Expt Kit, Science Expt, Puzzler, Math Games, Topper, IIT Rank, Std 9, Std 10, Std 11, Std 12, Std 8, Std 7, Std 6, Std 5, School Help, Exam Helper, Exam Help, Test preparation, Competitive Exams, Engineering Entrance, IIT Entrance, NIT Entrance, BITSAT, JEE Mains, JEE Advanced">
      	<meta name="author" content="">
	<?php
		echo $this->Html->meta('icon');
  ?>
    <!--<link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css">-->
  <?php
   
    //echo $this->Html->css('bootstrap');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('bootstrap-responsive.min');
    echo $this->Html->css('style');

		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
</head>
<body>
             <div class="container">
    <?php echo $this->element('navbar'); ?>
     <div id="header">
      <?php echo $this->element('header'); ?>
    </div>
           <div id="content" >
  
       <?php echo $this->fetch('content'); ?></div>
       <div class="push"></div></div>
<div id="footer" >
   <div id="head" style="background-color:black;">
          </div>
<div id="inner-footer">
 <?php echo $this->element('footer'); ?>
</div>
</div>
  <div id="templates"> </div>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.0.3/bootstrap.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>-->
<?php

    echo $this->Html->script('jquery.min'); 
    echo $this->Html->script('bootstrap.min');
    echo $this->Html->script('underscore-min');
   echo $this->Html->script('tinymces/jscripts/tiny_mce/jquery.tinymce.js');
?>
		<script src="/js/ahaguru.js?v=3"></script>
 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']], displayMath: [['$$','$$'], ['\\[','\\]']]}});
    </script>
    <script src="/js/mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<?php
		echo $this->fetch('script');
?>
</body>
</html>

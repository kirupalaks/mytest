<?php
$cakeDescription = __d('cake_dev','Ahaguru - IIT JEE CBSE Class for Physics, Maths, Chemistry. Interactive Online Video Courses. Science and Math Foundation Classes. Science Experiment Books. Science Made Easy and Fun.');
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
       <?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>
	</title>
  <meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <meta name="description" content="AhaGuru makes Science and Math really easy. AhaGuru’s Online Courses, Interactice Video Lessons, Direct CBSE and IIT Classes, Books, Practice Tests, and Tablet Apps deepens students Physics, Math and Chemistry understanding.">
		<meta name="keywords" content="IIT, JEE, CBSE, IIT JEE, IITJEE, Physics, Math, Maths, Chemistry, Science, IIT Coaching, Ahaguru, Online Course, Interactive Video, Video Class, Balaji Sampath, IIT Online Class, IIT Physics Class, Direct Classroom Program for IIT, IIT Coaching in Chennai, IIT Online Class, Physics Online Class, Math Online Class, Maths Online Class, Online Video Course, Video Course, Concept Lesson, Books, Workbooks, Learning Apps, Tablet Apps, Mobile Apps, TabLab, Chemistry Class, Math Class, Physics Excellence, Science Foundation, Maths Foundation, Math Foundation, IIT Foundation, IIT Class, Balaji Sampath Physics, Balaji Sampath Physics Class, Balaji Physics Class, Balaji Physics, IIT Class in Chennai, IIT Maths Class, IIT Math Class, CBSE Physics Class, CBSE Online Class, CBSE Maths Class, Learn at Home, Learn Online, Learning is Fun, Science Experiment, Science Experiments, Math Puzzle, Math Puzzles, Fun Science, Learning by Doing, Experiment Kit, Experiment Kits, Expt Kit, Science Expt, Puzzler, Math Games, Topper, IIT Rank, Std 9, Std 10, Std 11, Std 12, Std 8, Std 7, Std 6, Std 5, School Help, Exam Helper, Exam Help, Test preparation, Competitive Exams, Engineering Entrance, IIT Entrance, NIT Entrance, BITSAT, JEE Mains, JEE Advanced">
      	<meta name="author" content="">
      	<?php
		echo $this->Html->meta('icon');
  ?>

              
     <?php         
    echo $this->Html->css('post_message');
    echo $this->Html->css('thirdparty/sbadmin_bootstrap_theme/css/bootstrap.min.css');
    echo $this->Html->css('thirdparty/sbadmin_bootstrap_theme/css/bootstrap.css');
    echo $this->Html->css('thirdparty/sbadmin_bootstrap_theme/font-awesome/css/font-awesome.min.css');
    echo $this->Html->css('thirdparty/sbadmin_bootstrap_theme/css/sb-admin.css');

    echo $this->fetch('meta');
    echo $this->fetch('css');
  ?>
</head>
<body>  
    <div id="content" >
      <?php echo $this->fetch('content'); ?>
    </div>
    <div class="push">      
    </div>
    <div id="scroll-to-top">
    <img alt="&uarr;" width="32" height="32" src="/img/up_btn.png" >
  </div>
<div id="templates"> </div>

<!--<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62807239-1', 'auto');
  ga('send', 'pageview');

</script>-->
<?php
echo $this->Html->script('thirdparty/underscore.js');
echo $this->Html->script('thirdparty/jquery-2.1.3.js');
echo $this->Html->script('thirdparty/angular.js');
echo $this->Html->script('thirdparty/angular-messages.min.js');
echo $this->Html->script('thirdparty/sbadmin_bootstrap_theme/js/bootstrap.min.js');
?>
            <!-- Bootstrap Core CSS -->
    

<?php
		echo $this->fetch('script');
?>
</body>
</html>

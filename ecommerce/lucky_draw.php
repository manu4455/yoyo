<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="max-age=604800" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sneekers | My Luck</title>
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Bootstrap cdn and custom css -->
	<?php include "link.php"; ?>
</head>
<body>
<div class="loader"></div>
<!-- header section -->
<?php include "header.php"; ?>

<section class="section-content padding-y mt-4 bg-light">
<div class="container-fluid bg-light">

<div class="row">
	<aside class="col-md-3 rounded-0">
		<ul class="list-group rounded-0">
			<a class="list-group-item " href="account.php"><i class="fa fa-user"></i> My Account  </a>
			<a class="list-group-item" href="orders.php"><i class="fa fa-first-order"></i> My Orders </a>
			<a class="list-group-item " href="wishlist.php"><i class="fa fa-heart"></i> My wishlist </a>
			<a class="list-group-item" href="cart.php"><i class="fa fa-shopping-cart"></i> My Cart </a>
			<a class="list-group-item" href="notify.php"><i class="fa fa-bell"></i> My Notification </a>
			<a class="list-group-item active" href="lucky_draw.php"><i class="fa fa-gift"></i> My Luck </a>
			
		</ul>
	</aside> <!-- col.// -->
	<main class="col-md-9">
		<article class="card mb-3">
		<header class="card-header">My Profile</header>
        <canvas id='canvas' width='880' height='300' class="bg-dark">
            Canvas not supported, use another browser.
        </canvas>
        <script>
            let theWheel = new Winwheel({
                'outerRadius'     : 212,        // Set outer radius so wheel fits inside the background.
                'innerRadius'     : 75,         // Make wheel hollow so segments dont go all way to center.
                'textFontSize'    : 24,         // Set default font size for the segments.
                'textOrientation' : 'vertical', // Make text vertial so goes down from the outside of wheel.
                'textAlignment'   : 'outer',    // Align text to outside of wheel.
                'numSegments'     : 24,         // Specify number of segments.
                'segments'        :             // Define segments including colour and text.
                [                               // font size and text colour overridden on backrupt segments.
                   {'fillStyle' : '#ee1c24', 'text' : '300'},
                   {'fillStyle' : '#3cb878', 'text' : '450'},
                   {'fillStyle' : '#f6989d', 'text' : '600'},
                   {'fillStyle' : '#00aef0', 'text' : '750'},
                   {'fillStyle' : '#f26522', 'text' : '500'},
                   {'fillStyle' : '#000000', 'text' : 'BANKRUPT', 'textFontSize' : 16, 'textFillStyle' : '#ffffff'},
                   {'fillStyle' : '#e70697', 'text' : '3000'},
                   {'fillStyle' : '#fff200', 'text' : '600'},
                   {'fillStyle' : '#f6989d', 'text' : '700'},
                   {'fillStyle' : '#ee1c24', 'text' : '350'},
                   {'fillStyle' : '#3cb878', 'text' : '500'},
                   {'fillStyle' : '#f26522', 'text' : '800'},
                   {'fillStyle' : '#a186be', 'text' : '300'},
                   {'fillStyle' : '#fff200', 'text' : '400'},
                   {'fillStyle' : '#00aef0', 'text' : '650'},
                   {'fillStyle' : '#ee1c24', 'text' : '1000'},
                   {'fillStyle' : '#f6989d', 'text' : '500'},
                   {'fillStyle' : '#f26522', 'text' : '400'},
                   {'fillStyle' : '#3cb878', 'text' : '900'},
                   {'fillStyle' : '#000000', 'text' : 'BANKRUPT', 'textFontSize' : 16, 'textFillStyle' : '#ffffff'},
                   {'fillStyle' : '#a186be', 'text' : '600'},
                   {'fillStyle' : '#fff200', 'text' : '700'},
                   {'fillStyle' : '#00aef0', 'text' : '800'},
                   {'fillStyle' : '#ffffff', 'text' : 'LOOSE TURN', 'textFontSize' : 12}
                ],
                'animation' :           // Specify the animation to use.
                {
                    'type'     : 'spinToStop',
                    'duration' : 10,
                    'spins'    : 3,
                    'callbackFinished' : alertPrize,  // Function to call whent the spinning has stopped.
                    'callbackSound'    : playSound,   // Called when the tick sound is to be played.
                    'soundTrigger'     : 'pin'        // Specify pins are to trigger the sound.
                },
                'pins' :                // Turn pins on.
                {
                    'number'     : 24,
                    'fillStyle'  : 'silver',
                    'outerRadius': 4,
                }
            });
 
            // Loads the tick audio sound in to an audio object.
            let audio = new Audio('tick.mp3');
 
            // This function is called when the sound is to be played.
            function playSound()
            {
                // Stop and rewind the sound if it already happens to be playing.
                audio.pause();
                audio.currentTime = 0;
 
                // Play the sound.
                audio.play();
            }
 
            // Called when the animation has finished.
            function alertPrize(indicatedSegment)
            {
                // Display different message if win/lose/backrupt.
                if (indicatedSegment.text == 'LOOSE TURN') {
                    alert('Sorry but you loose a turn.');
                } else if (indicatedSegment.text == 'BANKRUPT') {
                    alert('Oh no, you have gone BANKRUPT!');
                } else {
                    alert("You have won " + indicatedSegment.text);
                }
            }
        </script>
    </main>
  </div>
 </div>
</section>
<!-- =========================  COMPONENT TRACKING END.// ========================= -->


<!-- ========================= FOOTER ========================= -->
<?php include 'footer.php'; ?>
</body>
</html>
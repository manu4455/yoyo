<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Bootstrap CSS CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<!-- Font Awsome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Scrollbar Custom CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
<!-- Font family-->
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
<!-- Custom CSS -->
<link rel="stylesheet" href="css/style.css">
<!-- Custom JS -->
<script src="js/shoes.js"></script>
<script>	
    var loadFile = function(event) {
      var image = document.getElementById('output');
      image.src = URL.createObjectURL(event.target.files[0]);
    };
	$(document).ready (function() {
		$(".loader").fadeOut("slow");
	});
	$(document).ready(function() {
    $('#newlimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'new_order.php?limit=' + limit;
        }
    });
});

$(document).ready(function() {
    $('#bannerlimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'banner.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('#receivedlimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'received_order.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('#categorylimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'category_summary.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('#productlimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'product_summary.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('#countrylimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'country.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('#statelimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'state.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('#citylimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'cities.php?limit=' + limit;
        }
    });
});

$(document).ready(function() {
    $('#orderlimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'all_order.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('#consumerlimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'consumers.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('#brandlimit').on('change', function() {
        var limit = $(this).val();
        if (limit) {
            window.location.href = 'brand_summary.php?limit=' + limit;
        }
    });
});
$(document).ready(function() {
    $('.new-order').on('click', function(e) {
        var id = $(this).attr('href');
        var remove_id = id.replace(/[#]/g, '');
        
        $('.loader2').fadeIn(500);
        e.preventDefault();
        if (remove_id) {
            $.ajax({
                type: 'POST',
                url: 'order_action.php',
                data: 'received=' + remove_id,
                success: function(html) {
                    $('#message').html(html);
                    $(id).remove();
                    $(".loader2").fadeOut("slow");
                }
            });
        }
    });
});
$(document).ready(function() {
    $('.packed-order').on('click', function(e) {
        var id = $(this).attr('id');
        $(".loader2").fadeIn("slow");
        e.preventDefault();
        if (id) {
            $.ajax({
                type: 'POST',
                url: 'order_action.php',
                data: 'packed=' + id,
                success: function(html) {
                    $('#message').html(html);
                    $('.packed-order').hide(500);
                    $(".loader2").fadeOut("slow");                   
                }
            });
        }
    });
});
$(document).ready(function() {
    $('.shipped-order').on('click', function(e) {
        var id = $(this).attr('id');
        $(".loader2").fadeIn("slow");
        e.preventDefault();
        if (id) {
            $.ajax({
                type: 'POST',
                url: 'order_action.php',
                data: 'shipped=' + id,
                success: function(html) {
                    $('#message').html(html); 
                    $('.shipped-order').hide(500); 
                    $(".loader2").fadeOut("slow");                  
                }
            });
        }
    });
});
$(document).ready(function() {
    $('.online-dilevered').on('click', function(e) {
        var id = $(this).attr('id');
        $(".loader2").fadeIn("slow");
        e.preventDefault();
        if (id) {
            $.ajax({
                type: 'POST',
                url: 'order_action.php',
                data: 'online-dilevered=' + id,
                success: function(html) {
                    $('#message').html(html);  
                    $('.online-dilevered').hide(500);
                    $(".loader2").fadeOut("slow");                  
                }
            });
        }
    });
});
$(document).ready(function() {
    $('.cod-dilevered').on('click', function(e) {
        var id = $(this).attr('id');
        $(".loader2").fadeIn("slow");
        e.preventDefault();
        if (id) {
            $.ajax({
                type: 'POST',
                url: 'order_action.php',
                data: 'cod-dilevered=' + id,
                success: function(html) {
                    $('#message').html(html);
                    $('.cod-dilevered').hide(500); 
                    $(".loader2").fadeOut("slow");                   
                }
            });
        }
    });
});
$(document).ready(function() {
    $('.online-dilevered-pay').on('click', function(e) {
        var id = $(this).attr('id');
        $(".loader2").fadeIn("slow");
        e.preventDefault();
        if (id) {
            $.ajax({
                type: 'POST',
                url: 'order_action.php',
                data: 'online-dilevered-pay=' + id,
                success: function(html) {
                    $('#message').html(html); 
                    $('.online-dilevered-pay').hide(500);  
                    $(".loader2").fadeOut("slow");                 
                }
            });
        }
    });
});

</script>
<style>
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(loader/loader.gif) center no-repeat #fff;
}
.loader2 {
	position: fixed;
	left: 45%;
    top: 45%;
    left: 45%;
	width: 5%;
	height: 10%;
	z-index: 9999;
	background: url(loader/loader_2.gif) center no-repeat #102375;
}
</style>

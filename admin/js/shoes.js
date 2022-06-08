jQuery(function($) {
    $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
            .parent()
            .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function() {
        $(".page-wrapper").addClass("toggled");
    });

});

//add and remove input feild
$(document).ready(function() {
    var max = 10; //Input fields increment limitation
    var min = 1;
    var color = 1;
    $('.add_feild').click(function() {
        //Check maximum number of input fields
        if (min < max) {
            min++; //Increment field counter
            $('.size').append('<tr id="size' + min + '"><td><input type="number" class="form-control mt-1" name="size[]" required="" placeholder="Add Size"></td><td><a href="#size' + min + '" class="remove_feild btn btn-danger mt-1"> <i class="fa fa-times"></i></a></td></tr>'); //Add field html
            $('.oldprice').append('<tr id="oldprice' + min + '"><td><input type="number" class="form-control mt-1" name="oldprice[]" value="0"  placeholder="Add Price"></td><td><a href="#oldprice' + min + '" class="remove_feild btn btn-danger mt-1"> <i class="fa fa-times"></i></a></td></tr>'); //Add field html
            $('.price').append('<tr id="price' + min + '"><td><input type="number" class="form-control mt-1" name="newprice[]" required="" placeholder="Add Price"></td><td><a href="#price' + min + '" class="remove_feild btn btn-danger mt-1"> <i class="fa fa-times"></i></a></td></tr>'); //Add field html
            $('.stock').append('<tr id="stock' + min + '"><td><input type="number" class="form-control mt-1" name="stock[]" required="" placeholder="Add Stock"></td><td><a href="#stock' + min + '" class="remove_feild btn btn-danger mt-1"> <i class="fa fa-times"></i></a></td></tr>'); //Add field html
        } else {
            alert("Max feild limit is 10");
        }
    });
    $('.add_color').click(function() {
        //Check maximum number of input fields
        if (color < max) {
            color++; //Increment field counter
            $('.color').append('<tr id="color' + color + '"><td><input type="text" class="form-control mt-1" name="color[]" required="" placeholder="Add Color"></td><td><a href="#color' + color + '" class="remove_color btn btn-danger mt-1"> <i class="fa fa-times"></i></a></td></tr>'); //Add field html
        } else {
            alert("Max feild limit is 10");
        }
    });
    $('.table_stock,.table_size,.table_price,.table_oldprice').on('click', '.remove_feild', function(e) {
        e.preventDefault();
        var id = $(this).attr('href');
        var remove_id = id.replace(/[a-zA-Z#]/g, '');
        $("#size" + remove_id).remove(); //Remove field html
        $("#stock" + remove_id).remove(); //Remove field html
        $("#price" + remove_id).remove(); //Remove field html
        $("#oldprice" + remove_id).remove(); //Remove field html
        min--; //Decrement field counter
    });
    $('.table_stock,.table_size,.table_price,.table_oldprice').on('click', '.feild_remove', function(e) {
        e.preventDefault();
        var id = $(this).attr('href');
        var remove_id = id.replace(/[a-zA-Z#]/g, '');
        $("#sizes" + remove_id).remove(); //Remove field html
        $("#stocks" + remove_id).remove(); //Remove field html
        $("#prices" + remove_id).remove(); //Remove field html
        $("#oldprices" + remove_id).remove(); //Remove field html		
    });
    $('.table_color').on('click', '.remove_color', function(e) {
        e.preventDefault();
        var color_id = $(this).attr('href');
        $(color_id).remove(); //Remove field html
        color--; //Decrement field counter
    });
    $('.table_color').on('click', '.feild_color', function(e) {
        e.preventDefault();
        var color_id = $(this).attr('href');
        $(color_id).remove(); //Remove field html
    });
});
/* loader */
$(window).load(function() {
    // Animate loader off screen
    $(".loader").fadeOut("slow");;
});
/* history */
function goBack() {
    window.history.back();
}
$(document).ready(function() {
    $('.form-signin').on('click', '#forgot_pswd', function(e) {
        $('.form-reset').show(1000);
        $('.form-signin').hide(1000);
        e.preventDefault();
    });
});
$(document).ready(function() {
    $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function() {
        $(".page-wrapper").addClass("toggled");
    });
});

$(document).ready(function() {
    $('.search-box input[type="text"]').on("keyup input", function() {
        var search = $(this).val();
        if (search) {
            $.ajax({
                type: 'POST',
                url: 'search.php',
                data: 'search=' + search,
                success: function(message) {
                    $('.results').html(message);
                }
            });
        }
    });

    // Set search input value on click of result item
    $(document).on("click", ".result p", function() {
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
$(document).ready(function() {
    $('#countrys').on('change', function() {
        var country_id = $(this).val();
        if (country_id) {
            $.ajax({
                type: 'POST',
                url: 'search.php',
                data: 'country_id=' + country_id,
                success: function(html) {
                    $('#states').html(html);
                    $('#city').html('<option value="">Select State</option>');
                }
            });
        } else {
            $('#states').html('<option value="">Select Country</option>');
            $('#city').html('<option value="">Select State</option>');
        }
    });

    $('#states').on('change', function() {
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                type: 'POST',
                url: 'search.php',
                data: 'state_id=' + stateID,
                success: function(html) {
                    $('#city').html(html);
                }
            });
        } else {
            $('#city').html('<option value="">Select State</option>');
        }
    });
});

$(document).ready(function() {
    $('#filter').hide();
    $('#filter-button').on('click', function() {
        $('#filter').show(1000);
    });
    $('#filter-apply').on('click', function() {
        $('#filter').hide(1000);
    });
    $('#filter-close').on('click', function() {
        $('#filter').hide(1000);
    });
});
$(document).ready(function() {
    $('.close').on('click', function() {
        $('#login').hide(1000);
    });
});
$(document).ready(function() {
    $('.cart').on('click', function(e) {
        var id = $(this).attr('href');
        var remove_id = id.replace(/[#]/g, '');
        e.preventDefault();
        if (remove_id) {
            $.ajax({
                type: 'POST',
                url: 'action.php',
                data: 'cart_id=' + remove_id,
                success: function(message) {
                    $(id).remove();
                }
            });
        }
    });
});
$(document).ready(function() {
    $('.wish').on('click', function(e) {
        var id = $(this).attr('id');
        e.preventDefault();
        if (id) {
            $.ajax({
                type: 'POST',
                url: 'wish.php',
                cache: false,
                data: 'wishlist=' + id,
                success: function(message) { 
                    $('#wish').show();
                    $('#wish').html(message);
                }
            });
        }
    });
});
$(document).ready(function() {
    var cart = "cart";
    setInterval(function() {
        if (cart) {
            $.ajax({
                type: 'POST',
                url: 'action.php',
                data: 'cart=' + cart,
                success: function(message) {
                    $('.notify').html(message);
                }
            });
        }
    }, 500);
});
$(document).ready(function() {
    $('.quantity').on('change', function(e) {
        var id = $(this).attr('id');
        var cart_value = $(this).val();
        var quantity_cart_id = id.replace(/[q]/g, '');
        e.preventDefault();
        if (quantity_cart_id) {
            $.ajax({
                type: 'POST',
                url: 'action.php',
                data: { 'quantity_cart_id': quantity_cart_id, 'cart_value': cart_value },
                success: function(message) {
                    $('#abs').html(message);
                }
            });
        }
    });
    setInterval(function() {
        var cart_total = "total";
        $.ajax({
            type: 'POST',
            url: 'action.php',
            data: 'cart_total=' + cart_total,
            success: function(message) {
                $('.cart_total').html(message);
            }
        });
    }, 500);
});

/* form wizard */
$(document).ready(function() {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function() {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    $(".previous").click(function() {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    $(".submit").click(function() {
        return false;
    })

});

function goBack() {
    window.history.back();
}
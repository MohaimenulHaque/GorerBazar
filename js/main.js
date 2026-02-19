// Ghorer Bazar - Main JavaScript

$(document).ready(function() {
    // Mobile Menu
    $('.mobile-menu-btn').click(function() {
        $('.mobile-menu').addClass('active');
        $('.overlay').addClass('active');
    });
    
    $('.close-menu, .overlay').click(function() {
        $('.mobile-menu').removeClass('active');
        $('.overlay').removeClass('active');
    });
    
    // Hero Slider
    let currentSlide = 0;
    const slides = $('.slide');
    const totalSlides = slides.length;
    
    function showSlide(index) {
        if (index >= totalSlides) currentSlide = 0;
        else if (index < 0) currentSlide = totalSlides - 1;
        else currentSlide = index;
        
        $('.slider-wrapper').css('transform', 'translateX(-' + (currentSlide * 100) + '%)');
    }
    
    $('.slider-next').click(function() {
        showSlide(currentSlide + 1);
    });
    
    $('.slider-prev').click(function() {
        showSlide(currentSlide - 1);
    });
    
    // Auto slide every 5 seconds
    setInterval(function() {
        showSlide(currentSlide + 1);
    }, 5000);
    
    // Product Tabs
    $('.tab-btn').click(function() {
        const tab = $(this).data('tab');
        
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        
        $('.tab-content').removeClass('active');
        $('#' + tab).addClass('active');
    });
    
    // Account Menu
    $('.account-menu a').click(function(e) {
        e.preventDefault();
        const target = $(this).attr('href');
        
        $('.account-menu a').removeClass('active');
        $(this).addClass('active');
        
        $('.content-section').hide();
        $(target).show();
    });
    
    // Price Range Slider
    $('#priceRange').on('input', function() {
        $('#priceValue').text($(this).val());
    });
});

// Add to Cart Function
function addToCart(productId) {
    const qty = $('#qty-' + productId).val() || 1;
    
    $.ajax({
        url: 'ajax/add-to-cart.php',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: qty
        },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data.success) {
                    $('.cart-count').text(data.cart_count);
                    showToast('Product added to cart!');
                } else {
                    showToast('Failed to add to cart');
                }
            } catch(e) {
                showToast('Error: ' + response);
            }
        },
        error: function(xhr, status, error) {
            showToast('AJAX Error: ' + error);
        }
    });
}

// Add to Cart from Product Detail
function addToCartFromDetail(productId) {
    const qty = $('#detailQty').val() || 1;
    
    $.ajax({
        url: 'ajax/add-to-cart.php',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: qty
        },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                $('.cart-count').text(data.cart_count);
                showToast('Product added to cart!');
            } else {
                showToast('Failed to add to cart');
            }
        }
    });
}

// Update Quantity
function updateQty(productId, change) {
    const input = $('#qty-' + productId);
    let currentVal = parseInt(input.val()) || 1;
    let newVal = currentVal + change;
    
    if (newVal < 1) newVal = 1;
    input.val(newVal);
}

// Update Detail Quantity
function updateDetailQty(change) {
    const input = $('#detailQty');
    let currentVal = parseInt(input.val()) || 1;
    let newVal = currentVal + change;
    const max = parseInt(input.attr('max')) || 99;
    
    if (newVal < 1) newVal = 1;
    if (newVal > max) newVal = max;
    input.val(newVal);
}

// Update Cart Quantity
function updateCartQty(productId, change) {
    $.ajax({
        url: 'ajax/update-cart.php',
        type: 'POST',
        data: {
            product_id: productId,
            change: change
        },
        success: function(response) {
            location.reload();
        }
    });
}

// Remove from Cart
function removeFromCart(productId) {
    if (confirm('Are you sure you want to remove this item?')) {
        $.ajax({
            url: 'ajax/remove-from-cart.php',
            type: 'POST',
            data: {
                product_id: productId
            },
            success: function(response) {
                location.reload();
            }
        });
    }
}

// Quick View
function quickView(productId) {
    $.ajax({
        url: 'ajax/quick-view.php',
        type: 'GET',
        data: {
            product_id: productId
        },
        success: function(response) {
            $('.quick-view-content').html(response);
            $('.quick-view-modal').addClass('active');
        }
    });
}

// Close Modal
$('.close-modal').click(function() {
    $('.quick-view-modal').removeClass('active');
});

// Close Modal on Outside Click
$('.quick-view-modal').click(function(e) {
    if (e.target === this) {
        $(this).removeClass('active');
    }
});

// Toast Notification
function showToast(message) {
    $('.toast-message').text(message);
    $('.toast-notification').addClass('show');
    
    setTimeout(function() {
        $('.toast-notification').removeClass('show');
    }, 3000);
}

// Smooth Scroll
$('a[href^="#"]').click(function(e) {
    const target = $(this).attr('href');
    if (target !== '#') {
        e.preventDefault();
        $(target).offset().top;
    }
});

<script>
    $(document).on('click', '.addTofav', function (e) {
        e.preventDefault(); // Prevent default anchor behavior.

        let button = $(this); // Reference the clicked button.
        let productID = button.data('product-id'); // Retrieve the product ID.
        let productName = button.data('product-name'); // Retrieve the product ID.

        $.ajax({
            url: '{{ route('add-favs') }}', // Laravel route to handle toggle favorite.
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // CSRF token.
                product_id: productID
            },
            success: function (response) {
                if(response.attached != ""){
                    button.find('.icon-heart1').attr('src', '/web-app/images/icons/icon-heart-02.png');
                    button.find('.icon-heart2').attr('src', '/web-app/images/icons/icon-heart-01.png');
                    swal(productName,"Added to wishlist!", "success");
                }else{
                    button.find('.icon-heart1').attr('src', '/web-app/images/icons/icon-heart-01.png');
                    button.find('.icon-heart2').attr('src', '/web-app/images/icons/icon-heart-02.png');
                    swal(productName,"Removed from wishlist!", "error");

                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>
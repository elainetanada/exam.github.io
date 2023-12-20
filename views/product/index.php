<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="/assets/css/main.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div style="text-align: right;">
            <a href="/product/create" class="btn btn-primary">Add Product</a>
        </div>
        <?php if(isset($_GET['message']) && $_GET['message']):?>
        <div class="alert alert-success mt-2"><?php echo $_GET['message'];?></div>
       <?php endif;?>
        <h1>Products</h1>
        <div class="row table-responsive">
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Expiry Date</th>
                        <th>Available Inventory</th>
                        <th>Available Inventory Cost</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                   
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU2OFqWzxTTu0A8RSqCqG8fX/KKNq7rXap/Zn5I2rM4YLCsCXHLjKuxrlzY0" crossorigin="anonymous"></script>
</body>
</html>
<script>

// Call GET request to get all products
$.ajax({
    url: '/product/getAll',
    method: 'GET',
    success: function (data) {
        var tbody = document.getElementById("tbody");
        data.forEach(function(item, key) {
             var row = tbody.insertRow();
             let c1 = row.insertCell(0);
             let c2 = row.insertCell(1);
             let c3 = row.insertCell(2);
             let c4 = row.insertCell(3);
             let c5 = row.insertCell(4);
             let c6 = row.insertCell(5);
             let c7 = row.insertCell(6);
             let c8 = row.insertCell(7);
             c1.innerText = item.name;
             c2.innerText = item.unit;
             c3.innerText = item.price;
             c4.innerText = item.expiry_date;
             c5.innerText = item.available_inventory;
             c6.innerText = item.available_inventory * item.price;

            var imgProduct = document.createElement("img");

            // Set attributes for the image (src, alt, width, height, etc.)
            imgProduct.src = item.image;
            imgProduct.alt = "Product Image";
            imgProduct.width = 50; // Set the width in pixels
            c7.appendChild(imgProduct);

            var buttonEdit= document.createElement("a");
                buttonEdit.textContent = "Edit";
                buttonEdit.classList.add("btn-success");
                buttonEdit.classList.add("btn");
                buttonEdit.href = "/product/edit/" + item.id;
                buttonEdit.style = "--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; margin-right: 10px";

            var buttonDelete= document.createElement("a");
                buttonDelete.textContent = "Delete";
                buttonDelete.classList.add("btn-danger");
                buttonDelete.classList.add("btn");
                buttonDelete.href = "#";
                buttonDelete.style = "--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;";
                buttonDelete.addEventListener("click", function() {
                    // Call DELETE request to delete a product
                    $.ajax({
                        url: '/product/delete/' + item.id,
                        method: 'DELETE',
                        success: function (data) {
                            console.log(data)
                            window.location.href = "/product?message=" + data.message;

                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            
            c8.appendChild(buttonEdit);
            c8.appendChild(buttonDelete)
        });
    },
    error: function (xhr, status, error) {
        console.error(error);
    }
});
</script>
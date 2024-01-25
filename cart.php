<?php
session_start();
include 'header.php'; 
include 'connection.php';

$totalPrice = 0; 
$subTotal = 0;

?>


                        <tbody>
                            <?php 
                            if (isset($_SESSION['cart'])) {
                                $cartData = $_SESSION['cart'];
                            //    echo "<pre>";
                            //   print_r($_SESSION['cart']);
                            //   echo "</pre>";
                                foreach ($cartData as $item) {
                                    $sql = "SELECT * FROM products WHERE id = {$item['id']}";
                                    $result = mysqli_query($conn, $sql);
    
                                    if ($result === false) {
                                        echo "Error: " . mysqli_error($conn);
                                    } else {

                                        if (mysqli_num_rows($result) > 0) {
                                            $product = mysqli_fetch_assoc($result);
                                            
                                            // Ensure that values are treated as numbers
                                            $productPrice = floatval($product['product_price']);
                                            $itemQuantity = intval($item['quantity']);
                                            
                                            $itemTotal = $productPrice * $itemQuantity;
                                            $totalPrice += $itemTotal;
                                            $subTotal += $product['product_price'] * $item['quantity'];

                            ?>  
                            <tr class="table-item">
                                <td class="product-thumbnail">
                                    <img src="<?php echo $product['product_image']?>" alt="Image" class="img-fluid pro-img">
                                </td>
                                <td class="product-name">
                                    <h2 class="h5 text-black"><?php echo $product['product_name'] ?></h2>
                                    <input type="hidden" class="product-id" value="<?php echo $product['id'] ?>">
                                </td>  
                                <td class="product-price"><?php echo $productPrice; ?></td>
                                <td>
                                    <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-black decrease" type="button">&minus;</button>
                                        </div>
                                        <input data-id="<?php echo $product['id'] ?>" type="text" class="form-control text-center quantity-amount" value="<?php echo $itemQuantity ?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" class="quantityupdate">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-black increase" type="button">&plus;</button>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $itemTotal; ?></td>
                                <td class="delete" id="testing_delete">
                                    <span class="btn btn-black btn-sm delete-item" data-id="<?php echo $item['id']; ?>">X</soan>
                                </td>
                            </tr>
                            <?php 
                                        }
                                    }
                                }
                            } else {
                                echo "Cart is empty";
                            }
                            // session_destroy();
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- Rest of your HTML code -->
       
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <button class="btn btn-black btn-sm btn-block" id="updateCart">Update Cart</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="text-black h4" for="coupon">Coupon</label>
                        <p>Enter your coupon code if you have one.</p>
                    </div>
                    <div class="col-md-8 mb-3 mb-md-0">
                        <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-black">Apply Coupon</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 text-right border-bottom mb-5">
                                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-black">Subtotal</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black">$<?php echo number_format($subTotal, 2); ?></strong>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <span class="text-black">Total</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black">$<?php echo number_format($totalPrice, 2); ?></strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12"> 
                                <a  href="checkout.php" class="btn btn-black btn-lg py-3 btn-block">Proceed To Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Close the database connection
mysqli_close($conn);
include 'footer.php';
?>

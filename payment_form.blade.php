<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>

<h2>Buy Product</h2>

<form id="payment-form">
    @csrf
    <label>Product Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label>Price (₹):</label><br>
    <input type="number" id="price" name="price" required><br><br>

    <button type="submit">Pay with Razorpay</button>
</form>

<h3>Payment Response:</h3>
<pre id="payment-response" style="background: #f4f4f4; padding: 10px;"></pre>

<script>
document.getElementById('payment-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    let name = document.getElementById('name').value;
    let price = document.getElementById('price').value;

    const res = await fetch('/payment/create-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ amount: price })
    });

    const data = await res.json();

    const options = {
        key: data.key,
        amount: data.amount,
        currency: data.currency,
        name: name,
        order_id: data.order_id,
        handler: function (response) {
            fetch('/payment/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(response)
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('payment-response').textContent = JSON.stringify(data, null, 4);
                alert(data.status === 'success' ? '✅ Payment Success' : '❌ Payment Failed');
            });
        }
    };

    const rzp = new Razorpay(options);
    rzp.open();
});
</script>

</body>
</html>

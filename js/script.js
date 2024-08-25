// Signup functionality
document.getElementById('signupBtn').addEventListener('click', function (e) {
    e.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (localStorage.getItem(username)) {
        document.getElementById('alert').innerText = 'Username already exists!';
    } else {
        localStorage.setItem(username, password);
        document.getElementById('alert').innerText = 'Signup successful! Redirecting to login...';
        setTimeout(() => {
            window.location.href = "login.html";
        }, 1500);  // Redirect after 1.5 seconds
    }
});

// Login functionality
document.getElementById('loginBtn').addEventListener('click', function (e) {
    e.preventDefault();
    const username = document.getElementById('loginUsername').value;
    const password = document.getElementById('loginPassword').value;

    if (localStorage.getItem(username) === password) {
        sessionStorage.setItem('loggedInUser', username);
        window.location.href = "generator.html";
    } else {
        document.getElementById('alert').innerText = 'Invalid username or password!';
    }
});

// QR Code generation
if (document.getElementById('generate')) {
    document.getElementById('generate').addEventListener('click', function (e) {
        e.preventDefault();
        if (!sessionStorage.getItem('loggedInUser')) {
            alert('Please login to generate a QR code.');
            window.location.href = "login.html";
            return;
        }

        const data = document.getElementById('codeData').value;
        const size = document.getElementById('codeSize').value;

        if (data === "") {
            document.getElementById('alert').innerText = 'Please enter a URL or text';
        } else {
            document.getElementById('image').innerHTML = "<img src='http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "' alt='qr' />";
            document.getElementById('link').innerHTML = "<a href='http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "'>Download QR Code</a>";
            document.getElementById('code').innerHTML = "<p><strong>Image Link:</strong> http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "</p>";
        }
   

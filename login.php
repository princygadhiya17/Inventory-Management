<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      background: #EEEDFE;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .card {
      width: 100%;
      max-width: 700px;
      display: flex;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(83, 74, 183, 0.22), 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    /* ---- LEFT PANEL ---- */
    .left {
      width: 42%;
      background: #534AB7;
      padding: 2.5rem 2rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    .left::before {
      content: '';
      position: absolute;
      width: 240px;
      height: 240px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.08);
      top: -70px;
      right: -70px;
    }

    .left::after {
      content: '';
      position: absolute;
      width: 170px;
      height: 170px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.06);
      bottom: 30px;
      left: -55px;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      position: relative;
      z-index: 1;
    }

    .brand-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .brand-icon i {
      font-size: 18px;
      color: #fff;
    }

    .brand-name {
      font-size: 17px;
      font-weight: 700;
      color: #fff;
    }

    .left-body {
      position: relative;
      z-index: 1;
    }

    .left-body h2 {
      font-size: 22px;
      font-weight: 700;
      color: #fff;
      line-height: 1.35;
      margin-bottom: 10px;
    }

    .left-body p {
      font-size: 13px;
      color: rgba(255, 255, 255, 0.7);
      line-height: 1.65;
      margin-bottom: 24px;
    }

    .features {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 11px;
    }

    .features li {
      display: flex;
      align-items: center;
      gap: 9px;
      font-size: 13px;
      color: rgba(255, 255, 255, 0.9);
    }

    .feat-dot {
      width: 22px;
      height: 22px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 11px;
      color: #fff;
    }

    .dots {
      display: flex;
      gap: 6px;
      position: relative;
      z-index: 1;
    }

    .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
    }

    .dot.active {
      width: 18px;
      border-radius: 4px;
      background: #fff;
    }

    /* ---- RIGHT PANEL ---- */
    .right {
      flex: 1;
      background: #fff;
      padding: 2.5rem 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-head {
      margin-bottom: 1.6rem;
    }

    .form-head h1 {
      font-size: 22px;
      font-weight: 700;
      color: #1e1b4b;
      margin-bottom: 4px;
    }

    .form-head p {
      font-size: 13px;
      color: #94a3b8;
    }

    .color-strip {
      display: flex;
      gap: 4px;
      margin-bottom: 1.6rem;
    }

    .seg {
      height: 3px;
      border-radius: 3px;
      flex: 1;
    }

    .field {
      margin-bottom: 1rem;
    }

    .field label {
      display: block;
      font-size: 11.5px;
      font-weight: 700;
      color: #64748b;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      margin-bottom: 6px;
    }

    .input-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-wrap i.left-icon {
      position: absolute;
      left: 13px;
      font-size: 15px;
      color: #a78bfa;
      pointer-events: none;
    }

    .input-wrap input {
      width: 100%;
      height: 46px;
      padding: 0 42px 0 42px;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      background: #f8fafc;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px;
      color: #1e1b4b;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }

    .input-wrap input:focus {
      border-color: #7F77DD;
      background: #fff;
      box-shadow: 0 0 0 3px #EEEDFE;
    }

    .input-wrap input::placeholder {
      color: #c4b5fd;
    }

    .eye-toggle {
      position: absolute;
      right: 12px;
      font-size: 15px;
      color: #c4b5fd;
      cursor: pointer;
    }

    .eye-toggle:hover {
      color: #534AB7;
    }

    .row-meta {
      text-align: right;
      margin: -4px 0 1.4rem;
    }

    .row-meta a {
      font-size: 12px;
      font-weight: 600;
      color: #534AB7;
      text-decoration: none;
    }

    .row-meta a:hover {
      text-decoration: underline;
    }

    .btn-login {
      width: 100%;
      height: 48px;
      border: none;
      border-radius: 10px;
      background: #534AB7;
      color: #fff;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background 0.2s, transform 0.12s;
      box-shadow: 0 6px 20px rgba(83, 74, 183, 0.35);
      margin-bottom: 1.25rem;
    }

    .btn-login:hover {
      background: #3C3489;
    }

    .btn-login:active {
      transform: scale(0.98);
    }

    .or-row {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 12px;
      color: #cbd5e1;
      font-weight: 600;
      margin-bottom: 1.1rem;
    }

    .or-row::before,
    .or-row::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e2e8f0;
    }

    .social-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-bottom: 1.5rem;
    }

    .social-btn {
      height: 40px;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      background: #fff;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 13px;
      font-weight: 600;
      color: #475569;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      transition: border-color 0.2s, background 0.2s, color 0.2s;
    }

    .social-btn:hover {
      border-color: #7F77DD;
      background: #EEEDFE;
      color: #534AB7;
    }

    .signup-row {
      text-align: center;
      font-size: 13px;
      color: #94a3b8;
      font-weight: 500;
    }

    .signup-row a {
      color: #534AB7;
      font-weight: 700;
      text-decoration: none;
    }

    .signup-row a:hover {
      text-decoration: underline;
    }

    @media (max-width: 560px) {
      .left {
        display: none;
      }

      .right {
        border-radius: 20px;
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="card">

    <!-- LEFT PANEL -->
    <div class="left">
      <div class="brand">
        <div class="brand-icon">
          <i class="fas fa-shield-halved"></i>
        </div>
        <span class="brand-name">Inventory Management</span>
      </div>

      <div class="left-body">
        <h2>Welcome back!<br>Sign in to continue</h2>
        <p>Access all your data securly.</p>
        <ul class="features">
          <li>
            <span class="feat-dot"><i class="fas fa-check"></i></span>
            Secure &amp; encrypted login
          </li>
        </ul>
      </div>

      <div class="dots">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right">
      <div class="form-head">
        <h1>Login Form</h1>
        <p>Please enter your credentials to continue</p>
      </div>

      <div class="color-strip">
        <div class="seg" style="background:#534AB7;"></div>
        <div class="seg" style="background:#1D9E75;"></div>
        <div class="seg" style="background:#D85A30;"></div>
        <div class="seg" style="background:#D4537E;"></div>
        <div class="seg" style="background:#378ADD;"></div>
      </div>

      <form action="login_process.php" method="POST">

        <div class="field">
          <label for="email">Email address</label>
          <div class="input-wrap">
            <i class="fas fa-user left-icon"></i>
            <input type="email" id="email" name="email" placeholder="Enter your email" required />
          </div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap">
            <i class="fas fa-lock left-icon"></i>
            <input type="password" id="password" name="password" placeholder="Enter your password" required />
            <i class="fas fa-eye eye-toggle" id="togglePw"></i>
          </div>
        </div>

        <div class="row-meta">
          <a href="#">Forgot password?</a>
        </div>

        <button type="submit" name="login" class="btn-login">
          <i class="fas fa-right-to-bracket"></i>
          Login
        </button>

      </form>

      <div class="or-row">or continue with</div>

      <div class="social-row">
        <button class="social-btn" type="button" onclick="googleLogin()">
          <svg width="15" height="15" viewBox="0 0 24 24">
            <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z" />
            <path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z" />
            <path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z" />
            <path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z" />
          </svg>

          Google
        </button>
        <button class="social-btn" type="button">
          <svg width="15" height="15" viewBox="0 0 24 24">
            <path fill="#1877F2" d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.235 2.686.235v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.253h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073Z" />
          </svg>
          Facebook
        </button>
      </div>

      <div class="signup-row">Not a member? <a href="#">Signup now</a></div>
    </div>

  </div>

  <script>
    const pw = document.getElementById('password');
    const eye = document.getElementById('togglePw');
    eye.addEventListener('click', function() {
      const show = pw.type === 'password';
      pw.type = show ? 'text' : 'password';
      this.className = show ? 'fas fa-eye-slash eye-toggle' : 'fas fa-eye eye-toggle';
    });
  </script>
</body>
<script type="module">
  import {
    initializeApp
  }
  from "https://www.gstatic.com/firebasejs/12.0.0/firebase-app.js";

  import {
    getAuth,
    GoogleAuthProvider,
    signInWithPopup
  }
  from "https://www.gstatic.com/firebasejs/12.0.0/firebase-auth.js";


  const firebaseConfig = {

    apiKey: "AIzaSyBSEGe_MiyxgJrJRWttsRFT_dpitzA51a4",

    authDomain: "inventory-management-c2792.firebaseapp.com",

    projectId: "inventory-management-c2792",

    appId: "1:178906160667:web:2ff87ca824411a1d75e2be",

  };

  const app = initializeApp(firebaseConfig);

  const auth = getAuth();

  const provider = new GoogleAuthProvider();

  window.googleLogin = function() {

    signInWithPopup(auth, provider)

      .then((result) => {

        const user = result.user;

        const data = {

          name: user.displayName,

          email: user.email,

          uid: user.uid

        };

        console.log(data);

      })
      .catch((error) => {

        console.log(error);

      });
  }
  fetch("save-user.php", {

      method: "POST",

      headers: {
        "Content-Type": "application/json"
      },

      body: JSON.stringify(data)

    })
    .then(res => res.text())

    .then(response => {

      window.location = "dashboard.php";

    });
</script>

</html>
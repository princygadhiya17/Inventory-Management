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
            <input type="email" id="email" name="email" placeholder="admin@gmail.com" required />
          </div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap">
            <i class="fas fa-lock left-icon"></i>
            <input type="password" id="password" name="password" placeholder="123456" required />
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
<!-- <script type="module">
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
</script> -->

</html>
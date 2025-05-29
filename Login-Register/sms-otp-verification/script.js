// For Firebase
const firebaseConfig = {
  apiKey: "AIzaSyDuSKnIXfR7VSia0QMDs8JqMkiw1L2pjgw",
  authDomain: "profitease-otp.firebaseapp.com",
  projectId: "profitease-otp",
  storageBucket: "profitease-otp.firebasestorage.app",
  messagingSenderId: "55477680622",
  appId: "1:55477680622:web:45842f8041b99d4619b6ff",
  measurementId: "G-JKNE3T8GFS",
}
// initializing firebase SDK
firebase.initializeApp(firebaseConfig)

// render recaptcha verifier
render()
function render() {
  window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier("recaptcha-container")
  recaptchaVerifier.render()
}

// function for send OTP
function sendOTP() {
  var number = document.getElementById("number").value
  firebase
    .auth()
    .signInWithPhoneNumber(number, window.recaptchaVerifier)
    .then((confirmationResult) => {
      window.confirmationResult = confirmationResult
      coderesult = confirmationResult
      document.querySelector(".number-input").style.display = "none"
      document.querySelector(".verification").style.display = ""
    })
    .catch((error) => {
      // error in sending OTP
      alert(error.message)
    })
}

// function for OTP verify
function verifyCode() {
  var code = document.getElementById("verificationCode").value
  coderesult
    .confirm(code)
    .then(() => {
      document.querySelector(".verification").style.display = "none"
      document.querySelector(".result").style.display = ""
      document.querySelector(".correct").style.display = ""
      console.log("OTP Verified")
    })
    .catch(() => {
      document.querySelector(".verification").style.display = "none"
      document.querySelector(".result").style.display = ""
      document.querySelector(".incorrect").style.display = ""
      console.log("OTP Not correct")
    })
}

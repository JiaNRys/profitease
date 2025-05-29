;(($) => {
  var mainApp = {
    main_fun: () => {
      /*====================================
              LOAD APPROPRIATE MENU BAR
           ======================================*/
      $(window).bind("load resize", function () {
        if ($(this).width() < 768) {
          $("div.sidebar-collapse").addClass("collapse")
        } else {
          $("div.sidebar-collapse").removeClass("collapse")
        }
      })
    },

    initialization: () => {
      mainApp.main_fun()
    },
  }
  // Initializing ///

  $(document).ready(() => {
    mainApp.main_fun()
  })
})(jQuery)

document.querySelector("form").addEventListener("submit", (e) => {
  const debit = Number.parseFloat(document.getElementById("debit1").value) || 0
  const credit = Number.parseFloat(document.getElementById("credit1").value) || 0

  if ((debit > 0 && credit > 0) || (debit === 0 && credit === 0)) {
    alert("Please enter either a Debit or a Credit amount, not both.")
    e.preventDefault()
  }
})

document.getElementById("transaction_date").valueAsDate = new Date()

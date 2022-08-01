$(document).on("click", "#download-pdf", async function (e) {
  e.preventDefault();
  const loaderDiv = $("#loaderdiv");
  loaderDiv.removeClass("d-none");
  loaderDiv.addClass("loader");
  axios({
    url: downloadRoute, //your url
    method: "POST",
    data: {
      memberid: memberid,
      from_date: from_date,
      to_date: to_date,
    },
    responseType: "blob", // important
  }).then((response) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", `${memberid}.pdf`);
    document.body.appendChild(link);
    link.click();
    loaderDiv.removeClass("loader");
    loaderDiv.addClass("d-none");
  }).catch(e=> {
    // alert('Error Occured Please try again')
    Swal.fire({
      icon: 'error',
      title: 'Opps!..',
      text: 'Error Occured Please try again.',
    })
    loaderDiv.removeClass("loader");
    loaderDiv.addClass("d-none");
  });
});

// $(document).on('keydown', '#memberid', function(e){
//   var keyCode = e.keyCode || e.which;
//   console.log(keyCode);
//   if(keyCode === 13){
//     console.log('enter pressed');
//     // $('form').submit();
//   }
// })

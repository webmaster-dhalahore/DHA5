$(function () {
  $("#memberid").focus();
  $("#memberid").trigger("blur");
  $("#memberid").focus();
});

$(document).on("blur", "#memberid", async function (e) {
  const memberid = $("#memberid").val().trim().toUpperCase();
  const submitBtn = $('#submitBtn');
  submitBtn.prop("disabled", true);
  if (!memberid) return;
  try {
    const res = await axios.post(getMemberRoute, { memberid });
    const data = res.data.data;
    if (!data) {
      Swal.fire({
        icon: 'error',
        title: 'Opps!..',
        text: 'No Member Found.',
      })
      return;
    } else {
      submitBtn.prop("disabled", false);
    }
    const typeDes = data.type ? data.type.des : "";
    const todate = data.todate ? moment(data.todate).format("YYYY-MM-DD") : "";
    const fromdate = data.fromdate
      ? moment(data.fromdate).format("YYYY-MM-DD")
      : "";

    $("#membersr").val(data.membersr);
    $("#membername").val(data.membername);
    $("#typeid").val(data.typeid);
    $("#member_type_desc").val(typeDes);
    $("#status").val(data.status);
    $("#blockstatus").val(data.blockstatus);
    $("#fromdate").val(fromdate);
    $("#todate").val(todate);
    $("#remarks").val(data.remarks);
  } catch (error) {
    submitBtn.prop("disabled", false);
    console.log(error);
    console.log(error.response.data);
  }
});

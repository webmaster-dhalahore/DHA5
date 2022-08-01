// var items = [];
// async function refetchPSItemsData() {
//   // const p = await fetchMemberTypesData();
//   // drawMTLOVTable(p);
//   console.log("refetchPSItemsData");
// }

// function searchPSItems(e) {
//   //   const val = e.target.value.toLowerCase();
//   //   const filteredMTs = memberTypes.filter(({ code, des }) => {
//   //     return code.toString().includes(val) || des.toLowerCase().includes(val);
//   //   });

//   //   drawMTLOVTable(filteredMTs);
//   console.log("searchPSItems");
// }

// async function getItems() {
//   try {
//     const url = `${item_route}`;
//     console.log(url);
//     const res = await axios.get(`${item_route}`);
//     // localStorage.setItem(JSON.stringify(res.data))
//     items = res.data;
//     drawItemsTable(res.data)
//   } catch (e) {
//     console.log(e);
//     console.log(e.response.data);
//   }
// }

// function drawItemsTable(items) {
//   // console.log('draw items');
//   let html = `<table class="table table-sm table-striped">
//       <thead>
//         <tr>
//           <th scope="col" width="1px">#</th>
//           <th scope="col">Alias</th>
//           <th scope="col">Item Name</th>
//           <th scope="col">Price</th>
//           <th scope="col">ID</th>
//           <th scope="col">Tax-able</th>
//           <th scope="col">ST Rate</th>
//         </tr>
//       </thead>
//       <tbody id="itemsBody">`;

//   items.forEach((item, ind) => {
//     html += `<tr class="" id="item-${item.item_id}" style="cursor: pointer;" onclick="selectedItem('${item.item_id}')">
//           <th scope="row">${ind + 1}</th>
//           <td>${item.item_alias}</td>
//           <td>${item.item_name}</td>
//           <td>${item.sale_price}</td>
//           <td>${item.item_id}</td>
//           <td>${item.taxable}</td>
//           <td>${item.staxrate}</td>
//         </tr>`;
//   });
//   html += `</tbody></table>`;
//   $("#lovPSItemTable").html(html);
//   // return html;
// }

// function selectedItem(item_id) {
//   const item = items.find((i) => i.item_id == item_id)
//   console.log('selecte item id is', item_id, item);

//   $("#lov_ps_items").modal("hide");
// }

// $(function () {
//   getItems();
// });

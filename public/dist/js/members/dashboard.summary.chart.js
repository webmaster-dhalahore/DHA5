/* global Chart:false */

$(function () {
  "use strict";

  var ticksStyle = {
    fontColor: "#495057",
    fontStyle: "bold",
  };

  var mode = "index";
  var intersect = true;

  async function getSummaryData() {
    try {
      const res = await axios.get("/api/v1/summary");
      const labels = res.data.member_summary.map((sumarry) => {
        return sumarry.membertype;
      }); //countmembers
      const chartData = res.data.member_summary.map((sumarry) => {
        return sumarry.countmembers;
      }); //countmembers
      const datasets = [
        {
          backgroundColor: "#007bff",
          borderColor: "#007bff",
          data: chartData,
        },
      ];
      console.log({ datasets, labels });
      drawChart($("#member-summary-chart"), datasets, labels);
    } catch (e) {
      console.log(e);
      console.log(e.response.data);
    }
  }

  getSummaryData();
  // $("#member-summary-chart")
  function drawChart(el, datasets, labels, type = "bar") {
    const options = {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect,
      },
      hover: {
        mode: mode,
        intersect: intersect,
      },
      legend: {
        display: false,
      },
      scales: {
        yAxes: [
          {
            // display: false,
            gridLines: {
              display: true,
              lineWidth: "4px",
              color: "rgba(0, 0, 0, .2)",
              zeroLineColor: "transparent",
            },
            ticks: $.extend(
              {
                beginAtZero: true,
              },
              ticksStyle
            ),
          },
        ],
        xAxes: [
          {
            display: true,
            gridLines: {
              display: false,
            },
            ticks: ticksStyle,
          },
        ],
      },
    };

    return new Chart(el, {
      type: type,
      data: { labels, datasets },
      options: options,
    });
  }
});

// lgtm [js/unused-local-variable]
